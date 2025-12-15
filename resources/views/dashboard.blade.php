@extends('layouts.app')

@section('title', 'Dashboard - DailyDo')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    /* Custom Flatpickr theme - Compact Size */
    .flatpickr-calendar {
        background: #F1F0E4;
        border-radius: 12px;
        border: 2px solid #896C6C;
        box-shadow: 0 5px 20px rgba(137, 108, 108, 0.3);
        width: 310px !important;
        font-size: 13px;
    }
    
    @media (max-width: 576px) {
        .flatpickr-calendar {
            width: 290px !important;
            font-size: 12px;
        }
        
        .flatpickr-day {
            height: 30px !important;
            line-height: 30px !important;
            max-width: 36px !important;
            font-size: 12px !important;
        }
    }
    
    .flatpickr-months {
        background: #896C6C;
        border-radius: 10px 10px 0 0;
        padding: 8px 0;
        height: 40px;
    }
    
    .flatpickr-month, .flatpickr-current-month {
        color: white;
        font-weight: 600;
        font-size: 14px;
        height: 28px;
    }
    
    .flatpickr-prev-month, .flatpickr-next-month {
        fill: white;
        padding: 4px;
        height: 28px;
        width: 28px;
    }
    
    .flatpickr-prev-month:hover, .flatpickr-next-month:hover {
        background: rgba(255,255,255,0.2);
        border-radius: 6px;
    }
    
    .flatpickr-weekdays {
        background: #A67C7C;
        height: 32px;
    }
    
    span.flatpickr-weekday {
        color: white;
        font-weight: 600;
        font-size: 12px;
        line-height: 32px;
    }
    
    .flatpickr-days {
        background: white;
        width: 310px !important;
    }
    
    .flatpickr-day {
        color: #333;
        border-radius: 8px;
        height: 34px;
        line-height: 34px;
        max-width: 36px;
        font-size: 13px;
    }
    
    .flatpickr-day:hover {
        background: rgba(137, 108, 108, 0.1);
        border-color: #896C6C;
    }
    
    .flatpickr-day.today {
        background: rgba(137, 108, 108, 0.2);
        border-color: #896C6C;
        color: #896C6C;
        font-weight: 700;
    }
    
    .flatpickr-day.selected {
        background: #896C6C;
        border-color: #896C6C;
        color: white;
        font-weight: 600;
    }
    
    .flatpickr-time {
        background: white;
        border-top: 2px solid #DDDAD0;
        border-radius: 0 0 10px 10px;
        height: 38px;
        max-height: 38px;
    }
    
    .flatpickr-time input {
        color: #896C6C;
        font-weight: 600;
        font-size: 14px;
        height: 32px;
    }
    
    .flatpickr-time .flatpickr-time-separator,
    .flatpickr-time .flatpickr-am-pm {
        height: 32px;
        line-height: 32px;
        font-size: 13px;
    }
    
    .flatpickr-time .numInputWrapper {
        height: 32px;
    }
    
    .flatpickr-time .numInputWrapper span {
        height: 16px;
    }
</style>
@endpush

