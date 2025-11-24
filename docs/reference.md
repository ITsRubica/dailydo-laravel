<?php
require_once 'includes/auth.php';

// Require login for dashboard
requireLogin();
$user = getCurrentUser();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Dashboard - DailyDo</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
  <script defer src="assets/script.js"></script>
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
          <a class="nav-link active" href="dashboard.php">
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
          <a class="nav-link" href="calendar.php">
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
        <a class="navbar-brand fw-bold d-lg-none" href="dashboard.php">DailyDo</a>
        <div class="ms-auto">
          <span class="navbar-text d-none d-lg-inline" id="currentDate">Loading...</span>
        </div>
      </div>
    </nav>

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
  <section class="dashboard-section mt-4">
    <div class="container-fluid px-4 py-4">
      <!-- Header Section -->
      <div class="row mb-4">
        <div class="col-12">
          <h1 class="display-6 fw-bold mb-2"><i class="bi bi-stars me-2" style="color: #896C6C;"></i>Welcome to your task space, <span id="userName">User</span>!</h1>
          <p class="text-muted fs-5">Stay organized and productive with DailyDo</p>
        </div>
      </div>

      <div class="row g-4">
        <!-- Quick Add Task - Large Card -->
         <div class="col-12 col-lg-8">
           <div class="card h-100" style="background: #F1F0E4; border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); border: 2px solid #896C6C;">
             <div class="card-body p-4">
               <div class="d-flex align-items-center mb-3">
                 <i class="bi bi-plus-circle-fill fs-3 me-3" style="color: #896C6C;"></i>
                 <h4 class="mb-0 fw-bold" style="color: #333;">Quick Add Task</h4>
               </div>
               <form id="quickAddForm">
                 <div class="row g-3">
                   <div class="col-md-6">
                     <input type="text" class="form-control form-control-lg" id="taskTitle" placeholder="What needs to be done?" required style="border-radius: 15px; border: 2px solid #DDDAD0;">
                   </div>
                   <div class="col-md-4">
                     <input type="datetime-local" class="form-control form-control-lg" id="taskDue" style="border-radius: 15px; border: 2px solid #DDDAD0;">
                   </div>
                   <div class="col-md-2">
                     <button type="submit" class="btn btn-lg w-100 fw-bold" style="border-radius: 15px; background: #896C6C; color: white; border: none;">Add</button>
                   </div>
                 </div>
                 <div class="row mt-3">
                   <div class="col-12">
                     <div class="form-check">
                       <input class="form-check-input" type="checkbox" id="setReminder" style="border-radius: 6px;">
                       <label class="form-check-label fw-medium" for="setReminder" style="color: #333;">
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
           <div class="card h-100 border-0" style="background: linear-gradient(135deg, #896C6C, #A67C7C); border-radius: 20px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
             <div class="card-body p-4 text-white text-center">
               <i class="bi bi-graph-up fs-1 mb-3"></i>
               <h3 class="fw-bold mb-2">Today's Progress</h3>
               <div class="row text-center">
                 <div class="col-6">
                   <h2 class="fw-bold mb-0" id="pendingCount">0</h2>
                   <small class="opacity-75">Pending</small>
                 </div>
                 <div class="col-6">
                   <h2 class="fw-bold mb-0" id="completedCount">0</h2>
                   <small class="opacity-75">Completed</small>
                 </div>
               </div>
             </div>
           </div>
         </div>

        <!-- Today's Tasks -->
        <div class="col-12 col-lg-6">
          <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header border-0 pt-4 px-4" style="background: #F1F0E4; border-radius: 20px 20px 0 0;">
               <div class="d-flex align-items-center">
                 <i class="bi bi-calendar-day fs-4 me-3" style="color: #896C6C;"></i>
                 <h5 class="mb-0 fw-bold" style="color: #333;">Today's Tasks</h5>
               </div>
             </div>
            <div class="card-body px-4 pb-4">
              <div id="todayTasks">
                <!-- Tasks will be displayed here -->
              </div>
            </div>
          </div>
        </div>

        <!-- Upcoming Tasks -->
        <div class="col-12 col-lg-6">
          <div class="card h-100 border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-header border-0 pt-4 px-4" style="background: #F1F0E4; border-radius: 20px 20px 0 0;">
               <div class="d-flex align-items-center">
                 <i class="bi bi-calendar-week fs-4 me-3" style="color: #896C6C;"></i>
                 <h5 class="mb-0 fw-bold" style="color: #333;">Upcoming Tasks</h5>
               </div>
             </div>
            <div class="card-body px-4 pb-4">
              <div id="upcomingTasks">
                <!-- Tasks will be displayed here -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <p>&copy; 2025 DailyDo. All rights reserved.</p>
  </footer>
  </div> <!-- End main-content -->

  <script>
    // Sidebar functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const sidebarToggle = document.getElementById('sidebarToggle');
    
    // Mobile menu toggle
    if (mobileMenuToggle) {
      mobileMenuToggle.addEventListener('click', function() {
        sidebar.classList.add('show');
        sidebarOverlay.classList.add('show');
      });
    }
    
    // Sidebar close button
    if (sidebarToggle) {
      sidebarToggle.addEventListener('click', function() {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
      });
    }
    
    // Overlay click to close sidebar
    if (sidebarOverlay) {
      sidebarOverlay.addEventListener('click', function() {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
      });
    }
    
    // Close sidebar on window resize if desktop
    window.addEventListener('resize', function() {
      if (window.innerWidth >= 992) {
        sidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
      }
    });

    // Fetch user data from API
    async function fetchUserData() {
      try {
        const response = await fetch('api/user.php');
        
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        
        const data = await response.json();
        
        if (data.success && data.user) {
          const fullName = data.user.first_name || data.user.username || 'User';
          document.getElementById('userName').textContent = fullName;
        } else {
          // If not authenticated, redirect to login
          console.log('User not authenticated, redirecting to login');
          window.location.href = 'login.php';
        }
      } catch (error) {
        console.error('Error fetching user data:', error);
        // Set a default name instead of leaving it blank
        const userNameElement = document.getElementById('userName');
        if (userNameElement) {
          userNameElement.textContent = 'User';
        }
      }
    }

    // Initialize dashboard data
    function initializeDashboard() {
      // Set current date
      const now = new Date();
      const options = { month: 'long', day: '2-digit', weekday: 'long' };
      const formattedDate = now.toLocaleDateString('en-US', options);
      const dateString = formattedDate.replace(/,/, ',').replace(/(\w+) (\d+), (\w+)/, '$1 $2, $3');
      document.getElementById('currentDate').textContent = dateString;
      
      // Fetch and set user name from API
      fetchUserData();
      
      // Update statistics
      updateStatistics();
      
      // Load tasks from database
      loadDashboardTasks();
    }
    
    // Function to load tasks from database
    async function loadDashboardTasks() {
      try {
        const response = await fetch('api/tasks.php');
        const data = await response.json();

        if (!data.success) {
          throw new Error(data.error || 'Failed to load tasks');
        }

        const tasks = data.tasks || [];
        
        // Clear existing tasks
        document.getElementById('todayTasks').innerHTML = '';
        document.getElementById('upcomingTasks').innerHTML = '';
        
        // Categorize and display tasks
        const today = new Date();
        today.setHours(0, 0, 0, 0);
        
        tasks.forEach(task => {
          const taskElement = createDashboardTaskElement(task);
          
          if (task.deadline) {
            const dueDate = new Date(task.deadline);
            dueDate.setHours(0, 0, 0, 0);
            
            if (dueDate.getTime() <= today.getTime()) {
              // Task is due today or overdue
              document.getElementById('todayTasks').appendChild(taskElement);
            } else {
              // Task is due in the future
              document.getElementById('upcomingTasks').appendChild(taskElement);
            }
          } else {
            // No due date, add to upcoming tasks
            document.getElementById('upcomingTasks').appendChild(taskElement);
          }
        });
        
        // Update statistics
        updateStatistics();
        
      } catch (error) {
        console.error('Error loading tasks:', error);
        document.getElementById('todayTasks').innerHTML = '<p class="text-muted">Error loading tasks</p>';
        document.getElementById('upcomingTasks').innerHTML = '<p class="text-muted">Error loading tasks</p>';
      }
    }

    // Function to create task element for dashboard
    function createDashboardTaskElement(task) {
      const taskItem = document.createElement('div');
      taskItem.className = 'task-item mb-3 p-3 rounded-3';
      taskItem.style.cssText = task.reminder ? 
        'background: rgba(137, 108, 108, 0.1); border-radius: 10px; border-left: 4px solid #896C6C;' :
        'background: rgba(241, 240, 228, 0.3); border-radius: 10px;';
      
      const dueText = task.deadline ? new Date(task.deadline).toLocaleString() : 'No due date';
      const isCompleted = task.status === 'completed';
      
      taskItem.innerHTML = `
        <div class="d-flex align-items-center">
          <input type="checkbox" class="form-check-input me-3 task-checkbox" 
                 style="transform: scale(1.2);" 
                 ${isCompleted ? 'checked' : ''} 
                 onchange="toggleTaskCompletion(this, ${task.id})">
          <div class="flex-grow-1">
            <h6 class="mb-1 task-title" style="${isCompleted ? 'text-decoration: line-through; opacity: 0.6;' : ''}">${task.title}</h6>
            <small class="text-muted task-due" style="${isCompleted ? 'opacity: 0.6;' : ''}">Due: ${dueText}</small>
          </div>
          ${task.reminder ? '<span class="badge" style="background: #896C6C;"><i class="bi bi-bell-fill"></i></span>' : ''}
        </div>
      `;
      
      if (isCompleted) {
        taskItem.style.background = 'rgba(40, 167, 69, 0.1)';
        taskItem.style.borderLeft = '4px solid #28a745';
      }
      
      return taskItem;
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
    
    // Function to toggle task completion
    async function toggleTaskCompletion(checkbox, taskId) {
      const taskItem = checkbox.closest('.task-item');
      const taskTitle = taskItem.querySelector('.task-title');
      const taskDue = taskItem.querySelector('.task-due');
      
      const newStatus = checkbox.checked ? 'completed' : 'pending';
      
      try {
        // Get current task data from API first
        const response = await fetch('api/tasks.php');
        const data = await response.json();
        
        if (!data.success) {
          throw new Error('Failed to fetch task data');
        }
        
        const task = data.tasks.find(t => t.id == taskId);
        if (!task) {
          throw new Error('Task not found');
        }
        
        // Update task status
        const updateResponse = await fetch('api/tasks.php', {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({
            id: taskId,
            status: newStatus
          })
        });

        const updateData = await updateResponse.json();

        if (!updateData.success) {
          throw new Error(updateData.error || 'Failed to update task');
        }

        // Update UI
        if (checkbox.checked) {
          // Mark as completed
          taskTitle.style.textDecoration = 'line-through';
          taskTitle.style.opacity = '0.6';
          taskDue.style.opacity = '0.6';
          taskItem.style.background = 'rgba(40, 167, 69, 0.1)';
          taskItem.style.borderLeft = '4px solid #28a745';
        } else {
          // Mark as pending
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
        // Revert checkbox state
        checkbox.checked = !checkbox.checked;
        showToast('Error updating task: ' + error.message);
      }
    }
    
    // Initialize dashboard on page load
    document.addEventListener('DOMContentLoaded', initializeDashboard);
    
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
    
    // Function to show toast notification
    function showToast(message) {
      const toastElement = document.getElementById('successToast');
      const toastMessage = document.getElementById('toastMessage');
      
      // Update message
      toastMessage.textContent = message;
      
      // Create and show toast
      const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 3000
      });
      
      toast.show();
    }

    // Quick add task functionality
    document.getElementById('quickAddForm').addEventListener('submit', async function(e) {
      e.preventDefault();
      
      const taskTitle = document.getElementById('taskTitle').value;
      const taskDue = document.getElementById('taskDue').value;
      const setReminder = document.getElementById('setReminder').checked;
      
      if (taskTitle.trim()) {
        try {
          const taskData = {
            title: taskTitle,
            description: '',
            deadline: taskDue || null,
            priority: 'medium',
            reminder: setReminder,
            reminder_time: setReminder ? 15 : 15
          };

          console.log('Sending task data:', taskData); // Debug log

          const response = await fetch('api/tasks.php', {
            method: 'POST',
            headers: {
              'Content-Type': 'application/json'
            },
            body: JSON.stringify(taskData)
          });

          const data = await response.json();

          if (!data.success) {
            throw new Error(data.error || 'Failed to create task');
          }

          // Reset form
          this.reset();
          
          // Show success message
          showToast('Task added successfully!');
          
          // Reload tasks to show the new task
          await loadDashboardTasks();
          
        } catch (error) {
          console.error('Error creating task:', error);
          showToast('Error creating task: ' + error.message);
        }
      }
    });
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