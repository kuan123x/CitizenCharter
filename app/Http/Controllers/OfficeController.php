<?php

namespace App\Http\Controllers;

use App\Models\Office;
use Illuminate\Http\Request;

class OfficeController extends Controller
{
    public function index()
    {
        $offices = Office::all();
        return view('pages.offices', compact('offices'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'office_name' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
        ]);

        Office::create($validatedData);

        return redirect()->route('admin.offices.index')->with('success', 'Office added successfully.');
    }
}

