<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Task;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display the admin dashboard (User Management).
     */
    public function index()
    {
        // Get all users
        $users = User::orderBy('created_at', 'desc')->get();
        
        // Get statistics
        $totalUsers = User::count();
        
        // Get active users (users who created tasks in the last 7 days)
        $activeUsers = User::whereHas('tasks', function ($query) {
            $query->where('created_at', '>=', Carbon::now()->subDays(7));
        })->count();
        
        // Get new users this month
        $newUsers = User::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();
        
        return view('admin.dashboard', compact(
            'users',
            'totalUsers',
            'activeUsers',
            'newUsers'
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
     * Update a user.
     */
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);
        
        $user->update([
            'username' => $request->username,
            'email' => $request->email,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully.',
            'user' => $user
        ]);
    }
    
    /**
     * Delete a user.
     */
    public function deleteUser(User $user)
    {
        // Prevent deleting admin users
        if ($user->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Cannot delete admin users.'
            ], 403);
        }
        
        // Delete user's tasks first
        $user->tasks()->delete();
        
        // Delete the user
        $user->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully.'
        ]);
    }
}
