<?php

namespace App\Http\Controllers\Backend\Earnings;

use App\Http\Controllers\Controller;
use App\Models\EarningStatistic;
use App\Models\User;
use App\Models\Withdrawal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $empty = true;
        $users = User::all();
        $startDate = null;
        $endDate = null;
        if (request()->filled('date_from')) {
            $startDate = Carbon::parse(request('date_from'));
            $empty = false;
        }
        if (request()->filled('date_to')) {
            $endDate = Carbon::parse(request('date_to'));
            $empty = false;
        }
        $userId = null;
        if (request()->filled('user')) {
            $userId = request('user');
            $empty = false;
        }
        $counters = $this->getCountersData($userId, $startDate, $endDate);
        $filesData = $this->generateFilesData($userId, $startDate, $endDate);
        $tableCountriesDownloads = $this->getCountriesDownloads($userId, $startDate, $endDate, true);
        $geoCountriesDownloads = $this->getCountriesDownloads($userId, $startDate, $endDate, false);
        return view('backend.earnings.reports', [
            'empty' => $empty,
            'users' => $users,
            'counters' => $counters,
            'filesData' => $filesData,
            'tableCountriesDownloads' => $tableCountriesDownloads,
            'geoCountriesDownloads' => $geoCountriesDownloads,
        ]);
    }

    private function generateFilesData($userId, $startDate, $endDate)
    {
        $earningStatistics = EarningStatistic::query();
        if ($startDate) {
            $earningStatistics->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $earningStatistics->where('created_at', '<=', $endDate);
        }
        if ($userId) {
            $earningStatistics->forUser($userId);
        }
        $data = $earningStatistics->sourceDownload()
            ->select('file_entry_id', 'file_entry_details', DB::raw('SUM(downloads) as total_downloads'), DB::raw('SUM(earnings) as total_earnings'))
            ->groupBy('file_entry_id', 'file_entry_details')
            ->orderbyDesc('total_downloads')
            ->paginate(50);
        $data->appends(request()->only(['date_from', 'date_to', 'user']));
        return $data;
    }

    private function getCountersData($userId, $startDate, $endDate)
    {
        $earningStatistics = EarningStatistic::query();
        $withdrawals = Withdrawal::query();
        if ($startDate) {
            $earningStatistics->where('created_at', '>=', $startDate);
            $withdrawals->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $earningStatistics->where('created_at', '<=', $endDate);
            $withdrawals->where('created_at', '<=', $endDate);
        }
        if ($userId) {
            $earningStatistics->forUser($userId);
            $withdrawals->forUser($userId);
        }
        $earningStatisticsClone = clone $earningStatistics;
        $counters['total_downloads'] = $earningStatistics->sourceDownload()->sum('downloads');
        $counters['total_downloads_earnings'] = $earningStatistics->sourceDownload()->sum('earnings');
        $counters['total_referrals_earnings'] = $earningStatisticsClone->sourceReferral()->sum('earnings');
        $counters['total_withdrawn_amount'] = $withdrawals->whereIn('status', [Withdrawal::STATUS_APPROVED, Withdrawal::STATUS_COMPLETED])->sum('total');
        return $counters;
    }

    private function getCountriesDownloads($userId, $startDate, $endDate, $all = true)
    {
        $earningStatistics = EarningStatistic::query();
        if (!$all) {
            $earningStatistics->where('country', '!=', 'Other');
        } else {
            $earningStatistics->limit(12);
        }
        if ($startDate) {
            $earningStatistics->where('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $earningStatistics->where('created_at', '<=', $endDate);
        }
        if ($userId) {
            $earningStatistics->forUser($userId);
        }
        $countriesDownloads = $earningStatistics->sourceDownload()
            ->select('country', DB::raw('SUM(downloads) as downloads'))
            ->groupBy('country')
            ->orderbyDesc('downloads')
            ->get();
        return $countriesDownloads;
    }

}