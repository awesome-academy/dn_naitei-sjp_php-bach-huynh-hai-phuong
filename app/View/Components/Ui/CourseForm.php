<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CourseForm extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(public ?int $id = null, public ?string $title = null, public ?string $description = null, public ?string $featuredImage = null)
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.course-form');
    }
}
