<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

class InfoController extends Controller
{
    public function index()
    {
        $system['application']['name'] = config('vironeer.item.alias');
        $system['application']['version'] = config('vironeer.item.version');
        $system['application']['laravel'] = app()->version();
        $system['application']['timezone'] = config('app.timezone');
        $system['server'] = $_SERVER;
        $system['server']['php'] = phpversion();
        $system = json_decode(json_encode($system));
        return view('backend.system.info', ['system' => $system]);
    }

    public function cache()
    {
        Artisan::call('optimize:clear');
        removeFileFromStorage('direct', 'logs/laravel.log');
        toastr()->success(admin_trans('Cache Cleared Successfully'));
        return back();
    }
}
