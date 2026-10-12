<?php

namespace App\Http\Controllers\Backend\Earnings;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\PayoutRate;
use Illuminate\Http\Request;
use Validator;

class PayoutRateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payoutRates = PayoutRate::orderbyDesc('amount')->get();
        return view('backend.earnings.payout-rates.index', ['payoutRates' => $payoutRates]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.earnings.payout-rates.create');
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
            'flag' => ['required', 'mimes:png,jpg,jpeg,svg'],
            'amount' => ['required', 'regex:/^\d*(\.\d{2})?$/', 'numeric', 'min:0.01'],
            'country_id' => ['sometimes', 'required', 'integer', 'unique:payout_rates'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }

        if ($request->country_id != 0) {
            $country = Country::find($request->country_id);
            if (is_null($country)) {
                toastr()->error(admin_trans('Invalid Country'));
                return back()->withInput();
            }
            $countryId = $country->id;
            $code = strtolower($country->code);
        } else {
            $existsAllCountries = PayoutRate::whereNull('country_id')->first();
            if (!is_null($existsAllCountries)) {
                toastr()->error(admin_trans('All other countries rate already exists'));
                return back()->withInput();
            }
            $countryId = null;
            $code = "all";
        }
        $flagUpload = fileUpload($request->file('flag'), 'images/payout-rates/', $code);
        $create = PayoutRate::create([
            'flag' => $flagUpload,
            'country_id' => $countryId,
            'amount' => $request->amount,
        ]);
        if ($create) {
            toastr()->success(admin_trans('Created Successfully'));
            return redirect()->route('admin.earnings.payout-rates.index');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PayoutRate  $payoutRate
     * @return \Illuminate\Http\Response
     */
    public function show(PayoutRate $payoutRate)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PayoutRate  $payoutRate
     * @return \Illuminate\Http\Response
     */
    public function edit(PayoutRate $payoutRate)
    {
        return view('backend.earnings.payout-rates.edit', ['payoutRate' => $payoutRate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PayoutRate  $payoutRate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PayoutRate $payoutRate)
    {
        $validator = Validator::make($request->all(), [
            'flag' => ['nullable', 'mimes:png,jpg,jpeg,svg'],
            'amount' => ['required', 'regex:/^\d*(\.\d{2})?$/', 'numeric', 'min:0'],
            'country_id' => ['sometimes', 'required', 'integer', 'unique:payout_rates,id,' . $payoutRate->id],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        if ($request->country_id != 0) {
            $country = Country::find($request->country_id);
            if (is_null($country)) {
                toastr()->error(admin_trans('Invalid Country'));
                return back()->withInput();
            }
            $countryId = $country->id;
            $code = strtolower($country->code);
        } else {
            $existsAllCountries = PayoutRate::where('country_id', null)->first();
            if (!is_null($existsAllCountries)) {
                if ($payoutRate->id != $existsAllCountries->id) {
                    toastr()->error(admin_trans('All other countries rate already exists'));
                    return back()->withInput();
                }
            }
            $countryId = null;
            $code = "all";
        }
        if ($request->has('flag')) {
            $flagUpload = fileUpload($request->file('flag'), 'images/payout-rates/', $code, $payoutRate->flag);
        } else {
            $flagUpload = $payoutRate->flag;
        }
        if ($flagUpload) {
            $update = $payoutRate->update([
                'flag' => $flagUpload,
                'country_id' => $countryId,
                'amount' => $request->amount,
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
     * @param  \App\Models\PayoutRate  $payoutRate
     * @return \Illuminate\Http\Response
     */
    public function destroy(PayoutRate $payoutRate)
    {
        removeFile(public_path($payoutRate->flag));
        $payoutRate->delete();
        toastr()->success(admin_trans('Deleted Successfully'));
        return back();
    }
}
