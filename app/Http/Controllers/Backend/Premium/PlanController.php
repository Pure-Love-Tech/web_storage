<?php

namespace App\Http\Controllers\Backend\Premium;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\PremiumPlan;
use Illuminate\Http\Request;
use Validator;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $plans = Plan::orderBy('sort_id', 'asc')->get();
        $idsArray = implode(',', $plans->pluck('id')->toArray());
        return view('backend.premium.plans.index', ['plans' => $plans, 'idsArray' => $idsArray]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit(Plan $plan)
    {
        return view('backend.premium.plans.edit', ['plan' => $plan]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Plan $plan)
    {
        $rules = [
            'name' => ['required', 'string', 'max:100', 'unique:plans,id,' . $plan->id],
            'short_description' => ['nullable', 'string', 'max:255'],
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

        if ($plan->isPremium()) {
            if (!$request->has('premium_plans') || count($request->premium_plans) < 1) {
                toastr()->error(admin_trans('The premium plan should include at least one price'));
                return back();
            }
            foreach ($request->premium_plans as $key => $premium_plan) {
                if (empty($premium_plan['interval']) || empty($premium_plan['price'])) {
                    toastr()->error(admin_trans('All plans should include the price and the interval'));
                    return back();
                }
                if (!preg_match("/^\d*(\.\d{2})?$/", $premium_plan['price'])) {
                    toastr()->error(admin_trans('The price amount is invalid'));
                    return back();
                }
                if ($premium_plan['interval'] < 1 || $premium_plan['interval'] > 3650) {
                    toastr()->error(admin_trans('Interval must be between 1 to 3650 days'));
                    return back();
                }
            }
        } else {
            $request->premium_plans = null;
        }

        $updatePlan = $plan->update([
            'name' => $request->name,
            'short_description' => $request->short_description,
            'storage_space' => $request->storage_space,
            'max_file_size' => $request->max_file_size,
            'file_expiry_days' => $request->file_expiry_days,
            'download_waiting_time' => $request->download_waiting_time,
            'advertisements' => $request->advertisements,
            'download_captcha' => $request->download_captcha,
            'upload_status' => $request->upload_status,
        ]);

        if ($updatePlan) {
            if ($request->premium_plans) {
                foreach ($request->premium_plans as $key => $premium_plan) {
                    if (!empty($premium_plan['id'])) {
                        $premiumPlan = PremiumPlan::where('plan_id', $plan->id)->where('id', $premium_plan['id'])->firstOrFail();
                        $premiumPlan->interval = $premium_plan['interval'];
                        $premiumPlan->price = $premium_plan['price'];
                        $premiumPlan->update();
                    } else {
                        $premiumPlan = new PremiumPlan();
                        $premiumPlan->plan_id = $plan->id;
                        $premiumPlan->interval = $premium_plan['interval'];
                        $premiumPlan->price = $premium_plan['price'];
                        $premiumPlan->save();
                    }
                }
            }
            toastr()->success(admin_trans('Updated Successfully'));
            return back();
        }
    }

    /**
     *  Sort menu
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sort(Request $request)
    {
        if ($request->has('ids')) {
            $arr = explode(',', $request->ids);
            foreach ($arr as $sortOrder => $id) {
                $plan = Plan::find($id);
                $plan->sort_id = $sortOrder;
                $plan->save();
            }
            toastr()->success(admin_trans('updated Successfully'));
            return back();
        } else {
            toastr()->error(admin_trans('Sorting error'));
            return back();
        }
    }

    /**
     * Deletes the given PremiumPlan object from the database and returns a JSON response indicating success.
     *
     * @param  PremiumPlan  $premium_plan
     * @return \Illuminate\Http\JsonResponse
     */
    public function deletePremiumPlan(PremiumPlan $premium_plan)
    {
        $premium_plan->delete();
        return response()->json(['success' => true]);
    }
}
