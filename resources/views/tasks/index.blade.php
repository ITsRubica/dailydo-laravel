@extends('layouts.app')

@section('title', 'My Tasks - DailyDo')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>My Tasks</h1>
                <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Task
                </a>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <form method="GET" action="{{ route('tasks.index') }}" class="row g-3">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" 
                                   placeholder="Search tasks..." value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="priority">
                                <option value="">All Priorities</option>
                                <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select class="form-select" name="status">
                                <option value="">All Status</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-search me-1"></i>Filter
                            </button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('tasks.index') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-times me-1"></i>Clear
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tasks List -->
    <div class="row">
        <div class="col-12">
            @if($tasks->count() > 0)
                @foreach($tasks as $task)
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="card-title mb-1 {{ $task->completed ? 'task-completed' : '' }}">
                                        {{ $task->title }}
                                    </h5>
                                    <p class="card-text text-muted mb-2">{{ Str::limit($task->description, 100) }}</p>
                                    <div class="d-flex align-items-center">
                                        <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }} me-2">
                                            {{ ucfirst($task->priority) }} Priority
                                        </span>
                                        @if($task->deadline)
                                            <small class="text-muted me-2">
                                                <i class="fas fa-calendar me-1"></i>Due: {{ $task->formatted_deadline }}
                                            </small>
                                        @endif
                                        @if($task->completed)
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($task->isOverdue())
                                            <span class="badge bg-danger">Overdue</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('tasks.show', $task) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-secondary btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-{{ $task->completed ? 'warning' : 'success' }} btn-sm">
                                                <i class="fas fa-{{ $task->completed ? 'undo' : 'check' }}"></i>
                                            </button>
                                        </form>
                                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" 
                                              onsubmit="return confirm('Are you sure you want to delete this task?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $tasks->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-tasks fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No tasks found</h4>
                    <p class="text-muted">Start by creating your first task!</p>
                    <a href="{{ route('tasks.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Create Task
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
