<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::NotificationIndex()->get();

        return view('notification.index', [
            'notifications' => $notifications,
        ]);
    }
}
