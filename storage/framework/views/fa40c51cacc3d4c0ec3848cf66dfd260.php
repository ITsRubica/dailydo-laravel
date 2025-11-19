<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo e(config('app.name', 'DailyDo Laravel')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
        }
        .feature-card {
            transition: transform 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?php echo e(route('home')); ?>">
                <i class="fas fa-tasks me-2"></i>DailyDo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <?php if(auth()->guard()->check()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('dashboard')); ?>">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('tasks.index')); ?>">Tasks</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('profile.show')); ?>">Profile</a>
                        </li>
                        <li class="nav-item">
                            <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-outline-light btn-sm">Logout</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('login')); ?>">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo e(route('register')); ?>">Register</a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-4">Welcome to DailyDo</h1>
            <p class="lead mb-5">Your personal task management solution. Stay organized, stay productive.</p>
            <?php if(auth()->guard()->guest()): ?>
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-light btn-lg px-4">Get Started</a>
                    <a href="<?php echo e(route('login')); ?>" class="btn btn-outline-light btn-lg px-4">Sign In</a>
                </div>
            <?php else: ?>
                <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-light btn-lg px-4">Go to Dashboard</a>
            <?php endif; ?>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5">
        <div class="container">
            <div class="row text-center mb-5">
                <div class="col-lg-8 mx-auto">
                    <h2 class="display-5 fw-bold">Why Choose DailyDo?</h2>
                    <p class="lead text-muted">Powerful features to help you manage your tasks efficiently</p>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card h-100 feature-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-list-check fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">Task Management</h5>
                            <p class="card-text text-muted">Create, organize, and track your tasks with ease. Set priorities and deadlines to stay on top of your work.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 feature-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-chart-line fa-3x text-success"></i>
                            </div>
                            <h5 class="card-title">Progress Tracking</h5>
                            <p class="card-text text-muted">Monitor your productivity with detailed analytics and progress reports. See how much you accomplish each day.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card h-100 feature-card border-0 shadow-sm">
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <i class="fas fa-users fa-3x text-info"></i>
                            </div>
                            <h5 class="card-title">User Friendly</h5>
                            <p class="card-text text-muted">Clean, intuitive interface designed for productivity. Access your tasks from anywhere, anytime.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <?php if(auth()->guard()->guest()): ?>
    <section class="bg-light py-5">
        <div class="container text-center">
            <h3 class="mb-4">Ready to Get Organized?</h3>
            <p class="lead mb-4">Join thousands of users who have improved their productivity with DailyDo.</p>
            <a href="<?php echo e(route('register')); ?>" class="btn btn-primary btn-lg px-5">Start Free Today</a>
        </div>
    </section>
    <?php endif; ?>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; <?php echo e(date('Y')); ?> DailyDo Laravel. Built with Laravel & Bootstrap.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html><?php /**PATH D:\XAMPP\htdocs\dailydo-laravel\resources\views/welcome.blade.php ENDPATH**/ ?>