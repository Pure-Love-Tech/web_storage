<?php

namespace App\Providers;

use Illuminate\Translation\FileLoader;
use Illuminate\Translation\TranslationServiceProvider;
use Illuminate\Translation\Translator;

class TransServiceProvider extends TranslationServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerLoader();

        $this->app->singleton('translator', function ($app) {
            $loader = $app['translation.loader'];
            $locale = $app->getLocale();
            $trans = new Translator($loader, $locale);
            $trans->setFallback($app->getFallbackLocale());
            return $trans;
        });
    }

    /**
     * Register the translation line loader.
     *
     * @return void
     */
    protected function registerLoader()
    {
        $this->app->singleton('translation.loader', function ($app) {
            $activeTheme = activeTheme();
            $themeTranslationPath = base_path("lang/themes/{$activeTheme}");
            return new FileLoader($this->app['files'], $themeTranslationPath);
        });
    }
}
