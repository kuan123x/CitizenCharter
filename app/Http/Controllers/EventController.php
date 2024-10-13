<?php

namespace App\Http\Controllers;

use App\Models\Event;
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
        } elseif (auth()->user()->hasRole('head')) {
            $event->status = 'pending'; // Heads need approval
        }

        $event->user_id = auth()->id();
        $event->save();

        // Notify admins if the event is pending
        if ($event->status === 'pending') {
            $admins = User::role('admin')->get();
            if ($admins->isNotEmpty()) {
                Notification::send($admins, new EventCreatedNotification($event));
                Log::info('Notification sent to admins for event: ' . $event->id);
            } else {
                Log::warning('No admin users found to notify.');
            }
        }

        return redirect()->route('events.page')->with('success', 'Event created successfully.' . ($event->status === 'pending' ? ' Waiting for approval.' : ''));
    } catch (\Exception $e) {
        Log::error('Error creating event: ' . $e->getMessage());
        return redirect()->back()->with('error', 'Failed to create event.');
    }
}


    public function showPendingEvents()
    {
        // Fetch pending events for the admin to approve or reject
        $pendingEvents = Event::where('status', 'pending')->get();
        return view('pendings-folder.pending-events', compact('pendingEvents'));
    }

    public function approveEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'approved';
        $event->save();

        // Notify the user who created the event
        $user = User::find($event->user_id);
        if ($user) {
            $user->notify(new EventStatusNotification($event, 'approved'));
            Log::info('User notified for event approval: ' . $event->id);
        } else {
            Log::warning('User not found for event approval notification: ' . $event->id);
        }

        return redirect()->route('pending.events')->with('success', 'Event approved successfully.');
    }

    public function rejectEvent($id)
    {
        $event = Event::findOrFail($id);
        $event->status = 'rejected';
        $event->save();

        // Notify the user who created the event
        $user = User::find($event->user_id);
        if ($user) {
            $user->notify(new EventStatusNotification($event, 'rejected'));
            Log::info('User notified for event rejection: ' . $event->id);
        } else {
            Log::warning('User not found for event rejection notification: ' . $event->id);
        }

        return redirect()->route('pending.events')->with('success', 'Event rejected successfully.');
    }



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
            Log::error($e->getMessage());
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
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'Failed to delete event.');
        }
    }
}
