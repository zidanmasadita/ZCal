<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $notifications = $user->notifications()->paginate(15);
        $user->unreadNotifications->markAsRead();

        return view('notifications.index', compact('notifications'));
    }
}
