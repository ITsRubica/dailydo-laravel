<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'DailyDo - Task Management'); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">
    
    <?php echo $__env->yieldPushContent('styles'); ?>
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
                    <a class="nav-link <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>" href="<?php echo e(route('profile.show')); ?>">
                        <i class="bi bi-person-circle me-2"></i>
                        Profile
                    </a>
                </li>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(!auth()->user()->isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('dashboard')); ?>">
                                <i class="bi bi-speedometer2 me-2"></i>
                                Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('tasks.*') ? 'active' : ''); ?>" href="<?php echo e(route('tasks.index')); ?>">
                                <i class="bi bi-list-task me-2"></i>
                                Task List
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('calendar') ? 'active' : ''); ?>" href="<?php echo e(route('calendar')); ?>">
                                <i class="bi bi-calendar-check me-2"></i>
                                Calendar
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(auth()->user()->isAdmin()): ?>
                        <li class="nav-item">
                            <a class="nav-link <?php echo e(request()->routeIs('admin.*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">
                                <i class="bi bi-people me-2"></i>
                                User Management
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
        </nav>
        <div class="sidebar-footer">
            <form action="<?php echo e(route('logout')); ?>" method="POST" id="logoutForm">
                <?php echo csrf_field(); ?>
                <a class="nav-link logout-link" href="#" onclick="event.preventDefault(); document.getElementById('logoutForm').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i>
                    Logout
                </a>
            </form>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="main-content">
        <!-- NAVBAR -->
        <nav class="navbar navbar-expand-lg navbar-light sticky-top" style="height: 60px; padding: 0.5rem 1rem;">
            <div class="container-fluid">
                <button class="navbar-toggler d-lg-none me-2" type="button" id="mobileMenuToggle" style="border: none; padding: 0.25rem 0.5rem;">
                    <i class="bi bi-list" style="font-size: 1.5rem;"></i>
                </button>
                <a class="navbar-brand fw-bold d-lg-none" href="<?php echo e(route('dashboard')); ?>" style="font-size: 1.25rem;">DailyDo</a>
                <div class="ms-auto">
                    <span class="navbar-text d-none d-lg-inline" id="currentDate" style="font-size: 0.9rem;">Loading...</span>
                </div>
            </div>
        </nav>

        <main style="padding-bottom: 3rem;">
            <?php echo $__env->yieldContent('content'); ?>
        </main>
    </div>

    <!-- REMINDER NOTIFICATION MODAL -->
    <div id="reminderNotifications" style="position: fixed; bottom: 20px; right: 20px; z-index: 1050; max-width: 380px; width: 100%;"></div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    
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

        // Set current date
        const now = new Date();
        const options = { month: 'long', day: '2-digit', weekday: 'long' };
        const formattedDate = now.toLocaleDateString('en-US', options);
        const dateString = formattedDate.replace(/,/, ',').replace(/(\w+) (\d+), (\w+)/, '$1 $2, $3');
        const currentDateElement = document.getElementById('currentDate');
        if (currentDateElement) {
            currentDateElement.textContent = dateString;
        }

        // Reminder notification system
        <?php if(auth()->guard()->check()): ?>
        let shownReminders = new Set();
        let allTasks = [];
        
        // Fetch all tasks on page load
        function loadTasks() {
            console.log('Loading tasks from API...');
            fetch('/api/tasks', {
                method: 'GET',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                credentials: 'same-origin'
            })
            .then(response => {
                console.log('API response status:', response.status);
                if (!response.ok) {
                    throw new Error('API request failed: ' + response.status);
                }
                return response.json();
            })
            .then(data => {
                console.log('API response data:', data);
                if (data.success && data.tasks) {
                    allTasks = Array.isArray(data.tasks) ? data.tasks : (data.tasks.data || []);
                    console.log('Loaded ' + allTasks.length + ' tasks for reminder checking');
                } else if (Array.isArray(data)) {
                    allTasks = data;
                    console.log('Loaded ' + allTasks.length + ' tasks (direct array)');
                } else {
                    console.error('Unexpected API response format:', data);
                }
            })
            .catch(error => {
                console.error('Error loading tasks:', error);
                // Try alternative: get tasks from page data if available
                if (window.pageTasksData) {
                    allTasks = window.pageTasksData;
                    console.log('Using page tasks data:', allTasks.length);
                }
            });
        }
        
        function checkReminders() {
            const now = new Date();
            console.log('Checking reminders at:', now.toLocaleString());
            
            allTasks.forEach(task => {
                if (task.status === 'completed' || !task.reminder || !task.deadline) {
                    return;
                }
                
                // Parse deadline - handle both formats
                let deadline = new Date(task.deadline);
                
                // If invalid, try replacing space with T for ISO format
                if (isNaN(deadline.getTime())) {
                    deadline = new Date(task.deadline.replace(' ', 'T'));
                }
                
                const reminderTime = task.reminder_time || 15;
                const reminderDate = new Date(deadline.getTime() - (reminderTime * 60 * 1000));
                const reminderKey = `${task.id}-${reminderTime}`;
                
                console.log(`Task ${task.id}: Now=${now.toLocaleString()}, Reminder=${reminderDate.toLocaleString()}, Deadline=${deadline.toLocaleString()}`);
                console.log(`  Should show: now >= reminder (${now >= reminderDate}) && now < deadline (${now < deadline}) && not shown (${!shownReminders.has(reminderKey)})`);
                
                if (now >= reminderDate && now < deadline && !shownReminders.has(reminderKey)) {
                    console.log('✓ SHOWING REMINDER for task:', task.id, task.title);
                    showReminderNotification(task, reminderTime);
                    shownReminders.add(reminderKey);
                } else {
                    console.log('✗ Not showing - conditions not met');
                }
            });
        }

        function showReminderNotification(task, minutesBefore) {
            const container = document.getElementById('reminderNotifications');
            
            const priorityColors = {
                'high': '#dc3545',
                'medium': '#ffc107',
                'low': '#28a745'
            };
            
            const priorityIcons = {
                'high': 'exclamation-triangle-fill',
                'medium': 'info-circle-fill',
                'low': 'check-circle-fill'
            };
            
            const notificationId = `reminder-${task.id}-${Date.now()}`;
            
            const notification = document.createElement('div');
            notification.id = notificationId;
            notification.className = 'reminder-notification';
            notification.style.cssText = `
                background: white;
                border-radius: 12px;
                box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
                margin-bottom: 12px;
                padding: 16px;
                border-left: 4px solid ${priorityColors[task.priority]};
                animation: slideInRight 0.4s ease-out;
                position: relative;
            `;
            
            notification.innerHTML = `
                <div style="display: flex; align-items: start; gap: 12px;">
                    <div style="flex-shrink: 0;">
                        <i class="bi bi-${priorityIcons[task.priority]}" style="font-size: 24px; color: ${priorityColors[task.priority]};"></i>
                    </div>
                    <div style="flex: 1; min-width: 0;">
                        <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 8px;">
                            <h6 style="margin: 0; font-weight: 600; color: #333; font-size: 14px;">
                                <i class="bi bi-bell-fill me-1" style="color: ${priorityColors[task.priority]};"></i>
                                Task Reminder
                            </h6>
                            <button onclick="dismissReminder('${notificationId}')" style="background: none; border: none; color: #6c757d; cursor: pointer; padding: 0; font-size: 18px; line-height: 1;">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                        <p style="margin: 0 0 8px 0; font-weight: 600; color: #333; font-size: 13px;">${task.title}</p>
                        ${task.description ? `<p style="margin: 0 0 8px 0; color: #6c757d; font-size: 12px; line-height: 1.4;">${task.description}</p>` : ''}
                        <div style="display: flex; align-items: center; gap: 8px; margin-top: 8px;">
                            <span style="background: rgba(137, 108, 108, 0.1); color: #896C6C; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600;">
                                <i class="bi bi-clock me-1"></i>Due in ${minutesBefore} minutes
                            </span>
                            <span style="background: ${priorityColors[task.priority]}15; color: ${priorityColors[task.priority]}; padding: 4px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; text-transform: uppercase;">
                                ${task.priority}
                            </span>
                        </div>
                        <div style="margin-top: 12px;">
                            <a href="/tasks" style="display: inline-block; background: #896C6C; color: white; padding: 6px 12px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 600;">
                                <i class="bi bi-list-task me-1"></i>View Task
                            </a>
                        </div>
                    </div>
                </div>
            `;
            
            container.appendChild(notification);
            
            // Play notification sound
            playNotificationSound();
            
            // Auto-dismiss after 10 seconds
            setTimeout(() => {
                dismissReminder(notificationId);
            }, 10000);
        }

        function dismissReminder(notificationId) {
            const notification = document.getElementById(notificationId);
            if (notification) {
                notification.style.animation = 'slideOutRight 0.3s ease-out';
                setTimeout(() => {
                    notification.remove();
                }, 300);
            }
        }

        function playNotificationSound() {
            // Create a simple beep sound using Web Audio API
            try {
                const audioContext = new (window.AudioContext || window.webkitAudioContext)();
                const oscillator = audioContext.createOscillator();
                const gainNode = audioContext.createGain();
                
                oscillator.connect(gainNode);
                gainNode.connect(audioContext.destination);
                
                oscillator.frequency.value = 800;
                oscillator.type = 'sine';
                
                gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                gainNode.gain.exponentialRampToValueAtTime(0.01, audioContext.currentTime + 0.5);
                
                oscillator.start(audioContext.currentTime);
                oscillator.stop(audioContext.currentTime + 0.5);
            } catch (e) {
                console.log('Audio notification not supported');
            }
        }

        // Add CSS animations
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(400px);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(400px);
                    opacity: 0;
                }
            }
            
            .reminder-notification:hover {
                box-shadow: 0 12px 32px rgba(0, 0, 0, 0.2);
                transform: translateY(-2px);
                transition: all 0.2s ease;
            }
            
            @media (max-width: 576px) {
                #reminderNotifications {
                    max-width: calc(100% - 40px);
                    right: 20px;
                    left: 20px;
                }
            }
        `;
        document.head.appendChild(style);

        // Load tasks and start checking reminders
        console.log('Reminder system initialized');
        loadTasks();
        
        // Check reminders every 30 seconds
        setInterval(checkReminders, 30000);
        
        // Initial check after 2 seconds (give time for tasks to load)
        setTimeout(checkReminders, 2000);
        
        // Expose functions globally for testing
        window.testReminders = checkReminders;
        window.reloadTasks = loadTasks;
        window.closeReminder = dismissReminder;
        
        // Test function to show a sample notification
        window.testNotification = function() {
            showReminderNotification({
                id: 999,
                title: "Test Reminder",
                description: "This is a test notification",
                priority: "high",
                deadline: new Date()
            }, 15);
        };
        
        // Debug function to check tasks
        window.debugReminders = function() {
            console.log('=== REMINDER DEBUG ===');
            console.log('All tasks:', allTasks);
            console.log('Shown reminders:', Array.from(shownReminders));
            console.log('Current time:', new Date().toLocaleString());
            console.log('Container exists:', !!document.getElementById('reminderNotifications'));
            
            allTasks.forEach(task => {
                if (task.reminder && task.deadline) {
                    const deadline = new Date(task.deadline);
                    const reminderTime = task.reminder_time || 15;
                    const reminderDate = new Date(deadline.getTime() - (reminderTime * 60 * 1000));
                    const now = new Date();
                    
                    console.log(`Task ${task.id} (${task.title}):`);
                    console.log('  Deadline:', deadline.toLocaleString());
                    console.log('  Reminder at:', reminderDate.toLocaleString());
                    console.log('  Should show:', now >= reminderDate && now < deadline);
                }
            });
        };
        <?php endif; ?>
    </script>
    
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH D:\dailydo-laravel\dailydo-laravel\resources\views/layouts/app.blade.php ENDPATH**/ ?>