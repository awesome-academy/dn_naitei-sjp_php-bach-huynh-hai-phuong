<?php

namespace App\View\Components\Ui;

use App\Models\Enums\BadgeVariant;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Badge extends Component
{
    public const BASE_STYLE = "inline-flex items-center justify-center rounded-md border px-2 py-0.5 text-xs font-medium w-fit whitespace-nowrap shrink-0 [&>svg]:size-3 gap-1 [&>svg]:pointer-events-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive transition-[color,box-shadow] overflow-hidden";

    public const VARIANT_STYLES = [
        BadgeVariant::DEFAULT ->value => "border-transparent bg-primary text-primary-foreground [a&]:hover:bg-primary/90",
        BadgeVariant::DESTRUCTIVE->value => "border-transparent bg-destructive text-white [a&]:hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40 dark:bg-destructive/60",
        BadgeVariant::OUTLINE->value => "text-foreground [a&]:hover:bg-accent [a&]:hover:text-accent-foreground",
        BadgeVariant::SECONDARY->value => "border-transparent bg-secondary text-secondary-foreground [a&]:hover:bg-secondary/90",
    ];

    public string $variant;

    /**
     * Create a new component instance.
     */
    public function __construct(string $variant = BadgeVariant::DEFAULT ->value)
    {
        $enum = BadgeVariant::tryFrom($variant) ?? BadgeVariant::DEFAULT;
        $this->variant = $enum->value;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.badge');
    }
}