@section('content')
<!-- TOAST NOTIFICATION -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="successToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" style="background: #896C6C;">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span id="toastMessage">Task added successfully!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- DASHBOARD CONTENT -->
<section class="dashboard-section mt-3" style="padding-bottom: 3rem;">
    <div class="container-fluid px-4 py-3">
        <!-- Header Section -->
        <div class="row mb-3">
            <div class="col-12">
                <h1 class="fw-bold mb-1">
                    <i class="bi bi-stars me-2" style="color: #896C6C;"></i>
                    Welcome to your task space, <span id="userName">{{ auth()->user()->first_name }}</span>!
                </h1>
                <p class="text-muted fs-5">Stay organized and productive with DailyDo</p>
            </div>
        </div>

        <div class="row g-3">
            <!-- Quick Add Task - Large Card -->
            <div class="col-12 col-lg-8">
                <div class="card h-100" style="background: #F1F0E4; border-radius: 15px; box-shadow: 0 3px 10px rgba(0,0,0,0.1); border: 2px solid #896C6C;">
                    <div class="card-body p-3">
                        <div class="d-flex align-items-center mb-2">
                            <i class="bi bi-plus-circle-fill me-2" style="color: #896C6C; font-size: 1.5rem;"></i>
                            <h4 class="mb-0 fw-bold" style="color: #333; font-size: 1.15rem;">Quick Add Task</h4>
                        </div>
                        <form id="quickAddForm" action="{{ route('tasks.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="priority" value="medium">
                            <div class="row g-2">
                                <div class="col-12 col-md-6">
                                    <input type="text" class="form-control form-control-lg" name="title" id="taskTitle" placeholder="What needs to be done?" required style="border-radius: 15px; border: 2px solid #DDDAD0;">
                                </div>
                                <div class="col-8 col-md-4">
                                    <input type="text" class="form-control form-control-lg" name="deadline" id="taskDue" placeholder="Select date & time" style="border-radius: 15px; border: 2px solid #DDDAD0;">
                                </div>
                                <div class="col-4 col-md-2">
                                    <button type="submit" class="btn btn-lg w-100 fw-bold" style="border-radius: 15px; background: #896C6C; color: white; border: none;">Add</button>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="reminder" id="setReminder" value="1" style="border-radius: 6px;">
                                        <label class="form-check-label fw-medium" for="setReminder" style="color: #333; font-size: 0.9rem;">
                                            <i class="bi bi-bell me-1" style="color: #896C6C;"></i> Set reminder
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Stats Card -->
            <div class="col-12 col-lg-4">
                <div class="card h-100 border-0" style="background: linear-gradient(135deg, #896C6C, #A67C7C); border-radius: 15px; box-shadow: 0 3px 10px rgba(0,0,0,0.1);">
                    <div class="card-body p-3 text-white text-center">
                        <i class="bi bi-graph-up mb-2" style="font-size: 2rem;"></i>
                        <h3 class="fw-bold mb-2" style="font-size: 1.25rem;">Today's Progress</h3>
                        <div class="row text-center">
                            <div class="col-6">
                                <h2 class="fw-bold mb-0" id="pendingCount">{{ $pendingTasks ?? 0 }}</h2>
                                <small class="opacity-75">Pending</small>
                            </div>
                            <div class="col-6">
                                <h2 class="fw-bold mb-0" id="completedCount">{{ $completedTasks ?? 0 }}</h2>
                                <small class="opacity-75">Completed</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Today's Tasks -->
            <div class="col-12 col-lg-6">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header border-0 pt-3 px-3" style="background: #F1F0E4; border-radius: 15px 15px 0 0;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-day me-2" style="color: #896C6C; font-size: 1.15rem;"></i>
                            <h5 class="mb-0 fw-bold" style="color: #333; font-size: 1rem;">Today's Tasks</h5>
                        </div>
                    </div>
                    <div class="card-body px-3 pb-3">
                        <div id="todayTasks">
                            @forelse($todayTasks ?? [] as $task)
                                <div class="task-item mb-3 p-3 rounded-3" style="{{ $task->reminder ? 'background: rgba(137, 108, 108, 0.1); border-radius: 10px; border-left: 4px solid #896C6C;' : 'background: rgba(241, 240, 228, 0.3); border-radius: 10px;' }}">
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-3 task-checkbox" style="transform: scale(1.2);" {{ $task->status === 'completed' ? 'checked' : '' }} onchange="toggleTaskCompletion(this, {{ $task->id }})">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 task-title" style="{{ $task->status === 'completed' ? 'text-decoration: line-through; opacity: 0.6;' : '' }}">{{ $task->title }}</h6>
                                            <small class="text-muted task-due" style="{{ $task->status === 'completed' ? 'opacity: 0.6;' : '' }}">Due: {{ $task->deadline ? $task->deadline->format('M d, Y h:i A') : 'No due date' }}</small>
                                        </div>
                                        @if($task->reminder)
                                            <span class="badge" style="background: #896C6C;"><i class="bi bi-bell-fill"></i></span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center">No tasks for today</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upcoming Tasks -->
            <div class="col-12 col-lg-6">
                <div class="card h-100 border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header border-0 pt-3 px-3" style="background: #F1F0E4; border-radius: 15px 15px 0 0;">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-calendar-week me-2" style="color: #896C6C; font-size: 1.15rem;"></i>
                            <h5 class="mb-0 fw-bold" style="color: #333; font-size: 1rem;">Upcoming Tasks</h5>
                        </div>
                    </div>
                    <div class="card-body px-3 pb-3">
                        <div id="upcomingTasks">
                            @forelse($upcomingTasks ?? [] as $task)
                                <div class="task-item mb-3 p-3 rounded-3" style="{{ $task->reminder ? 'background: rgba(137, 108, 108, 0.1); border-radius: 10px; border-left: 4px solid #896C6C;' : 'background: rgba(241, 240, 228, 0.3); border-radius: 10px;' }}">
                                    <div class="d-flex align-items-center">
                                        <input type="checkbox" class="form-check-input me-3 task-checkbox" style="transform: scale(1.2);" {{ $task->status === 'completed' ? 'checked' : '' }} onchange="toggleTaskCompletion(this, {{ $task->id }})">
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1 task-title" style="{{ $task->status === 'completed' ? 'text-decoration: line-through; opacity: 0.6;' : '' }}">{{ $task->title }}</h6>
                                            <small class="text-muted task-due" style="{{ $task->status === 'completed' ? 'opacity: 0.6;' : '' }}">Due: {{ $task->deadline ? $task->deadline->format('M d, Y h:i A') : 'No due date' }}</small>
                                        </div>
                                        @if($task->reminder)
                                            <span class="badge" style="background: #896C6C;"><i class="bi bi-bell-fill"></i></span>
                                        @endif
                                    </div>
                                </div>
                            @empty
                                <p class="text-muted text-center">No upcoming tasks</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Function to show toast notification
    function showToast(message) {
        const toastElement = document.getElementById('successToast');
        const toastMessage = document.getElementById('toastMessage');
        
        toastMessage.textContent = message;
        
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: 3000
        });
        
        toast.show();
    }

    // Function to toggle task completion
    async function toggleTaskCompletion(checkbox, taskId) {
        const taskItem = checkbox.closest('.task-item');
        const taskTitle = taskItem.querySelector('.task-title');
        const taskDue = taskItem.querySelector('.task-due');
        
        const newStatus = checkbox.checked ? 'completed' : 'pending';
        
        try {
            const response = await fetch(`/tasks/${taskId}/toggle`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({
                    status: newStatus
                })
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();

            if (!data.success) {
                throw new Error(data.error || 'Failed to update task');
            }

            // Update UI
            if (checkbox.checked) {
                taskTitle.style.textDecoration = 'line-through';
                taskTitle.style.opacity = '0.6';
                taskDue.style.opacity = '0.6';
                taskItem.style.background = 'rgba(40, 167, 69, 0.1)';
                taskItem.style.borderLeft = '4px solid #28a745';
            } else {
                taskTitle.style.textDecoration = 'none';
                taskTitle.style.opacity = '1';
                taskDue.style.opacity = '1';
                taskItem.style.background = 'rgba(241, 240, 228, 0.3)';
                taskItem.style.borderLeft = 'none';
            }
            
            // Update statistics
            updateStatistics();
            
        } catch (error) {
            console.error('Error updating task:', error);
            checkbox.checked = !checkbox.checked;
            showToast('Error updating task: ' + error.message);
        }
    }

    // Function to update statistics
    function updateStatistics() {
        const allTasks = document.querySelectorAll('.task-item');
        let pendingCount = 0;
        let completedCount = 0;
        
        allTasks.forEach(task => {
            const checkbox = task.querySelector('.task-checkbox');
            if (checkbox && checkbox.checked) {
                completedCount++;
            } else {
                pendingCount++;
            }
        });
        
        document.getElementById('pendingCount').textContent = pendingCount;
        document.getElementById('completedCount').textContent = completedCount;
    }

    // Quick add form submission
    document.getElementById('quickAddForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            });

            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }

            const data = await response.json();
            
            if (data.success) {
                showToast('Task added successfully!');
                this.reset();
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            } else {
                showToast('Error: ' + (data.message || data.error || 'Failed to add task'));
            }
        } catch (error) {
            console.error('Error:', error);
            showToast('Error adding task: ' + error.message);
        }
    });

