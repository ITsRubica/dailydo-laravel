# Task Reminder Feature

## Overview
The reminder feature allows users to set notifications for their tasks. When a task's deadline approaches, a beautiful notification popup appears at the bottom right of the screen.

## How It Works

### 1. Setting a Reminder
When creating or editing a task:
- Check the "Set Reminder" checkbox
- Select when you want to be reminded (15 minutes, 30 minutes, 1 hour, or 1 day before deadline)
- The reminder will be saved with the task

### 2. Reminder Notifications
- The system checks for upcoming reminders every 60 seconds
- When a task's reminder time is reached, a notification popup appears at the bottom right
- The notification includes:
  - Task title and description
  - Time until deadline
  - Priority badge (color-coded)
  - Quick link to view the task
  - Dismiss button

### 3. Notification Features
- **Auto-dismiss**: Notifications automatically disappear after 30 seconds
- **Manual dismiss**: Click the X button to close immediately
- **Sound alert**: A gentle beep plays when a notification appears
- **Priority colors**:
  - High priority: Red
  - Medium priority: Yellow
  - Low priority: Green
- **Responsive**: Works on mobile and desktop
- **Non-intrusive**: Appears at bottom right, doesn't block content

### 4. Technical Details

#### Database Structure
The `tasks` table includes:
- `reminder` (boolean): Whether reminder is enabled
- `reminder_time` (integer): Minutes before deadline to remind (default: 15)

#### API Endpoint
- **Route**: `GET /api/tasks/reminders`
- **Controller**: `TaskController@checkReminders`
- **Returns**: Array of tasks with active reminders

#### Frontend
- JavaScript checks reminders every 60 seconds
- Tracks shown reminders to avoid duplicates
- Uses CSS animations for smooth appearance/disappearance
- Web Audio API for notification sound

## Usage Example

1. Create a task with deadline: "December 16, 2025 10:00 AM"
2. Enable reminder and set to "30 minutes before"
3. At 9:30 AM on December 16, a notification will appear
4. The notification stays for 30 seconds or until dismissed

## Browser Compatibility
- Works in all modern browsers (Chrome, Firefox, Safari, Edge)
- Gracefully degrades if audio is not supported
- Responsive design for mobile devices
