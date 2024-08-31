<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use App\Models\Office;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'office_id' => 'required|exists:offices,id',
            'comment'   => 'required|string',
        ]);

        Feedback::create([
            'office_id' => $request->office_id,
            'comment'   => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Feedback submitted successfully.');
    }

    public function reply(Request $request, Feedback $feedback)
    {
        $request->validate([
            'reply' => 'required|string',
        ]);

        $feedback->update([
            'reply' => $request->reply,
        ]);

        return redirect()->back()->with('success', 'Reply submitted successfully.');
    }

    public function index()
    {
        $offices = Office::all();
        $feedbacks = Feedback::with('office')->get();

        return view('feedbacks.index', compact('offices', 'feedbacks'));
    }
}
