<?php

namespace App\Http\Controllers\Backend\Files;

use App\Http\Controllers\Controller;
use App\Models\EarningStatistic;
use App\Models\FileEntry;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class UsersFilesController extends Controller
{
    public function index()
    {
        $users = User::all();
        $fileEntries = FileEntry::forUsers()->file();
        updateIsViewed($fileEntries->get(), true);
        if (request()->filled('search')) {
            $searchTerm = '%' . request('search') . '%';
            $fileEntries->where(function ($query) use ($searchTerm) {
                $query->where('id', 'like', $searchTerm)
                    ->orWhere('user_id', 'like', $searchTerm)
                    ->orWhere('name', 'like', $searchTerm)
                    ->orWhere('filename', 'like', $searchTerm)
                    ->orWhere('description', 'like', $searchTerm);
            });
        }
        if (request()->filled('shared_id')) {
            $fileEntries->where('id', unhashid(request('shared_id')));
        }
        if (request()->filled('user')) {
            $fileEntries->where('user_id', request('user'));
        }
        if (request()->filled('visibility')) {
            $fileEntries->where('visibility', request('visibility'));
        }
        $counters['total_files'] = $fileEntries->count();
        $counters['used_space'] = $fileEntries->sum('size');
        $fileEntries = $fileEntries->orderbyDesc('id')->paginate(50);
        $fileEntries->appends(request()->only(['search', 'shared_id', 'user', 'visibility']));
        return view('backend.files.users.index', [
            'counters' => $counters,
            'users' => $users,
            'fileEntries' => $fileEntries,
        ]);
    }

    public function show(FileEntry $fileEntry)
    {
        abort_if($fileEntry->isForVisitor(), 404);
        return view('backend.files.users.show', ['fileEntry' => $fileEntry]);
    }

    public function update(Request $request, FileEntry $fileEntry)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'visibility' => ['required', 'boolean'],
            'password' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if ($request->name != $fileEntry->name) {
            $name = FileEntry::getUniqueEntryName($request->name, $fileEntry->parent_id, $fileEntry->user->id);
        } else {
            $name = $request->name;
        }
        $update = $fileEntry->update([
            'name' => $name,
            'visibility' => $request->visibility,
            'password' => $request->password,
            'description' => $request->description,
        ]);
        if ($update) {
            toastr()->success(admin_trans('Updated Successfully'));
            return back();
        }
    }

    public function statistics(FileEntry $fileEntry)
    {
        abort_if($fileEntry->isForVisitor(), 404);
        if (request()->filled('period')) {
            $period = request()->input('period');
            $startDate = Carbon::parse($period)->startOfMonth();
            $endDate = Carbon::parse($period)->endOfMonth();
            $currentMonth = Carbon::parse($period)->month;
            $currentYear = Carbon::parse($period)->year;
            $daysInCurrentMonth = Carbon::parse($period)->daysInMonth;
        } else {
            $startDate = Carbon::now()->startOfMonth();
            $endDate = Carbon::now()->endOfMonth();
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;
            $daysInCurrentMonth = Carbon::now()->daysInMonth;
        }
        $dates = $this->generateSelectDates($fileEntry);
        $counters = $this->generateStatisticsCounters($fileEntry, $startDate, $endDate);
        $chart = $this->generateStatisticsChartData($fileEntry, $startDate, $endDate);
        $tableData = $this->generateStatisticsTableData($fileEntry, $currentMonth, $currentYear, $daysInCurrentMonth);
        return view('backend.files.users.statistics', [
            'fileEntry' => $fileEntry,
            'dates' => $dates,
            'counters' => $counters,
            'chart' => $chart,
            'tableData' => $tableData,
        ]);
    }

    public function download(FileEntry $fileEntry, $filename)
    {
        abort_if($filename != $fileEntry->getFullName(), 404);
        try {
            $response = $fileEntry->downloadFile();
            if (isset($response->type) && $response->type == "error") {
                toastr()->error($response->message);
                return back();
            }
            return $response;
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function destroy(FileEntry $fileEntry)
    {
        $fileEntry->deleteRecursive();
        toastr()->success(admin_trans('Deleted Successfully'));
        return redirect()->route('admin.files.users.index');
    }

    public function destroySelected(Request $request)
    {
        if (empty($request->delete_ids)) {
            toastr()->error(admin_trans('No items selected'));
            return back();
        }
        try {
            $selectedIds = explode(',', $request->delete_ids);
            foreach ($selectedIds as $selectedId) {
                $fileEntry = FileEntry::where('id', $selectedId)->forUsers()->file()->first();
                if ($fileEntry) {
                    $fileEntry->deleteRecursive();
                }
            }
            toastr()->success(admin_trans('Deleted Successfully'));
            return back();
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return back();
        }
    }

    private function generateSelectDates($fileEntry)
    {
        $startMonth = Carbon::parse($fileEntry->created_at)->startOfMonth();
        $currentMonth = Carbon::now()->startOfMonth();
        $months = [];
        while ($startMonth->lte($currentMonth)) {
            $months[] = [
                "row" => $startMonth->format('Y-m'),
                "format" => $startMonth->format('F Y'),
            ];
            $startMonth->addMonth();
        }
        return collect($months)->sortByDesc('row');
    }

    private function generateStatisticsCounters($fileEntry, $startDate, $endDate)
    {
        $query = EarningStatistic::where('file_entry_id', $fileEntry->id)
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate);
        $counters['downloads'] = $query->sourceDownload()->sum('downloads');
        $counters['earnings'] = $query->sourceDownload()->sum('earnings');
        return $counters;
    }

    private function generateStatisticsChartData($fileEntry, $startDate, $endDate)
    {
        $dates = chartDates($startDate, $endDate);
        $query = EarningStatistic::where('file_entry_id', $fileEntry->id)
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate);
        $currentMonthDownloads = $query->sourceDownload()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
        $currentMonthDownloadsData = $dates->merge($currentMonthDownloads);
        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($currentMonthDownloadsData as $date => $count) {
            $label = Carbon::parse($date)->format('d M');
            $chart['labels'][] = $label;
            $chart['data'][] = $count;
        }
        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;
        return $chart;
    }

    private function generateStatisticsTableData($fileEntry, $currentMonth, $currentYear, $daysInCurrentMonth)
    {
        $tableData = [];
        for ($i = 1; $i <= $daysInCurrentMonth; $i++) {
            $date = Carbon::createFromDate($currentYear, $currentMonth, $i);
            $data = EarningStatistic::where('file_entry_id', $fileEntry->id)->select(
                DB::raw('COALESCE(sum(downloads), 0) as downloads'),
                DB::raw('COALESCE(SUM(CASE WHEN earning_source = "' . EarningStatistic::SOURCE_DOWNLOAD . '" THEN earnings ELSE 0 END), 0) as earnings'),
                DB::raw('COALESCE(AVG(payout_rate), 0) as cpm')
            )->whereDate('created_at', $date->toDateString())->first();
            $tableData[$date->toDateString()] = $data;
        }
        return $tableData;
    }
}
