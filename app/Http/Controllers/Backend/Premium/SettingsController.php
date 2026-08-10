<?php

namespace App\Http\Controllers\Backend\Premium;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Validator;

class SettingsController extends Controller
{
    public function index()
    {
        return view('backend.premium.settings');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'subscription.delete_expired' => ['required', 'integer', 'min:0', 'max:730'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {toastr()->error($error);}
            return back();
        }

        $requestData = $request->except('_token');

        $requestData['subscription']['expire_notification'] = ($request->has('subscription.expire_notification')) ? 1 : 0;

        foreach ($requestData as $key => $value) {
            $update = Settings::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(admin_trans('Updated Error'));
                return back();
            }
        }

        toastr()->success(admin_trans('Updated Successfully'));
        return back();
    }
}
