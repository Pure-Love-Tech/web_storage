<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\EarningStatistic;
use App\Models\FileEntry;
use App\Models\Transaction;
use App\Models\User;
use App\Models\UserLog;
use App\Models\Withdrawal;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $counters['earnings']['total'] = EarningStatistic::valid()->sum('earnings');
        $counters['earnings']['monthly'] = EarningStatistic::valid()->whereMonth('created_at', Carbon::now()->month)->sum('earnings');
        $counters['earnings']['daily'] = EarningStatistic::valid()->whereDate('created_at', Carbon::today())->sum('earnings');

        $counters['income']['total'] = Transaction::paid()->sum('price');
        $counters['income']['monthly'] = Transaction::paid()->whereMonth('created_at', Carbon::now()->month)->sum('price');
        $counters['income']['daily'] = Transaction::paid()->whereDate('created_at', Carbon::today())->sum('price');

        $counters['users']['total'] = User::all()->count();
        $counters['files']['total'] = FileEntry::file()->count();
        $counters['files']['used_space'] = FileEntry::file()->sum('size');

        $counters['withdrawals']['total'] = Withdrawal::all()->count();
        $counters['withdrawals']['total_amount'] = Withdrawal::whereIn('status', [Withdrawal::STATUS_APPROVED, Withdrawal::STATUS_COMPLETED])->sum('total');
        $counters['withdrawals']['pending_amount'] = Withdrawal::pending()->sum('total');

        $users = User::orderbyDesc('id')->limit(6)->get();
        $charts['users'] = $this->generateUsersChartData();
        $charts['uploads'] = $this->generateUploadsChartData();
        $charts['logs'] = $this->generateLogsChartData();

        return view('backend.dashboard', [
            'counters' => $counters,
            'users' => $users,
            'charts' => $charts,
        ]);
    }

    private function generateUsersChartData()
    {
        $startDate = Carbon::now()->startOfWeek();
        $endDate = Carbon::now()->endOfWeek();
        $dates = chartDates($startDate, $endDate);
        $usersRecord = User::where('created_at', '>=', Carbon::now()->startOfWeek())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
        $usersRecordData = $dates->merge($usersRecord);
        $chart['labels'] = [];
        $chart['data'] = [];
        foreach ($usersRecordData as $key => $value) {
            $chart['labels'][] = Carbon::parse($key)->format('d F');
            $chart['data'][] = $value;
        }
        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;
        return $chart;
    }

    public function generateUploadsChartData()
    {
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();
        $dates = chartDates($startDate, $endDate);
        $monthlyUploads = FileEntry::file()->where('created_at', '>=', Carbon::now()->startOfMonth())
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->pluck('count', 'date');
        $monthlyUploadsData = $dates->merge($monthlyUploads);
        $chart['labels'] = [];
        foreach ($monthlyUploadsData as $key => $value) {
            $chart['labels'][] = Carbon::parse($key)->format('d M');
            $chart['data'][] = $value;
        }
        $chart['max'] = (max($chart['data']) > 9) ? max($chart['data']) + 2 : 10;
        return $chart;
    }

    private function generateLogsChartData()
    {
        $usersLogs = UserLog::where('created_at', '>=', Carbon::now()->startOfMonth())->get(['browser', 'os', 'country']);
        $chart = [];
        if ($usersLogs->count() > 0) {
            $browserChartData = $usersLogs->groupBy('browser')->map(function ($item, $key) {
                return collect($item)->count();
            });
            $osChartData = $usersLogs->groupBy('os')->map(function ($item, $key) {
                return collect($item)->count();
            });
            $countryChartData = $usersLogs->groupBy('country')->map(function ($item, $key) {
                return collect($item)->count();
            });
            $chart['browsers'] = ['labels' => $browserChartData->keys(), 'data' => $browserChartData->flatten()];
            $chart['os'] = ['labels' => $osChartData->keys(), 'data' => $osChartData->flatten()];
            $chart['countries'] = ['labels' => $countryChartData->keys(), 'data' => $countryChartData->flatten()];
        }
        return $chart;
    }
}
