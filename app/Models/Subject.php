<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    /** @use HasFactory<\Database\Factories\SubjectFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
    ];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_subject')
            ->withPivot('sort_order', 'status', 'started_at', 'finished_at', 'estimated_duration_days')
            ->withTimestamps();
    }

    public function courseSubjects(): HasMany
    {
        return $this->hasMany(CourseSubject::class);
    }
}
