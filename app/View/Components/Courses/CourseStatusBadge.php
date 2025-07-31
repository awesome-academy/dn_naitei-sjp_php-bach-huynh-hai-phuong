<?php

namespace App\View\Components\Courses;

use App\Models\Enums\BadgeVariant;
use App\Models\Enums\CourseStatus;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CourseStatusBadge extends Component
{
    protected const MAP_STATUS_TO_BADGE_VARIANT = [
        CourseStatus::DRAFT->value => BadgeVariant::SECONDARY->value,
        CourseStatus::STARTED->value => BadgeVariant::DEFAULT->value,
        CourseStatus::FINISHED->value => BadgeVariant::DESTRUCTIVE->value,
    ];

    public string $name;
    public string $badgeVariant;

    /**
     * Create a new component instance.
     */
    public function __construct(string $status)
    {
        $status = CourseStatus::from($status)->value;

        $this->name = __('course.' . $status);
        $this->badgeVariant = self::MAP_STATUS_TO_BADGE_VARIANT[$status] ?? BadgeVariant::DEFAULT->value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.courses.course-status-badge');
    }
}
