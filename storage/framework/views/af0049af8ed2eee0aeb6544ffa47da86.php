<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>dailydo - Home</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo e(asset('assets/style.css')); ?>">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
        <script defer src="<?php echo e(asset('assets/script.js')); ?>"></script>
    </head>
    <body>
        <!--NAVBAR-->
        <nav class="navbar">
            <div class="navbar-container">
              <a href="<?php echo e(url('/')); ?>" class="navbar-logo">dailydo</a>
              <button class="navbar-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
              </button>
              <ul class="navbar-menu">
                <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
                <li><a href="<?php echo e(route('register')); ?>">Register</a></li>
              </ul>
            </div>
        </nav>
        <!-- HERO SECTION -->
        <section class="hero">
            <div class="hero-content">
            <h1><i class="bi bi-stars me-2"></i>Organize Your Day, Stress-Free</h1>
            <p>Stay productive and never miss a task again with our simple and powerful To-Do List app.</p>
            </div>
        </section>

        <!-- FEATURES -->
        <section class="features">
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="feature-card text-center">
                            <i class="bi bi-check-circle-fill"></i>
                            <h3>Easy to Use</h3>
                            <p>Create, edit, and manage tasks in just a few clicks.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card text-center">
                            <i class="bi bi-calendar-check"></i>
                            <h3>Stay on Track</h3>
                            <p>Set deadlines, reminders, and priorities to never miss a task.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feature-card text-center">
                            <i class="bi bi-phone"></i>
                            <h3>Accessible Anywhere</h3>
                            <p>Use it on desktop, tablet, or mobile seamlessly.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="footer">
            <p>&copy; 2025 dailydo. All rights reserved.</p>
        </footer>

        <script>
        // Logout function
        async function logout() {
            try {
                await fetch('api/logout.php', { method: 'POST' });
                localStorage.removeItem('profileData');
                localStorage.removeItem('userSession');
                window.location.href = 'index.php';
            } catch (error) {
                console.error('Logout error:', error);
                window.location.href = 'index.php';
            }
        }
        </script>
    </body>
</html>
<?php /**PATH D:\dailydo-laravel\dailydo-laravel\resources\views/welcome.blade.php ENDPATH**/ ?>