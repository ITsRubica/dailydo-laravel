

<?php $__env->startSection('title', 'Profile - DailyDo'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .profile-picture {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #896C6C;
    }
    .profile-card {
        background: #F1F0E4;
        border-radius: 12px;
        box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    }
    .stats-card {
        background: #896C6C;
        color: white;
        border-radius: 10px;
        padding: 12px 16px;
        transition: all 0.2s ease;
        min-height: 70px;
    }
    .stats-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 10px rgba(137, 108, 108, 0.3);
    }
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border: 1px solid rgba(0,0,0,0.05);
    }
    .profile-picture-placeholder {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #896C6C;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        border: 3px solid #896C6C;
    }
    .file-upload-btn {
        position: relative;
        overflow: hidden;
        display: inline-block;
    }
    .file-upload-btn input[type=file] {
        position: absolute;
        left: -9999px;
    }
    .admin-header {
        background: linear-gradient(135deg, #896C6C, #A67C7C);
        color: white;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 20px;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<!-- PROFILE CONTENT -->
<section class="dashboard-section mt-3" style="padding-bottom: 3rem;">
    <div class="container-fluid px-4 py-3" style="max-width: 1400px;">
        <!-- Header -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="admin-header">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="fw-bold mb-1" style="font-size: 1.5rem;">
                                <i class="bi bi-person-circle me-2"></i>Profile
                            </h2>
                            <p class="mb-0" style="font-size: 0.9rem;">Manage your account information and preferences</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <i class="bi bi-person-fill" style="font-size: 2rem; opacity: 0.3;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <?php if(session('success')): ?>
            <div class="row mb-2">
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible fade show py-2" role="alert" style="font-size: 0.85rem;">
                        <i class="bi bi-check-circle me-1"></i><?php echo e(session('success')); ?>

                        <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.7rem; padding: 0.5rem;"></button>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <div class="row g-3">
            <!-- Profile Information Card -->
            <div class="col-12 col-xl-3 col-lg-4">
                <div class="profile-card p-3 text-center h-100">
                    <div class="mb-3 d-flex justify-content-center" style="margin-top: 20px;">
                        <?php if($user->profile_picture): ?>
                            <img src="<?php echo e(asset('storage/' . $user->profile_picture)); ?>?v=<?php echo e(time()); ?>" alt="Profile Picture" class="profile-picture" id="profilePictureImg">
                        <?php else: ?>
                            <div class="profile-picture-placeholder" id="profilePicturePlaceholder">
                                <i class="bi bi-person-fill"></i>
                            </div>
                        <?php endif; ?>
                    </div>
                    <h5 class="fw-bold mb-1" style="font-size: 1.1rem;"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></h5>
                    <p class="text-muted mb-1 small" style="font-size: 0.85rem;"><?php echo e($user->email); ?></p>
                    <p class="small text-muted mb-2" style="font-size: 0.8rem;">Member since <?php echo e($user->created_at->format('M Y')); ?></p>
                    
                    <!-- Profile Picture Upload -->
                    <div class="mb-3">
                        <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" id="profilePictureForm">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('PATCH'); ?>
                            <label class="file-upload-btn btn btn-outline-dark btn-sm" style="font-size: 0.8rem; padding: 4px 12px;">
                                <i class="bi bi-camera me-1"></i>Update Picture
                                <input type="file" name="profile_picture" accept="image/*" id="profilePictureInput">
                            </label>
                        </form>
                    </div>

                    <!-- Activity Stats -->
                    <div class="d-flex justify-content-center" style="margin-top: 20px;">
                        <div class="stats-card py-3 px-3 d-flex flex-row align-items-center justify-content-center gap-2" style="width: 100%; max-width: 240px; min-height: 70px;">
                            <i class="bi bi-fire fs-2"></i>
                            <div class="text-start">
                                <h3 class="fw-bold mb-0" style="font-size: 1.5rem;"><?php echo e($user->current_streak ?? 0); ?></h3>
                                <span style="font-size: 1rem;">Streak</span>
                                <p class="text-white mb-0 small" style="font-size: 0.75rem;">without missing a task</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Forms and Bio Section -->
            <div class="col-12 col-xl-9 col-lg-8">
                <div class="row g-3">
                    <!-- Bio/Interests Section -->
                    <div class="col-12 col-lg-6">
                        <div class="form-section h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fw-bold mb-0" style="font-size: 1rem;">
                                    <i class="bi bi-chat-text me-2"></i>Bio & Interests
                                </h5>
                                <button class="btn btn-outline-secondary btn-sm" onclick="toggleEdit('bio')" style="border-color: #896C6C; color: #896C6C; font-size: 0.8rem; padding: 4px 10px;">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </button>
                            </div>
                            
                            <!-- Bio Display Mode -->
                            <div id="bioDisplay">
                                <div class="mb-2">
                                    <label class="form-label fw-semibold" style="font-size: 0.85rem;">About Me</label>
                                    <p class="form-control-plaintext" style="font-size: 0.85rem;"><?php echo e($user->bio ?? 'Tell us about yourself...'); ?></p>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold" style="font-size: 0.85rem;">Interests</label>
                                    <div class="d-flex flex-wrap gap-1">
                                        <?php if($user->interests): ?>
                                            <?php $__currentLoopData = explode(',', $user->interests); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $interest): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="badge bg-primary" style="font-size: 0.75rem;"><?php echo e(trim($interest)); ?></span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                            <span class="badge bg-secondary" style="font-size: 0.75rem;">Add your interests</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Bio Edit Mode -->
                            <div id="bioEdit" style="display: none;">
                                <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <div class="mb-2">
                                        <label for="bio" class="form-label" style="font-size: 0.85rem;">About Me</label>
                                        <textarea class="form-control" id="bio" name="bio" rows="2" placeholder="Tell us about yourself..." style="font-size: 0.85rem;"><?php echo e($user->bio); ?></textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label for="interests" class="form-label" style="font-size: 0.85rem;">Interests (comma-separated)</label>
                                        <input type="text" class="form-control" id="interests" name="interests" placeholder="e.g., Reading, Coding, Travel" value="<?php echo e($user->interests); ?>" style="font-size: 0.85rem;">
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm" style="background: #896C6C; border: none; color: white; font-size: 0.8rem; padding: 4px 12px;">
                                            <i class="bi bi-check-lg me-1"></i>Save
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit('bio')" style="font-size: 0.8rem; padding: 4px 12px;">
                                            <i class="bi bi-x-lg me-1"></i>Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Information Display/Edit -->
                    <div class="col-12 col-lg-6">
                        <div class="form-section h-100">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fw-bold mb-0" style="font-size: 1rem;">
                                    <i class="bi bi-person-gear me-2"></i>Profile Information
                                </h5>
                                <button class="btn btn-outline-secondary btn-sm" onclick="toggleEdit('profile')" style="border-color: #896C6C; color: #896C6C; font-size: 0.8rem; padding: 4px 10px;">
                                    <i class="bi bi-pencil me-1"></i>Edit
                                </button>
                            </div>
                    
                            <!-- Display Mode -->
                            <div id="profileDisplay">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <label class="form-label fw-semibold" style="font-size: 0.85rem;">First Name</label>
                                        <p class="form-control-plaintext" style="font-size: 0.85rem;"><?php echo e($user->first_name); ?></p>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <label class="form-label fw-semibold" style="font-size: 0.85rem;">Last Name</label>
                                        <p class="form-control-plaintext" style="font-size: 0.85rem;"><?php echo e($user->last_name); ?></p>
                                    </div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label fw-semibold" style="font-size: 0.85rem;">Email Address</label>
                                    <p class="form-control-plaintext" style="font-size: 0.85rem;"><?php echo e($user->email); ?></p>
                                </div>
                            </div>
                    
                            <!-- Edit Mode -->
                            <div id="profileEdit" style="display: none;">
                                <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <div class="mb-2">
                                        <label for="first_name" class="form-label" style="font-size: 0.85rem;">First Name</label>
                                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo e($user->first_name); ?>" required style="font-size: 0.85rem;">
                                    </div>
                                    <div class="mb-2">
                                        <label for="last_name" class="form-label" style="font-size: 0.85rem;">Last Name</label>
                                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo e($user->last_name); ?>" required style="font-size: 0.85rem;">
                                    </div>
                                    <div class="mb-2">
                                        <label for="email" class="form-label" style="font-size: 0.85rem;">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo e($user->email); ?>" required style="font-size: 0.85rem;">
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-sm" style="background: #896C6C; border: none; color: white; font-size: 0.8rem; padding: 4px 12px;">
                                            <i class="bi bi-check-lg me-1"></i>Save Changes
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit('profile')" style="font-size: 0.8rem; padding: 4px 12px;">
                                            <i class="bi bi-x-lg me-1"></i>Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Password Management -->
                    <div class="col-12">
                        <div class="form-section">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="fw-bold mb-0" style="font-size: 1rem;">
                                    <i class="bi bi-shield-lock me-2"></i>Password Management
                                </h5>
                                <button class="btn btn-outline-warning btn-sm" onclick="toggleEdit('password')" style="font-size: 0.8rem; padding: 4px 10px;">
                                    <i class="bi bi-key me-1"></i>Change Password
                                </button>
                            </div>
                    
                            <!-- Display Mode -->
                            <div id="passwordDisplay">
                                <div class="mb-2">
                                    <label class="form-label fw-semibold" style="font-size: 0.85rem;">Current Password</label>
                                    <p class="form-control-plaintext" style="font-size: 0.85rem;">••••••••••••</p>
                                </div>
                            </div>
                    
                            <!-- Edit Mode -->
                            <div id="passwordEdit" style="display: none;">
                                <form action="<?php echo e(route('profile.update')); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PATCH'); ?>
                                    <div class="mb-2">
                                        <label for="current_password" class="form-label" style="font-size: 0.85rem;">Current Password</label>
                                        <input type="password" class="form-control" id="current_password" name="current_password" required style="font-size: 0.85rem;">
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-2">
                                            <label for="password" class="form-label" style="font-size: 0.85rem;">New Password</label>
                                            <input type="password" class="form-control" id="password" name="password" minlength="8" required style="font-size: 0.85rem;">
                                        </div>
                                        <div class="col-md-6 mb-2">
                                            <label for="password_confirmation" class="form-label" style="font-size: 0.85rem;">Confirm New Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8" required style="font-size: 0.85rem;">
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-warning btn-sm" style="font-size: 0.8rem; padding: 4px 12px;">
                                            <i class="bi bi-key me-1"></i>Change Password
                                        </button>
                                        <button type="button" class="btn btn-secondary btn-sm" onclick="toggleEdit('password')" style="font-size: 0.8rem; padding: 4px 12px;">
                                            <i class="bi bi-x-lg me-1"></i>Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function toggleEdit(section) {
        const display = document.getElementById(section + 'Display');
        const edit = document.getElementById(section + 'Edit');
        
        if (display.style.display === 'none') {
            display.style.display = 'block';
            edit.style.display = 'none';
        } else {
            display.style.display = 'none';
            edit.style.display = 'block';
        }
    }

    // Handle profile picture upload - submit immediately
    document.getElementById('profilePictureInput').addEventListener('change', function(e) {
        if (this.files && this.files[0]) {
            document.getElementById('profilePictureForm').submit();
        }
    });
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\dailydo-laravel\dailydo-laravel\resources\views/profile/show.blade.php ENDPATH**/ ?>