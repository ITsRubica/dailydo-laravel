<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>dailydo - Register</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link rel="stylesheet" href="<?php echo e(asset('assets/style.css')); ?>">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="navbar-container">
      <a href="<?php echo e(auth()->check() ? route('dashboard') : url('/')); ?>" class="navbar-logo">dailydo</a>
      <button class="navbar-toggle">
        <span class="bar"></span>
        <span class="bar"></span>
        <span class="bar"></span>
      </button>
      <ul class="navbar-menu">
        <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
        <li><a href="<?php echo e(route('login')); ?>">Login</a></li>
        <?php if(auth()->guard()->check()): ?>
        <li>
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="d-inline">
                <?php echo csrf_field(); ?>
                <button type="submit" class="btn btn-link p-0" style="color: #ff6b6b; text-decoration: none; border: none; background: none;">Logout</button>
            </form>
        </li>
        <?php endif; ?>
      </ul>
    </div>
  </nav>
  
  <!-- REGISTER FORM -->
  <section class="register-section">
    <div class="register-container">
      <h2>Create Account</h2>
      <p>Join us to manage your tasks</p>
      
      <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?php echo e(route('register')); ?>" class="register-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
          <input type="text" name="first_name" placeholder="First Name" value="<?php echo e(old('first_name')); ?>" required>
        </div>
        <div class="form-group">
          <input type="text" name="last_name" placeholder="Last Name" value="<?php echo e(old('last_name')); ?>" required>
        </div>
        <div class="form-group">
          <input type="text" name="username" placeholder="Username" value="<?php echo e(old('username')); ?>" required>
        </div>
        <div class="form-group">
          <input type="email" name="email" placeholder="Email" value="<?php echo e(old('email')); ?>" required>
        </div>
        <div class="form-group">
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
          <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        </div>
        <button type="submit" class="register-btn">Register</button>
      </form>
      
      <div class="register-link">
        <p>Already have an account? <a href="<?php echo e(route('login')); ?>">Login here</a></p>
      </div>
    </div>
  </section>

  <!-- FOOTER -->
  <footer class="footer">
    <p>&copy; 2025 dailydo. All rights reserved.</p>
  </footer>

  <script>
    // Mobile menu toggle
    document.querySelector('.navbar-toggle').addEventListener('click', function() {
        document.querySelector('.navbar-menu').classList.toggle('active');
    });

    // Show success message if registration is successful
    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Registration Successful',
            text: '<?php echo e(session('success')); ?>'
        }).then(() => {
            window.location.href = '<?php echo e(route('login')); ?>';
        });
    <?php endif; ?>

    // Show error message if registration fails
    <?php if($errors->any()): ?>
        Swal.fire({
            icon: 'error',
            title: 'Registration Failed',
            text: '<?php echo e($errors->first()); ?>'
        });
    <?php endif; ?>
  </script>
</body>
</html>
<?php /**PATH D:\dailydo-laravel\dailydo-laravel\resources\views/auth/register.blade.php ENDPATH**/ ?>