@extends('layouts.app')

@section('title', $task->title . ' - DailyDo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Task Details</h4>
                    <div class="btn-group" role="group">
                        <a href="{{ route('tasks.edit', $task) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit
                        </a>
                        <form action="{{ route('tasks.toggle', $task) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-outline-{{ $task->completed ? 'warning' : 'success' }} btn-sm">
                                <i class="fas fa-{{ $task->completed ? 'undo' : 'check' }} me-1"></i>
                                {{ $task->completed ? 'Mark Pending' : 'Mark Complete' }}
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <h2 class="mb-3 {{ $task->completed ? 'task-completed' : '' }}">{{ $task->title }}</h2>
                            
                            @if($task->description)
                                <div class="mb-4">
                                    <h6 class="text-muted">Description</h6>
                                    <p class="lead">{{ $task->description }}</p>
                                </div>
                            @endif

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Priority</h6>
                                    <span class="badge bg-{{ $task->priority == 'high' ? 'danger' : ($task->priority == 'medium' ? 'warning' : 'success') }} fs-6">
                                        {{ ucfirst($task->priority) }} Priority
                                    </span>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Status</h6>
                                    @if($task->completed)
                                        <span class="badge bg-success fs-6">Completed</span>
                                    @elseif($task->isOverdue())
                                        <span class="badge bg-danger fs-6">Overdue</span>
                                    @else
                                        <span class="badge bg-primary fs-6">Pending</span>
                                    @endif
                                </div>
                            </div>

                            @if($task->deadline)
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Deadline</h6>
                                        <p class="mb-0">
                                            <i class="fas fa-calendar me-2"></i>{{ $task->formatted_deadline }}
                                        </p>
                                        @if(!$task->completed && $task->deadline)
                                            <small class="text-muted">{{ $task->time_until_deadline }}</small>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            @if($task->reminder && $task->reminder_time)
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Reminder</h6>
                                        <p class="mb-0">
                                            <i class="fas fa-bell me-2"></i>{{ $task->reminder_time->format('M j, Y g:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @endif

                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Created</h6>
                                    <p class="mb-0">{{ $task->created_at->format('M j, Y g:i A') }}</p>
                                </div>
                                @if($task->updated_at != $task->created_at)
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Last Updated</h6>
                                        <p class="mb-0">{{ $task->updated_at->format('M j, Y g:i A') }}</p>
                                    </div>
                                @endif
                            </div>

                            @if($task->completed && $task->completed_at)
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <h6 class="text-muted">Completed</h6>
                                        <p class="mb-0 text-success">
                                            <i class="fas fa-check-circle me-2"></i>{{ $task->completed_at->format('M j, Y g:i A') }}
                                        </p>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                        </a>
                        <form action="{{ route('tasks.destroy', $task) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Are you sure you want to delete this task?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Delete Task
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
