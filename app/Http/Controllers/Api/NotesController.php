<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Note;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    public function createNote(Request $request){
        $request->validate([
            "title"=>"required|string",
            "description"=>"required|string"
        ]);

        $note = auth()->user()->notes()->create($request->all());

        return response()->json([
            "status" => true,
            "message" => "Note created successfully",
            "data" => $note
        ]);
    }

    public function getNotes(){
        $notes = auth()->user()->notes;

        return response()->json([
            "status" => true,
            "message" => "Notes fetched successfully",
            "data" => $notes
        ]);
    }

    public function getNotesWithID($id){
        $note = auth()->user()->notes()->find($id);

        if (!$note){
            return response()->json([
                "status" => false,
                "message" => "Not not found"
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Note fetched successfully",
            "data" => $note
        ]);
    }

    public function updateNote(Request $request, $id){
        $request->validate([
            "title" => "required|string",
            "description" => "required|string"
        ]);

        $note = auth()->user()->notes()->find($id);

        if(!$note) {
            return response() -> json([
                "status" => false,
                "message" => "Note not found",
            ], 404);
        }

        $note -> update($request->all());

        return response()->json([
            "status" => true,
            "message" => "Note updated successfully",
            "data" => $note
        ]);

    }

    public function deleteNote($id){
        $note = auth()->user()->notes()->find($id);

        if(!$note){
            return response()->json([
                "status" => false,
                "message" => "Note not found",
            ], 404);
        }

        $note->delete();

        return response()->json([
            "status" => true,
            "message" => "Note deleted successfully",
        ]);
    }
}
