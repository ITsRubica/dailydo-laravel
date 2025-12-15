

<?php $__env->startSection('title', 'Task List - DailyDo'); ?>

<?php $__env->startPush('styles'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
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
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2">
                    <div>
                        <h1 class="fw-bold mb-1" style="font-size: 1.5rem;"><i class="bi bi-list-task me-2" style="color: #896C6C;"></i>Task Management</h1>
                        <p class="text-muted mb-0" style="font-size: 0.95rem;">Organize and track your tasks efficiently</p>
                    </div>
                    <button class="btn fw-bold" id="addTaskBtn" data-bs-toggle="modal" data-bs-target="#addTaskModal" style="background: #896C6C; color: white; border: none; border-radius: 12px; padding: 8px 16px; font-size: 0.9rem; white-space: nowrap;">
                        <i class="bi bi-plus-circle me-1"></i><span class="d-none d-sm-inline">Add New Task</span><span class="d-inline d-sm-none">Add</span>
                    </button>
                </div>
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
                            <span class="badge ms-1" id="activeTaskCount" style="background: rgba(255,255,255,0.3); color: white; font-size: 0.75rem;"><?php echo e($tasks->where('status', 'pending')->count()); ?></span>
                        </button>
                    </li>
                    <li class="nav-item" role="presentation" style="flex: 1;">
                        <button class="nav-link w-100 fw-bold" id="completed-tab" data-bs-toggle="pill" data-bs-target="#completed-tasks" type="button" role="tab" aria-controls="completed-tasks" aria-selected="false" style="border-radius: 8px; color: #6c757d; border: none; padding: 8px 12px; transition: all 0.3s ease; font-size: 0.85rem;">
                            <i class="bi bi-check-circle me-1"></i>Completed Tasks
                            <span class="badge ms-1" id="completedTaskCount" style="background: #6c757d; color: white; font-size: 0.75rem;"><?php echo e($tasks->where('status', 'completed')->count()); ?></span>
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
                            <?php
                                $activeTasks = $tasks->where('status', 'pending');
                            ?>
                            <?php if($activeTasks->count() > 0): ?>
                                <?php $__currentLoopData = $activeTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('tasks.partials.task-card', ['task' => $task], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-list-task" style="font-size: 3rem; color: #ccc;"></i>
                                    <h5 class="mt-2 text-muted" style="font-size: 1rem;">No active tasks</h5>
                                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Add your first task to get started!</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <!-- Completed Tasks Tab -->
                    <div class="tab-pane fade" id="completed-tasks" role="tabpanel" aria-labelledby="completed-tab">
                        <div id="completedTasksContainer">
                            <?php
                                $completedTasks = $tasks->where('status', 'completed');
                            ?>
                            <?php if($completedTasks->count() > 0): ?>
                                <?php $__currentLoopData = $completedTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('tasks.partials.task-card', ['task' => $task], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-check-circle" style="font-size: 3rem; color: #ccc;"></i>
                                    <h5 class="mt-2 text-muted" style="font-size: 1rem;">No completed tasks</h5>
                                    <p class="text-muted mb-0" style="font-size: 0.85rem;">Complete some tasks to see them here!</p>
                                </div>
                            <?php endif; ?>
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
                <form id="taskForm" action="<?php echo e(route('tasks.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" id="taskId" value="">
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
                            <input type="text" class="form-control" id="taskDeadline" name="deadline" placeholder="Select date & time" style="border: 2px solid #DDDAD0; border-radius: 12px; padding: 8px 12px; font-size: 0.9rem;">
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
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Edit task function
    window.editTask = function(taskId) {
        fetch(`/tasks/${taskId}/edit`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to fetch task');
                }
                return response.json();
            })
            .then(task => {
                // Set form values
                document.getElementById('taskId').value = task.id;
                document.getElementById('taskTitle').value = task.title;
                document.getElementById('taskDescription').value = task.description || '';
                
                // Set deadline using flatpickr if available
                const deadlineInput = document.getElementById('taskDeadline');
                if (task.deadline) {
                    // Set the value directly for flatpickr
                    deadlineInput.value = task.deadline;
                    // If flatpickr instance exists, update it
                    if (deadlineInput._flatpickr) {
                        deadlineInput._flatpickr.setDate(task.deadline);
                    }
                } else {
                    deadlineInput.value = '';
                    if (deadlineInput._flatpickr) {
                        deadlineInput._flatpickr.clear();
                    }
                }
                
                document.getElementById('taskPriority').value = task.priority;
                document.getElementById('taskReminder').checked = task.reminder || false;
                document.getElementById('reminderTime').value = task.reminder_time || '15';
                
                const reminderSettings = document.getElementById('reminderSettings');
                reminderSettings.style.display = task.reminder ? 'block' : 'none';
                
                document.getElementById('addTaskModalLabel').textContent = 'Edit Task';
                new bootstrap.Modal(document.getElementById('addTaskModal')).show();
            })
            .catch(error => {
                console.error('Error loading task:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to load task details. Please try again.'
                });
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

    // Toggle task status with 5-second delay for completed tasks
    window.toggleTaskStatus = function(taskId) {
        const taskCard = document.querySelector(`.task-card[data-task-id="${taskId}"]`);
        const isCurrentlyCompleted = taskCard.classList.contains('completed-task');
        
        // If marking as completed, show animation first
        if (!isCurrentlyCompleted) {
            // Add completion animation
            taskCard.style.background = 'linear-gradient(135deg, rgba(25, 135, 84, 0.1), rgba(25, 135, 84, 0.05))';
            taskCard.style.transform = 'scale(0.98)';
            
            // Show success indicator
            const checkIcon = taskCard.querySelector('.task-checkbox i');
            checkIcon.className = 'bi bi-check';
            checkIcon.style.color = 'white';
            taskCard.querySelector('.task-checkbox > div').style.background = '#198754';
            
            // Add strikethrough to title
            const title = taskCard.querySelector('.card-title');
            title.classList.add('text-decoration-line-through', 'text-muted');
            
            // Wait 3 seconds before submitting
            setTimeout(() => {
                submitToggle(taskId);
            }, 3000);
        } else {
            // If unchecking, submit immediately
            submitToggle(taskId);
        }
    };
    
    function submitToggle(taskId) {
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
    }

    // Filter tasks function (needs to be global for event listeners)
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

    // Initialize event listeners when DOM is ready
    document.addEventListener('DOMContentLoaded', function() {
        // Task reminder checkbox toggle
        const taskReminderCheckbox = document.getElementById('taskReminder');
        if (taskReminderCheckbox) {
            taskReminderCheckbox.addEventListener('change', function() {
                const reminderSettings = document.getElementById('reminderSettings');
                if (this.checked) {
                    reminderSettings.style.display = 'block';
                } else {
                    reminderSettings.style.display = 'none';
                }
            });
        }

        // Save task button
        const saveTaskBtn = document.getElementById('saveTaskBtn');
        if (saveTaskBtn) {
            saveTaskBtn.addEventListener('click', async function(e) {
                e.preventDefault();
                const form = document.getElementById('taskForm');
                const taskId = document.getElementById('taskId').value;
                
                // Validate required fields
                const title = document.getElementById('taskTitle').value.trim();
                if (!title) {
                    alert('Please enter a task title');
                    return;
                }
                
                // Disable button to prevent double submission
                saveTaskBtn.disabled = true;
                saveTaskBtn.textContent = 'Saving...';
                
                try {
                    const formData = new FormData(form);
                    
                    // Handle checkbox - convert to 1 or 0
                    const reminderCheckbox = document.getElementById('taskReminder');
                    if (reminderCheckbox) {
                        formData.set('reminder', reminderCheckbox.checked ? '1' : '0');
                    }
                    
                    const url = taskId ? `/tasks/${taskId}` : '<?php echo e(route("tasks.store")); ?>';
                    const method = taskId ? 'PUT' : 'POST';
                    
                    if (method === 'PUT') {
                        formData.append('_method', 'PUT');
                    }
                    
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'text/html'
                        }
                    });
                    
                    if (response.ok) {
                        // Force full page reload
                        window.location.href = '<?php echo e(route("tasks.index")); ?>?_=' + Date.now();
                    } else {
                        alert('Error saving task. Please try again.');
                        saveTaskBtn.disabled = false;
                        saveTaskBtn.innerHTML = '💾 Save Task';
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error saving task. Please try again.');
                    saveTaskBtn.disabled = false;
                    saveTaskBtn.innerHTML = '💾 Save Task';
                }
            });
        }

        // Add click handler for Add Task button
        const addTaskBtn = document.getElementById('addTaskBtn');
        if (addTaskBtn) {
            addTaskBtn.addEventListener('click', function(e) {
                console.log('Add Task button clicked');
            });
        }

        // Reset form when modal is hidden
        const modalElement = document.getElementById('addTaskModal');
        if (modalElement) {
            modalElement.addEventListener('hidden.bs.modal', function() {
                document.getElementById('taskForm').reset();
                document.getElementById('taskId').value = '';
                document.getElementById('reminderSettings').style.display = 'none';
                document.getElementById('addTaskModalLabel').textContent = 'Add New Task';
            });
        }

        // Tab switching event listeners
        const activeTab = document.getElementById('active-tab');
        const completedTab = document.getElementById('completed-tab');
        
        if (activeTab) {
            activeTab.addEventListener('click', function() {
                this.style.background = '#896C6C';
                this.style.color = 'white';
                document.getElementById('activeTaskCount').style.background = 'rgba(255,255,255,0.3)';
                document.getElementById('activeTaskCount').style.color = 'white';
                
                completedTab.style.background = 'transparent';
                completedTab.style.color = '#6c757d';
                document.getElementById('completedTaskCount').style.background = '#6c757d';
                document.getElementById('completedTaskCount').style.color = 'white';
            });
        }

        if (completedTab) {
            completedTab.addEventListener('click', function() {
                this.style.background = '#6c757d';
                this.style.color = 'white';
                document.getElementById('completedTaskCount').style.background = 'rgba(255,255,255,0.3)';
                document.getElementById('completedTaskCount').style.color = 'white';
                
                activeTab.style.background = 'transparent';
                activeTab.style.color = '#896C6C';
                document.getElementById('activeTaskCount').style.background = '#896C6C';
                document.getElementById('activeTaskCount').style.color = 'white';
            });
        }

        // Search and filter functionality
        const searchInput = document.getElementById('searchTasks');
        const filterSelect = document.getElementById('filterPriority');
        
        if (searchInput) {
            searchInput.addEventListener('input', filterTasks);
        }
        
        if (filterSelect) {
            filterSelect.addEventListener('change', filterTasks);
        }

        // Initialize Flatpickr for datetime picker
        flatpickr("#taskDeadline", {
            enableTime: true,
            dateFormat: "Y-m-d H:i",
            time_24hr: false,
            minuteIncrement: 15,
            altInput: true,
            altFormat: "F j, Y h:i K",
            minDate: "today"
        });

        // Show success message if exists
        <?php if(session('success')): ?>
            document.getElementById('toastMessage').textContent = '<?php echo e(session("success")); ?>';
            const toast = new bootstrap.Toast(document.getElementById('successToast'));
            toast.show();
        <?php endif; ?>
    });
    
    // Pass tasks data to reminder system
    window.pageTasksData = [
        <?php $__currentLoopData = $tasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            {
                id: <?php echo e($task->id); ?>,
                title: "<?php echo e(addslashes($task->title)); ?>",
                description: "<?php echo e(addslashes($task->description ?? '')); ?>",
                status: "<?php echo e($task->status); ?>",
                priority: "<?php echo e($task->priority); ?>",
                deadline: "<?php echo e($task->deadline ? $task->deadline->format('Y-m-d H:i:s') : ''); ?>",
                reminder: <?php echo e($task->reminder ? 'true' : 'false'); ?>,
                reminder_time: <?php echo e($task->reminder_time ?? 15); ?>

            },
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    ];
    console.log('Tasks loaded on page:', window.pageTasksData);
</script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\dailydo-laravel\dailydo-laravel\resources\views/tasks/index.blade.php ENDPATH**/ ?>