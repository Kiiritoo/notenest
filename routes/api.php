<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Note;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::get('/users/{user}/notes', function (User $user) {
        abort_if(!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin(), 403);
        
        return response()->json([
            'notes' => $user->notes()->latest()->get()->map(function ($note) {
                return [
                    'id' => $note->id,
                    'title' => $note->title,
                    'content' => $note->content,
                    'created_at' => $note->created_at->format('M d, Y H:i')
                ];
            })
        ]);
    });
    Route::get('/notes/{note}', function (Note $note) {
        abort_if(!auth()->user()->isAdmin() && !auth()->user()->isSuperAdmin() && auth()->id() !== $note->user_id, 403);
        
        return response()->json([
            'note' => [
                'id' => $note->id,
                'title' => $note->title,
                'content' => $note->content,
                'created_at' => $note->created_at->format('M d, Y H:i'),
                'user' => [
                    'name' => $note->user->name
                ]
            ]
        ]);
    });
});

Route::get('/contoh', [NoteController::class, 'contoh']);