<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Methods\ReCaptchaValidation;
use App\Models\Page;
use App\Models\PayoutRate;
use App\Models\Withdrawal;
use App\Models\WithdrawalMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Validator;

class GlobalController extends Controller
{
    public function cookie()
    {
        Cookie::queue('gdpr_cookie', true, 1440 * 30);
        return response()->json(['success' => true]);
    }

    public function popup()
    {
        Cookie::queue('popup_notice', true);
    }

    public function payoutRates()
    {
        $payoutRates = PayoutRate::with('country')->orderbyDesc('amount')->get();
        $withdrawalMethods = WithdrawalMethod::orderBy('sort_id', 'asc')->active()->get();
        return theme_view('payout-rates', [
            'payoutRates' => $payoutRates,
            'withdrawalMethods' => $withdrawalMethods,
        ]);
    }

    public function paymentProof()
    {
        $status = [Withdrawal::STATUS_APPROVED, Withdrawal::STATUS_COMPLETED];
        $counters['total_requests'] = Withdrawal::whereIn('status', $status)->count();
        $counters['total_paid_amount'] = Withdrawal::whereIn('status', $status)->sum('total');
        $withdrawals = Withdrawal::whereIn('status', $status)->paginate(20);
        return theme_view('payment-proof', ['counters' => $counters, 'withdrawals' => $withdrawals]);
    }

    public function page($slug)
    {
        $page = Page::where([['slug', $slug], ['lang', getLocale()]])->firstOrFail();
        $page->increment('views');
        return theme_view('page', ['page' => $page]);
    }

    public function contact()
    {
        return theme_view('contact');
    }

    public function contactSend(Request $request)
    {
        if (!settings('smtp')->status || !settings('general')->contact_email) {
            toastr()->error(translate('Sending emails is not available right now', 'pages'));
            return back();
        }
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ] + ReCaptchaValidation::validate());
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back()->withInput();
        }
        try {
            $name = $request->name;
            $email = $request->email;
            $subject = $request->subject;
            $msg = replace_br($request->message);
            \Mail::send([], [], function ($message) use ($msg, $email, $subject, $name) {
                $message->to(settings('general')->contact_email)
                    ->from(env('MAIL_FROM_ADDRESS'), $name)
                    ->replyTo($email)
                    ->subject($subject)
                    ->html($msg);
            });
            toastr()->success(translate('Your message has been sent successfully', 'pages'));
            return back();
        } catch (\Exception $e) {
            toastr()->error(translate('Error on sending', 'pages'));
            return back()->withInput();
        }
    }
}
