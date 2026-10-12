<?php

use App\Methods\Dotenv;
use App\Methods\SubscriptionManager;
use App\Models\Addon;
use App\Models\Backend\AdminNotification;
use App\Models\Country;
use App\Models\Extension;
use App\Models\Language;
use App\Models\MailTemplate;
use App\Models\PaymentGateway;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Jenssegers\Date\Date;
use Vinkla\Hashids\Facades\Hashids;
use Vironeer\BrowserDetector;
use Vironeer\GeoLite\GeoIp;
use Vironeer\OSDetector;

function demoMode()
{
    return config('vironeer.system.demo_mode');
}

function adminPath()
{
    return env('SYSTEM_ADMIN_PATH');
}

function adminUrl($path = null)
{
    $url = url(adminPath());
    if ($path) {
        $url = $url . '/' . $path;
    }
    return $url;
}

function admin_trans($key)
{
    return $key;
}

function settings($key = null)
{
    if (!empty($key)) {
        return Settings::selectSettings($key);
    }
    $settings = Settings::pluck('value', 'key')->all();
    return json_decode(json_encode($settings), false);
}

function extension($alias)
{
    $extension = Extension::where('alias', $alias)->first();
    return $extension;
}

function countries()
{
    $countries = Country::all();
    return $countries;
}

function updateIsViewed($query, $direct = null)
{
    if ($direct) {
        $unViewedItems = $query;
    } else {
        $unViewedItems = $query::where('is_viewed', 0)->get();
    }
    if ($unViewedItems->count() > 0) {
        foreach ($unViewedItems as $unViewedItem) {
            $unViewedItem->is_viewed = 1;
            $unViewedItem->save();
        }
    }
}

function dateFormat($date)
{
    Date::setLocale(getLocale());
    $format = Date::parse($date)->format(Settings::dateFormats()[settings('general')->date_format]);
    return $format;
}

function generateUniqueFileName($file, $specificName = null)
{
    if (!empty($specificName)) {
        $filename = $specificName . '.' . $file->getClientOriginalExtension();
    } else {
        $filename = Str::random(15) . '_' . time() . '.' . $file->getClientOriginalExtension();
    }
    return $filename;
}

function imageUpload($image, $location, $size = null, $specificName = null, $old = null)
{
    makeDirectory(public_path($location));
    if (!empty($old)) {
        removeFile(public_path($old));
    }
    $filename = generateUniqueFileName($image, $specificName);
    if (!empty($size)) {
        $image = Image::make($image);
        $width = $image->width();
        $height = $image->height();
        $newSize = explode('x', strtolower($size));
        if ($newSize[0] != $width && $newSize[1] != $height) {
            $image->resize($newSize[0], $newSize[1]);
        }
        $image->save(public_path($location . $filename));
    } else {
        $image->move(public_path($location), $filename);
    }
    return $location . $filename;
}

function fileUpload($file, $location, $specificName = null, $old = null)
{
    makeDirectory(public_path($location));
    if (!empty($old)) {
        removeFile(public_path($old));
    }
    $filename = generateUniqueFileName($file, $specificName);
    $file->move(public_path($location), $filename);
    return $location . $filename;
}

function storageFileUpload($file, $location, $disk, $specificName = null, $old = null)
{
    if (!empty($old)) {
        removeFileFromStorage($disk, $old);
    }
    $filename = generateUniqueFileName($file, $specificName);
    $filePath = $location . $filename;
    Storage::disk($disk)->put($filePath, fopen($file, 'r+'));
    return $filePath;
}

function removeFileFromStorage($disk, $path)
{
    $disk = Storage::disk($disk);
    if ($disk->has($path)) {
        $disk->delete($path);
    }
    return true;
}

function removeFile($path)
{
    if (File::exists($path)) {
        File::delete($path);
    }
    return true;
}

function removeDirectory($path)
{
    if (File::exists($path)) {
        File::deleteDirectory($path);
    }
    return true;
}

function makeDirectory($path)
{
    if (!File::exists($path)) {
        File::makeDirectory($path, 0775, true);
    }
    return true;
}

function shortertext($text, $chars_limit)
{
    return Str::limit($text, $chars_limit, $end = '...');
}

function formatNumber($number)
{
    if ($number != 0) {
        $abbrevs = [12 => 'T', 9 => 'B', 6 => 'M', 3 => 'K', 0 => ''];
        foreach ($abbrevs as $exponent => $abbrev) {
            if (abs($number) >= pow(10, $exponent)) {
                $display = $number / pow(10, $exponent);
                $decimals = ($exponent >= 3 && round($display) < 100) ? 1 : 0;
                $number = number_format($display, $decimals) . $abbrev;
                break;
            }
        }
    }
    return $number;
}

function setEnv($key, $value, $quote = false)
{
    $env = new Dotenv();
    return $env->setKey($key, $value, $quote);
}

function localizationUrl($lang)
{
    if (settings('actions')->language_type) {
        return LaravelLocalization::getLocalizedURL($lang, null, [], true);
    } else {
        return route('localize', $lang);
    }
}

