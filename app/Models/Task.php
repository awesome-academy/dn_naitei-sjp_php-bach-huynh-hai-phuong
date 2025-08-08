<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $table = 'course_subject_tasks';

    protected $fillable = [
        'title',
        'description',
        'sort_order',
    ];

    public function courseSubject(): BelongsTo
    {
        return $this->belongsTo(CourseSubject::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_task', 'course_subject_task_id', 'user_id')
            ->withPivot('is_done', 'done_at')
            ->withTimestamps();
    }

    public function userTasks(): HasMany
    {
        return $this->hasMany(UserTask::class, 'course_subject_task_id');
    }
}
