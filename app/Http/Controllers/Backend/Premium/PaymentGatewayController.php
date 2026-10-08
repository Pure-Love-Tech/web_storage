<?php

namespace App\Http\Controllers\Backend\Premium;

use App\Http\Controllers\Controller;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Validator;

class PaymentGatewayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paymentGateways = PaymentGateway::orderBy('sort_id', 'asc')->get();
        $idsArray = implode(',', $paymentGateways->pluck('id')->toArray());
        return view('backend.premium.payment-gateways.index', ['paymentGateways' => $paymentGateways, 'idsArray' => $idsArray]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PaymentGateway  $paymentGateway
     * @return \Illuminate\Http\Response
     */
    public function edit(PaymentGateway $paymentGateway)
    {
        return view('backend.premium.payment-gateways.edit', ['paymentGateway' => $paymentGateway]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PaymentGateway  $paymentGateway
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PaymentGateway $paymentGateway)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'logo' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        if (!$paymentGateway->isManual()) {
            $request->instructions = null;
            foreach ($request->credentials as $key => $value) {
                if (!array_key_exists($key, (array) $paymentGateway->credentials)) {
                    toastr()->error(admin_trans('Credentials error'));
                    return back();
                }
                if ($request->has('status')) {
                    if (empty($value)) {
                        toastr()->error(str_replace('_', ' ', ucfirst($key)) . ' ' . admin_trans('cannot be empty'));
                        return back();
                    }
                }
            }
        } else {
            $request->credentials = null;
        }

        if ($request->has('logo')) {
            $logo = imageUpload($request->file('logo'), 'images/payment-gateways/', null, $paymentGateway->alias, $paymentGateway->logo);
        } else {
            $logo = $paymentGateway->logo;
        }

        $request->status = ($request->has('status')) ? 1 : 0;
        $updatePaymentGateway = $paymentGateway->update([
            'name' => $request->name,
            'logo' => $logo,
            'credentials' => $request->credentials,
            'instructions' => $request->instructions,
            'status' => $request->status,
        ]);
        if ($updatePaymentGateway) {
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
                $paymentGateway = PaymentGateway::find($id);
                $paymentGateway->sort_id = $sortOrder;
                $paymentGateway->save();
            }
            toastr()->success(admin_trans('updated Successfully'));
            return back();
        } else {
            toastr()->error(admin_trans('Sorting error'));
            return back();
        }
    }
}
