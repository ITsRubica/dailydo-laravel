<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // Get system statistics
        $totalUsers = User::count();
        $totalTasks = Task::count();
        $completedTasks = Task::where('completed', true)->count();
        $pendingTasks = Task::where('completed', false)->count();
        $overdueTasks = Task::where('completed', false)
            ->where('deadline', '<', Carbon::now())
            ->count();
        
        // Get recent users
        $recentUsers = User::orderBy('created_at', 'desc')->limit(5)->get();
        
        // Get recent tasks
        $recentTasks = Task::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        
        // Get user activity (users who created tasks in the last 7 days)
        $activeUsers = User::whereHas('tasks', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        })->count();
        
        // Calculate completion rate
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
        
        return view('admin.dashboard', compact(
            'totalUsers',
            'totalTasks',
            'completedTasks',
            'pendingTasks',
            'overdueTasks',
            'recentUsers',
            'recentTasks',
            'activeUsers',
            'completionRate'
        ));
    }

    /**
     * Display all users.
     */
    public function users(Request $request)
    {
        $query = User::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%");
            });
        }
        
        // Filter by role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->withCount(['tasks', 'tasks as completed_tasks_count' => function ($q) {
            $q->where('completed', true);
        }])->orderBy('created_at', 'desc')->paginate(15);
        
        return view('admin.users', compact('users'));
    }

    /**
     * Display all tasks.
     */
    public function tasks(Request $request)
    {
        $query = Task::with('user');
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('username', 'like', "%{$search}%");
                  });
            });
        }
        
        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'completed') {
                $query->where('completed', true);
            } elseif ($request->status === 'pending') {
                $query->where('completed', false);
            } elseif ($request->status === 'overdue') {
                $query->where('completed', false)
                      ->where('deadline', '<', Carbon::now());
            }
        }
        
        // Filter by priority
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }
        
        $tasks = $query->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.tasks', compact('tasks'));
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user)
    {
        // Prevent deleting admin users
        if ($user->isAdmin()) {
            return back()->withErrors(['error' => 'Cannot delete admin users.']);
        }
        
        // Delete user's tasks first
        $user->tasks()->delete();
        
        // Delete the user
        $user->delete();
        
        return back()->with('success', 'User deleted successfully.');
    }
}
