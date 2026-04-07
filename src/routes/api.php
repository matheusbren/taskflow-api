<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\ProfileController;

// Rotas de Projects
Route::prefix('projects')->group(function () {
    Route::get('/', [ProjectController::class, 'index']);
    Route::post('/', [ProjectController::class, 'store']);
    Route::get('/{id}', [ProjectController::class, 'show']);
    Route::put('/{id}', [ProjectController::class, 'update']);
    Route::delete('/{id}', [ProjectController::class, 'destroy']);
});

// Rotas aninhadas de Tasks
Route::prefix('projects/{id}')->group(function () {
    Route::get('/tasks', [TaskController::class, 'index']);
    Route::post('/tasks', [TaskController::class, 'store']);
    Route::get('/tasks/{taskId}', [TaskController::class, 'show']);
    Route::put('/tasks/{taskId}', [TaskController::class, 'update']);
    Route::patch('/tasks/{taskId}/status', [TaskController::class, 'updateStatus']);
    Route::delete('/tasks/{taskId}', [TaskController::class, 'destroy']);
});

// Rotas de Tags
Route::prefix('tags')->group(function () {
    Route::get('/', [TagController::class, 'index']);
    Route::post('/', [TagController::class, 'store']);
});

// Rotas de Associação Task-Tag
Route::post('/tasks/{taskId}/tags/{tagId}', [TaskController::class, 'attachTag']);
Route::delete('/tasks/{taskId}/tags/{tagId}', [TaskController::class, 'detachTag']);

// Rotas de Profile
Route::prefix('users/{id}')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show']);
    Route::put('/profile', [ProfileController::class, 'update']);
});