<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\AdminNotification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::orderbyDesc('id')->paginate(10);
        $unreadNotificationsCount = AdminNotification::where('status', 0)->get()->count();
        return view('backend.notifications.index', ['notifications' => $notifications, 'unreadNotificationsCount' => $unreadNotificationsCount]);
    }

    public function show(AdminNotification $notification)
    {
        $updateStatus = $notification->update(['status' => true]);
        if ($updateStatus) {
            return redirect($notification->link);
        }
    }

    public function readAll()
    {
        $notifications = AdminNotification::where('status', 0)->get();
        if ($notifications->count() == 0) {
            toastr()->error(admin_trans('No unread notifications available'));
            return back();
        }
        foreach ($notifications as $notification) {
            $notification->update(['status' => 1]);
        }
        toastr()->success(admin_trans('All notifications has been read successfully'));
        return back();
    }

    public function deleteAllRead()
    {
        $notifications = AdminNotification::where('status', 1)->get();
        if ($notifications->count() == 0) {
            toastr()->error(admin_trans('No read notifications available'));
            return back();
        }
        foreach ($notifications as $notification) {
            $notification->delete();
        }
        toastr()->success(admin_trans('Deleted Successfully'));
        return back();
    }
}
