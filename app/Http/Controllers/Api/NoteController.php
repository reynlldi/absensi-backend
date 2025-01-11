<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    // index
    public function index(Request $request)
    {
        $notes = Note::where('users_id', $request->user()->id)->orderBy('id', 'desc')->get();
        return response(['notes' => $notes], 200);
    }

    // create note
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'note' => 'required',
        ]);

        $notes = new Note();
        $notes->users_id = $request->user()->id;
        $notes->title = $request->title;
        $notes->note = $request->note;
        $notes->save();

        return response(['message' => 'Note created successfully'], 201);
    }
}