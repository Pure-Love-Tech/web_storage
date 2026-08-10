<?php

namespace App\Http\Controllers\Files;

use App\Http\Controllers\Controller;
use App\Methods\ReCaptchaValidation;
use App\Models\Country;
use App\Models\EarningStatistic;
use App\Models\FileEntry;
use App\Models\FileReport;
use App\Models\PayoutRate;
use App\Models\Plan;
use App\Models\UserLog;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Trustip;

class FileController extends Controller
{
    public $secret;
    public $pages = ['down_1', 'down_2'];
    public $methods = ['free', 'premium'];

    public function __construct()
    {
        $this->secret = sha1(env('APP_KEY'));
    }

    public function index($id)
    {
        $fileEntry = FileEntry::whereHashId($id)->file()->public()->firstOrFail();
        return theme_view('files.download1', ['fileEntry' => $fileEntry]);
    }

    public function action(Request $request, $id)
    {
        $fileEntry = FileEntry::whereHashId($id)->file()->public()->firstOrFail();
        $page = $request->p;
        $method = $request->method;
        if (!in_array($page, $this->pages) || !in_array($method, $this->methods)) {
            toastr()->error(translate('Unauthorized request', 'download pages'));
            return redirect($fileEntry->sharedLink());
        }
        if ($method == "premium") {
            if (licenseType(1)) {
                return redirect($fileEntry->sharedLink());
            }
            if (!subscription()->is_premium) {
                return redirect()->route('premium.index');
            }
            if (subscription()->is_expired) {
                return redirect()->route('user.settings.subscription');
            }
        }
        $downloadPlan = $this->getPlanByMethod($method);
        if ($page == $this->pages[0]) {
            if (!$request->hasCookie('adb') || $request->cookie('adb') == 2) {
                return redirect($fileEntry->sharedLink());
            }
            $this->setDownloadSession($fileEntry->sharedId(), $page);
            return theme_view('files.download2', [
                'fileEntry' => $fileEntry,
                'downloadPlan' => $downloadPlan,
                'method' => $method,
            ]);
        }
        if ($page == $this->pages[1]) {
            if (!$request->hasCookie('adb') || $request->cookie('adb') == 2) {
                return redirect($fileEntry->sharedLink());
            }
            $downloadSession = $this->getDownloadSession($fileEntry->sharedId());
            if (!$downloadSession || $downloadSession['page'] != $this->pages[0]) {
                toastr()->error(translate('Invalid or expired download session', 'download pages'));
                return redirect($fileEntry->sharedLink());
            }
            if ($downloadPlan->download_captcha) {
                $validator = Validator::make($request->all(), ReCaptchaValidation::validate());
                if ($validator->fails()) {
                    foreach ($validator->errors()->all() as $error) {
                        toastr()->error($error);
                    }
                    return back();
                }
            }
            $this->setDownloadSession($fileEntry->sharedId(), $page);
            return theme_view('files.download3', [
                'fileEntry' => $fileEntry,
                'downloadPlan' => $downloadPlan,
                'method' => $method,
            ]);
        }
        toastr()->error(translate('Invalid or expired download session', 'download pages'));
        return redirect($fileEntry->sharedLink());
    }

    public function generateDownloadLink(Request $request, $id)
    {
        $fileEntry = FileEntry::whereHashId($id)->file()->public()->first();
        if (!$fileEntry) {
            return response()->json(['error' => translate('Invalid or expired file', 'download pages')]);
        }
        $downloadSession = $this->getDownloadSession($fileEntry->sharedId());
        if (!$downloadSession || $downloadSession['page'] != $this->pages[1] || $downloadSession['ip'] != ipInfo()->ip || !$request->hasCookie('adb') ||
            $request->cookie('adb') == 2 || !$request->hasCookie('rqf') || $request->cookie('rqf') != $fileEntry->sharedId()) {
            return response()->json(['error' => translate('Invalid or expired download session', 'download pages')]);
        }
        $expiration = Carbon::now()->addMinutes(settings('filesystem')->download->links_expiration_time)->timestamp;
        $signature = hash_hmac('sha256', $fileEntry->sharedId() . '|' . $expiration, $this->secret);
        $encryptedId = encrypt($fileEntry->sharedId());
        $downloadLink = route('files.download', [
            $encryptedId,
            $fileEntry->getFullName(),
            "expiration=" . $expiration,
            "signature=" . $signature,
        ]);
        return response()->json(['download_link' => $downloadLink]);
    }

