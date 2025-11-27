<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    /**
     * Display a listing of the tasks.
     */
    public function index(Request $request)
    {
        $query = Auth::user()->tasks()->latest();

        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply priority filter
        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        // Apply status filter
        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->completed();
            } elseif ($request->status === 'pending') {
                $query->pending();
            }
        }

        $tasks = $query->paginate(10);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'tasks' => $tasks
            ]);
        }

        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new task.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created task in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:low,medium,high',
            'deadline' => 'nullable|date',
            'reminder' => 'boolean',
            'reminder_time' => 'nullable|integer|min:1|max:1440',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $task = Auth::user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority ?? 'medium',
            'deadline' => $request->deadline,
            'reminder' => $request->boolean('reminder'),
            'reminder_time' => $request->reminder_time ?? 15,
            'status' => 'pending',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task created successfully',
                'task' => $task
            ], 201);
        }

        return redirect()->route('tasks.index')->with('success', 'Task created successfully!');
    }

    /**
     * Display the specified task.
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'task' => $task
            ]);
        }

        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified task.
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        // Return JSON for AJAX requests
        if (request()->expectsJson() || request()->ajax() || request()->wantsJson()) {
            return response()->json($task);
        }

        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified task in storage.
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:low,medium,high',
            'deadline' => 'nullable|date',
            'reminder' => 'boolean',
            'reminder_time' => 'nullable|integer|min:1|max:1440',
            'status' => 'nullable|in:pending,completed',
        ]);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }
            return back()->withErrors($validator)->withInput();
        }

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'deadline' => $request->deadline,
            'reminder' => $request->boolean('reminder'),
            'reminder_time' => $request->reminder_time ?? 15,
            'status' => $request->status ?? $task->status,
            'completed' => $request->status === 'completed',
        ]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task updated successfully',
                'task' => $task->fresh()
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully!');
    }

    /**
     * Remove the specified task from storage.
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        if (request()->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Task deleted successfully'
            ]);
        }

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully!');
    }

    /**
     * Toggle task completion status.
     */
    public function toggleComplete(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        // Check if status is provided in request
        if ($request->has('status')) {
            $newStatus = $request->input('status');
            if ($newStatus === 'completed') {
                $task->markAsCompleted();
                $message = 'Task marked as completed';
            } else {
                $task->markAsPending();
                $message = 'Task marked as pending';
            }
        } else {
            // Toggle based on current status
            if ($task->status === 'completed') {
                $task->markAsPending();
                $message = 'Task marked as pending';
            } else {
                $task->markAsCompleted();
                $message = 'Task marked as completed';
            }
        }

        // Always return JSON for AJAX requests
        if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'task' => $task->fresh()
            ]);
        }

        return back()->with('success', $message);
    }

    /**
     * Get task statistics for dashboard.
     */
    public function statistics()
    {
        $user = Auth::user();
        
        $stats = [
            'total' => $user->tasks()->count(),
            'pending' => $user->tasks()->pending()->count(),
            'completed' => $user->tasks()->completed()->count(),
            'overdue' => $user->tasks()->pending()->where('deadline', '<', now())->count(),
            'high_priority' => $user->tasks()->pending()->byPriority('high')->count(),
        ];

        return response()->json([
            'success' => true,
            'statistics' => $stats
        ]);
    }
}
