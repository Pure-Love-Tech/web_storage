<script>
    "use strict";
    const downloadConfig = {!! json_encode([
        'id' => $fileEntry->sharedId(),
        'captcha' => $settings->general->default_captcha ? ($downloadPlan->download_captcha ? 1 : 0) : 0,
        'adb' => $downloadPlan->advertisements ? intval($settings->general->adblock_detection) : '',
        'counter_time' => $downloadPlan->download_waiting_time ?? 0,
        'trans' => [
            'captcha_required' => translate('The captcha is required', 'download pages'),
            'adblock_alert' => translate('Adblock detected! Please disable it to continue', 'download pages'),
            'download_button_text' => translate('Click Here to Download', 'download pages'),
            'generating_button_text' => translate('Generating...', 'download pages'),
        ],
    ]) !!}
</script>