</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    // Initialize Flatpickr after library is loaded
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#taskDue", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: false,
            minuteIncrement: 15,
            altInput: true,
            altFormat: "F j, Y h:i K",
            minDate: "today"
        });
    });
    
    // Pass tasks data to reminder system
    window.pageTasksData = [
        @if(isset($todayTasks))
            @foreach($todayTasks as $task)
                {
                    id: {{ $task->id }},
                    title: "{{ addslashes($task->title) }}",
                    description: "{{ addslashes($task->description ?? '') }}",
                    status: "{{ $task->status }}",
                    priority: "{{ $task->priority }}",
                    deadline: "{{ $task->deadline ? $task->deadline->format('Y-m-d H:i:s') : '' }}",
                    reminder: {{ $task->reminder ? 'true' : 'false' }},
                    reminder_time: {{ $task->reminder_time ?? 15 }}
                },
            @endforeach
        @endif
        @if(isset($upcomingTasks))
            @foreach($upcomingTasks as $task)
                {
                    id: {{ $task->id }},
                    title: "{{ addslashes($task->title) }}",
                    description: "{{ addslashes($task->description ?? '') }}",
                    status: "{{ $task->status }}",
                    priority: "{{ $task->priority }}",
                    deadline: "{{ $task->deadline ? $task->deadline->format('Y-m-d H:i:s') : '' }}",
                    reminder: {{ $task->reminder ? 'true' : 'false' }},
                    reminder_time: {{ $task->reminder_time ?? 15 }}
                },
            @endforeach
        @endif
    ];
    console.log('Tasks loaded on page:', window.pageTasksData);
</script>
@endpush
@endsection
