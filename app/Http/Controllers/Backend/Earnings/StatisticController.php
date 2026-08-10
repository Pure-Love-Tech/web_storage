<?php

namespace App\Http\Controllers\Backend\Earnings;

use App\Http\Controllers\Controller;
use App\Models\EarningStatistic;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    public function index()
    {
        $dates = EarningStatistic::selectRaw("DATE_FORMAT(created_at, '%Y-%m') `row`, DATE_FORMAT(created_at, '%M %Y') format")
            ->groupBy(['row', 'format'])
            ->orderByRaw("`row` DESC")
            ->get();
        $users = User::all();
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
        $userId = null;
        if (request()->filled('user')) {
            $userId = request('user');
        }
        $counters = $this->generateCounters($userId, $startDate, $endDate);
        $chart = $this->generateChartData($userId, $startDate, $endDate);
        $tableData = $this->generateTableData($userId, $currentMonth, $currentYear, $daysInCurrentMonth);
        return view('backend.earnings.statistics', [
            'dates' => $dates,
            'users' => $users,
            'counters' => $counters,
            'chart' => $chart,
            'tableData' => $tableData,
        ]);
    }

    private function generateCounters($userId, $startDate, $endDate)
    {
        $query = EarningStatistic::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate);
        if ($userId) {
            $query->forUser($userId);
        }
        $queryClone = clone $query;
        $counters['downloads'] = $query->sourceDownload()->sum('downloads');
        $counters['downloads_earnings'] = $query->sourceDownload()->sum('earnings');
        $counters['referrals_earnings'] = $queryClone->sourceReferral()->sum('earnings');
        return $counters;
    }

    private function generateChartData($userId, $startDate, $endDate)
    {
        $dates = chartDates($startDate, $endDate);
        $query = EarningStatistic::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate);
        if ($userId) {
            $query->forUser($userId);
        }
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

    private function generateTableData($userId, $currentMonth, $currentYear, $daysInCurrentMonth)
    {
        $tableData = [];
        for ($i = 1; $i <= $daysInCurrentMonth; $i++) {
            $date = Carbon::createFromDate($currentYear, $currentMonth, $i);
            $query = EarningStatistic::query();
            if ($userId) {
                $query->forUser($userId);
            }
            $data = $query->select(
                DB::raw('COALESCE(sum(downloads), 0) as downloads'),
                DB::raw('COALESCE(SUM(CASE WHEN earning_source = "' . EarningStatistic::SOURCE_DOWNLOAD . '" THEN earnings ELSE 0 END), 0) as download_earnings'),
                DB::raw('COALESCE(SUM(CASE WHEN earning_source = "' . EarningStatistic::SOURCE_REFERRAL . '" THEN earnings ELSE 0 END), 0) as referral_earnings'),
                DB::raw('COALESCE(AVG(payout_rate), 0) as cpm')
            )->whereDate('created_at', $date->toDateString())->first();
            $tableData[$date->toDateString()] = $data;
        }
        return $tableData;
    }
}
