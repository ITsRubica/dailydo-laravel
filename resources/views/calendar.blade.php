@extends('layouts.app')

@section('title', 'Calendar - DailyDo')

@push('styles')
<style>
    .calendar-container {
        background: #F1F0E4;
        border-radius: 15px;
        padding: 1.5rem;
    }
    
    .calendar-header {
        background: white;
        border-radius: 12px;
        padding: 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .calendar-grid {
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    
    .calendar-day-header {
        background: #896C6C;
        color: white;
        padding: 0.75rem;
        text-align: center;
        font-weight: 600;
        font-size: 0.85rem;
        border-right: 1px solid rgba(255,255,255,0.2);
    }
    
    .calendar-day-header:last-child {
        border-right: none;
    }
    
    .calendar-day {
        min-height: 100px;
        border: 1px solid #e9ecef;
        padding: 0.5rem;
        position: relative;
        cursor: pointer;
        transition: background-color 0.2s ease;
        overflow: hidden;
    }
    
    /* Tablet */
    @media (max-width: 768px) {
        .calendar-container {
            padding: 1rem;
        }
        
        .calendar-day-header {
            font-size: 0.75rem;
            padding: 0.6rem 0.3rem;
        }
        
        .calendar-day {
            min-height: 80px;
            padding: 0.4rem;
        }
        
        .calendar-day-number {
            font-size: 0.8rem;
        }
    }
    
    /* Mobile */
    @media (max-width: 576px) {
        .calendar-container {
            padding: 0.75rem;
            border-radius: 10px;
        }
        
        .calendar-header {
            padding: 0.75rem;
            margin-bottom: 1rem;
        }
        
        .calendar-day-header {
            font-size: 0.7rem;
            padding: 0.5rem 0.2rem;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        .calendar-day {
            min-height: 65px;
            padding: 0.3rem;
        }
        
        .calendar-day-number {
            font-size: 0.75rem;
            margin-bottom: 0.2rem;
        }
        
        .task-indicator {
            font-size: 0.6rem;
            padding: 0.1rem 0.25rem;
            margin-bottom: 0.1rem;
        }
    }
    
    /* Extra small mobile */
    @media (max-width: 400px) {
        .calendar-day-header {
            font-size: 0.65rem;
            padding: 0.4rem 0.15rem;
        }
        
        .calendar-day {
            min-height: 55px;
            padding: 0.25rem;
        }
        
        .calendar-day-number {
            font-size: 0.7rem;
        }
    }
    
    .calendar-day:hover {
        background-color: #f8f9fa;
    }
    
    .calendar-day.other-month {
        background-color: #f8f9fa;
        color: #6c757d;
    }
    
    .calendar-day.today {
        background-color: #fff3cd;
        border-color: #ffc107;
    }
    
    .calendar-day-number {
        font-weight: 600;
        margin-bottom: 0.4rem;
        font-size: 0.85rem;
    }
    
    .task-indicator {
        font-size: 0.7rem;
        padding: 0.15rem 0.3rem;
        border-radius: 6px;
        margin-bottom: 0.15rem;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        cursor: pointer;
    }
    
    .task-high {
        background-color: #dc3545;
        color: white;
    }
    
    .task-medium {
        background-color: #ffc107;
        color: #212529;
    }
    
    .task-low {
        background-color: #28a745;
        color: white;
    }
    
    .task-completed {
        background-color: #6c757d;
        color: white;
        text-decoration: line-through;
    }
    
    .nav-button {
        background: #896C6C;
        color: white;
        border: none;
        border-radius: 8px;
        padding: 0.4rem 0.8rem;
        font-weight: 600;
        font-size: 0.85rem;
        transition: all 0.3s ease;
    }
    
    .nav-button:hover {
        background: #7a5d5d;
        color: white;
    }
    
    .month-year-display {
        color: #896C6C;
        font-weight: 700;
        font-size: 1.3rem;
    }
    
    /* Mobile responsiveness for header */
    @media (max-width: 576px) {
        .month-year-display {
            font-size: 1.1rem;
        }
        
        .nav-button {
            padding: 0.35rem 0.6rem;
            font-size: 0.8rem;
        }
    }
</style>
@endpush

@section('content')
<!-- TOAST NOTIFICATION -->
<div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1055;">
    <div id="successToast" class="toast align-items-center text-white border-0" role="alert" aria-live="assertive" aria-atomic="true" style="background: #896C6C;">
        <div class="d-flex">
            <div class="toast-body" id="toastMessage">
                Calendar loaded successfully!
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<!-- CALENDAR SECTION -->
<section class="calendar-section mt-3" style="padding-bottom: 3rem;">
    <div class="container-fluid px-4 py-3">
        <!-- Header Section -->
        <div class="row mb-3">
            <div class="col-12">
                <h1 class="fw-bold mb-1" style="font-size: 1.5rem;"><i class="bi bi-calendar-check me-2" style="color: #896C6C;"></i>Task Calendar</h1>
                <p class="text-muted mb-0" style="font-size: 0.95rem;">View your tasks organized by due dates</p>
            </div>
        </div>

        <!-- Calendar Container -->
        <div class="calendar-container">
            <!-- Calendar Header with Navigation -->
            <div class="calendar-header">
                <div class="row align-items-center g-2">
                    <div class="col-auto">
                        <button class="nav-button" id="prevMonth">
                            <i class="bi bi-chevron-left"></i><span class="d-none d-sm-inline"> Previous</span>
                        </button>
                    </div>
                    <div class="col text-center">
                        <h2 class="month-year-display mb-0" id="monthYearDisplay">Loading...</h2>
                    </div>
                    <div class="col-auto">
                        <button class="nav-button" id="nextMonth">
                            <span class="d-none d-sm-inline">Next </span><i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col text-center">
                        <button class="btn btn-outline-secondary btn-sm" id="todayBtn" style="font-size: 0.8rem; padding: 4px 12px;">
                            <i class="bi bi-calendar-day me-1"></i>Today
                        </button>
                    </div>
                </div>
            </div>

            <!-- Calendar Grid -->
            <div class="calendar-grid">
                <!-- Day Headers -->
                <div class="row g-0">
                    <div class="col calendar-day-header">Sunday</div>
                    <div class="col calendar-day-header">Monday</div>
                    <div class="col calendar-day-header">Tuesday</div>
                    <div class="col calendar-day-header">Wednesday</div>
                    <div class="col calendar-day-header">Thursday</div>
                    <div class="col calendar-day-header">Friday</div>
                    <div class="col calendar-day-header">Saturday</div>
                </div>
                
                <!-- Calendar Days -->
                <div id="calendarDays">
                    <!-- Days will be generated by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Task Detail Modal -->
<div class="modal fade" id="taskDetailModal" tabindex="-1" aria-labelledby="taskDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="border-radius: 15px; border: none;">
            <div class="modal-header" style="background: #896C6C; color: white; border-radius: 15px 15px 0 0; padding: 1rem;">
                <h5 class="modal-title" id="taskDetailModalLabel" style="font-size: 1.1rem;">
                    <i class="bi bi-calendar-event me-2"></i>Tasks for <span id="selectedDate"></span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding: 1.5rem;">
                <div id="taskDetailContent">
                    <!-- Task details will be loaded here -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    let currentDate = new Date();
    let currentMonth = currentDate.getMonth();
    let currentYear = currentDate.getFullYear();
    let tasksData = {};

    const monthNames = [
        'January', 'February', 'March', 'April', 'May', 'June',
        'July', 'August', 'September', 'October', 'November', 'December'
    ];

    // Initialize calendar on page load
    document.addEventListener('DOMContentLoaded', async function() {
        await loadTasks();
        renderCalendar();
        
        // Event listeners
        document.getElementById('prevMonth').addEventListener('click', async () => {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            await loadTasks();
            renderCalendar();
        });

        document.getElementById('nextMonth').addEventListener('click', async () => {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            await loadTasks();
            renderCalendar();
        });

        document.getElementById('todayBtn').addEventListener('click', async () => {
            const today = new Date();
            currentMonth = today.getMonth();
            currentYear = today.getFullYear();
            await loadTasks();
            renderCalendar();
        });
    });

    // Load tasks from API
    async function loadTasks() {
        try {
            const apiResponse = await fetch('/api/calendar/tasks', {
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });
            const data = await apiResponse.json();
            
            if (data.success && data.tasks) {
                tasksData = {};
                
                data.tasks.forEach(task => {
                    if (task.deadline) {
                        const taskDate = new Date(task.deadline);
                        if (!isNaN(taskDate.getTime())) {
                            const dateKey = `${taskDate.getFullYear()}-${String(taskDate.getMonth() + 1).padStart(2, '0')}-${String(taskDate.getDate()).padStart(2, '0')}`;
                            if (!tasksData[dateKey]) {
                                tasksData[dateKey] = [];
                            }
                            tasksData[dateKey].push(task);
                        }
                    }
                });
                console.log('Tasks loaded for calendar:', Object.keys(tasksData).length, 'dates with tasks');
            }
        } catch (error) {
            console.error('Error loading tasks:', error);
        }
    }

    // Render calendar
    function renderCalendar() {
        const monthYearDisplay = document.getElementById('monthYearDisplay');
        monthYearDisplay.textContent = `${monthNames[currentMonth]} ${currentYear}`;

        const calendarDays = document.getElementById('calendarDays');
        calendarDays.innerHTML = '';

        const firstDay = new Date(currentYear, currentMonth, 1);
        const lastDay = new Date(currentYear, currentMonth + 1, 0);
        const daysInMonth = lastDay.getDate();
        const startingDayOfWeek = firstDay.getDay();

        const prevMonth = currentMonth === 0 ? 11 : currentMonth - 1;
        const prevYear = currentMonth === 0 ? currentYear - 1 : currentYear;
        const daysInPrevMonth = new Date(prevYear, prevMonth + 1, 0).getDate();

        let dayCount = 1;
        let nextMonthDayCount = 1;

        for (let week = 0; week < 6; week++) {
            const weekRow = document.createElement('div');
            weekRow.className = 'row g-0';

            for (let day = 0; day < 7; day++) {
                const dayCell = document.createElement('div');
                dayCell.className = 'col calendar-day';

                const dayIndex = week * 7 + day;
                let dayNumber, isCurrentMonth = true, cellDate;

                if (dayIndex < startingDayOfWeek) {
                    dayNumber = daysInPrevMonth - startingDayOfWeek + dayIndex + 1;
                    dayCell.classList.add('other-month');
                    isCurrentMonth = false;
                    cellDate = new Date(prevYear, prevMonth, dayNumber);
                } else if (dayCount <= daysInMonth) {
                    dayNumber = dayCount;
                    cellDate = new Date(currentYear, currentMonth, dayNumber);
                    dayCount++;
                } else {
                    dayNumber = nextMonthDayCount;
                    dayCell.classList.add('other-month');
                    isCurrentMonth = false;
                    const nextMonth = currentMonth === 11 ? 0 : currentMonth + 1;
                    const nextYear = currentMonth === 11 ? currentYear + 1 : currentYear;
                    cellDate = new Date(nextYear, nextMonth, dayNumber);
                    nextMonthDayCount++;
                }

                const today = new Date();
                if (cellDate.toDateString() === today.toDateString()) {
                    dayCell.classList.add('today');
                }

                const dayNumberDiv = document.createElement('div');
                dayNumberDiv.className = 'calendar-day-number';
                dayNumberDiv.textContent = dayNumber;
                dayCell.appendChild(dayNumberDiv);

                const dateKey = `${cellDate.getFullYear()}-${String(cellDate.getMonth() + 1).padStart(2, '0')}-${String(cellDate.getDate()).padStart(2, '0')}`;
                if (tasksData[dateKey]) {
                    const tasksToShow = tasksData[dateKey].slice(0, 3);
                    tasksToShow.forEach(task => {
                        const taskDiv = document.createElement('div');
                        taskDiv.className = `task-indicator task-${task.priority}`;
                        if (task.status === 'completed') {
                            taskDiv.classList.add('task-completed');
                        }
                        taskDiv.textContent = task.title;
                        taskDiv.title = task.title;
                        dayCell.appendChild(taskDiv);
                    });

                    if (tasksData[dateKey].length > 3) {
                        const moreDiv = document.createElement('div');
                        moreDiv.className = 'task-indicator';
                        moreDiv.style.background = '#6c757d';
                        moreDiv.style.color = 'white';
                        moreDiv.textContent = `+${tasksData[dateKey].length - 3} more`;
                        dayCell.appendChild(moreDiv);
                    }
                }

                dayCell.addEventListener('click', () => showTaskDetails(cellDate, tasksData[dateKey] || []));
                weekRow.appendChild(dayCell);
            }

            calendarDays.appendChild(weekRow);
        }
    }

    // Show task details in modal
    function showTaskDetails(date, tasks) {
        const modal = new bootstrap.Modal(document.getElementById('taskDetailModal'));
        const selectedDateSpan = document.getElementById('selectedDate');
        const taskDetailContent = document.getElementById('taskDetailContent');

        selectedDateSpan.textContent = date.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });

        if (tasks.length === 0) {
            taskDetailContent.innerHTML = `
                <div class="text-center py-3">
                    <i class="bi bi-calendar-x" style="font-size: 2.5rem; color: #6c757d;"></i>
                    <h5 class="mt-2 text-muted" style="font-size: 1rem;">No tasks scheduled</h5>
                    <p class="text-muted mb-0" style="font-size: 0.85rem;">You have no tasks due on this date.</p>
                </div>
            `;
        } else {
            let tasksHtml = '';
            tasks.forEach(task => {
                const priorityColor = task.priority === 'high' ? '#dc3545' : 
                                     task.priority === 'medium' ? '#ffc107' : '#28a745';
                const statusIcon = task.status === 'completed' ? 'bi-check-circle-fill' : 'bi-circle';
                const statusClass = task.status === 'completed' ? 'text-decoration-line-through text-muted' : '';

                tasksHtml += `
                    <div class="card mb-2 border-0 shadow-sm">
                        <div class="card-body p-2">
                            <div class="d-flex align-items-start">
                                <i class="bi ${statusIcon} me-2 mt-1" style="color: ${priorityColor}; font-size: 1rem;"></i>
                                <div class="flex-grow-1">
                                    <h6 class="card-title mb-1 ${statusClass}" style="font-size: 0.9rem;">${task.title}</h6>
                                    ${task.description ? `<p class="card-text text-muted small ${statusClass}" style="font-size: 0.75rem;">${task.description}</p>` : ''}
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge" style="background: ${priorityColor}; font-size: 0.7rem;">${task.priority.toUpperCase()}</span>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            <i class="bi bi-clock me-1"></i>
                                            ${new Date(task.deadline).toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'})}
                                        </small>
                                        <small class="text-muted" style="font-size: 0.75rem;">
                                            <i class="bi bi-flag me-1"></i>
                                            ${task.status.charAt(0).toUpperCase() + task.status.slice(1)}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            });
            taskDetailContent.innerHTML = tasksHtml;
        }

        modal.show();
    }
</script>
@endpush
