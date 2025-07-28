<?php

namespace App\View\Components\Ui;

use Closure;
use InvalidArgumentException;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

enum ButtonVariant: string
{
    case DEFAULT = 'default';
    case DESTRUCTIVE = 'destructive';
    case OUTLINE = 'outline';
    case SECONDARY = 'secondary';
    case GHOST = 'ghost';
    case LINK = 'link';
}

enum ButtonSize: string
{
    case DEFAULT = 'default';
    case SMALL = 'small';
    case LARGE = 'large';
    case ICON = 'icon';
}

class Button extends Component
{
    public const BASE_STYLE = "inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium transition-all disabled:pointer-events-none disabled:opacity-50 [&_svg]:pointer-events-none [&_svg:not([class*='size-'])]:size-4 shrink-0 [&_svg]:shrink-0 outline-none focus-visible:border-ring focus-visible:ring-ring/50 focus-visible:ring-[3px] aria-invalid:ring-destructive/20 dark:aria-invalid:ring-destructive/40 aria-invalid:border-destructive";

    public const VARIANT_STYLES = [
        ButtonVariant::DEFAULT ->value => "bg-primary text-primary-foreground shadow-xs hover:bg-primary/90",
        ButtonVariant::DESTRUCTIVE->value => "bg-destructive text-white shadow-xs hover:bg-destructive/90 focus-visible:ring-destructive/20 dark:focus-visible:ring-destructive/40 dark:bg-destructive/60",
        ButtonVariant::OUTLINE->value => "border bg-background shadow-xs hover:bg-accent hover:text-accent-foreground dark:bg-input/30 dark:border-input dark:hover:bg-input/50",
        ButtonVariant::SECONDARY->value => "bg-secondary text-secondary-foreground shadow-xs hover:bg-secondary/80",
        ButtonVariant::GHOST->value => "hover:bg-accent hover:text-accent-foreground dark:hover:bg-accent/50",
        ButtonVariant::LINK->value => "text-primary underline-offset-4 hover:underline",
    ];

    public const SIZE_STYLES = [
        ButtonSize::DEFAULT ->value => "h-9 px-4 py-2 has-[>svg]:px-3",
        ButtonSize::SMALL->value => "h-8 rounded-md gap-1.5 px-3 has-[>svg]:px-2.5",
        ButtonSize::LARGE->value => "h-10 rounded-md px-6 has-[>svg]:px-4",
        ButtonSize::ICON->value => "size-9",
    ];

    public const ALLOWED_TAGS = ['button', 'a', 'div'];

    public string $variant;

    public string $size;

    public string $tag;

    /**
     * Create a new component instance.
     */
    public function __construct(string $variant = ButtonVariant::DEFAULT ->value, string $size = ButtonSize::DEFAULT ->value, string $tag = 'button')
    {
        $this->variant = ButtonVariant::from($variant)->value;
        $this->size = ButtonSize::from($size)->value;

        if (!in_array($tag, self::ALLOWED_TAGS)) {
            throw new InvalidArgumentException("Invalid tag: $tag. Allowed tags are: " . implode(', ', self::ALLOWED_TAGS));
        }
        $this->tag = $tag;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.button');
    }
}
