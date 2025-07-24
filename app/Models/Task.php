<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Task extends Model
{
    protected $table = 'course_subject_tasks';

    public function courseSubject(): BelongsTo
    {
        return $this->belongsTo(CourseSubject::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_task', 'course_subject_task_id', 'user_id')
            ->withPivot('id_done', 'done_at')
            ->withTimestamps();
    }
}
