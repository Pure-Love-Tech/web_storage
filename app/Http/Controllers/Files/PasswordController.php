<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Models\FileEntry;
use App\Traits\Files\FileEntryPartials;
use Illuminate\Http\Request;
use Validator;

class PasswordController extends Controller
{
    use FileEntryPartials;

    public function index($id)
    {
        $fileEntry = FileEntry::whereHashId($id)->public()->firstOrFail();
        return theme_view('files.password', [
            'fileEntry' => $fileEntry,
        ]);
    }

    public function unlock(Request $request, $id)
    {
        $validator = Validator::make($request->all(), ['password' => ['required']]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        $fileEntry = FileEntry::whereHashId($id)->public()->firstOrFail();
        if ($request->password != $fileEntry->password) {
            toastr()->error(translate('Incorrect password', 'password page'));
            return back();
        }
        $passwordSessionPrefix = "password_" . $fileEntry->sharedId();
        $request->session()->put($passwordSessionPrefix, $fileEntry->password);
        return redirect($fileEntry->sharedLink());
    }
}
