<?php

namespace App\Traits;

use App\Classes\ThemeManager;
use Illuminate\Pagination\Cursor;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\Paginator;

trait WithPagination
{
    /**
     * The current page number.
     *
     * @var int
     */
    public $page = 1;

    /**
     * An array to store all the paginators.
     *
     * @var array
     */
    public $paginators = [];

    /**
     * An array to keep track of the number of times a paginator has been rendered.
     *
     * @var array
     */
    protected $numberOfPaginatorsRendered = [];

    /**
     * Returns an array with the keys of the paginators and their values set to an array with the key 'except' set to 1.
     *
     * @return array
     */
    public function queryStringWithPagination()
    {
        foreach ($this->paginators as $key => $value) {
            $this->$key = $value;
        }

        return array_fill_keys(array_keys($this->paginators), ['except' => 1]);
    }

    /**
     * Initializes the collection with pagination.
     *
     * @return void
     */
    public function initializeWithPagination()
    {
        foreach ($this->paginators as $key => $value) {
            $this->$key = $value;
        }

        $this->page = $this->resolvePage();

        $this->paginators['page'] = $this->page;

        if (class_exists(CursorPaginator::class)) {
            CursorPaginator::currentCursorResolver(function ($pageName) {
                if (!isset($this->paginators[$pageName])) {
                    $this->paginators[$pageName] = request()->query($pageName, '');
                }
                return Cursor::fromEncoded($this->paginators[$pageName]);
            });
        }

        Paginator::currentPageResolver(function ($pageName) {
            if (!isset($this->paginators[$pageName])) {
                $this->paginators[$pageName] = request()->query($pageName, 1);
            }

            return (int) $this->paginators[$pageName];
        });

        Paginator::defaultView($this->paginationView());
    }

    /**
     * Get the pagination view for the Livewire component.
     *
     * @return string
     */
    public function paginationView()
    {
        return app(ThemeManager::class)->getActiveThemeViewPrefix() . '.' . 'livewire.pagination.bootstrap';
    }

    /**
     * Set the paginator to the previous page.
     *
     * @param  string  $pageName
     * @return void
     */
    public function previousPage($pageName = 'page')
    {
        $this->setPage(max($this->paginators[$pageName] - 1, 1), $pageName);
    }

    /**
     * Set the paginator to the next page.
     *
     * @param  string  $pageName
     * @return void
     */
    public function nextPage($pageName = 'page')
    {
        $this->setPage($this->paginators[$pageName] + 1, $pageName);
    }

    /**
     * Set the current page for the paginator.
     *
     * @param  int  $page
     * @param  string  $pageName
     * @return void
     */
    public function gotoPage($page, $pageName = 'page')
    {
        $this->setPage($page, $pageName);
    }

    /**
     * Reset the current page to the first page.
     *
     * @param  string  $pageName
     * @return void
     */
    public function resetPage($pageName = 'page')
    {
        $this->setPage(1, $pageName);
    }

    /**
     * Set the current page for the paginator.
     *
     * @param  int  $page
     * @param  string  $pageName
     * @return void
     */
    public function setPage($page, $pageName = 'page')
    {
        if (is_numeric($page)) {
            $page = (int) $page;
            $page = $page <= 0 ? 1 : $page;
        }
        $beforePaginatorMethod = 'updatingPaginators';
        $afterPaginatorMethod = 'updatedPaginators';

        $beforeMethod = 'updating' . $pageName;
        $afterMethod = 'updated' . $pageName;

        if (method_exists($this, $beforePaginatorMethod)) {
            $this->{$beforePaginatorMethod}($page, $pageName);
        }

        if (method_exists($this, $beforeMethod)) {
            $this->{$beforeMethod}($page, null);
        }

        $this->paginators[$pageName] = $page;

        $this->{$pageName} = $page;

        if (method_exists($this, $afterPaginatorMethod)) {
            $this->{$afterPaginatorMethod}($page, $pageName);
        }

        if (method_exists($this, $afterMethod)) {
            $this->{$afterMethod}($page, null);
        }

        $this->emit('deselectall');
    }

    /**
     * Resolves the current page number from the query string.
     *
     * @return int
     */
    public function resolvePage()
    {
        return request()->query(data_get($this->queryString, 'page.as', 'page'), $this->page);
    }
}
