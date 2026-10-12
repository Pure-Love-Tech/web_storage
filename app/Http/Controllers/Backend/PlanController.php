<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use Illuminate\Http\Request;
use Validator;

class PlanController extends Controller
{
    public function index()
    {
        $plans = Plan::whereIn('alias', ['visitors', 'users'])->orderBy('sort_id', 'asc')->get();
        return view('backend.plans.index', ['plans' => $plans]);
    }

    public function edit(Plan $plan)
    {
        abort_if($plan->isPremium(), 404);
        return view('backend.plans.edit', ['plan' => $plan]);
    }

    public function update(Request $request, Plan $plan)
    {
        $rules = [
            'download_waiting_time' => ['required_without:disable_download_waiting_time', 'integer', 'min:1', 'max:1000'],
        ];
        $uploadRules = [
            'storage_space' => ['required_without:unlimited_storage_space', 'integer', 'min:1'],
            'max_file_size' => ['required_without:unlimited_max_file_size', 'integer', 'min:1'],
            'file_expiry_days' => ['required_without:unlimited_file_expiry_days', 'integer', 'min:1', 'max:3650'],
        ];
        if ($plan->isForVisitors()) {
            if ($request->has('upload_status')) {
                $rules = array_merge($rules, $uploadRules);
                $request->upload_status = true;
            } else {
                $request->upload_status = false;
            }
        } else {
            $rules = array_merge($rules, $uploadRules);
            $request->upload_status = true;
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if ($request->has('storage_space')) {
            if ($request->max_file_size > $request->storage_space) {
                toastr()->error(admin_trans('Max file size must be less or equal storage space'));
                return back();
            }
        }
        $request->storage_space = ($request->has('unlimited_storage_space')) ? null : $request->storage_space;
        $request->max_file_size = ($request->has('unlimited_max_file_size')) ? null : $request->max_file_size;
        $request->file_expiry_days = ($request->has('unlimited_file_expiry_days')) ? null : $request->file_expiry_days;
        $request->download_waiting_time = ($request->has('disable_download_waiting_time')) ? null : $request->download_waiting_time;
        $request->advertisements = ($request->has('advertisements')) ? 1 : 0;
        $request->download_captcha = ($request->has('download_captcha')) ? 1 : 0;
        $updatePlan = $plan->update([
            'storage_space' => $request->storage_space,
            'max_file_size' => $request->max_file_size,
            'file_expiry_days' => $request->file_expiry_days,
            'download_waiting_time' => $request->download_waiting_time,
            'advertisements' => $request->advertisements,
            'download_captcha' => $request->download_captcha,
            'upload_status' => $request->upload_status,
        ]);
        if ($updatePlan) {
            toastr()->success(admin_trans('Updated Successfully'));
            return back();
        }
    }
}
