<?php

namespace App\Http\Controllers\Backend\System;

use App\Http\Controllers\Controller;
use App\Models\Backend\EditorFile;
use Illuminate\Http\Request;
use Validator;

class EditorFileController extends Controller
{
    public function index()
    {
        $files = EditorFile::all();
        return view('backend.system.editor-files', ['files' => $files]);
    }

    public function upload(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                return response()->json(['error' => $error], 400);
            }
        }
        $image = imageUpload($request->file('image'), 'images/uploads/');
        if ($image) {
            $editorFile = new EditorFile();
            $editorFile->path = $image;
            $editorFile->save();
        }
        return response()->json(['uploaded' => true, 'default' => asset($image)]);
    }

    public function destroy(EditorFile $editorFile)
    {
        removeFile(public_path($editorFile->path));
        $editorFile->delete();
        toastr()->success(admin_trans('Deleted Successfully'));
        return back();
    }
}