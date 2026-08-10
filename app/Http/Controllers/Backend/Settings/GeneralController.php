<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Validator;

class GeneralController extends Controller
{
    public function index()
    {
        return view('backend.settings.general');
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'general.site_name' => 'required|string|max:255',
            'general.site_url' => 'required|url',
            'general.contact_email' => 'nullable|required_if:actions.contact_page,on|email',
            'general.terms_of_service_link' => 'nullable|url',
            'general.date_format' => 'required|in:' . implode(',', array_keys(Settings::dateFormats())),
            'general.timezone' => 'required|in:' . implode(',', array_keys(Settings::timezones())),
            'default_captcha' => 'sometimes|string|max:100',
            'adblock_detection' => 'sometimes|integer|min:1|max:2',
            'currency.code' => ['required', 'string', 'max:4', 'regex:/^[A-Z]{3}$/'],
            'currency.symbol' => ['required', 'string', 'max:4'],
            'currency.position' => ['required', 'integer', 'min:1', 'max:2'],
            'currency.earnings_decimals' => ['required', 'integer', 'max:9'],
            'currency.prices_decimals' => ['required', 'integer', 'max:9'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {toastr()->error($error);}
            return back();
        }

        $requestData = $request->except('_token');

        if (!is_null($requestData['general']['default_captcha'])) {
            if (!extension($requestData['general']['default_captcha']) || !extension($requestData['general']['default_captcha'])->status) {
                toastr()->error(admin_trans('The selected captcha is not enabled in the extensions'));
                return back();
            }
        }

        $requestData['actions']['email_verification_status'] = ($request->has('actions.email_verification_status')) ? 1 : 0;
        $requestData['actions']['registration_status'] = ($request->has('actions.registration_status')) ? 1 : 0;
        $requestData['actions']['disposable_emails_status'] = ($request->has('actions.disposable_emails_status')) ? 1 : 0;
        $requestData['actions']['gdpr_cookie_status'] = ($request->has('actions.gdpr_cookie_status')) ? 1 : 0;
        $requestData['actions']['force_ssl_status'] = ($request->has('actions.force_ssl_status')) ? 1 : 0;
        $requestData['actions']['blog_status'] = ($request->has('actions.blog_status')) ? 1 : 0;
        $requestData['actions']['language_type'] = ($request->has('actions.language_type')) ? 1 : 0;
        $requestData['actions']['language_menu'] = ($request->has('actions.language_menu')) ? 1 : 0;
        $requestData['actions']['contact_page'] = ($request->has('actions.contact_page')) ? 1 : 0;
        $requestData['actions']['payout_rates_page'] = ($request->has('actions.payout_rates_page')) ? 1 : 0;
        $requestData['actions']['payment_proof_page'] = ($request->has('actions.payment_proof_page')) ? 1 : 0;

        foreach ($requestData as $key => $value) {
            $update = Settings::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(admin_trans('Updated Error'));
                return back();
            }
        }

        setEnv('APP_NAME', Str::slug($requestData['general']['site_name'], '_'));
        setEnv('APP_URL', $requestData['general']['site_url']);
        setEnv('APP_TIMEZONE', "'{$requestData['general']['timezone']}'");

        toastr()->success(admin_trans('Updated Successfully'));
        return back();
    }
}
