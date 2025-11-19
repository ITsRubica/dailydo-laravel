@extends('layouts.app')

@section('title', 'Edit Task - DailyDo')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Edit Task</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('tasks.update', $task) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Task Title <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $task->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="4">{{ old('description', $task->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                    <select class="form-select @error('priority') is-invalid @enderror" 
                                            id="priority" name="priority" required>
                                        <option value="">Select Priority</option>
                                        <option value="low" {{ old('priority', $task->priority) == 'low' ? 'selected' : '' }}>Low</option>
                                        <option value="medium" {{ old('priority', $task->priority) == 'medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="high" {{ old('priority', $task->priority) == 'high' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('priority')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="deadline" class="form-label">Deadline</label>
                                    <input type="datetime-local" class="form-control @error('deadline') is-invalid @enderror" 
                                           id="deadline" name="deadline" 
                                           value="{{ old('deadline', $task->deadline ? $task->deadline->format('Y-m-d\TH:i') : '') }}">
                                    @error('deadline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="reminder" name="reminder" 
                                       value="1" {{ old('reminder', $task->reminder) ? 'checked' : '' }}>
                                <label class="form-check-label" for="reminder">
                                    Set Reminder
                                </label>
                            </div>
                        </div>

                        <div class="mb-3" id="reminder-time-group" style="display: {{ old('reminder', $task->reminder) ? 'block' : 'none' }};">
                            <label for="reminder_time" class="form-label">Reminder Time</label>
                            <input type="datetime-local" class="form-control @error('reminder_time') is-invalid @enderror" 
                                   id="reminder_time" name="reminder_time" 
                                   value="{{ old('reminder_time', $task->reminder_time ? $task->reminder_time->format('Y-m-d\TH:i') : '') }}">
                            @error('reminder_time')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="completed" name="completed" 
                                       value="1" {{ old('completed', $task->completed) ? 'checked' : '' }}>
                                <label class="form-check-label" for="completed">
                                    Mark as Completed
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('tasks.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Tasks
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const reminderCheckbox = document.getElementById('reminder');
    const reminderTimeGroup = document.getElementById('reminder-time-group');
    
    reminderCheckbox.addEventListener('change', function() {
        if (this.checked) {
            reminderTimeGroup.style.display = 'block';
        } else {
            reminderTimeGroup.style.display = 'none';
        }
    });
});
</script>
@endsection
