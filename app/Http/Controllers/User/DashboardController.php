<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\EarningStatistic;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
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
        $counters = $this->generateCounters($user, $startDate, $endDate);
        $chart = $this->generateChartData($user, $startDate, $endDate);
        $tableData = $this->generateTableData($user, $currentMonth, $currentYear, $daysInCurrentMonth);
        return theme_view('user.dashboard', [
            'counters' => $counters,
            'chart' => $chart,
            'tableData' => $tableData,
        ]);
    }

    private function generateCounters($user, $startDate, $endDate)
    {
        $query = EarningStatistic::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->forUser($user->id)
            ->sourceDownload();
        $counters['downloads'] = $query->sum('downloads');
        $counters['earnings'] = $query->sum('earnings');
        $counters['cpm'] = $query->avg('payout_rate');
        $counters['referral_earnings'] = EarningStatistic::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->forUser($user->id)
            ->sourceReferral()
            ->sum('earnings');
        return $counters;
    }

    private function generateChartData($user, $startDate, $endDate)
    {
        $dates = chartDates($startDate, $endDate);
        $currentMonthDownloads = EarningStatistic::where('created_at', '>=', $startDate)
            ->where('created_at', '<=', $endDate)
            ->forUser($user->id)
            ->sourceDownload()
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

    private function generateTableData($user, $currentMonth, $currentYear, $daysInCurrentMonth)
    {
        $tableData = [];
        for ($i = 1; $i <= $daysInCurrentMonth; $i++) {
            $date = Carbon::createFromDate($currentYear, $currentMonth, $i);
            $data = EarningStatistic::forUser($user->id)
                ->select(
                    DB::raw('COALESCE(sum(downloads), 0) as downloads'),
                    DB::raw('COALESCE(SUM(CASE WHEN earning_source = "' . EarningStatistic::SOURCE_DOWNLOAD . '" THEN earnings ELSE 0 END), 0) as download_earnings'),
                    DB::raw('COALESCE(SUM(CASE WHEN earning_source = "' . EarningStatistic::SOURCE_REFERRAL . '" THEN earnings ELSE 0 END), 0) as referral_earnings'),
                    DB::raw('COALESCE(AVG(payout_rate), 0) as cpm')
                )
                ->whereDate('created_at', $date->toDateString())
                ->first();
            $tableData[$date->toDateString()] = $data;
        }
        return $tableData;
    }

}
