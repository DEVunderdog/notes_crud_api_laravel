<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\NotesController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:api');

Route::post("register", [ApiController::class, "register"]);
Route::post("login", [ApiController::class, "login"]);


Route::group([
    "middleware" => ["auth:api"]
], function () {
    Route::get("profile", [ApiController::class, "profile"]);
    Route::get("logout", [ApiController::class, "logout"]);
    Route::post("notes", [NotesController::class, "createNote"]);
    Route::get("notes", [NotesController::class, "getNotes"]);
    Route::get("notes/{id}", [NotesController::class, "getNotesWithID"]);
    Route::put("notes/{id}", [NotesController::class, "updateNote"]);
    Route::delete("notes/{id}", [NotesController::class, "deleteNote"]);
});
