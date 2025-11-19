@extends('layouts.app')

@section('title', 'Dashboard - DailyDo')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Welcome back, {{ auth()->user()->first_name }}!</h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                    <h3 class="card-title">{{ $totalTasks }}</h3>
                    <p class="card-text text-muted">Total Tasks</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h3 class="card-title">{{ $pendingTasks }}</h3>
                    <p class="card-text text-muted">Pending</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3 class="card-title">{{ $completedTasks }}</h3>
                    <p class="card-text text-muted">Completed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                    <h3 class="card-title">{{ $overdueTasks }}</h3>
                    <p class="card-text text-muted">Overdue</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Tasks -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Tasks</h5>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Task
                    </a>
                </div>
                <div class="card-body">
                    @if($recentTasks->count() > 0)
                        @foreach($recentTasks as $task)
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                                <div>
                                    <h6 class="mb-1 {{ $task->completed ? 'task-completed' : '' }}">
                                        {{ $task->title }}
                                    </h6>
                                    <small class="text-muted">
                                        <span class="priority-{{ $task->priority }}">
                                            <i class="fas fa-circle"></i> {{ ucfirst($task->priority) }}
                                        </span>
                                        @if($task->deadline)
                                            | Due: {{ $task->formatted_deadline }}
                                        @endif
                                    </small>
                                </div>
                                <div>
                                    @if($task->completed)
                                        <span class="badge bg-success">Completed</span>
                                    @else
                                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-primary btn-sm">View</a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary">View All Tasks</a>
                        </div>
                    @else
                        <p class="text-muted text-center">No tasks yet. <a href="{{ route('tasks.create') }}">Create your first task!</a></p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Upcoming Deadlines</h5>
                </div>
                <div class="card-body">
                    @if($upcomingDeadlines->count() > 0)
                        @foreach($upcomingDeadlines as $task)
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                                <div>
                                    <h6 class="mb-1">{{ $task->title }}</h6>
                                    <small class="text-muted">
                                        Due: {{ $task->formatted_deadline }}
                                        <span class="priority-{{ $task->priority }}">
                                            | {{ ucfirst($task->priority) }} Priority
                                        </span>
                                    </small>
                                </div>
                                <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-primary btn-sm">View</a>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">No upcoming deadlines</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Overview -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Progress Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h4 class="text-success">{{ $completionRate }}%</h4>
                            <p class="text-muted">Completion Rate</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-danger">{{ $highPriorityTasks }}</h4>
                            <p class="text-muted">High Priority</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-warning">{{ $mediumPriorityTasks }}</h4>
                            <p class="text-muted">Medium Priority</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-success">{{ $lowPriorityTasks }}</h4>
                            <p class="text-muted">Low Priority</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
