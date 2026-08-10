<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Validator;

class FileSystemController extends Controller
{
    public function index()
    {
        return view('backend.settings.filesystem');
    }

    public function update(Request $request)
    {
        $fields = array_merge($request->all(), [
            'file_types' => explode(',', $request->input('filesystem.upload.types.extensions')),
            'default_folders' => explode(',', $request->input('filesystem.others.default_folders')),
        ]);

        $validator = Validator::make($fields, [
            'filesystem.upload.types.extensions' => ['nullable', 'required_without:filesystem.upload.types.status', 'string'],
            'file_types.*' => ['string', 'alpha_dash'],
            'filesystem.upload.chunk_size' => ['required', 'integer', 'min:1', 'max:500'],
            'filesystem.upload.max_files' => ['required', 'integer', 'min:1'],
            'filesystem.download.links_expiration_time' => ['required', 'integer', 'min:1', 'max:5256000'],
            'filesystem.download.download_links_prefix' => ['required', 'string', 'alpha_dash', 'max:255'],
            'default_folders.*' => ['string', 'alpha_dash'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }

        $requestData = $request->except('_token');

        $requestData['filesystem']['upload']['types']['status'] = ($request->has('filesystem.upload.types.status')) ? 1 : 0;

        foreach ($requestData as $key => $value) {
            $update = Settings::updateSettings($key, $value);
            if (!$update) {
                toastr()->error(admin_trans('Updated Error'));
                return back();
            }
        }

        setEnv('DOWNLOAD_PREFIX', $requestData['filesystem']['download']['download_links_prefix']);

        toastr()->success(admin_trans('Updated Successfully'));
        return back();
    }

}
