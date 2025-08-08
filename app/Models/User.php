<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Enums\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => Role::class
        ];
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'user_course')
            ->withPivot('is_active', 'assigned_at')
            ->withTimestamps();
    }

    public function supervisedCourses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_supervisors', 'supervisor_id', 'course_id')->withTimestamps();
    }

    public function courseSubjects(): BelongsToMany
    {
        return $this->belongsToMany(CourseSubject::class, 'user_subject', 'user_id', 'course_subject_id')
            ->withPivot('status', 'started_at', 'finished_at')
            ->withTimestamps();
    }

    public function tasks(): BelongsToMany
    {
        return $this->belongsToMany(Task::class, 'user_task', 'user_id', 'course_subject_task_id')
            ->withPivot('is_done', 'done_at')
            ->withTimestamps();
    }
}
