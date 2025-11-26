@php
    $priorityColors = [
        'high' => '#dc3545',
        'medium' => '#6c757d',
        'low' => '#198754'
    ];
    
    $priorityIcons = [
        'high' => 'exclamation-triangle-fill',
        'medium' => 'dash-circle-fill',
        'low' => 'check-circle-fill'
    ];
    
    $priorityColor = $priorityColors[$task->priority] ?? '#6c757d';
    $priorityIcon = $priorityIcons[$task->priority] ?? 'dash-circle-fill';
    $isOverdue = $task->deadline && $task->deadline < now() && $task->status === 'pending';
    $deadlineText = $task->deadline ? $task->deadline->format('M d, Y h:i A') : 'No deadline';
@endphp

<div class="card mb-3 task-card {{ $task->status === 'completed' ? 'completed-task' : '' }}" data-task-id="{{ $task->id }}" data-priority="{{ $task->priority }}" style="border: none; border-radius: 10px; box-shadow: 0 1px 4px rgba(0,0,0,0.08); background: {{ $task->status === 'completed' ? '#f8f9fa' : 'white' }}; border-left: 3px solid {{ $priorityColor }}; transition: all 0.5s ease;">
    <div class="card-body p-3">
        <div class="d-flex justify-content-between align-items-start">
            <div class="d-flex align-items-start flex-grow-1">
                <div class="task-checkbox me-2" onclick="toggleTaskStatus('{{ $task->id }}')" title="{{ $task->status === 'completed' ? 'Mark as Pending' : 'Mark as Completed' }}" style="cursor: pointer;">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; background: {{ $task->status === 'completed' ? '#198754' : '#e9ecef' }}; transition: all 0.3s ease;">
                        <i class="bi bi-{{ $task->status === 'completed' ? 'check' : '' }}" style="font-size: 0.75rem; color: {{ $task->status === 'completed' ? 'white' : '#6c757d' }};"></i>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <div class="d-flex align-items-center mb-1">
                        <h6 class="card-title mb-0 fw-bold {{ $task->status === 'completed' ? 'text-decoration-line-through text-muted' : '' }}" style="color: {{ $task->status === 'completed' ? '#6c757d' : '#333' }}; font-size: 0.95rem;">{{ $task->title }}</h6>
                        <span class="badge ms-2 px-2 py-1 d-flex align-items-center" style="background: {{ $priorityColor }}; color: white; border-radius: 12px; font-size: 0.65rem; font-weight: 600;">
                            <i class="bi bi-{{ $priorityIcon }} me-1" style="font-size: 0.6rem;"></i>{{ strtoupper($task->priority) }}
                        </span>
                        @if($task->reminder)
                            <i class="bi bi-bell-fill ms-2" style="color: #896C6C; font-size: 0.8rem;" title="Reminder Set"></i>
                        @endif
                        @if($isOverdue)
                            <span class="badge bg-danger ms-2 px-2 py-1 d-flex align-items-center" style="border-radius: 12px; font-size: 0.65rem;"><i class="bi bi-exclamation-triangle-fill me-1" style="font-size: 0.6rem;"></i>OVERDUE</span>
                        @endif
                    </div>
                    @if($task->description)
                        <p class="card-text mb-1 {{ $task->status === 'completed' ? 'text-muted' : '' }}" style="color: #666; line-height: 1.4; font-size: 0.8rem;">{{ Str::limit($task->description, 100) }}</p>
                    @endif
                    <div class="d-flex align-items-center">
                        <small class="text-muted d-flex align-items-center" style="font-size: 0.75rem;">
                            <i class="bi bi-calendar3 me-1" style="color: #896C6C; font-size: 0.75rem;"></i>
                            <span>{{ $deadlineText }}</span>
                        </small>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-1 ms-2">
                <button class="btn btn-sm" onclick="editTask('{{ $task->id }}')" title="Edit Task" style="background: #F1F0E4; color: #896C6C; border: 1px solid #DDDAD0; border-radius: 8px; padding: 4px 8px; transition: all 0.3s ease; font-size: 0.8rem;">
                    <i class="bi bi-pencil-square"></i>
                </button>
                <button class="btn btn-sm" onclick="deleteTask('{{ $task->id }}')" title="Delete Task" style="background: #ffe6e6; color: #dc3545; border: 1px solid #ffcccc; border-radius: 8px; padding: 4px 8px; transition: all 0.3s ease; font-size: 0.8rem;">
                    <i class="bi bi-trash3"></i>
                </button>
            </div>
        </div>
    </div>
</div>
