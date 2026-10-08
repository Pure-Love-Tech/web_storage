<?php

namespace App\Http\Controllers\Backend\Earnings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Validator;

class SettingsController extends Controller
{
    public function index()
    {
        return view('backend.earnings.settings');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'earnings.downloads.paid' => ['nullable', 'required_if:earnings.downloads.status,on', 'integer', 'min:1', 'max:1000'],
            'earnings.referrals.percentage' => ['nullable', 'required_if:earnings.referrals.status,on', 'integer', 'min:1', 'max:100'],
            'earnings.bonus.users' => ['required', 'numeric', 'min:0'],
            'earnings.security.trustip_api_key' => ['nullable', 'required_if:earnings.security.proxy_vpn_detection,on', 'string', 'max:255'],
            'earnings.security.blocked_referrers' => ['nullable', 'string'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {toastr()->error($error);}
            return back();
        }

        $requestData = $request->except('_token');

        $blockedReferrers = $requestData['earnings']['security']['blocked_referrers'];
        if ($blockedReferrers) {
            $arr = explode(',', $blockedReferrers);
            $urlHost = parse_url(url('/'))['host'];
            if (in_array($urlHost, $arr)) {
                toastr()->error(admin_trans('Your website url cannot included in blocked referrers'));
                return back();
            }
        }

        $requestData['earnings']['downloads']['status'] = ($request->has('earnings.downloads.status')) ? 1 : 0;
        $requestData['earnings']['downloads']['store'] = ($request->has('earnings.downloads.store')) ? 1 : 0;
        $requestData['earnings']['referrals']['status'] = ($request->has('earnings.referrals.status')) ? 1 : 0;
        $requestData['earnings']['security']['proxy_vpn_detection'] = ($request->has('earnings.security.proxy_vpn_detection')) ? 1 : 0;

        foreach ($requestData as $key => $value) {
            $update = Settings::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(admin_trans('Updated Error'));
                return back();
            }
        }

        if ($requestData['earnings']['security']['trustip_api_key']) {
            setEnv('TRUSTIP_API_KEY', $requestData['earnings']['security']['trustip_api_key']);
        } else {
            setEnv('TRUSTIP_API_KEY', '');
        }

        toastr()->success(admin_trans('Updated Successfully'));
        return back();
    }
}
