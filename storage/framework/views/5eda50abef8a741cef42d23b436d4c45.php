<?php $__env->startSection('title', 'Dashboard - DailyDo'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4">Welcome back, <?php echo e(auth()->user()->first_name); ?>!</h1>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                    <h3 class="card-title"><?php echo e($totalTasks); ?></h3>
                    <p class="card-text text-muted">Total Tasks</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                    <h3 class="card-title"><?php echo e($pendingTasks); ?></h3>
                    <p class="card-text text-muted">Pending</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                    <h3 class="card-title"><?php echo e($completedTasks); ?></h3>
                    <p class="card-text text-muted">Completed</p>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-exclamation-triangle fa-2x text-danger mb-2"></i>
                    <h3 class="card-title"><?php echo e($overdueTasks); ?></h3>
                    <p class="card-text text-muted">Overdue</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Tasks -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Tasks</h5>
                    <a href="<?php echo e(route('tasks.create')); ?>" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus"></i> Add Task
                    </a>
                </div>
                <div class="card-body">
                    <?php if($recentTasks->count() > 0): ?>
                        <?php $__currentLoopData = $recentTasks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                                <div>
                                    <h6 class="mb-1 <?php echo e($task->completed ? 'task-completed' : ''); ?>">
                                        <?php echo e($task->title); ?>

                                    </h6>
                                    <small class="text-muted">
                                        <span class="priority-<?php echo e($task->priority); ?>">
                                            <i class="fas fa-circle"></i> <?php echo e(ucfirst($task->priority)); ?>

                                        </span>
                                        <?php if($task->deadline): ?>
                                            | Due: <?php echo e($task->formatted_deadline); ?>

                                        <?php endif; ?>
                                    </small>
                                </div>
                                <div>
                                    <?php if($task->completed): ?>
                                        <span class="badge bg-success">Completed</span>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('tasks.show', $task)); ?>" class="btn btn-outline-primary btn-sm">View</a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div class="text-center mt-3">
                            <a href="<?php echo e(route('tasks.index')); ?>" class="btn btn-outline-primary">View All Tasks</a>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center">No tasks yet. <a href="<?php echo e(route('tasks.create')); ?>">Create your first task!</a></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Upcoming Deadlines</h5>
                </div>
                <div class="card-body">
                    <?php if($upcomingDeadlines->count() > 0): ?>
                        <?php $__currentLoopData = $upcomingDeadlines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $task): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="d-flex justify-content-between align-items-center mb-2 p-2 border-bottom">
                                <div>
                                    <h6 class="mb-1"><?php echo e($task->title); ?></h6>
                                    <small class="text-muted">
                                        Due: <?php echo e($task->formatted_deadline); ?>

                                        <span class="priority-<?php echo e($task->priority); ?>">
                                            | <?php echo e(ucfirst($task->priority)); ?> Priority
                                        </span>
                                    </small>
                                </div>
                                <a href="<?php echo e(route('tasks.show', $task)); ?>" class="btn btn-outline-primary btn-sm">View</a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php else: ?>
                        <p class="text-muted text-center">No upcoming deadlines</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Overview -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Progress Overview</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <h4 class="text-success"><?php echo e($completionRate); ?>%</h4>
                            <p class="text-muted">Completion Rate</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-danger"><?php echo e($highPriorityTasks); ?></h4>
                            <p class="text-muted">High Priority</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-warning"><?php echo e($mediumPriorityTasks); ?></h4>
                            <p class="text-muted">Medium Priority</p>
                        </div>
                        <div class="col-md-3">
                            <h4 class="text-success"><?php echo e($lowPriorityTasks); ?></h4>
                            <p class="text-muted">Low Priority</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\XAMPP\htdocs\dailydo-laravel\resources\views/dashboard.blade.php ENDPATH**/ ?>