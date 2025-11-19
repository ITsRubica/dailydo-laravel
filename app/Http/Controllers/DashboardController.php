<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get task statistics
        $totalTasks = $user->tasks()->count();
        $pendingTasks = $user->tasks()->pending()->count();
        $completedTasks = $user->tasks()->completed()->count();
        $overdueTasks = $user->tasks()
            ->pending()
            ->where('deadline', '<', Carbon::now())
            ->count();
        
        // Get recent tasks
        $recentTasks = $user->tasks()
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get upcoming deadlines
        $upcomingDeadlines = $user->tasks()
            ->pending()
            ->whereNotNull('deadline')
            ->where('deadline', '>', Carbon::now())
            ->orderBy('deadline', 'asc')
            ->limit(5)
            ->get();
        
        // Get tasks by priority
        $highPriorityTasks = $user->tasks()->pending()->byPriority('high')->count();
        $mediumPriorityTasks = $user->tasks()->pending()->byPriority('medium')->count();
        $lowPriorityTasks = $user->tasks()->pending()->byPriority('low')->count();
        
        // Calculate completion rate
        $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
        
        return view('dashboard', compact(
            'totalTasks',
            'pendingTasks',
            'completedTasks',
            'overdueTasks',
            'recentTasks',
            'upcomingDeadlines',
            'highPriorityTasks',
            'mediumPriorityTasks',
            'lowPriorityTasks',
            'completionRate'
        ));
    }
}
