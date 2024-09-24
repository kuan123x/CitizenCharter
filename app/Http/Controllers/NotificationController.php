<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
class NotificationController extends Controller
{
    public function index()
{
    $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();
    return view('notifications.index', compact('notifications'));
}


    // Mark a notification as read
    public function markAsRead($id)
{
    $notification = Auth::user()->notifications()->findOrFail($id);
    $notification->markAsRead(); // Set the read_at timestamp

    return redirect()->back()->with('success', 'Notification marked as read.');
}


    public function markAllAsRead()
{
    $user = Auth::user();
    $user->unreadNotifications->markAsRead();

    return redirect()->back()->with('success', 'All notifications marked as read.');
}

}
