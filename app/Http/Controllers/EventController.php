<?php

namespace App\Http\Controllers;

use App\Models\Event;
// use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\EventCreatedNotification;
use App\Notifications\EventStatusNotification;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;

class EventController extends Controller
{
    public function index()
    {
        // Fetch all approved events
        $approvedEvents = Event::where('status', 'approved')->get();
        return view('pages.events', compact('approvedEvents'));
    }

//     public function store(Request $request)
// {

//     $request->validate([
//         'title' => 'required|string|max:255',
//         'description' => 'required|string',
//         'image' => 'required|url',
//     ]);

//     try {

//         $event = new Event();
//         $event->title = $request->title;
//         $event->description = $request->description;
//         $event->image = $request->image;
//         $event->status = 'pending';
//         $event->user_id = auth()->id();
//         $event->save();

//         return redirect()->route('events.page')->with('success', 'Event created and waiting for approval.');
//     } catch (\Exception $e) {
//         return redirect()->back()->with('error', 'Failed to create event.');
//     }
// }
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'required|url',
    ]);

    try {
        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->image = $request->image;

        // Check user role
        if (auth()->user()->hasRole('admin')) {
            $event->status = 'approved'; // Admins directly approve their events
        } else if (auth()->user()->hasRole('head')) {
            $event->status = 'pending'; // Heads need approval
        }

        $event->user_id = auth()->id();
        $event->save();

        // Notify admins if it's pending
        if ($event->status === 'pending') {
            $admins = User::role('admin')->get();
            foreach ($admins as $admin) {
                $admin->notify(new EventCreatedNotification($event));
            }
        }

        return redirect()->route('events.page')->with('success', 'Event created successfully.' . ($event->status === 'pending' ? ' Waiting for approval.' : ''));
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to create event.');
    }
}


    public function showPendingEvents()
    {
        // Fetch pending events for the admin to approve or reject
        $pendingEvents = Event::where('status', 'pending')->get();
        return view('pendings-folder.pending-events', compact('pendingEvents'));
    }

    // public function approveEvent($id)
    // {

    //     $event = Event::findOrFail($id);
    //     $event->status = 'approved';
    //     $event->save();

    //     return redirect()->route('pending.events')->with('success', 'Event approved successfully.');
    // }

    // public function rejectEvent($id)
    // {

    //     $event = Event::findOrFail($id);
    //     $event->status = 'rejected';
    //     $event->save();

    //     return redirect()->route('pending.events')->with('success', 'Event rejected successfully.');
    // }
    public function approveEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'approved';
        $event->save();

        // Notify the user who created the event
        $user = User::find($event->user_id);
        $user->notify(new EventStatusNotification($event, 'approved'));

        return redirect()->route('pending.events')->with('success', 'Event approved successfully.');
    }

    public function rejectEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        // Notify the user who created the event
        $user = User::find($event->user_id);
        $user->notify(new EventStatusNotification($event, 'rejected'));

        return redirect()->route('pending.events')->with('success', 'Event rejected successfully.');
    }

//     public function notifications()
// {
//     $notifications = auth()->user()->notifications()->orderBy('created_at', 'desc')->get();
//     return view('notifications.index', compact('notifications'));
// }

// public function markAsRead($id)
// {
//     // Fetch the notification for the authenticated user
//     $notification = Auth::user()->notifications()->findOrFail($id);

//     // Mark the notification as read
//     $notification->markAsRead(); // This is the method that marks the notification as read

//     return redirect()->back();
// }

public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'required|url',
    ]);

    try {
        $event = Event::findOrFail($id);
        $event->title = $request->title;
        $event->description = $request->description;
        $event->image = $request->image;
        $event->save();

        return redirect()->route('events.page')->with('success', 'Event updated successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to update event.');
    }
}

public function destroy($id)
{
    try {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('events.page')->with('success', 'Event deleted successfully.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Failed to delete event.');
    }
}



}
