<?php

namespace App\View\Components;

use App\Methods\ReCaptchaValidation;
use Illuminate\View\Component;

class Captcha extends Component
{
    public $callback = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($callback = [])
    {
        $this->callback = $callback;
    }

    public function render()
    {
        if (extension('google_recaptcha')->status) {
            $display = ReCaptchaValidation::display($this->callback);
            $scripts = ReCaptchaValidation::defaultCaptchaLibrary();
            return theme_view('components.captcha', [
                'display' => $display,
                'scripts' => $scripts,
            ]);
        }
    }
}