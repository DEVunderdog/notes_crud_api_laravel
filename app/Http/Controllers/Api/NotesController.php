<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\NoteService;
use Illuminate\Http\Request;

class NotesController extends Controller
{
    protected $noteService;

    public function __construct(NoteService $noteService)
    {
        $this->noteService = $noteService;
    }

    public function createNote(Request $request)
    {
        $request->validate([
            "title" => "required|string",
            "description" => "required|string"
        ]);

        $note = $this->noteService->create(
            auth()->id(),
            $request->input('title'),
            $request->input('description')
        );

        return response()->json([
            "status" => true,
            "message" => "Note created successfully",
            "data" => $note
        ]);
    }

    public function getNotes(Request $request)
    {
        $limit = $request->query('limit', 10);
        $offset = $request->query('offset', 0);
        
        $notes = $this->noteService->getAll(
            auth()->id(),
            $limit,
            $offset
        );

        return response()->json([
            "status" => true,
            "message" => "Fetched all Notes",
            "data" => $notes
        ]);

    }

    public function getNotesWithID($id)
    {
        $note = $this->noteService->getOne(
            auth()->id(),
            $id
        );

        if (!$note) {
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

    public function updateNote(Request $request, $id)
    {
        $request->validate([
            "title" => "required|string",
            "description" => "required|string"
        ]);

        $note = $this->noteService->update(
            auth()->id(),
            $id,
            $request->input('title'),
            $request->input('description')
        );

        if (!$note) {
            return response()->json([
                "status" => false,
                "message" => "Note not found",
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Note updated successfully",
            "data" => $note
        ]);
    }

    public function deleteNote($id)
    {
        $note = $this->noteService->delete(
            auth()->id(),
            $id
        );

        if (!$note) {
            return response()->json([
                "status" => false,
                "message" => "Note not found",
            ], 404);
        }

        return response()->json([
            "status" => true,
            "message" => "Note deleted successfully",
        ]);
    }
}
