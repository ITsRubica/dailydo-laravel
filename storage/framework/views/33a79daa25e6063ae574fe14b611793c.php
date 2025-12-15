<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>dailydo - Login</title>
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
        <li><a href="<?php echo e(route('register')); ?>">Register</a></li>
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
  
  <!-- LOGIN FORM -->
  <section class="login-section">
    <div class="login-container">
      <h2>Welcome Back!</h2>
      <p>Log in to manage your tasks</p>
      
      <?php if($errors->any()): ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
      <?php endif; ?>

      <form method="POST" action="<?php echo e(route('login')); ?>" class="login-form">
        <?php echo csrf_field(); ?>
        <div class="form-group">
          <input type="text" name="login" placeholder="Email or Username" value="<?php echo e(old('login')); ?>" required>
        </div>
        <div class="form-group">
          <input type="password" name="password" placeholder="Password" required>
        </div>
        <button type="submit" class="login-btn">Login</button>
      </form>
      
      <div class="text-center mt-3">
        <p>Don't have an account? <a href="<?php echo e(route('register')); ?>">Register here</a></p>
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

    // Show success message if login is successful
    <?php if(session('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Login Successful',
            text: '<?php echo e(session('success')); ?>'
        });
    <?php endif; ?>

    // Show error message if login fails
    <?php if($errors->any()): ?>
        Swal.fire({
            icon: 'error',
            title: 'Login Failed',
            text: '<?php echo e($errors->first()); ?>'
        });
    <?php endif; ?>
  </script>
</body>
</html>
<?php /**PATH D:\dailydo-laravel\dailydo-laravel\resources\views/auth/login.blade.php ENDPATH**/ ?>