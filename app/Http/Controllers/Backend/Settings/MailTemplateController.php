<?php

namespace App\Http\Controllers\Backend\Settings;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\MailTemplate;
use Illuminate\Http\Request;
use Validator;

class MailTemplateController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('lang')) {
            $language = Language::where('code', $request->lang)->firstOrFail();
            $mailTemplates = MailTemplate::where('lang', $language->code)->forLicense()->with('language')->get();
            return view('backend.settings.mail-templates.index', [
                'mailTemplates' => $mailTemplates,
                'active' => $language->name,
            ]);
        } else {
            return redirect(url()->current() . '?lang=' . env('DEFAULT_LANGUAGE'));
        }
    }

    public function edit(Request $request, MailTemplate $mailTemplate)
    {
        abort_if(!$mailTemplate->isForLicense(), 404);
        return view('backend.settings.mail-templates.edit', ['mailTemplate' => $mailTemplate]);
    }

    public function update(Request $request, MailTemplate $mailTemplate)
    {
        abort_if(!$mailTemplate->isForLicense(), 404);
        $validator = Validator::make($request->all(), [
            'subject' => ['required', 'string', 'max:255'],
            'body' => ['required'],
        ]);
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {toastr()->error($error);}
            return back();
        }
        if (!$mailTemplate->nonDisabled()) {
            $request->status = ($request->has('status')) ? 1 : 0;
        } else {
            $request->status = 1;
        }
        $update = $mailTemplate->update([
            'subject' => $request->subject,
            'status' => $request->status,
            'body' => $request->body,
        ]);
        if ($update) {
            toastr()->success(admin_trans('Updated Successfully'));
            return back();
        }
    }
}
