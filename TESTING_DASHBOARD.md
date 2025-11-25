# Dashboard Testing Guide

## Prerequisites
1. Ensure database is migrated: `php artisan migrate`
2. Ensure you're logged in as a user
3. Navigate to `/dashboard`

## Test Cases

### Test 1: Quick Add Task Form
**Steps:**
1. Enter a task title in "What needs to be done?" field
2. Optionally set a deadline using the datetime picker
3. Optionally check "Set reminder"
4. Click "Add" button

**Expected Result:**
- Toast notification appears: "Task added successfully!"
- Page reloads after 1 second
- New task appears in appropriate section (Today's or Upcoming)
- Form is cleared

**Validation:**
- Title is required (form won't submit without it)
- Deadline is optional
- Reminder is optional

---

### Test 2: Toggle Task Completion (Today's Tasks)
**Steps:**
1. Find a task in "Today's Tasks" section
2. Click the checkbox next to the task

**Expected Result:**
- Checkbox becomes checked/unchecked
- Task title gets strikethrough (if completed)
- Task opacity changes to 0.6 (if completed)
- Background changes to green tint (if completed)
- Statistics update (Pending/Completed counts)

**Reverse:**
- Uncheck the checkbox
- Task returns to normal appearance
- Statistics update accordingly

---

### Test 3: Toggle Task Completion (Upcoming Tasks)
**Steps:**
1. Find a task in "Upcoming Tasks" section
2. Click the checkbox next to the task

**Expected Result:**
- Same behavior as Test 2
- Statistics update correctly

---

### Test 4: Statistics Update
**Steps:**
1. Note current Pending and Completed counts
2. Toggle any task completion
3. Observe statistics card

**Expected Result:**
- Pending count decreases by 1 when task is completed
- Completed count increases by 1 when task is completed
- Counts update in real-time without page reload

---

### Test 5: Task with Reminder Badge
**Steps:**
1. Create a task with "Set reminder" checked
2. Observe the task in the list

**Expected Result:**
- Task has a bell icon badge on the right
- Task background has slight brown tint
- Task has left border in brown color (#896C6C)

---

### Test 6: Task Display Sections
**Steps:**
1. Create a task with today's date as deadline
2. Create a task with tomorrow's date as deadline
3. Create a task with no deadline

**Expected Result:**
- Task with today's deadline appears in "Today's Tasks"
- Task with tomorrow's deadline appears in "Upcoming Tasks"
- Task with no deadline (created today) appears in "Today's Tasks"

---

### Test 7: Empty States
**Steps:**
1. Complete or delete all tasks
2. Observe both sections

**Expected Result:**
- "Today's Tasks" shows: "No tasks for today"
- "Upcoming Tasks" shows: "No upcoming tasks"
- Statistics show 0 for both Pending and Completed

---

## Common Issues & Solutions

### Issue: "Task added successfully!" but task doesn't appear
**Solution:** Check if task has a future deadline - it should appear in "Upcoming Tasks"

### Issue: Checkbox doesn't toggle
**Solution:** 
- Check browser console for JavaScript errors
- Verify CSRF token is present
- Ensure user is authenticated

### Issue: Statistics don't update
**Solution:**
- Check if `updateStatistics()` function is being called
- Verify task items have correct classes (`.task-item`, `.task-checkbox`)

### Issue: 500 Error when toggling task
**Solution:**
- Verify TaskPolicy is registered in AuthServiceProvider
- Check if user owns the task
- Verify route exists: `POST /tasks/{task}/toggle`

---

## Browser Console Commands (for debugging)

```javascript
// Check if toggleTaskCompletion function exists
typeof toggleTaskCompletion

// Check if showToast function exists
typeof showToast

// Manually trigger toast
showToast('Test message')

// Check CSRF token
document.querySelector('meta[name="csrf-token"]')?.content

// Count task items
document.querySelectorAll('.task-item').length
```

---

## API Testing (using curl or Postman)

### Create Task
```bash
POST /tasks
Headers: X-CSRF-TOKEN, Cookie (session)
Body: {
  "title": "Test Task",
  "deadline": "2024-12-31 23:59:00",
  "reminder": true
}
```

### Toggle Task
```bash
POST /tasks/1/toggle
Headers: X-CSRF-TOKEN, Cookie (session)
Body: {
  "status": "completed"
}
```

---

## Success Criteria
✅ All forms submit successfully
✅ All buttons perform their intended actions
✅ Real-time updates work without page reload
✅ Statistics are accurate
✅ Toast notifications appear
✅ Tasks display in correct sections
✅ Authorization prevents unauthorized access
✅ No JavaScript errors in console
✅ No PHP errors in logs
