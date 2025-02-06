<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function index()
    {
        $notes = auth()->user()->notes()->latest()->get();
        return view('dashboard', compact('notes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required|min:10',
        ], [
            'title.required' => 'The note title is required.',
            'title.max' => 'The note title must not exceed 255 characters.',
            'content.required' => 'The note content is required.',
            'content.min' => 'The note content must be at least 10 characters.',
        ]);

        auth()->user()->notes()->create($request->all());

        return redirect()->route('dashboard')->with('success', 'Note created successfully.');
    }

    public function update(Request $request, Note $note)
    {
        $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
        ]);

        $note->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Note updated successfully.');
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return redirect()->route('dashboard')->with('success', 'Note deleted successfully.');
    }
}