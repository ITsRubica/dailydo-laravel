

<?php $__env->startSection('title', 'User Management - DailyDo Admin'); ?>

<?php $__env->startPush('styles'); ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .user-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.2s, box-shadow 0.2s;
        cursor: pointer;
    }
    .user-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .user-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #896C6C;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        font-weight: bold;
    }
    .admin-header {
        background: linear-gradient(135deg, #896C6C, #A67C7C);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 25px;
    }
    .stats-card {
        background: #F1F0E4;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        border: 2px solid #896C6C;
    }
    .modal-header {
        background: #896C6C;
        color: white;
    }
    .info-label {
        font-weight: 600;
        color: #896C6C;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<section class="dashboard-section mt-3">
    <div class="container-fluid px-3 py-3" style="max-width: 1400px;">
        <!-- Admin Header -->
        <div class="admin-header">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h2 class="fw-bold mb-2">
                        <i class="bi bi-shield-check me-2"></i>User Management
                    </h2>
                    <p class="mb-0">Manage and monitor all registered users</p>
                </div>
                <div class="col-md-4 text-end">
                    <i class="bi bi-people-fill" style="font-size: 2.5rem; opacity: 0.3;"></i>
                </div>
            </div>
        </div>

        <!-- Stats Row -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="bi bi-people fs-1 mb-2" style="color: #896C6C;"></i>
                    <h3 class="fw-bold" id="totalUsers"><?php echo e($totalUsers); ?></h3>
                    <p class="mb-0">Total Users</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="bi bi-person-check fs-1 mb-2" style="color: #896C6C;"></i>
                    <h3 class="fw-bold" id="activeUsers"><?php echo e($activeUsers); ?></h3>
                    <p class="mb-0">Active Users</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-card">
                    <i class="bi bi-calendar-plus fs-1 mb-2" style="color: #896C6C;"></i>
                    <h3 class="fw-bold" id="newUsers"><?php echo e($newUsers); ?></h3>
                    <p class="mb-0">New This Month</p>
                </div>
            </div>
        </div>

        <!-- Search and Filter -->
        <div class="row mb-4">
            <div class="col-md-6">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" class="form-control" id="searchUsers" placeholder="Search users by name or email...">
                </div>
            </div>
            <div class="col-md-6">
                <button class="btn btn-outline-primary" onclick="window.location.reload()">
                    <i class="bi bi-arrow-clockwise me-1"></i>Refresh
                </button>
            </div>
        </div>

        <!-- Users List -->
        <div class="row">
            <div class="col-12">
                <h5 class="fw-bold mb-3">
                    <i class="bi bi-list-ul me-2"></i>Registered Users
                </h5>
                <div id="usersList">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="user-card" onclick="showUserDetails(<?php echo e($user->id); ?>)">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="user-avatar">
                                        <?php echo e(strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1))); ?>

                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1 fw-bold"><?php echo e($user->first_name); ?> <?php echo e($user->last_name); ?></h6>
                                    <p class="mb-1 text-muted"><?php echo e($user->email); ?></p>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i>Joined: <?php echo e($user->created_at->format('M d, Y')); ?>

                                    </small>
                                </div>
                                <div class="col-auto">
                                    <?php if($user->role === 'admin'): ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">User</span>
                                    <?php endif; ?>
                                    <i class="bi bi-chevron-right ms-2 text-muted"></i>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="text-center py-5">
                            <i class="bi bi-people" style="font-size: 4rem; color: #ccc;"></i>
                            <h5 class="text-muted mt-3">No users found</h5>
                            <p class="text-muted">No registered users match your search criteria.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- User Details Modal -->
