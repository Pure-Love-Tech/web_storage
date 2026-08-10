<?php

namespace App\View\Components\Backend;

use App\Methods\ReCaptchaValidation;
use Illuminate\View\Component;

class Captcha extends Component
{
    public function render()
    {
        if (extension('google_recaptcha')->status) {
            $display = ReCaptchaValidation::display();
            $scripts = ReCaptchaValidation::defaultCaptchaLibrary();
            return view('backend.components.captcha', [
                'display' => $display,
                'scripts' => $scripts,
            ]);
        }
    }
}
