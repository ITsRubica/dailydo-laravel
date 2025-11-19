@extends('layouts.app')

@section('title', 'Welcome to DailyDo')

@section('content')
<div class="hero-section bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Welcome to DailyDo</h1>
                <p class="lead mb-4">Your personal task management solution. Organize your daily tasks, set priorities, track deadlines, and boost your productivity.</p>
                @guest
                    <div class="d-flex gap-3">
                        <a href="{{ route('register') }}" class="btn btn-light btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Get Started
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-sign-in-alt me-2"></i>Sign In
                        </a>
                    </div>
                @else
                    <a href="{{ route('dashboard') }}" class="btn btn-light btn-lg">
                        <i class="fas fa-tachometer-alt me-2"></i>Go to Dashboard
                    </a>
                @endguest
            </div>
            <div class="col-lg-6 text-center">
                <i class="fas fa-tasks fa-10x opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-12 text-center mb-5">
            <h2 class="display-5 mb-4">Why Choose DailyDo?</h2>
            <p class="lead text-muted">Simple, powerful, and designed for productivity</p>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-list-check fa-2x text-primary"></i>
                    </div>
                    <h5 class="card-title">Task Management</h5>
                    <p class="card-text text-muted">Create, organize, and manage your tasks with ease. Set priorities and deadlines to stay on track.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-bell fa-2x text-success"></i>
                    </div>
                    <h5 class="card-title">Smart Reminders</h5>
                    <p class="card-text text-muted">Never miss a deadline with intelligent reminders and notifications for your important tasks.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-chart-line fa-2x text-info"></i>
                    </div>
                    <h5 class="card-title">Progress Tracking</h5>
                    <p class="card-text text-muted">Monitor your productivity with detailed statistics and insights about your task completion.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-flag fa-2x text-warning"></i>
                    </div>
                    <h5 class="card-title">Priority System</h5>
                    <p class="card-text text-muted">Organize tasks by priority levels to focus on what matters most and maximize your efficiency.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-mobile-alt fa-2x text-danger"></i>
                    </div>
                    <h5 class="card-title">Responsive Design</h5>
                    <p class="card-text text-muted">Access your tasks anywhere, anytime. DailyDo works perfectly on desktop, tablet, and mobile devices.</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body text-center p-4">
                    <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 80px; height: 80px;">
                        <i class="fas fa-shield-alt fa-2x text-secondary"></i>
                    </div>
                    <h5 class="card-title">Secure & Private</h5>
                    <p class="card-text text-muted">Your data is secure with us. We prioritize privacy and ensure your tasks remain confidential.</p>
                </div>
            </div>
        </div>
    </div>

    @guest
        <div class="row">
            <div class="col-12">
                <div class="card bg-light border-0">
                    <div class="card-body text-center py-5">
                        <h3 class="mb-4">Ready to Get Started?</h3>
                        <p class="lead text-muted mb-4">Join thousands of users who have improved their productivity with DailyDo</p>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('register') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-user-plus me-2"></i>Create Account
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg">
                                <i class="fas fa-sign-in-alt me-2"></i>Sign In
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endguest
</div>
@endsection

@section('styles')
<style>
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.fa-10x {
    font-size: 10rem;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-5px);
}
</style>
@endsection