<div class="modal fade" id="userModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-person-lines-fill me-2"></i>User Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <!-- View Mode -->
                <div id="viewMode">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            <div class="user-avatar mx-auto mb-3" id="modalUserAvatar" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                <i class="bi bi-person-fill"></i>
                            </div>
                            <h5 id="modalUserName">-</h5>
                            <p class="text-muted" id="modalUserEmail">-</p>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label class="info-label">First Name:</label>
                                    <p id="modalFirstName">-</p>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="info-label">Last Name:</label>
                                    <p id="modalLastName">-</p>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="info-label">Username:</label>
                                    <p id="modalUsername">-</p>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="info-label">Email Address:</label>
                                    <p id="modalEmail">-</p>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="info-label">Registration Date:</label>
                                    <p id="modalRegDate">-</p>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label class="info-label">Role:</label>
                                    <p id="modalRole"><span class="badge bg-success">User</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Edit Mode -->
                <div id="editMode" style="display: none;">
                    <form id="editUserForm">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" id="editUserId" name="id">
                        <div class="row">
                            <div class="col-md-4 text-center mb-4">
                                <div class="user-avatar mx-auto mb-3" id="editUserAvatar" style="width: 100px; height: 100px; font-size: 2.5rem;">
                                    <i class="bi bi-person-fill"></i>
                                </div>
                                <h6 class="text-muted">User Avatar</h6>
                            </div>
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <label for="editUsername" class="form-label info-label">Username:</label>
                                        <input type="text" class="form-control" id="editUsername" name="username" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="editEmail" class="form-label info-label">Email Address:</label>
                                        <input type="email" class="form-control" id="editEmail" name="email" required>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label class="info-label">Registration Date:</label>
                                        <p id="editRegDate" class="form-control-plaintext">-</p>
                                    </div>
                                    <div class="col-sm-6 mb-3">
                                        <label class="info-label">Role:</label>
                                        <p id="editRole" class="form-control-plaintext"><span class="badge bg-success">User</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <!-- View Mode Buttons -->
                <div id="viewModeButtons">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg me-1"></i>Close
                    </button>
                    <button type="button" class="btn btn-primary" onclick="enterEditMode()">
                        <i class="bi bi-pencil me-1"></i>Edit User
                    </button>
                </div>
                
                <!-- Edit Mode Buttons -->
                <div id="editModeButtons" style="display: none;">
                    <button type="button" class="btn btn-secondary" onclick="cancelEdit()">
                        <i class="bi bi-x-lg me-1"></i>Cancel
                    </button>
                    <button type="button" class="btn btn-danger" onclick="deleteUser()">
                        <i class="bi bi-trash me-1"></i>Delete User
                    </button>
                    <button type="button" class="btn btn-success" onclick="saveUser()">
                        <i class="bi bi-check-lg me-1"></i>Save Changes
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Store users data
    const users = <?php echo json_encode($users, 15, 512) ?>;
    let currentUser = null;

    // Search functionality
    document.getElementById('searchUsers').addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();
        const userCards = document.querySelectorAll('.user-card');
        
        userCards.forEach(card => {
            const text = card.textContent.toLowerCase();
            if (text.includes(searchTerm)) {
                card.style.display = '';
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Show user details in modal
    function showUserDetails(userId) {
        currentUser = users.find(u => u.id === userId);
        if (!currentUser) return;
        
        // Reset modal to view mode
        document.getElementById('viewMode').style.display = 'block';
        document.getElementById('editMode').style.display = 'none';
        document.getElementById('viewModeButtons').style.display = 'block';
        document.getElementById('editModeButtons').style.display = 'none';
        
        // Get initials for avatar
        const avatarText = (currentUser.first_name.charAt(0) + currentUser.last_name.charAt(0)).toUpperCase();
        const displayName = `${currentUser.first_name} ${currentUser.last_name}`;
        
        // Populate modal with user data
        document.getElementById('modalUserAvatar').innerHTML = avatarText;
        document.getElementById('modalUserName').textContent = displayName;
        document.getElementById('modalUserEmail').textContent = currentUser.email;
        document.getElementById('modalFirstName').textContent = currentUser.first_name || 'Not provided';
        document.getElementById('modalLastName').textContent = currentUser.last_name || 'Not provided';
        document.getElementById('modalUsername').textContent = currentUser.username;
        document.getElementById('modalEmail').textContent = currentUser.email;
        document.getElementById('modalRegDate').textContent = new Date(currentUser.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        
        const roleClass = currentUser.role === 'admin' ? 'bg-danger' : 'bg-success';
        const roleText = currentUser.role === 'admin' ? 'Admin' : 'User';
        document.getElementById('modalRole').innerHTML = `<span class="badge ${roleClass}">${roleText}</span>`;
        
        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('userModal'));
        modal.show();
    }

    // Enter edit mode
    function enterEditMode() {
        document.getElementById('viewMode').style.display = 'none';
        document.getElementById('editMode').style.display = 'block';
        document.getElementById('viewModeButtons').style.display = 'none';
        document.getElementById('editModeButtons').style.display = 'block';
        
        // Populate edit form
        const avatarText = (currentUser.first_name.charAt(0) + currentUser.last_name.charAt(0)).toUpperCase();
        document.getElementById('editUserAvatar').innerHTML = avatarText;
        document.getElementById('editUserId').value = currentUser.id;
        document.getElementById('editUsername').value = currentUser.username;
        document.getElementById('editEmail').value = currentUser.email;
        document.getElementById('editRegDate').textContent = new Date(currentUser.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'short', day: 'numeric' });
        
        const roleClass = currentUser.role === 'admin' ? 'bg-danger' : 'bg-success';
        const roleText = currentUser.role === 'admin' ? 'Admin' : 'User';
        document.getElementById('editRole').innerHTML = `<span class="badge ${roleClass}">${roleText}</span>`;
    }

    // Cancel edit mode
    function cancelEdit() {
        document.getElementById('viewMode').style.display = 'block';
        document.getElementById('editMode').style.display = 'none';
        document.getElementById('viewModeButtons').style.display = 'block';
        document.getElementById('editModeButtons').style.display = 'none';
    }

    // Save user changes
    async function saveUser() {
        const username = document.getElementById('editUsername').value.trim();
        const email = document.getElementById('editEmail').value.trim();
        const userId = document.getElementById('editUserId').value;
        
        if (!username || !email) {
            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: 'Please fill in all required fields.'
            });
            return;
        }
        
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email',
                text: 'Please enter a valid email address.'
            });
            return;
        }
        
        try {
            const response = await fetch(`/admin/users/${userId}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ username, email })
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'User updated successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                setTimeout(() => window.location.reload(), 2000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to update user.'
                });
            }
        } catch (error) {
            console.error('Error updating user:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while updating the user.'
            });
        }
    }

    // Delete user
    async function deleteUser() {
        const result = await Swal.fire({
            title: 'Are you sure?',
            text: `This will permanently delete the user "${currentUser.username}" and all their tasks. This action cannot be undone!`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete user!',
            cancelButtonText: 'Cancel'
        });
        
        if (!result.isConfirmed) return;
        
        try {
            const response = await fetch(`/admin/users/${currentUser.id}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Deleted!',
                    text: 'User has been deleted successfully.',
                    timer: 2000,
                    showConfirmButton: false
                });
                
                setTimeout(() => window.location.reload(), 2000);
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to delete user.'
                });
            }
        } catch (error) {
            console.error('Error deleting user:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while deleting the user.'
            });
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\dailydo-laravel\dailydo-laravel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>