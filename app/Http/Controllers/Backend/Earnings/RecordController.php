<?php

namespace App\Http\Controllers\Backend\Earnings;

use App\Http\Controllers\Controller;
use App\Models\EarningStatistic;
use App\Models\User;
use Carbon\Carbon;

class RecordController extends Controller
{
    public function index()
    {
        $dates = EarningStatistic::selectRaw("DATE_FORMAT(created_at, '%Y-%m') `row`, DATE_FORMAT(created_at, '%M %Y') format")
            ->groupBy(['row', 'format'])
            ->orderByRaw("`row` DESC")
            ->get();
        $users = User::all();
        $query = EarningStatistic::query();
        if (request()->filled('period')) {
            $month = Carbon::parse(request('period'))->month;
            $year = Carbon::parse(request('period'))->year;
            $query->whereMonth('created_at', $month)->whereYear('created_at', $year);
        }
        if (request()->filled('user')) {
            $query->where('user_id', request('user'));
        }
        if (request()->filled('source')) {
            $query->where('earning_source', request('source'));
        }
        $records = $query->orderbyDesc('id')->paginate(50);
        $records->appends(request()->only(['period', 'user', 'source']));
        return view('backend.earnings.records.index', [
            'dates' => $dates,
            'users' => $users,
            'records' => $records,
        ]);
    }

    public function show(EarningStatistic $record)
    {
        return view('backend.earnings.records.show', ['record' => $record]);
    }
}