    public function download(Request $request, $id, $filename)
    {
        $fileEntry = FileEntry::whereHashId(decrypt($id))->file()->public()->firstOrFail();
        $receivedExpiration = $request->expiration;
        $receivedSignature = $request->signature;
        $receivedMethod = $request->method;
        $computedSignature = hash_hmac('sha256', $fileEntry->sharedId() . '|' . $receivedExpiration, $this->secret);
        abort_if($receivedSignature !== $computedSignature || $receivedExpiration < time(), 404);
        try {
            $fileEntryClone = clone $fileEntry;
            $response = $fileEntry->downloadFile();
            if (isset($response->type) && $response->type == "error") {
                toastr()->error($response->message);
                return redirect($fileEntry->sharedLink());
            }
            $requestData = $request->all();
            $requestData['referer'] = $request->headers->get('referer');
            if ($requestData['referer'] && $requestData['referer'] == $fileEntry->sharedLink()) {
                $downloadSession = $this->getDownloadSession($fileEntry->sharedId());
                if (!$downloadSession || $downloadSession['page'] != $this->pages[1] || $downloadSession['ip'] != ipInfo()->ip) {
                    toastr()->error(translate('Invalid or expired download session', 'download pages'));
                    return redirect($fileEntry->sharedLink());
                }
            }
            if ($fileEntry->isForUser()) {
                $this->earningCalculating($requestData, $fileEntryClone);
            } else {
                $fileEntry->increment('downloads');
            }
            $fileEntry->updateExpiryDate();
            return $response;
        } catch (Exception $e) {
            toastr()->error($e->getMessage());
            return redirect($fileEntry->sharedLink());
        }
    }

    private function earningCalculating($requestData, $fileEntry)
    {
        $ip = ipInfo()->ip;
        $country = ipInfo()->location->country;
        $earningSettings = settings('earnings');
        $payoutRateAmount = $this->getPayoutRateByCountry($country);
        $statusReasons = EarningStatistic::status_reasons();
        if ($earningSettings->downloads->status) {
            $status = true;
            $statusReason = null;
            if (!$ip || !filter_var($ip, FILTER_VALIDATE_IP)) {
                $status = false;
                $statusReason = $statusReasons[3];
            }
            if ($status && $requestData['referer'] != $fileEntry->sharedLink()) {
                $status = false;
                $statusReason = $statusReasons[2];
            }
            if ($status && Cookie::has('_referer')) {
                $referer = decrypt(Cookie::get('_referer'));
                if ($referer['url'] == $fileEntry->sharedLink() && $referer['is_blocked']) {
                    $status = false;
                    $statusReason = $statusReasons[4];
                }
            }
            if ($status) {
                if (auth()->user() && auth()->user()->id == $fileEntry->user_id || $fileEntry->ip == $ip) {
                    $status = false;
                    $statusReason = $statusReasons[5];
                } else {
                    $userLog = UserLog::where('user_id', $fileEntry->user_id)->where('ip', $ip)->first();
                    if ($userLog) {
                        $status = false;
                        $statusReason = $statusReasons[5];
                    }
                }
            }
            if ($status && $payoutRateAmount == 0) {
                $status = false;
                $statusReason = $statusReasons[6];
            }
            if ($status) {
                $downloadEarningStatisticCount = EarningStatistic::where('ip', $ip)
                    ->where('file_entry_id', $fileEntry->id)
                    ->where('created_at', '>=', Carbon::now()->subHours(24))
                    ->valid()
                    ->get()
                    ->count();
                if ($downloadEarningStatisticCount >= $earningSettings->downloads->paid) {
                    $status = false;
                    $statusReason = $statusReasons[7];
                }
            }
            if ($status) {
                if ($earningSettings->security->proxy_vpn_detection && $earningSettings->security->trustip_api_key) {
                    $isIpProxy = $this->isIpProxy($ip);
                    if ($isIpProxy === "error") {
                        $status = false;
                        $statusReason = $statusReasons[9];
                    } else {
                        if ($isIpProxy == true) {
                            $status = false;
                            $statusReason = $statusReasons[8];
                        }
                    }
                }
            }
        } else {
            $status = false;
            $statusReason = $statusReasons[1];
        }
        $store = ($earningSettings->downloads->store) ? (($status) ? true : false) : true;
        if ($store) {
            $earningAmount = $status ? ($payoutRateAmount / 1000) : 0;
            $downloadEarningStatistic = new EarningStatistic();
            $downloadEarningStatistic->user_id = $fileEntry->user_id;
            $downloadEarningStatistic->ip = $ip;
            $downloadEarningStatistic->country = $country;
            $downloadEarningStatistic->payout_rate = ($status) ? $payoutRateAmount : null;
            $downloadEarningStatistic->earning_source = EarningStatistic::SOURCE_DOWNLOAD;
            $downloadEarningStatistic->earnings = $earningAmount;
            $downloadEarningStatistic->file_entry_id = $fileEntry->id;
            $downloadEarningStatistic->file_entry_details = $fileEntry;
            $downloadEarningStatistic->referer_domain = (isset($referer) && $referer['host']) ? $referer['host'] : 'direct';
            $downloadEarningStatistic->referer_details = isset($referer) ? $referer : null;
            $downloadEarningStatistic->status = $status;
            $downloadEarningStatistic->status_reason = $statusReason;
            $downloadEarningStatistic->save();
            $fileEntry->increment('downloads');
            if ($downloadEarningStatistic->isValid()) {
                $user = $downloadEarningStatistic->user;
                $user->increment('downloads_earnings', $downloadEarningStatistic->earnings);
                if ($earningSettings->referrals->status && $user->referrer) {
                    $referralPercentage = (int) $earningSettings->referrals->percentage;
                    $referralEarningsAmount = (($downloadEarningStatistic->earnings * $referralPercentage) / 100);
                    if ($referralEarningsAmount > 0) {
                        $referrer = $user->referrer;
                        $referringUser = $referrer->referring_user;
                        $referringUser->increment('referrals_earnings', $referralEarningsAmount);
                        $referralEarningStatistic = new EarningStatistic();
                        $referralEarningStatistic->user_id = $referringUser->id;
                        $referralEarningStatistic->earning_statistic_id = $downloadEarningStatistic->id;
                        $referralEarningStatistic->earning_source = EarningStatistic::SOURCE_REFERRAL;
                        $referralEarningStatistic->earnings = $referralEarningsAmount;
                        $referralEarningStatistic->referral_id = $user->referrer->id;
                        $referralEarningStatistic->downloads = 0;
                        $referralEarningStatistic->status = $status;
                        $referralEarningStatistic->save();
                        $referrer->increment('earnings', $referralEarningStatistic->earnings);
                    }
                }
            }
        }
    }

