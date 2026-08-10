<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BlogArticle;
use App\Models\Faq;
use App\Models\Feature;
use App\Models\Step;
use App\Models\WithdrawalMethod;

class HomeController extends Controller
{
    public function index()
    {
        $features = themeSettings('home_page')->features_section ? Feature::where('lang', getLocale())->get() : null;
        $steps = themeSettings('home_page')->steps_section ? Step::where('lang', getLocale())->get() : null;
        $faqs = themeSettings('home_page')->faqs_section ? Faq::where('lang', getLocale())->get() : null;
        $blogArticles = null;
        if (themeSettings('home_page')->blog_section && settings('actions')->blog_status) {
            $blogArticles = BlogArticle::where('lang', getLocale())->latest('id')->limit(3)->get();
        }
        $withdrawalMethods = themeSettings('home_page')->withdrawal_methods_section ? WithdrawalMethod::active()->orderBy('sort_id')->get() : null;
        return theme_view('home', [
            'features' => $features,
            'steps' => $steps,
            'faqs' => $faqs,
            'blogArticles' => $blogArticles,
            'withdrawalMethods' => $withdrawalMethods,
        ]);
    }

}
