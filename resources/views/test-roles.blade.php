<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Role-Based Access Control Test - DailyDo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
            padding: 20px;
        }
        .test-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .success { color: #28a745; }
        .error { color: #dc3545; }
        .warning { color: #ffc107; }
        .info { color: #17a2b8; }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="mb-4"><i class="bi bi-shield-check"></i> Role-Based Access Control Test</h1>
        
        <!-- Test 1: Admin Users -->
        <div class="test-card">
            <h3>Test 1: Admin Users in Database</h3>
            @php
                $adminUsers = \App\Models\User::where('role', 'admin')->get();
            @endphp
            
            @if($adminUsers->count() > 0)
                <p class="success"><i class="bi bi-check-circle-fill"></i> Admin users found:</p>
                @foreach($adminUsers as $admin)
                    <ul>
                        <li><strong>ID:</strong> {{ $admin->id }}</li>
                        <li><strong>Username:</strong> {{ $admin->username }}</li>
                        <li><strong>Email:</strong> {{ $admin->email }}</li>
                        <li><strong>Role:</strong> {{ $admin->role }}</li>
                    </ul>
                    <hr>
                @endforeach
            @else
                <p class="error"><i class="bi bi-x-circle-fill"></i> No admin users found</p>
                <p class="info">Run: <code>php artisan db:seed --class=AdminUserSeeder</code></p>
            @endif
        </div>

        <!-- Test 2: Regular Users -->
        <div class="test-card">
            <h3>Test 2: Regular Users in Database</h3>
            @php
                $regularUsers = \App\Models\User::where('role', 'user')->limit(5)->get();
            @endphp
            
            @if($regularUsers->count() > 0)
                <p class="success"><i class="bi bi-check-circle-fill"></i> Regular users found:</p>
                @foreach($regularUsers as $user)
                    <ul>
                        <li><strong>ID:</strong> {{ $user->id }}</li>
                        <li><strong>Username:</strong> {{ $user->username }}</li>
                        <li><strong>Email:</strong> {{ $user->email }}</li>
                        <li><strong>Role:</strong> {{ $user->role }}</li>
                    </ul>
                    <hr>
                @endforeach
            @else
                <p class="warning"><i class="bi bi-exclamation-triangle-fill"></i> No regular users found (this is normal if no users have registered yet)</p>
            @endif
        </div>

        <!-- Test 3: Authentication Functions -->
        <div class="test-card">
            <h3>Test 3: Authentication Functions</h3>
            
            @if(method_exists(\App\Models\User::class, 'isAdmin'))
                <p class="success"><i class="bi bi-check-circle-fill"></i> isAdmin() method exists in User model</p>
            @else
                <p class="error"><i class="bi bi-x-circle-fill"></i> isAdmin() method missing in User model</p>
            @endif
            
            @if(class_exists(\App\Http\Middleware\AdminMiddleware::class))
                <p class="success"><i class="bi bi-check-circle-fill"></i> AdminMiddleware class exists</p>
            @else
                <p class="error"><i class="bi bi-x-circle-fill"></i> AdminMiddleware class missing</p>
            @endif
            
            @if(class_exists(\App\Http\Controllers\AdminController::class))
                <p class="success"><i class="bi bi-check-circle-fill"></i> AdminController class exists</p>
            @else
                <p class="error"><i class="bi bi-x-circle-fill"></i> AdminController class missing</p>
            @endif
        </div>

        <!-- Test 4: Current Session Status -->
        <div class="test-card">
            <h3>Test 4: Current Session Status</h3>
            @auth
                @php
                    $currentUser = auth()->user();
                @endphp
                <p class="success"><i class="bi bi-check-circle-fill"></i> User is logged in:</p>
                <ul>
                    <li><strong>Username:</strong> {{ $currentUser->username }}</li>
                    <li><strong>Email:</strong> {{ $currentUser->email }}</li>
                    <li><strong>Role:</strong> {{ $currentUser->role }}</li>
                    <li><strong>Is Admin:</strong> {{ $currentUser->isAdmin() ? 'Yes' : 'No' }}</li>
                </ul>
                
                @if($currentUser->isAdmin())
                    <div class="alert alert-success mt-3">
                        <i class="bi bi-shield-check"></i> You have admin privileges!
                        <br>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-success btn-sm mt-2">
                            <i class="bi bi-people"></i> Go to User Management
                        </a>
                    </div>
                @else
                    <div class="alert alert-info mt-3">
                        <i class="bi bi-person"></i> You are logged in as a regular user.
                        <br>
                        <a href="{{ route('dashboard') }}" class="btn btn-primary btn-sm mt-2">
                            <i class="bi bi-speedometer2"></i> Go to Dashboard
                        </a>
                    </div>
                @endif
            @else
                <p class="warning"><i class="bi bi-exclamation-triangle-fill"></i> No user is currently logged in</p>
            @endauth
        </div>

        <!-- Test 5: Route Access -->
        <div class="test-card">
            <h3>Test 5: Route Access Test</h3>
            <p>Test the following routes to verify role-based access control:</p>
            
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Route</th>
                            <th>Required Role</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><code>/admin</code></td>
                            <td><span class="badge bg-danger">Admin</span></td>
                            <td>
                                <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-primary" target="_blank">
                                    Test Access
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><code>/dashboard</code></td>
                            <td><span class="badge bg-success">User</span></td>
                            <td>
                                <a href="{{ route('dashboard') }}" class="btn btn-sm btn-primary" target="_blank">
                                    Test Access
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td><code>/profile</code></td>
                            <td><span class="badge bg-info">All Authenticated</span></td>
                            <td>
                                <a href="{{ route('profile.show') }}" class="btn btn-sm btn-primary" target="_blank">
                                    Test Access
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Test Instructions -->
        <div class="test-card">
            <h3>Test Instructions</h3>
            <p>To fully test the role-based access control:</p>
            <ol>
                <li><strong>Create Admin User:</strong> Run <code>php artisan db:seed --class=AdminUserSeeder</code></li>
                <li><strong>Login as Admin:</strong> Use email 'admin@dailydo.com' and password 'admin123'</li>
                <li><strong>Test Admin Access:</strong> Navigate to <a href="{{ route('admin.dashboard') }}">User Management</a> - should work</li>
                <li><strong>Register as Regular User:</strong> Create a new account via registration</li>
                <li><strong>Test User Access:</strong> Try to access <a href="{{ route('admin.dashboard') }}">User Management</a> - should show 403 error</li>
                <li><strong>Check Navigation:</strong> Admin users should see 'User Management' in sidebar, regular users should not</li>
            </ol>
            
            <div class="mt-3">
                <a href="{{ route('login') }}" class="btn btn-primary">
                    <i class="bi bi-box-arrow-in-right"></i> Go to Login Page
                </a>
                <a href="{{ route('register') }}" class="btn btn-success">
                    <i class="bi bi-person-plus"></i> Go to Registration Page
                </a>
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                @endauth
            </div>
        </div>

        <!-- Database Statistics -->
        <div class="test-card">
            <h3>Database Statistics</h3>
            @php
                $totalUsers = \App\Models\User::count();
                $adminCount = \App\Models\User::where('role', 'admin')->count();
                $userCount = \App\Models\User::where('role', 'user')->count();
                $totalTasks = \App\Models\Task::count();
            @endphp
            
            <div class="row">
                <div class="col-md-3">
                    <div class="text-center p-3 bg-light rounded">
                        <h4 class="text-primary">{{ $totalUsers }}</h4>
                        <p class="mb-0">Total Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-light rounded">
                        <h4 class="text-danger">{{ $adminCount }}</h4>
                        <p class="mb-0">Admin Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-light rounded">
                        <h4 class="text-success">{{ $userCount }}</h4>
                        <p class="mb-0">Regular Users</p>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="text-center p-3 bg-light rounded">
                        <h4 class="text-info">{{ $totalTasks }}</h4>
                        <p class="mb-0">Total Tasks</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
