<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserTask extends Model
{
    protected $table = 'user_task';

    protected $fillable = [
        'is_done',
        'done_at',
    ];

    protected function casts(): array
    {
        return [
            'done_at' => 'datetime'
        ];
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'course_subject_task_id');
    }
}
