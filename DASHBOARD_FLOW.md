# Dashboard Functionality Flow

## Component Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                      DASHBOARD VIEW                          │
│                  (dashboard.blade.php)                       │
└─────────────────────────────────────────────────────────────┘
                              │
                              │
        ┌─────────────────────┼─────────────────────┐
        │                     │                     │
        ▼                     ▼                     ▼
┌──────────────┐    ┌──────────────┐    ┌──────────────┐
│ Quick Add    │    │ Today's      │    │ Upcoming     │
│ Task Form    │    │ Tasks        │    │ Tasks        │
└──────────────┘    └──────────────┘    └──────────────┘
        │                     │                     │
        │                     └─────────┬───────────┘
        │                               │
        ▼                               ▼
┌──────────────┐              ┌──────────────┐
│ TaskController│              │ JavaScript   │
│ ::store()    │              │ Functions    │
└──────────────┘              └──────────────┘
        │                               │
        │                               ▼
        │                     ┌──────────────┐
        │                     │ TaskController│
        │                     │ ::toggle()   │
        │                     └──────────────┘
        │                               │
        └───────────────┬───────────────┘
                        │
                        ▼
                ┌──────────────┐
                │ Task Model   │
                └──────────────┘
                        │
                        ▼
                ┌──────────────┐
                │  Database    │
                │ (tasks table)│
                └──────────────┘
```

## Data Flow

### 1. Page Load Flow
```
User visits /dashboard
        │
        ▼
DashboardController::index()
        │
        ├─► Get user's tasks
        ├─► Filter today's tasks
        ├─► Filter upcoming tasks
        ├─► Calculate statistics
        │
        ▼
Return view with data:
  - todayTasks
  - upcomingTasks
  - pendingTasks (count)
  - completedTasks (count)
        │
        ▼
Blade renders HTML with:
  - Quick Add Form
  - Today's Tasks list
  - Upcoming Tasks list
  - Statistics card
```

### 2. Quick Add Task Flow
```
User fills form & clicks "Add"
        │
        ▼
JavaScript intercepts submit
        │
        ▼
AJAX POST to /tasks
  Headers: X-CSRF-TOKEN
  Body: FormData {
    title: "...",
    deadline: "...",
    reminder: true/false,
    priority: "medium"
  }
        │
        ▼
TaskController::store()
        │
        ├─► Validate input
        ├─► Create task with user_id
        ├─► Set defaults (priority, status)
        │
        ▼
Return JSON response:
  {
    success: true,
    message: "Task created",
    task: {...}
  }
        │
        ▼
JavaScript receives response
        │
        ├─► Show toast notification
        ├─► Reset form
        │
        ▼
Page reloads after 1 second
        │
        ▼
New task appears in appropriate section
```

### 3. Toggle Task Completion Flow
```
User clicks checkbox
        │
        ▼
JavaScript: toggleTaskCompletion(checkbox, taskId)
        │
        ├─► Get task elements (title, due date)
        ├─► Determine new status (checked = completed)
        │
        ▼
AJAX POST to /tasks/{id}/toggle
  Headers: X-CSRF-TOKEN, Content-Type
  Body: JSON {
    status: "completed" or "pending"
  }
        │
        ▼
TaskController::toggleComplete()
        │
        ├─► Authorize user (TaskPolicy)
        ├─► Check request status parameter
        ├─► Update task status & completed flag
        │
        ▼
Return JSON response:
  {
    success: true,
    message: "Task marked as...",
    task: {...}
  }
        │
        ▼
JavaScript receives response
        │
        ├─► Update UI (strikethrough, opacity)
        ├─► Change background color
        ├─► Update statistics counters
        │
        ▼
UI reflects new state immediately
```

## Authorization Flow

```
Request to modify task
        │
        ▼
TaskController method
        │
        ▼
$this->authorize('update', $task)
        │
        ▼
TaskPolicy::update()
        │
        ├─► Check: user->id === task->user_id
        │
        ├─► TRUE ──► Continue
        │
        └─► FALSE ──► 403 Forbidden
```

## Database Queries

### Dashboard Load
```sql
-- Today's tasks
SELECT * FROM tasks 
WHERE user_id = ? 
  AND (
    DATE(deadline) = CURDATE() 
    OR (deadline IS NULL AND DATE(created_at) = CURDATE())
  )
ORDER BY deadline ASC, created_at DESC;

-- Upcoming tasks
SELECT * FROM tasks 
WHERE user_id = ? 
  AND deadline IS NOT NULL 
  AND deadline > NOW()
ORDER BY deadline ASC 
LIMIT 10;

-- Statistics
SELECT 
  COUNT(*) as total,
  SUM(CASE WHEN status = 'pending' THEN 1 ELSE 0 END) as pending,
  SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed
FROM tasks 
WHERE user_id = ?;
```

### Task Creation
```sql
INSERT INTO tasks (
  user_id, title, description, priority, 
  deadline, reminder, reminder_time, 
  status, completed, created_at, updated_at
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW());
```

### Task Toggle
```sql
UPDATE tasks 
SET status = ?, 
    completed = ?, 
    updated_at = NOW() 
WHERE id = ? AND user_id = ?;
```

## JavaScript Functions

### showToast(message)
- Creates Bootstrap toast notification
- Auto-hides after 3 seconds
- Displays success/error messages

### toggleTaskCompletion(checkbox, taskId)
- Async function
- Sends AJAX request to toggle endpoint
- Updates UI based on response
- Handles errors gracefully
- Calls updateStatistics()

### updateStatistics()
- Counts all task checkboxes
- Separates checked vs unchecked
- Updates DOM elements:
  - #pendingCount
  - #completedCount

### Quick Add Form Submit Handler
- Prevents default form submission
- Creates FormData from form
- Sends AJAX POST request
- Handles success/error responses
- Reloads page on success

## Security Measures

1. **CSRF Protection**
   - All POST requests include X-CSRF-TOKEN
   - Laravel validates token on every request

2. **Authentication**
   - All routes wrapped in 'auth' middleware
   - Only logged-in users can access

3. **Authorization**
   - TaskPolicy ensures users only access own tasks
   - Checked on every task operation

4. **Input Validation**
   - Title required, max 255 chars
   - Priority must be low/medium/high
   - Deadline must be valid datetime
   - Reminder must be boolean

5. **SQL Injection Prevention**
   - Eloquent ORM uses prepared statements
   - All queries parameterized

## Error Handling

### Frontend
- Try-catch blocks in async functions
- Checkbox reverts on error
- Toast shows error message
- Console logs for debugging

### Backend
- Validation errors return 422
- Authorization failures return 403
- Server errors return 500
- All errors include descriptive messages

## Performance Optimizations

1. **Eager Loading**
   - Tasks loaded with single query
   - No N+1 query problems

2. **Pagination**
   - Upcoming tasks limited to 10
   - Prevents loading thousands of tasks

3. **AJAX Requests**
   - No full page reload for toggles
   - Only statistics update

4. **Indexed Queries**
   - user_id indexed (foreign key)
   - deadline indexed for sorting
   - status indexed for filtering
