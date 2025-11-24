<?php
require_once 'includes/auth.php';

// Require login for calendar
requireLogin();
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Calendar - DailyDo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  <script defer src="assets/script.js"></script>
  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    .calendar-container {
      background: #F1F0E4;
      border-radius: 20px;
      padding: 2rem;
    }
    
    .calendar-header {
      background: white;
      border-radius: 15px;
      padding: 1.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .calendar-grid {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    
    .calendar-day-header {
      background: #896C6C;
      color: white;
      padding: 1rem;
      text-align: center;
      font-weight: 600;
      border-right: 1px solid rgba(255,255,255,0.2);
    }
    
    .calendar-day-header:last-child {
      border-right: none;
    }
    
    .calendar-day {
      min-height: 120px;
      border: 1px solid #e9ecef;
      padding: 0.5rem;
      position: relative;
      cursor: pointer;
      transition: background-color 0.2s ease;
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
      margin-bottom: 0.5rem;
    }
    
    .task-indicator {
      font-size: 0.75rem;
      padding: 0.2rem 0.4rem;
      border-radius: 8px;
      margin-bottom: 0.2rem;
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
      border-radius: 10px;
      padding: 0.5rem 1rem;
      font-weight: 600;
      transition: all 0.3s ease;
    }
    
    .nav-button:hover {
      background: #7a5d5d;
      color: white;
    }
    
    .month-year-display {
      color: #896C6C;
      font-weight: 700;
      font-size: 1.5rem;
    }
  </style>
</head>
<body>
  <!-- SIDEBAR OVERLAY -->
  <div class="sidebar-overlay" id="sidebarOverlay"></div>
  
  <!-- SIDEBAR -->
  <div class="sidebar" id="sidebar">
    <div class="sidebar-header">
      <h4 class="sidebar-brand">DailyDo</h4>
      <button class="sidebar-toggle d-lg-none" id="sidebarToggle">
        <i class="bi bi-x-lg"></i>
      </button>
    </div>
    <nav class="sidebar-nav">
      <ul class="nav flex-column">
        <li class="nav-item">
          <a class="nav-link" href="profile.php">
            <i class="bi bi-person-circle me-2"></i>
            Profile
          </a>
        </li>
        <?php if (!isAdmin()): ?>
        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">
            <i class="bi bi-speedometer2 me-2"></i>
            Dashboard
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="tasks.php">
            <i class="bi bi-list-task me-2"></i>
            Task List
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active" href="calendar.php">
            <i class="bi bi-calendar-check me-2"></i>
            Calendar
          </a>
        </li>
        <?php endif; ?>
        <?php if (isAdmin()): ?>
        <li class="nav-item">
          <a class="nav-link" href="admin.php">
            <i class="bi bi-people me-2"></i>
            User Management
          </a>
        </li>
        <?php endif; ?>
      </ul>
    </nav>
    <div class="sidebar-footer">
      <a class="nav-link logout-link" href="#" id="logoutBtn">
        <i class="bi bi-box-arrow-right me-2"></i>
        Logout
      </a>
    </div>
  </div>

  <!-- MAIN CONTENT -->
  <div class="main-content">
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top" style="box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
      <div class="container-fluid">
        <button class="navbar-toggler d-lg-none me-2" type="button" id="mobileMenuToggle">
          <i class="bi bi-list"></i>
        </button>
        <a class="navbar-brand fw-bold d-lg-none" href="calendar.php">DailyDo</a>
        <div class="ms-auto">
          <span class="navbar-text d-none d-lg-inline" id="currentDate">Loading...</span>
        </div>
      </div>
    </nav>

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
    <section class="calendar-section mt-4">
      <div class="container-fluid px-4 py-4">
        <!-- Header Section -->
        <div class="row mb-4">
          <div class="col-12">
            <h1 class="display-6 fw-bold mb-2"><i class="bi bi-calendar-check me-2" style="color: #896C6C;"></i>Task Calendar</h1>
            <p class="text-muted fs-5 mb-4">View your tasks organized by due dates</p>
          </div>
        </div>

        <!-- Calendar Container -->
        <div class="calendar-container">
          <!-- Calendar Header with Navigation -->
          <div class="calendar-header">
            <div class="row align-items-center">
              <div class="col-auto">
                <button class="nav-button" id="prevMonth">
                  <i class="bi bi-chevron-left"></i> Previous
                </button>
              </div>
              <div class="col text-center">
                <h2 class="month-year-display mb-0" id="monthYearDisplay">Loading...</h2>
              </div>
              <div class="col-auto">
                <button class="nav-button" id="nextMonth">
                  Next <i class="bi bi-chevron-right"></i>
                </button>
              </div>
            </div>
            <div class="row mt-3">
              <div class="col text-center">
                <button class="btn btn-outline-secondary btn-sm" id="todayBtn">
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
  </div>

  <!-- Task Detail Modal -->
  <div class="modal fade" id="taskDetailModal" tabindex="-1" aria-labelledby="taskDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content" style="border-radius: 20px; border: none;">
        <div class="modal-header" style="background: #896C6C; color: white; border-radius: 20px 20px 0 0;">
          <h5 class="modal-title" id="taskDetailModalLabel">
            <i class="bi bi-calendar-event me-2"></i>Tasks for <span id="selectedDate"></span>
          </h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding: 2rem;">
          <div id="taskDetailContent">
            <!-- Task details will be loaded here -->
          </div>
        </div>
      </div>
    </div>
  </div>

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
      
      // Logout functionality
       document.getElementById('logoutBtn').addEventListener('click', async function(e) {
         e.preventDefault();
         try {
           await fetch('api/logout.php', { method: 'POST' });
           localStorage.removeItem('profileData');
           localStorage.removeItem('userSession');
           window.location.href = 'index.php';
         } catch (error) {
           console.error('Logout error:', error);
           window.location.href = 'index.php';
         }
       });
      
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
        const response = await fetch('api/tasks.php');
        const data = await response.json();
        
        console.log('Calendar: Loaded tasks data:', data); // Debug log
        
        if (data.success) {
          // Group tasks by date
          tasksData = {};
          data.tasks.forEach(task => {
            console.log('Processing task:', task); // Debug log
            if (task.deadline && task.deadline !== null && task.deadline !== '') {
              try {
                const taskDate = new Date(task.deadline);
                
                // Check if date is valid
                if (!isNaN(taskDate.getTime())) {
                  const dateKey = `${taskDate.getFullYear()}-${String(taskDate.getMonth() + 1).padStart(2, '0')}-${String(taskDate.getDate()).padStart(2, '0')}`;
                  console.log('Date key for task:', dateKey, 'from deadline:', task.deadline); // Debug log
                  
                  if (!tasksData[dateKey]) {
                    tasksData[dateKey] = [];
                  }
                  tasksData[dateKey].push(task);
                } else {
                  console.log('Invalid date for task:', task.deadline);
                }
              } catch (dateError) {
                console.error('Error parsing date for task:', task.deadline, dateError);
              }
            }
          });
          
          console.log('Final tasksData:', tasksData); // Debug log
        } else {
          console.error('Failed to load tasks:', data.message);
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

      // Get first day of month and number of days
      const firstDay = new Date(currentYear, currentMonth, 1);
      const lastDay = new Date(currentYear, currentMonth + 1, 0);
      const daysInMonth = lastDay.getDate();
      const startingDayOfWeek = firstDay.getDay();

      // Calculate previous month days to show
      const prevMonth = currentMonth === 0 ? 11 : currentMonth - 1;
      const prevYear = currentMonth === 0 ? currentYear - 1 : currentYear;
      const daysInPrevMonth = new Date(prevYear, prevMonth + 1, 0).getDate();

      let dayCount = 1;
      let nextMonthDayCount = 1;

      // Generate 6 weeks (42 days)
      for (let week = 0; week < 6; week++) {
        const weekRow = document.createElement('div');
        weekRow.className = 'row g-0';

        for (let day = 0; day < 7; day++) {
          const dayCell = document.createElement('div');
          dayCell.className = 'col calendar-day';

          const dayIndex = week * 7 + day;
          let dayNumber, isCurrentMonth = true, cellDate;

          if (dayIndex < startingDayOfWeek) {
            // Previous month days
            dayNumber = daysInPrevMonth - startingDayOfWeek + dayIndex + 1;
            dayCell.classList.add('other-month');
            isCurrentMonth = false;
            cellDate = new Date(prevYear, prevMonth, dayNumber);
          } else if (dayCount <= daysInMonth) {
            // Current month days
            dayNumber = dayCount;
            cellDate = new Date(currentYear, currentMonth, dayNumber);
            dayCount++;
          } else {
            // Next month days
            dayNumber = nextMonthDayCount;
            dayCell.classList.add('other-month');
            isCurrentMonth = false;
            const nextMonth = currentMonth === 11 ? 0 : currentMonth + 1;
            const nextYear = currentMonth === 11 ? currentYear + 1 : currentYear;
            cellDate = new Date(nextYear, nextMonth, dayNumber);
            nextMonthDayCount++;
          }

          // Check if it's today
          const today = new Date();
          if (cellDate.toDateString() === today.toDateString()) {
            dayCell.classList.add('today');
          }

          // Create day content
          const dayNumberDiv = document.createElement('div');
          dayNumberDiv.className = 'calendar-day-number';
          dayNumberDiv.textContent = dayNumber;
          dayCell.appendChild(dayNumberDiv);

          // Add tasks for this date
          const dateKey = `${cellDate.getFullYear()}-${String(cellDate.getMonth() + 1).padStart(2, '0')}-${String(cellDate.getDate()).padStart(2, '0')}`;
          if (tasksData[dateKey]) {
            const tasksToShow = tasksData[dateKey].slice(0, 3); // Show max 3 tasks
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

          // Add click event to show task details
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
          <div class="text-center py-4">
            <i class="bi bi-calendar-x" style="font-size: 3rem; color: #6c757d;"></i>
            <h5 class="mt-3 text-muted">No tasks scheduled</h5>
            <p class="text-muted">You have no tasks due on this date.</p>
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
            <div class="card mb-3 border-0 shadow-sm">
              <div class="card-body">
                <div class="d-flex align-items-start">
                  <i class="bi ${statusIcon} me-3 mt-1" style="color: ${priorityColor}; font-size: 1.2rem;"></i>
                  <div class="flex-grow-1">
                    <h6 class="card-title mb-2 ${statusClass}">${task.title}</h6>
                    ${task.description ? `<p class="card-text text-muted small ${statusClass}">${task.description}</p>` : ''}
                    <div class="d-flex align-items-center gap-3">
                      <span class="badge" style="background: ${priorityColor};">${task.priority.toUpperCase()}</span>
                      <small class="text-muted">
                        <i class="bi bi-clock me-1"></i>
                        ${new Date(task.deadline).toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'})}
                      </small>
                      <small class="text-muted">
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
</body>
</html>

<!-- style.css -->

*{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body{
    font-family: "Poppins", sans-serif;
    min-height: 100vh;
    background-color: #fff;
    margin: 0;
}

.navbar{
    display: flex;
    align-items: center;
    justify-content: center;
    height: 80px;
    width: 100%;
    position: sticky;
    top: 0;
    background: #F1F0E4;
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(10px);
    z-index: 999;
}

.navbar-container{
    display: flex;
    align-items: center;
    justify-content: space-between;
    width: 100%;
    max-width: 100%;
    padding: 0px 50px;
}

.navbar-logo{
    font-size: 2rem;
    font-weight: 600;
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.navbar-container .navbar-menu{
    display: flex;
    text-align: center;
    gap: 1.5rem;
    list-style: none;
}

.navbar-container .navbar-menu li a{
    text-decoration: none;
    color: black;
    font-size: 1.3rem;
    font-weight: 500;
    padding: 3px 20px;
    border-radius: 20px;
    border: 2px solid transparent;
    transition: all 0.2s;
    white-space: nowrap;
    display: block;
    width: 100%;
    height: 100%;
    cursor: pointer;
}

.navbar-container .navbar-menu li a.logout-btn {
    color: #dc3545;
    font-weight: 600;
}

.navbar-container .navbar-menu li a:hover,
.navbar-container .navbar-menu li a.active:hover{
    color: #FAF9EE;
    background: rgba(137,108,108,0.8);
    border: 2px solid #DDDAD0;
}

.navbar-container .navbar-menu li a.logout-btn:hover {
    color: #FAF9EE;
    background: rgba(220, 53, 69, 0.8);
    border: 2px solid #dc3545;
}

.navbar-toggle{
    display: none;
    background: transparent;
    padding: 10px;
    border: none;
    cursor: pointer;
}

.bar{
    display: block;
    width: 25px;
    height: 3px;
    margin: 5px auto;
    background: black;
    transition: all 0.2s;
}

/*LANDING PAGE*/
.hero {
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    background: url("images/To-Do_BG.png") no-repeat center center/cover;
    color: white;
    position: relative;
    padding: 1rem;
}

.hero-content {
    max-width: 700px;
    width: 100%;
    padding: 2rem 1.5rem;
    background: rgba(221, 218, 208, 0.09);
    backdrop-filter: blur(10px);
    border-radius: 50px;
    color: black;
    margin: 0 1rem;
}

.hero-content h1{
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    font-weight: 600;
    line-height: 1.2;
}

.hero-content p {
    font-size: clamp(1rem, 2.5vw, 1.2rem);
    margin-top: 1rem;
}

.footer {
    color: #aaa;
    text-align: center;
    padding: 0.7rem 0;
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    z-index: 1000;
}

/* Task List Styles */
.task-section {
  min-height: calc(100vh - 200px);
  padding-left: 1.5rem;
  padding-right: 1.5rem;
}

.task-card {
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.task-card:hover {
  box-shadow: 0 4px 8px rgba(0,0,0,0.15);
  transform: translateY(-2px);
}

.task-card.completed-task {
  background-color: #f8f9fa;
  border-color: #dee2e6;
}

.task-card .card-body {
  padding: 1.25rem;
}

.task-card .btn-sm {
  padding: 0.25rem 0.5rem;
  font-size: 0.875rem;
}

.task-card .badge {
  font-size: 0.75rem;
  padding: 0.25em 0.5em;
}

.task-checkbox {
  transition: transform 0.2s ease;
}

.task-checkbox:hover {
  transform: scale(1.1);
}

.task-checkbox i {
  transition: color 0.2s ease;
}

.task-checkbox:hover i {
  color: #198754 !important;
}

/* Priority colors */
.badge.bg-danger {
  background-color: #dc3545 !important;
}

.badge.bg-warning {
  background-color: #ffc107 !important;
  color: #000;
}

.badge.bg-success {
  background-color: #198754 !important;
}

/* Modal customization */
.modal-content {
  border-radius: 8px;
  border: none;
  box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.modal-header {
  border-bottom: 1px solid #dee2e6;
  border-radius: 8px 8px 0 0;
}

.modal-footer {
  border-top: 1px solid #dee2e6;
  border-radius: 0 0 8px 8px;
}

/* Form controls */
.form-control:focus,
.form-select:focus {
  border-color: #896C6C;
  box-shadow: 0 0 0 0.2rem rgba(137, 108, 108, 0.25);
}

/* Toast notification */
.toast {
  border-radius: 8px;
}

/* Search and filter section */
.input-group-text {
  background-color: #f8f9fa;
  border-color: #ced4da;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .task-section {
    padding-left: 1rem;
    padding-right: 1rem;
  }
  
  .task-card .d-flex.gap-2 {
    flex-direction: column;
    gap: 0.5rem !important;
  }
  
  .task-card .btn-sm {
    width: 100%;
    justify-content: center;
  }
  
  .modal-dialog {
    margin: 1rem;
  }
}

/*LOGIN & REGISTER STYLES*/
.register-section, .login-section {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #f5f5f5;
    padding: 1rem;
}

.register-container, .login-container {
    background: #fff;
    padding: clamp(1.5rem, 4vw, 2rem);
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    text-align: center;
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
}

.register-container h2, .login-container h2 {
    margin-bottom: 0.5rem;
    font-size: 1.8rem;
    color: #333;
}

.register-container p, .login-container p {
    color: #666;
    margin-bottom: 1.5rem;
}

.register-form .form-group, .login-form .form-group {
    margin-bottom: 1rem;
}

.register-form input, .login-form input {
    width: 100%;
    padding: 0.8rem 1rem;
    border: 1px solid #ccc;
    border-radius: 8px;
    font-size: 1rem;
    outline: none;
}

.register-btn, .login-btn {
    width: 100%;
    padding: 0.8rem;
    background: #F1F0E4;
    color: black;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    transition: 0.2s;
}

.register-btn:hover, .login-btn:hover {
    background: #896C6C;
    color: white;
}

.register-link {
    margin-top: 1rem;
    font-size: 0.9rem;
    color: #666;
}

.register-link a{
    color: #896C6C;
    text-decoration: none;
}

.register-link a:hover {
    text-decoration: underline;
}


/*RESPONSIVE*/
/* Tablet and below */
@media (max-width: 991.98px) {
    .hero-content {
        margin: 0 0.5rem;
        padding: 1.5rem 1rem;
        border-radius: 30px;
    }
    
    .features .col-md-4 {
        margin-bottom: 2rem;
    }
    
    .register-container, .login-container {
        max-width: 350px;
    }
}

@media (max-width: 880px){
    .navbar{
        backdrop-filter: none;
        background-color: #FAF9EE;
    }

    .navbar-container .navbar-menu{
        display: none;
        flex-direction: column;
        align-items: flex-start;
        gap: 1.7rem !important;
        position: absolute;
        height: 100vh;
        width: 250px;
        top: 0;
        right: 0;
        padding: 5rem 1.5rem;
        box-shadow: 0px 10px 10px rgba(0,0,0,0.5);
        backdrop-filter: blur(10px);
        background-color: #FAF9EE;
    }

    .navbar-container .navbar-menu.active{
        display: flex;
    }

    .navbar-toggle{
        display: block;
        z-index: 999;
    }

    .navbar-toggle.active .bar:nth-child(2){
        opacity: 0;
    }
    .navbar-toggle.active .bar:nth-child(1){
        transform: translateY(8px) rotate(45deg);
    }
    .navbar-toggle.active .bar:nth-child(3){
        transform: translateY(-8px) rotate(-45deg);
    }
}

/* Mobile devices */
@media (max-width: 576px) {
    .navbar-container{
        padding: 0 1rem;
    }

    .navbar-logo{
        font-size: 1.7rem;
    }

    .navbar-container .navbar-menu li a{
        font-size: 1.2rem;
        padding: 3px 15px;
    }
    
    .hero {
        padding: 0.5rem;
    }
    
    .hero-content {
        margin: 0;
        padding: 1.5rem 1rem;
        border-radius: 20px;
    }
    
    .register-container, .login-container {
        max-width: 300px;
        padding: 1.5rem 1rem;
    }
    
    .register-container h2, .login-container h2 {
        font-size: 1.5rem;
    }
    
    .features {
        padding: 2rem 0 !important;
    }
    
    .features h3 {
        font-size: 1.3rem;
    }
    
    .features p {
        font-size: 0.9rem;
    }
}

/* SIDEBAR STYLES */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 280px;
    background: #F1F0E4;
    border-right: 1px solid #DDDAD0;
    z-index: 1000;
    display: flex;
    flex-direction: column;
    transition: transform 0.3s ease;
}

.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid #DDDAD0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.sidebar-brand {
    color: #896C6C;
    font-weight: 700;
    margin: 0;
    font-size: 1.5rem;
}

.sidebar-toggle {
    background: none;
    border: none;
    color: #896C6C;
    font-size: 1.2rem;
    cursor: pointer;
    padding: 0.5rem;
    border-radius: 6px;
    transition: background-color 0.2s;
}

.sidebar-toggle:hover {
    background-color: rgba(137, 108, 108, 0.1);
}

.sidebar-nav {
    flex: 1;
    padding: 1rem 0;
}

.sidebar-nav .nav-link {
    color: #333;
    padding: 0.75rem 1.5rem;
    border-radius: 0;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    text-decoration: none;
    font-weight: 500;
}

.sidebar-nav .nav-link:hover {
    background-color: rgba(137, 108, 108, 0.1);
    color: #896C6C;
}

.sidebar-nav .nav-link.active {
    background-color: #896C6C;
    color: white;
    border-left: 4px solid #6d5454;
}

.sidebar-nav .nav-link i {
    font-size: 1.1rem;
    width: 20px;
}

.sidebar-footer {
    padding: 1rem;
    border-top: 1px solid #DDDAD0;
}

.logout-link {
    color: #dc3545 !important;
    padding: 0.75rem 0.5rem;
    border-radius: 6px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    text-decoration: none;
    font-weight: 500;
    cursor: pointer;
    pointer-events: auto;
    position: relative;
    z-index: 1001;
}

.logout-link:hover {
    background-color: rgba(220, 53, 69, 0.1);
    color: #000000 !important;
}

.main-content {
    margin-left: 280px;
    min-height: 100vh;
    padding-bottom: 60px;
    transition: margin-left 0.3s ease;
}

/* RESPONSIVE SIDEBAR */
@media (max-width: 991.98px) {
    .sidebar {
        transform: translateX(-100%);
    }
    
    .sidebar.show {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0;
        padding-bottom: 60px;
    }
    
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 999;
        display: none;
    }
    
    .sidebar-overlay.show {
        display: block;
    }
}

/* Dashboard Responsive Styles */
@media (max-width: 991.98px) {
    .dashboard-section .container-fluid {
        padding: 1rem !important;
    }
    
    .dashboard-section h1 {
        font-size: clamp(1.5rem, 4vw, 2rem) !important;
    }
    
    .dashboard-section .card-body {
        padding: 1.5rem !important;
    }
}

@media (max-width: 768px) {
    .dashboard-section .row.g-4 {
        gap: 1rem !important;
    }
    
    .dashboard-section .col-md-6,
    .dashboard-section .col-md-4,
    .dashboard-section .col-md-2 {
        margin-bottom: 0.5rem;
    }
    
    .dashboard-section .btn-lg {
        padding: 0.5rem 1rem;
        font-size: 1rem;
    }
    
    .dashboard-section .form-control-lg {
        padding: 0.5rem 0.75rem;
        font-size: 1rem;
    }
}

@media (max-width: 576px) {
    .dashboard-section .container-fluid {
        padding: 0.5rem !important;
    }
    
    .dashboard-section .card {
        border-radius: 15px !important;
    }
    
    .dashboard-section .card-body {
        padding: 1rem !important;
    }
    
    .dashboard-section h4 {
        font-size: 1.2rem;
    }
    
    .dashboard-section .row.mt-3 {
        margin-top: 1rem !important;
    }
}