<?php

namespace App\View\Components\Layout\AdminPanel;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Menu extends Component
{
    public array $menuList;
    /**
     * Create a new component instance.
     */
    public function __construct(?array $menuList)
    {
        $this->menuList = $menuList ?: config('menu.admin_panel');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.admin-panel.menu');
    }
}
