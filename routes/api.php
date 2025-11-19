<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public API routes
Route::post('/login', [AuthController::class, 'apiLogin']);
Route::post('/register', [AuthController::class, 'apiRegister']);

// Protected API routes
Route::middleware('auth:sanctum')->group(function () {
    // User info
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Logout
    Route::post('/logout', [AuthController::class, 'apiLogout']);
    
    // Tasks API
    Route::apiResource('tasks', TaskController::class);
    Route::patch('/tasks/{task}/toggle', [TaskController::class, 'toggleComplete']);
    Route::get('/tasks/statistics', [TaskController::class, 'statistics']);
    
    // Search and filter
    Route::get('/search/tasks', function (Request $request) {
        $query = $request->get('q');
        $priority = $request->get('priority');
        $status = $request->get('status');
        
        $tasks = auth()->user()->tasks();
        
        if ($query) {
            $tasks->search($query);
        }
        
        if ($priority) {
            $tasks->byPriority($priority);
        }
        
        if ($status === 'completed') {
            $tasks->completed();
        } elseif ($status === 'pending') {
            $tasks->pending();
        }
        
        return $tasks->orderBy('created_at', 'desc')->paginate(10);
    });
});
