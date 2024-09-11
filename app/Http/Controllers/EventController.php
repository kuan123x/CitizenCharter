<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{

    public function index()
    {
        // Fetch all events or manually define which are considered approved
        $approvedEvents = Event::all(); // or manually select events

        return view('events.index', compact('approvedEvents'));
    }

public function create()
{
    return view('events.create');
}

// Store the new event in the database
public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'image' => 'nullable|image|max:2048', // Optional image upload
    ]);

    // Handle the event creation logic
    $event = new Event();
    $event->title = $request->title;
    $event->description = $request->description;

    if ($request->hasFile('image')) {
        $event->image = $request->file('image')->store('events', 'public');
    }

    $event->save();

    return redirect()->route('events.page')->with('success', 'Event created successfully!');
}

public function showPendingEvents()
{
    $pendingEvents = Event::where('status', 'pending')->get();

    return view('pendings-folder.pending-events', compact('pendingEvents'));
}


    // Show pending events for admin to approve/reject
    public function pendingEvents()
    {
        $pendingEvents = Event::pending()->get(); // Get pending events
        return view('pendings-folder.pending-events', compact('pendingEvents'));
    }

    // Approve an event
    public function approveEvent($id)
{
    $event = Event::find($id);
    $event->status = 'approved';
    $event->save();

    return redirect()->route('pending.events')->with('success', 'Event approved successfully');
}


    // Reject an event
    public function rejectEvent($id)
    {
        $event = Event::find($id);
        $event->status = 'rejected';
        $event->save();

        return redirect()->route('pending.events')->with('success', 'Event rejected successfully');
    }
}