function getLocale()
{
    return App::getLocale();
}

function getSupportedLocales()
{
    $locales = [];
    foreach (Language::all() as $language) {
        $locales[$language->code] = [
            'name' => $language->name,
        ];
    }
    return $locales;
}

function translate($key, $group = null, $locale = null)
{
    $locale = $locale ?? getLocale();
    $group = $group ? Str::slug($group) : 'general';
    $strKey = Str::slug($key, '_');
    $activeTheme = activeTheme();
    $allLanguages = File::directories(base_path("lang/themes/{$activeTheme}"));
    foreach ($allLanguages as $language) {
        $groupPath = $language . '/' . $group . '.php';
        if (!File::exists($groupPath)) {
            File::put($groupPath, "<?php\n\nreturn [];\n");
        }
        $trans = include $groupPath;
        if (!array_key_exists($strKey, $trans)) {
            $trans[$strKey] = $key;
            File::put($groupPath, "<?php\n\nreturn " . var_export($trans, true) . ";\n");
        }
    }
    return trans("{$group}.{$strKey}", [], $locale);
}

function mailTemplate($alias)
{
    $mailTemplate = MailTemplate::where([['lang', getLocale()], ['alias', $alias]])->first();
    return $mailTemplate;
}

function replace_br($string)
{
    return preg_replace("/\r\n|\n|\r/", "<br/>", $string);
}

function pageTitle($env)
{
    $name = settings('general')->site_name;
    $title = null;
    $section = null;
    if ($env->yieldContent('section')) {
        $section = ' — ' . $env->yieldContent('section');
    }
    if ($env->yieldContent('title')) {
        $title = ' — ' . $env->yieldContent('title');
    }
    return $name . $section . $title;
}

function isAddonActive($alias)
{
    $addon = Addon::where('alias', $alias)->first();
    if ($addon) {
        if ($addon->hasNoStatus() || $addon->isActive()) {
            return true;
        }
    }
    return false;
}

function chartDates(Carbon $startDate, Carbon $endDate, $format = 'Y-m-d')
{
    $dates = collect();
    $startDate = $startDate->copy();
    for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
        $dates->put($date->format($format), 0);
    }
    return $dates;
}

function ipInfo()
{
    $lookupData = GeoIp::lookup();
    $lookupData['system']['os'] = OSDetector::os();
    $lookupData['system']['browser'] = BrowserDetector::browser();
    return json_decode(json_encode($lookupData), false);
}

function adminNotify($title, $image, $link = null)
{
    $notify = new AdminNotification();
    $notify->title = $title;
    $notify->image = $image;
    $notify->link = $link;
    $notify->save();
}

function deleteAdminNotification($link)
{
    $notifications = AdminNotification::where('link', $link)->get();
    if ($notifications->count() > 0) {
        foreach ($notifications as $notification) {
            $notification->delete();
        }
    }
}

function hashid($id, $connection = null)
{
    return ($connection) ? Hashids::connection($connection)->encode($id) : Hashids::encode($id);
}

function unhashid($id, $connection = null)
{
    return ($connection) ? Hashids::connection($connection)->decode($id) : Hashids::decode($id);
}

function subscription()
{
    $subscriptionManager = new SubscriptionManager();
    $subscription = $subscriptionManager->getSubscription();
    return json_decode(json_encode($subscription), false);
}

function paymentGateway($alias)
{
    $paymentGateway = PaymentGateway::where('alias', $alias)->active()->first();
    return $paymentGateway;
}

function formatPrice($price)
{
    return number_format((float) $price, 2, '.', '');
}

function price($price)
{
    return number_format($price, settings('currency')->prices_decimals);
}

function priceSymbol($price)
{
    if (settings('currency')->position == 1) {
        return settings('currency')->symbol . price($price);
    } else {
        return price($price) . settings('currency')->symbol;
    }
}

function priceCode($price)
{
    if (settings('currency')->position == 1) {
        return settings('currency')->code . ' ' . price($price);
    } else {
        return price($price) . ' ' . settings('currency')->code;
    }
}

function priceSymbolCode($price)
{
    if (settings('currency')->position == 1) {
        return settings('currency')->code . ' ' . settings('currency')->symbol . price($price);
    } else {
        return price($price) . settings('currency')->symbol . ' ' . settings('currency')->code;
    }
}

function earning($earning)
{
    return number_format($earning, settings('currency')->earnings_decimals);
}

function earnings($earnings)
{
    if (settings('currency')->position == 1) {
        return settings('currency')->symbol . earning($earnings);
    } else {
        return earning($earnings) . settings('currency')->symbol;
    }
}

function formatBytes($bytes, $precision = 2)
{
    if ($bytes) {
        $units = [translate('B', 'file system'), translate('KB', 'file system'), translate('MB', 'file system'),
            translate('GB', 'file system'), translate('TB', 'file system'), translate('PB', 'file system')];
        $index = floor(log($bytes, 1024));
        $size = round($bytes / pow(1024, $index), $precision);
        return sprintf('%s %s', $size, $units[$index]);

    }
    return $bytes;
}