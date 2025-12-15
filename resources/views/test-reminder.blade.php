@extends('layouts.app')

@section('title', 'Test Reminder - DailyDo')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4>Test Reminder System</h4>
                </div>
                <div class="card-body">
                    <h5>Step 1: Check if container exists</h5>
                    <button class="btn btn-primary mb-3" onclick="checkContainer()">Check Container</button>
                    <div id="containerResult" class="alert alert-info" style="display: none;"></div>

                    <hr>

                    <h5>Step 2: Test API Endpoint</h5>
                    <button class="btn btn-primary mb-3" onclick="testAPI()">Test API</button>
                    <pre id="apiResult" class="alert alert-info" style="display: none;"></pre>

                    <hr>

                    <h5>Step 3: Show Test Notification</h5>
                    <button class="btn btn-success mb-3" onclick="showTestNotification()">Show Test Notification</button>

                    <hr>

                    <h5>Step 4: Check for Real Reminders</h5>
                    <button class="btn btn-warning mb-3" onclick="checkReminders()">Check Reminders Now</button>
                    <div id="reminderResult" class="alert alert-info" style="display: none;"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function checkContainer() {
    const container = document.getElementById('reminderNotifications');
    const result = document.getElementById('containerResult');
    result.style.display = 'block';
    
    if (container) {
        result.className = 'alert alert-success';
        result.textContent = '✓ Container exists! Position: ' + window.getComputedStyle(container).position;
    } else {
        result.className = 'alert alert-danger';
        result.textContent = '✗ Container NOT found!';
    }
}

function testAPI() {
    const result = document.getElementById('apiResult');
    result.style.display = 'block';
    result.textContent = 'Loading...';
    
    fetch('/api/tasks/reminders', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        result.className = 'alert alert-success';
        result.textContent = JSON.stringify(data, null, 2);
    })
    .catch(error => {
        result.className = 'alert alert-danger';
        result.textContent = 'Error: ' + error.message;
    });
}

function showTestNotification() {
    if (typeof showReminderNotification === 'function') {
        showReminderNotification({
            id: 999,
            title: "Test Reminder Notification",
            description: "This is a test to verify the notification system is working correctly.",
            deadline: "Dec 15, 2025 3:00 PM",
            priority: "high",
            time_until: "in 5 minutes"
        });
        alert('Test notification triggered! Check bottom right corner.');
    } else {
        alert('Error: showReminderNotification function not found!');
    }
}
</script>
@endsection
