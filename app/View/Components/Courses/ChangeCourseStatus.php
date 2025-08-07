<?php

namespace App\View\Components\Courses;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class ChangeCourseStatus extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public int $courseId, public bool $isToStartMode)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.courses.change-course-status');
    }
}
