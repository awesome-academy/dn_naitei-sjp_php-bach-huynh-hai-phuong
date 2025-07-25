<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Subject extends Model
{
    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_subject')
            ->withPivot('sort_order', 'status', 'started_at', 'finished_at', 'estimated_duration_days')
            ->withTimestamps();
    }
}
