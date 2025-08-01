<?php

namespace App\View\Components\Courses;

use App\Models\Enums\BadgeVariant;
use App\Models\Enums\CourseSubjectStatus;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SubjectStatusBadge extends Component
{
    protected const MAP_STATUS_TO_BADGE_VARIANT = [
        CourseSubjectStatus::NOT_STARTED->value => [
            'variant' => BadgeVariant::SECONDARY->value,
            'name' => 'course_subject.' . CourseSubjectStatus::NOT_STARTED->value,
        ],
        CourseSubjectStatus::STARTED->value => [
            'variant' => BadgeVariant::DEFAULT->value,
            'name'=> 'course_subject.' . CourseSubjectStatus::STARTED->value,
        ],
        CourseSubjectStatus::FINISHED->value => [
            'variant' => BadgeVariant::DESTRUCTIVE->value,
            'name' => 'course_subject.' . CourseSubjectStatus::FINISHED->value,
        ],
    ];

    public string $name;
    public string $badgeVariant;

    /**
     * Create a new component instance.
     */
    public function __construct(string $status)
    {
        $statusEnum = CourseSubjectStatus::tryFrom($status) ?: CourseSubjectStatus::NOT_STARTED;
        $status = $statusEnum->value;

        $mapped = self::MAP_STATUS_TO_BADGE_VARIANT[$status] ?: self::MAP_STATUS_TO_BADGE_VARIANT[CourseSubjectStatus::NOT_STARTED->value];

        $this->name = $mapped['name'];
        $this->badgeVariant = $mapped['variant'];
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.courses.subject-status-badge');
    }
}
