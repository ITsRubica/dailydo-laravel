@extends('layouts.app')

@section('title', 'My Profile - DailyDo')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body text-center">
                    @if($user->profile_picture)
                        <img src="{{ asset('storage/' . $user->profile_picture) }}" 
                             alt="Profile Picture" class="rounded-circle mb-3" width="150" height="150">
                    @else
                        <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                             style="width: 150px; height: 150px;">
                            <i class="fas fa-user fa-4x text-white"></i>
                        </div>
                    @endif
                    <h4>{{ $user->full_name }}</h4>
                    <p class="text-muted">{{ '@' . $user->username }}</p>
                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'primary' }}">
                        {{ ucfirst($user->role) }}
                    </span>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Task Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <h4 class="text-primary">{{ $user->tasks_count }}</h4>
                            <small class="text-muted">Total</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-success">{{ $user->completed_tasks_count }}</h4>
                            <small class="text-muted">Completed</small>
                        </div>
                        <div class="col-4">
                            <h4 class="text-warning">{{ $user->pending_tasks_count }}</h4>
                            <small class="text-muted">Pending</small>
                        </div>
                    </div>
                    @if($user->overdue_tasks_count > 0)
                        <div class="text-center mt-3">
                            <h5 class="text-danger">{{ $user->overdue_tasks_count }}</h5>
                            <small class="text-muted">Overdue</small>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Profile Information</h5>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit me-1"></i>Edit Profile
                    </a>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>First Name:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->first_name }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Last Name:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->last_name }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Username:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->username }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Email:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->email }}
                        </div>
                    </div>
                    @if($user->bio)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Bio:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $user->bio }}
                            </div>
                        </div>
                    @endif
                    @if($user->interests)
                        <div class="row mb-3">
                            <div class="col-sm-3">
                                <strong>Interests:</strong>
                            </div>
                            <div class="col-sm-9">
                                {{ $user->interests }}
                            </div>
                        </div>
                    @endif
                    <div class="row mb-3">
                        <div class="col-sm-3">
                            <strong>Member Since:</strong>
                        </div>
                        <div class="col-sm-9">
                            {{ $user->created_at->format('M j, Y') }}
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Recent Tasks</h5>
                </div>
                <div class="card-body">
                    @if($recentTasks->count() > 0)
                        @foreach($recentTasks as $task)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <div>
                                    <h6 class="mb-1 {{ $task->completed ? 'task-completed' : '' }}">
                                        {{ $task->title }}
                                    </h6>
                                    <small class="text-muted">
                                        {{ $task->created_at->diffForHumans() }}
                                        @if($task->deadline)
                                            • Due: {{ $task->formatted_deadline }}
                                        @endif
                                    </small>
                                </div>
                                <div>
                                    <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }}">
                                        {{ ucfirst($task->priority) }}
                                    </span>
                                    @if($task->completed)
                                        <span class="badge bg-success ms-1">Done</span>
                                    @elseif($task->isOverdue())
                                        <span class="badge bg-danger ms-1">Overdue</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        <div class="text-center mt-3">
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-primary btn-sm">
                                View All Tasks
                            </a>
                        </div>
                    @else
                        <p class="text-muted text-center">No tasks yet. <a href="{{ route('tasks.create') }}">Create your first task!</a></p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
