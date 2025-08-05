<?php

namespace App\View\Components\Form;

use App\Models\Course;
use App\Models\Subject;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TaskForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public Course $course, public Subject $subject, public ?int $id = null, public ?string $title = null, public ?string $description = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.form.task-form');
    }
}
