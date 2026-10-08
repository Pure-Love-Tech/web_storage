<?php

namespace App\Http\Controllers\Backend\Earnings;

use App\Http\Controllers\Controller;
use App\Models\WithdrawalMethod;
use Illuminate\Http\Request;
use Validator;

class WithdrawalMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $withdrawalMethods = WithdrawalMethod::orderBy('sort_id', 'asc')->get();
        $idsArray = implode(',', $withdrawalMethods->pluck('id')->toArray());
        return view('backend.earnings.withdrawal-methods.index', ['withdrawalMethods' => $withdrawalMethods, 'idsArray' => $idsArray]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.earnings.withdrawal-methods.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:withdrawal_methods'],
            'logo' => ['required', 'mimes:png,jpg,jpeg,svg'],
            'minimum' => ['nullable', 'regex:/^\d*(\.\d{2})?$/', 'numeric'],
            'description' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        if ($request->minimum < 0.10) {
            toastr()->error(admin_trans('The minimum withdrawal amount should be at least 0.10'));
            return back();
        }
        $request->status = ($request->has('status')) ? true : false;
        $request->minimum = ($request->has('minimum') && !is_null($request->minimum)) ? $request->minimum : "0.00";
        $countWithdrawalMethods = WithdrawalMethod::get()->count();
        $sortId = $countWithdrawalMethods + 1;
        $logo = fileUpload($request->file('logo'), 'images/withdrawal-methods/');
        if ($logo) {
            $create = WithdrawalMethod::create([
                'name' => $request->name,
                'logo' => $logo,
                'minimum' => $request->minimum,
                'description' => $request->description,
                'sort_id' => $sortId,
                'status' => $request->status,
            ]);
            if ($create) {
                toastr()->success(admin_trans('Created Successfully'));
                return redirect()->route('admin.earnings.withdrawal-methods.index');
            }
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
        $countWithdrawalMethods = WithdrawalMethod::get()->count();
        if (!$countWithdrawalMethods) {
            toastr()->error(admin_trans('This table is empty'));
            return back();
        }
        if ($request->has('ids')) {
            $arr = explode(',', $request->ids);
            foreach ($arr as $sortOrder => $id) {
                $menu = WithdrawalMethod::find($id);
                $menu->sort_id = $sortOrder;
                $menu->save();
            }
            toastr()->success(admin_trans('updated Successfully'));
            return back();
        } else {
            toastr()->error(admin_trans('Sorting error'));
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WithdrawalMethod  $withdrawalMethod
     * @return \Illuminate\Http\Response
     */
    public function show(WithdrawalMethod $withdrawalMethod)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\WithdrawalMethod  $withdrawalMethod
     * @return \Illuminate\Http\Response
     */
    public function edit(WithdrawalMethod $withdrawalMethod)
    {
        return view('backend.earnings.withdrawal-methods.edit', ['withdrawalMethod' => $withdrawalMethod]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WithdrawalMethod  $withdrawalMethod
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WithdrawalMethod $withdrawalMethod)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255', 'unique:withdrawal_methods,id,' . $withdrawalMethod->id],
            'logo' => ['nullable', 'mimes:png,jpg,jpeg,svg'],
            'minimum' => ['nullable', 'regex:/^\d*(\.\d{2})?$/', 'numeric'],
            'description' => ['nullable', 'string'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        if ($request->minimum < 0.10) {
            toastr()->error(admin_trans('The minimum withdrawal amount should be at least 0.10'));
            return back();
        }
        $request->status = ($request->has('status')) ? true : false;
        $request->minimum = ($request->has('minimum') && !is_null($request->minimum)) ? $request->minimum : "0.00";
        if ($request->has('logo')) {
            $logo = fileUpload($request->file('logo'), 'images/withdrawal-methods/', null, $withdrawalMethod->logo);
        } else {
            $logo = $withdrawalMethod->logo;
        }
        if ($logo) {
            $update = $withdrawalMethod->update([
                'name' => $request->name,
                'logo' => $logo,
                'minimum' => $request->minimum,
                'description' => $request->description,
                'status' => $request->status,
            ]);
            if ($update) {
                toastr()->success(admin_trans('Updated Successfully'));
                return back();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WithdrawalMethod  $withdrawalMethod
     * @return \Illuminate\Http\Response
     */
    public function destroy(WithdrawalMethod $withdrawalMethod)
    {
        removeFile(public_path($withdrawalMethod->logo));
        $withdrawalMethod->delete();
        toastr()->success(admin_trans('Deleted Successfully'));
        return back();
    }
}
