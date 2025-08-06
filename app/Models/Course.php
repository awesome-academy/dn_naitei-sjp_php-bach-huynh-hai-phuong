<?php

namespace App\Models;

use App\Models\Enums\CourseStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'featured_image',
    ];

    protected function casts(): array
    {
        return [
            'status' => CourseStatus::class,
            'started_at' => 'datetime',
            'finished_at' => 'datetime',
        ];
    }


    public function trainees(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_course')
            ->withPivot('is_active', 'assigned_at')
            ->withTimestamps();
    }

    public function supervisors(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_supervisors', 'course_id', 'supervisor_id')->withTimestamps();
    }

    public function subjects(): BelongsToMany
    {
        return $this->belongsToMany(Subject::class, 'course_subject')
            ->orderByPivot('sort_order')
            ->withPivot('sort_order', 'status', 'started_at', 'finished_at', 'estimated_duration_days')
            ->withTimestamps();
    }

    public function courseSubjects(): HasMany
    {
        return $this->hasMany(CourseSubject::class);
    }
}
