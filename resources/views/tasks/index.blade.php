@extends('layouts.app')

@section('title', 'Task List - DailyDo')

@section('content')
<!-- TOAST NOTIFICATION -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="successToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" style="background: #896C6C;">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                Task updated successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- TASK LIST SECTION -->
<section class="task-section mt-3" style="padding-bottom: 3rem;">
    <div class="container-fluid px-4 py-3">
        <!-- Header Section -->
        <div class="row mb-3">
            <div class="col-12 d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="fw-bold mb-1" style="font-size: 1.5rem;"><i class="bi bi-list-task me-2" style="color: #896C6C;"></i>Task Management</h1>
                    <p class="text-muted mb-0" style="font-size: 0.95rem;">Organize and track your tasks efficiently</p>
                </div>
                <button class="btn fw-bold" data-bs-toggle="modal" data-bs-target="#addTaskModal" style="background: #896C6C; color: white; border: none; border-radius: 12px; padding: 8px 16px; font-size: 0.9rem;">
                    <i class="bi bi-plus-circle me-1"></i>Add New Task
                </button>
            </div>
        </div>

        <!-- Tab Navigation -->
        <div class="card mb-3 border-0 shadow-sm" style="background: #F1F0E4; border-radius: 12px;">
            <div class="card-body p-3">
                <!-- Tab Headers -->
                <ul class="nav nav-pills mb-2" id="taskTabs" role="tablist" style="background: white; border-radius: 10px; padding: 4px;">
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link active w-100 fw-bold" id="active-tab" data-bs-toggle="pill" data-bs-target="#active-tasks" type="button" role="tab" aria-controls="active-tasks" aria-selected="true" style="border-radius: 8px; background: #896C6C; color: white; border: none; padding: 8px 12px; transition: all 0.3s ease; font-size: 0.85rem;">
                            <i class="bi bi-list-task me-1"></i>Active Tasks
                            <span class="badge ms-1" id="activeTaskCount" style="background: rgba(255,255,255,0.3); color: white; font-size: 0.75rem;">{{ $tasks->where('status', 'pending')->count() }}</span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link w-100 fw-bold" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed-tasks" type="button" role="tab" aria-controls="completed-tasks" aria-selected="false" style="border-radius: 8px; color: #6c757d; border: none; padding: 8px 12px; transition: all 0.3s ease; font-size: 0.85rem;">
                            <i class="bi bi-check-circle me-1"></i>Completed Tasks
                            <span class="badge ms-1" id="completedTaskCount" style="background: #6c757d; color: white; font-size: 0.75rem;">{{ $tasks->where('status', 'completed')->count() }}</span>
                        </button>
                    </li>
                </ul>

                <!-- Search and Filter Section -->
                <div class="row g-2">
                    <div class="col-12 col-lg-8">
                        <div class="input-group input-group-sm">
                            <span class="input-group-text" style="background: white; border: 2px solid #DDDAD0; border-right: none;"><i class="bi bi-search" style="color: #896C6C; font-size: 0.85rem;"></i></span>
                            <input type="text" class="form-control" id="searchTasks" placeholder="Search tasks..." style="border: 2px solid #DDDAD0; border-left: none; border-radius: 0 10px 10px 0; font-size: 0.85rem; padding: 6px 10px;">
                        </div>
                    </div>
                    <div class="col-12 col-lg-4">
                        <select class="form-select form-select-sm" id="filterPriority" style="border: 2px solid #DDDAD0; border-radius: 10px; font-size: 0.85rem; padding: 6px 10px;">
                            <option value="">All Priorities</option>
                            <option value="high">High Priority</option>
                            <option value="medium">Medium Priority</option>
                            <option value="low">Low Priority</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tasks Container -->
        <div class="row">
            <div class="col-12">
                <div class="tab-content" id="taskTabContent">
                    <!-- Active Tasks Tab -->
                    <div class="tab-pane fade show active" id="active-tasks" role="tabpanel" aria-labelledby="active-tab">
                        <div id="activeTasksContainer">
                            @php
                                $activeTasks = $tasks->where('status', 'pending');
                            @endphp
                            @if($activeTasks->count() > 0)
                                @foreach($activeTasks as $task)
                                    @include('tasks.partials.task-card', ['task' => $task])
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-list-task" style="font-size: 3rem; color: #ccc;"></i>
                                    <h5 class="mt-2 text-muted" style="font-size: 1rem;">No active tasks</h5>
                                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Add your first task to get started!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Completed Tasks Tab -->
                    <div class="tab-pane fade" id="completed-tasks" role="tabpanel" aria-labelledby="completed-tab">
                        <div id="completedTasksContainer">
                            @php
                                $completedTasks = $tasks->where('status', 'completed');
                            @endphp
                            @if($completedTasks->count() > 0)
                                @foreach($completedTasks as $task)
                                    @include('tasks.partials.task-card', ['task' => $task])
                                @endforeach
                            @else
                                <div class="text-center py-4">
                                    <i class="bi bi-check-circle" style="font-size: 3rem; color: #ccc;"></i>
                                    <h5 class="mt-2 text-muted" style="font-size: 1rem;">No completed tasks</h5>
                                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Complete some tasks to see them here!</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ADD/EDIT TASK MODAL -->
