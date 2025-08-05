<?php

namespace App\Models;

use App\Models\Enums\CourseSubjectStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseSubject extends Model
{
    protected $table = 'course_subject';

    protected function casts(): array
    {
        return [
            'status' => CourseSubjectStatus::class,
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class)->orderBy('sort_order');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_subject', 'course_subject_id', 'user_id')
            ->withPivot('status', 'started_at', 'finished_at')
            ->withTimestamps();
    }
}
