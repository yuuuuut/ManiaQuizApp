<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('visited_id', Auth::id())->get();

        return view('notification.index', [
            'notifications' => $notifications,
        ]);
    }
}
