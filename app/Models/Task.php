<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'priority',
        'deadline',
        'reminder',
        'reminder_time',
        'status',
        'completed',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'deadline' => 'datetime',
        'reminder' => 'boolean',
        'completed' => 'boolean',
    ];

    /**
     * Get the user that owns the task.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include pending tasks.
     */
    public function scopePending(Builder $query): void
    {
        $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include completed tasks.
     */
    public function scopeCompleted(Builder $query): void
    {
        $query->where('status', 'completed');
    }

    /**
     * Scope a query to filter by priority.
     */
    public function scopeByPriority(Builder $query, string $priority): void
    {
        $query->where('priority', $priority);
    }

    /**
     * Scope a query to search tasks.
     */
    public function scopeSearch(Builder $query, string $search): void
    {
        $query->where(function ($q) use ($search) {
            $q->where('title', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    /**
     * Check if task is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->deadline && 
               $this->status === 'pending' && 
               $this->deadline->isPast();
    }

    /**
     * Get formatted deadline.
     */
    public function getFormattedDeadlineAttribute(): ?string
    {
        return $this->deadline ? $this->deadline->format('M d, Y H:i') : null;
    }

    /**
     * Get priority badge class.
     */
    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'high' => 'badge-danger',
            'medium' => 'badge-warning',
            'low' => 'badge-success',
            default => 'badge-secondary'
        };
    }

    /**
     * Mark task as completed.
     */
    public function markAsCompleted(): void
    {
        $this->update([
            'status' => 'completed',
            'completed' => true,
        ]);
    }

    /**
     * Mark task as pending.
     */
    public function markAsPending(): void
    {
        $this->update([
            'status' => 'pending',
            'completed' => false,
        ]);
    }

    /**
     * Get time until deadline in human readable format.
     */
    public function getTimeUntilDeadlineAttribute(): ?string
    {
        if (!$this->deadline) {
            return null;
        }

        if ($this->deadline->isPast()) {
            return 'Overdue by ' . $this->deadline->diffForHumans();
        }

        return 'Due ' . $this->deadline->diffForHumans();
    }
}
