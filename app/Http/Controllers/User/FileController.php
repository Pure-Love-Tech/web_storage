<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EarningStatistic;
use App\Models\FileEntry;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class FileController extends Controller
{
    public function index()
    {
        return theme_view('user.files.index');
    }

    public function statistics($id)
    {
        $user = auth()->user();

        $fileEntry = FileEntry::where('id', $id)->forUser($user->id)->file()->firstOrFail();

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
        $chart = $this->generateStatisticsChartData($fileEntry, $user, $startDate, $endDate);
        $tableData = $this->generateStatisticsTableData($fileEntry, $user, $currentMonth, $currentYear, $daysInCurrentMonth);
        $tableCountriesDownloads = $this->getCountriesDownloadsStatistics($fileEntry, $user, $startDate, $endDate, true);
        $geoCountriesDownloads = $this->getCountriesDownloadsStatistics($fileEntry, $user, $startDate, $endDate, false);

        return theme_view('user.files.statistics', [
            'fileEntry' => $fileEntry,
            'dates' => $dates,
            'counters' => $counters,
            'chart' => $chart,
            'tableData' => $tableData,
            'tableCountriesDownloads' => $tableCountriesDownloads,
            'geoCountriesDownloads' => $geoCountriesDownloads,
        ]);
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

    private function generateStatisticsChartData($fileEntry, $user, $startDate, $endDate)
    {
        $chartDates = chartDates($startDate, $endDate);
        $currentMonthDownloads = EarningStatistic::where('file_entry_id', $fileEntry->id)
            ->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->forUser($user->id)
            ->sourceDownload()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
        $currentMonthDownloadsData = $chartDates->merge($currentMonthDownloads);
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

    private function generateStatisticsTableData($fileEntry, $user, $currentMonth, $currentYear, $daysInCurrentMonth)
    {
        $tableData = [];
        for ($i = 1; $i <= $daysInCurrentMonth; $i++) {
            $date = Carbon::createFromDate($currentYear, $currentMonth, $i);
            $data = EarningStatistic::where('file_entry_id', $fileEntry->id)
                ->forUser($user->id)
                ->select(
                    DB::raw('COALESCE(sum(downloads), 0) as downloads'),
                    DB::raw('COALESCE(SUM(CASE WHEN earning_source = "' . EarningStatistic::SOURCE_DOWNLOAD . '" THEN earnings ELSE 0 END), 0) as earnings'),
                    DB::raw('COALESCE(AVG(payout_rate), 0) as cpm')
                )
                ->whereDate('created_at', $date->toDateString())
                ->first();
            $tableData[$date->toDateString()] = $data;
        }
        return $tableData;
    }

    private function getCountriesDownloadsStatistics($fileEntry, $user, $startDate, $endDate, $all = true)
    {
        $query = EarningStatistic::where('file_entry_id', $fileEntry->id);
        if (!$all) {
            $query->where('country', '!=', 'Other');
        }
        $countriesDownloads = $query->where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->forUser($user->id)
            ->sourceDownload()
            ->select('country', DB::raw('SUM(downloads) as downloads'))
            ->groupBy('country')
            ->orderbyDesc('downloads')
            ->get();
        return $countriesDownloads;
    }

    private function generateSelectDates($fileEntry)
    {
        $startMonth = Carbon::parse($fileEntry->created_at)->startOfMonth();
        $currentMonth = Carbon::now()->startOfMonth();
        $months = [];
        while ($startMonth->lte($currentMonth)) {
            $months[] = [
                "key" => $startMonth->format('Y-m'),
                "value" => $startMonth->format('F Y'),
            ];
            $startMonth->addMonth();
        }
        return collect($months)->sortByDesc('key');
    }

    public function download($id, $filename)
    {
        $fileEntry = FileEntry::whereHashId($id)->forUser(auth()->user()->id)->file()->firstOrFail();
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
}
