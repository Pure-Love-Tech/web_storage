<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::where('lang', getLocale())->active()->orderbyDesc('id')->get();
        return theme_view('user.announcements', ['announcements' => $announcements]);
    }
}