    public function reportFile(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'reason' => ['required', 'integer', 'min:0', 'max:4'],
            'details' => ['required', 'string', 'max:600'],
        ] + ReCaptchaValidation::validate());
        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                toastr()->error($error);
            }
            return back();
        }
        abort_if(!array_key_exists($request->reason, FileReport::reasons()), 404);
        $fileEntry = FileEntry::whereHashId($id)->file()->public()->firstOrFail();
        $user = auth()->user();
        if ($user) {
            if ($fileEntry->user_id == $user->id) {
                toastr()->error(translate('You cannot report your files', 'download pages'));
                return back();
            }
        }
        $reportExists = FileReport::where([['file_entry_id', $fileEntry->id], ['ip', ipInfo()->ip]])
            ->OrWhere([['file_entry_id', $fileEntry->id], ['email', $request->email]])
            ->first();
        if ($reportExists) {
            toastr()->error(translate('You have already reported this file', 'download pages'));
            return back();
        }
        $fileReport = FileReport::create([
            'file_entry_id' => $fileEntry->id,
            'ip' => ipInfo()->ip,
            'name' => $request->name,
            'email' => $request->email,
            'reason' => $request->reason,
            'details' => $request->details,
        ]);
        if ($fileReport) {
            $title = admin_trans('New report #' . $fileEntry->sharedId());
            $image = asset('images/notifications/report.png');
            $link = route('admin.files.reports.show', $fileReport->id);
            adminNotify($title, $image, $link);
            toastr()->success(translate('Your report has been sent successfully, we will review and take the necessary action', 'download pages'));
            return back();
        }
    }

    private function getPayoutRateByCountry($country)
    {
        $country = Country::where('name', $country)->first();
        $payoutRate = $this->findPayoutRate($country);
        if ($payoutRate) {
            return $payoutRate->amount;
        }
        return 0;
    }

    private function findPayoutRate($country)
    {
        if ($country) {
            $payoutRate = PayoutRate::where('country_id', $country->id)->first();
            if (!$payoutRate) {
                $payoutRate = PayoutRate::whereNull('country_id')->first();
            }
        } else {
            $payoutRate = PayoutRate::whereNull('country_id')->first();
        }
        return $payoutRate;
    }

    private function isIpProxy($ip)
    {
        try {
            $trustip = Trustip::check($ip);
            if ($trustip->status == "error") {
                return "error";
            } elseif ($trustip->status == "success") {
                return $trustip->data->is_proxy;
            }
        } catch (Exception $e) {
            return "error";
        }
    }

    private function getPlanByMethod($method)
    {
        $user = auth()->user();
        $plan = Plan::query();
        if ($user) {
            if ($method == $this->methods[0]) {
                $plan = $plan->forUsers();
            } elseif ($method == $this->methods[1]) {
                $plan = $plan->Premium();
            }
        } else {
            $plan = $plan->forVisitors();
        }
        return $plan->first();
    }

    private function setDownloadSession($sharedId, $page)
    {
        $data['page'] = $page;
        $data['ip'] = ipInfo()->ip;
        Session::forget($sharedId);
        Session::put($sharedId, encrypt($data));
    }

    private function getDownloadSession($sharedId)
    {
        if (Session::has($sharedId)) {
            $session = decrypt(Session::get($sharedId));
            return $session;
        }
        return false;
    }

}
