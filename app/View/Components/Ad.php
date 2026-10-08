<?php

namespace App\View\Components;

use App\Models\Advertisement;
use Illuminate\View\Component;

class Ad extends Component
{
    public $alias;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($alias)
    {
        $this->alias = $alias;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $code = null;
        if (subscription()->plan->advertisements) {
            $advertisement = Advertisement::where('alias', $this->alias)->active()->first();
            if ($advertisement) {
                $code = $advertisement->code;
            }
        }
        return theme_view('components.ad', [
            'code' => $code,
        ]);
    }
}
