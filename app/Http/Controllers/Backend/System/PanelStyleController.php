<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use File;
use Illuminate\Http\Request;
use Validator;

class PanelStyleController extends Controller
{
    public function index()
    {
        $customCssFile = public_path(config('backend.css.custom'));
        if (!File::exists($customCssFile)) {
            File::put($customCssFile, '');
        }
        $customCssFile = File::get($customCssFile);
        return view('backend.system.panel-style', ['customCssFile' => $customCssFile]);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'system.colors.*' => 'required|regex:/^#[A-Fa-f0-9]{6}$/',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {toastr()->error($error);}
            return back();
        }

        $requestData = $request->except(['_token', 'custom_css']);
        foreach ($requestData as $key => $value) {
            $update = Settings::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(admin_trans('Updated Error'));
                return back();
            }
        }

        $this->updateBackendColors($requestData['system']['colors']);
        $this->updateBackendCustomCss($request->custom_css);

        toastr()->success(admin_trans('Updated Successfully'));
        return back();
    }

    public function updateBackendColors($colors)
    {
        $output = ':root {' . PHP_EOL;
        foreach ($colors as $key => $value) {
            $output .= '  --' . $key . ':' . $value . ';' . PHP_EOL;
        }
        $output .= '}' . PHP_EOL;
        $colorsFile = public_path(config('backend.css.colors'));
        if (!File::exists($colorsFile)) {
            File::put($colorsFile, '');
        }
        File::put($colorsFile, $output);
    }

    private function updateBackendCustomCss($content)
    {
        $customCssFile = public_path(config('backend.css.custom'));
        if (!File::exists($customCssFile)) {
            File::put($customCssFile, '');
        }
        File::put($customCssFile, $content);
        toastr()->success(admin_trans('Updated Successfully'));
        return back();
    }
}