<div class="modal fade" id="addTaskModal" tabindex="-1" aria-labelledby="addTaskModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
            <div class="modal-header" style="background: #F1F0E4; border-radius: 15px 15px 0 0; border-bottom: 2px solid #DDDAD0; padding: 1rem 1.25rem;">
                <div class="d-flex align-items-center">
                    <i class="bi bi-plus-circle-fill me-2" style="color: #896C6C; font-size: 1.25rem;"></i>
                    <h5 class="modal-title mb-0 fw-bold" id="addTaskModalLabel" style="color: #333; font-size: 1.1rem;">Add New Task</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 1.25rem;">
                <form id="taskForm" action="{{ route('tasks.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="taskId" name="task_id" value="">
                    <input type="hidden" id="formMethod" name="_method" value="POST">
                    <div class="row g-3">
                        <div class="col-12">
                            <label for="taskTitle" class="form-label fw-semibold d-flex align-items-center" style="color: #333; font-size: 0.9rem;">
                                <i class="bi bi-pencil-square me-2" style="color: #896C6C;"></i>Task Title *
                            </label>
                            <input type="text" class="form-control" id="taskTitle" name="title" required placeholder="Enter your task title..." style="border: 2px solid #DDDAD0; border-radius: 12px; padding: 8px 12px; font-size: 0.9rem;">
                        </div>
                        <div class="col-12">
                            <label for="taskDescription" class="form-label fw-semibold d-flex align-items-center" style="color: #333; font-size: 0.9rem;">
                                <i class="bi bi-text-paragraph me-2" style="color: #896C6C;"></i>Description
                            </label>
                            <textarea class="form-control" id="taskDescription" name="description" rows="3" placeholder="Add task details..." style="border: 2px solid #DDDAD0; border-radius: 12px; padding: 8px 12px; resize: vertical; font-size: 0.9rem;"></textarea>
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="taskDeadline" class="form-label fw-semibold d-flex align-items-center" style="color: #333; font-size: 0.9rem;">
                                <i class="bi bi-calendar3 me-2" style="color: #896C6C;"></i>Deadline
                            </label>
                            <input type="datetime-local" class="form-control" id="taskDeadline" name="deadline" style="border: 2px solid #DDDAD0; border-radius: 12px; padding: 8px 12px; font-size: 0.9rem;">
                        </div>
                        <div class="col-12 col-md-6">
                            <label for="taskPriority" class="form-label fw-semibold d-flex align-items-center" style="color: #333; font-size: 0.9rem;">
                                <i class="bi bi-flag me-2" style="color: #896C6C;"></i>Priority
                            </label>
                            <select class="form-select" id="taskPriority" name="priority" style="border: 2px solid #DDDAD0; border-radius: 12px; padding: 8px 12px; font-size: 0.9rem;">
                                <option value="low">Low Priority</option>
                                <option value="medium" selected>Medium Priority</option>
                                <option value="high">High Priority</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <div class="form-check p-2" style="background: #F8F9FA; border-radius: 12px; border: 2px solid #E9ECEF;">
                                <input class="form-check-input" type="checkbox" id="taskReminder" name="reminder" style="transform: scale(1.1);">
                                <label class="form-check-label fw-semibold ms-2 d-flex align-items-center" for="taskReminder" style="color: #333; font-size: 0.9rem;">
                                    <i class="bi bi-bell me-2" style="color: #896C6C;"></i>Set Reminder
                                </label>
                            </div>
                        </div>
                        <div class="col-12" id="reminderSettings" style="display: none;">
                            <label for="reminderTime" class="form-label fw-semibold d-flex align-items-center" style="color: #333; font-size: 0.9rem;">
                                <i class="bi bi-clock me-2" style="color: #896C6C;"></i>Reminder Time
                            </label>
                            <select class="form-select" id="reminderTime" name="reminder_time" style="border: 2px solid #DDDAD0; border-radius: 12px; padding: 8px 12px; font-size: 0.9rem;">
                                <option value="15">15 minutes before</option>
                                <option value="30">30 minutes before</option>
                                <option value="60">1 hour before</option>
                                <option value="1440">1 day before</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border-top: 2px solid #DDDAD0; padding: 1rem 1.25rem; border-radius: 0 0 15px 15px;">
                <button type="button" class="btn px-3" data-bs-dismiss="modal" style="background: #E9ECEF; color: #6c757d; border: 2px solid #DEE2E6; border-radius: 12px; font-weight: 600; font-size: 0.9rem;">Cancel</button>
                <button type="button" class="btn px-3" id="saveTaskBtn" style="background: #896C6C; color: white; border: 2px solid #896C6C; border-radius: 12px; font-weight: 600; font-size: 0.9rem;">💾 Save Task</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Task reminder checkbox toggle
    document.getElementById('taskReminder').addEventListener('change', function() {
        const reminderSettings = document.getElementById('reminderSettings');
        if (this.checked) {
            reminderSettings.style.display = 'block';
        } else {
            reminderSettings.style.display = 'none';
        }
    });

    // Save task
    document.getElementById('saveTaskBtn').addEventListener('click', function() {
        const form = document.getElementById('taskForm');
        const taskId = document.getElementById('taskId').value;
        
        if (taskId) {
            form.action = `/tasks/${taskId}`;
            document.getElementById('formMethod').value = 'PUT';
        } else {
            form.action = '{{ route("tasks.store") }}';
            document.getElementById('formMethod').value = 'POST';
        }
        
        form.submit();
    });

    // Edit task function
    window.editTask = function(taskId) {
        fetch(`/tasks/${taskId}/edit`)
            .then(response => response.json())
            .then(task => {
                document.getElementById('taskId').value = task.id;
                document.getElementById('taskTitle').value = task.title;
                document.getElementById('taskDescription').value = task.description || '';
                
                if (task.deadline) {
                    const date = new Date(task.deadline);
                    const formattedDate = date.toISOString().slice(0, 16);
                    document.getElementById('taskDeadline').value = formattedDate;
                } else {
                    document.getElementById('taskDeadline').value = '';
                }
                
                document.getElementById('taskPriority').value = task.priority;
                document.getElementById('taskReminder').checked = task.reminder || false;
                document.getElementById('reminderTime').value = task.reminder_time || '15';
                
                const reminderSettings = document.getElementById('reminderSettings');
                reminderSettings.style.display = task.reminder ? 'block' : 'none';
                
                document.getElementById('addTaskModalLabel').textContent = 'Edit Task';
                new bootstrap.Modal(document.getElementById('addTaskModal')).show();
            });
    };

    // Delete task function
    window.deleteTask = function(taskId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/tasks/${taskId}`;
                
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                const csrfInput = document.createElement('input');
                csrfInput.type = 'hidden';
                csrfInput.name = '_token';
                csrfInput.value = csrfToken;
                
                const methodInput = document.createElement('input');
                methodInput.type = 'hidden';
                methodInput.name = '_method';
                methodInput.value = 'DELETE';
                
                form.appendChild(csrfInput);
                form.appendChild(methodInput);
                document.body.appendChild(form);
                form.submit();
            }
        });
    };

    // Toggle task status
    window.toggleTaskStatus = function(taskId) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/tasks/${taskId}/toggle`;
        
        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = csrfToken;
        
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'PATCH';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    };

    // Reset form when modal is hidden
    document.getElementById('addTaskModal').addEventListener('hidden.bs.modal', function() {
        document.getElementById('taskForm').reset();
        document.getElementById('taskId').value = '';
        document.getElementById('reminderSettings').style.display = 'none';
        document.getElementById('addTaskModalLabel').textContent = 'Add New Task';
    });

    // Tab switching event listeners
    document.getElementById('active-tab').addEventListener('click', function() {
        this.style.background = '#896C6C';
        this.style.color = 'white';
        document.getElementById('activeTaskCount').style.background = 'rgba(255,255,255,0.3)';
        document.getElementById('activeTaskCount').style.color = 'white';
        
        document.getElementById('completed-tab').style.background = 'transparent';
        document.getElementById('completed-tab').style.color = '#6c757d';
        document.getElementById('completedTaskCount').style.background = '#6c757d';
        document.getElementById('completedTaskCount').style.color = 'white';
    });

    document.getElementById('completed-tab').addEventListener('click', function() {
        this.style.background = '#6c757d';
        this.style.color = 'white';
        document.getElementById('completedTaskCount').style.background = 'rgba(255,255,255,0.3)';
        document.getElementById('completedTaskCount').style.color = 'white';
        
        document.getElementById('active-tab').style.background = 'transparent';
        document.getElementById('active-tab').style.color = '#896C6C';
        document.getElementById('activeTaskCount').style.background = '#896C6C';
        document.getElementById('activeTaskCount').style.color = 'white';
    });

    // Search and filter functionality
    document.getElementById('searchTasks').addEventListener('input', filterTasks);
    document.getElementById('filterPriority').addEventListener('change', filterTasks);

    function filterTasks() {
        const searchTerm = document.getElementById('searchTasks').value.toLowerCase();
        const priorityFilter = document.getElementById('filterPriority').value;
        
        document.querySelectorAll('.task-card').forEach(card => {
            const title = card.querySelector('.card-title').textContent.toLowerCase();
            const description = card.querySelector('.card-text')?.textContent.toLowerCase() || '';
            const priority = card.dataset.priority;
            
            const matchesSearch = title.includes(searchTerm) || description.includes(searchTerm);
            const matchesPriority = !priorityFilter || priority === priorityFilter;
            
            card.style.display = (matchesSearch && matchesPriority) ? 'block' : 'none';
        });
    }

    // Show success message if exists
    @if(session('success'))
        document.getElementById('toastMessage').textContent = '{{ session("success") }}';
        const toast = new bootstrap.Toast(document.getElementById('successToast'));
        toast.show();
    @endif
</script>
@endpush
