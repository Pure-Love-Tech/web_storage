<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Extension;
use App\Models\Settings;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $extensions = Extension::all();
        return view('backend.settings.extensions.index', ['extensions' => $extensions]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Extension  $extension
     * @return \Illuminate\Http\Response
     */
    public function edit(Extension $extension)
    {
        return view('backend.settings.extensions.edit', ['extension' => $extension]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Extension  $extension
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Extension $extension)
    {
        foreach ($request->credentials as $key => $value) {
            if (!array_key_exists($key, (array) $extension->credentials)) {
                toastr()->error(admin_trans('Credentials parameter error'));
                return back();
            }
        }

        if ($request->has('status')) {
            foreach ($request->credentials as $key => $value) {
                if (empty($value)) {
                    toastr()->error(str_replace('_', ' ', $key) . admin_trans(' cannot be empty'));
                    return back();
                }
            }
            $request->status = 1;
        } else {
            $request->status = 0;
        }

        $update = $extension->update([
            'status' => $request->status,
            'credentials' => $request->credentials,
        ]);

        if ($update) {
            $extension->setCredentials();
            if (settings('general')->default_captcha == $extension->alias) {
                if (!$extension->isActive()) {
                    $settings = settings('general');
                    $settings->default_captcha = null;
                    Settings::updateSettings('general', $settings);
                }
            }
            toastr()->success(admin_trans('Updated Successfully'));
            return back();
        }
    }
}
