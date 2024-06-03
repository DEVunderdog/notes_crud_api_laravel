<?php

namespace App\Services;

use App\Models\Note;

class NoteService
{

    public function create($userId, $title, $description)
    {
        return Note::create([
            'user_id' => $userId,
            'title' => $title,
            'description' => $description
        ]);
    }

    public function getAll($userId, $limit, $offset)
    {

        return Note::where('user_id', $userId)
            ->skip($offset)
            ->take($limit)
            ->get();

        // OR
        /*
            return Note::where('user_id', $userId)
                ->paginate($limit);
        */
    }

    public function getOne($userId, $id)
    {
        return Note::where('user_id', $userId)->find($id);
    }

    public function update($userId, $id, $title, $description)
    {
        $note = Note::where('user_id', $userId)->find($id);

        if ($note) {
            $note->update([
                'title' => $title,
                'description' => $description
            ]);
        }

        return $note;
    }

    public function delete($userId, $id)
    {

        $note = Note::where('user_id', $userId)->find($id);

        if ($note) {
            $note->delete();
        }

        return $note;
    }
}
