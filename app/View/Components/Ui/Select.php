<?php

namespace App\View\Components\Ui;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Select extends Component
{
    /**
     * Create a new component instance.
     */
    public string $itemsJson;
    public ?string $defaultItem;

    public function __construct(array $items = [], string $defaultValue = '', public ?string $name = null, public ?string $id = null, public string $placeholder = 'Select Item', public bool $required = false)
    {
        $checkedItems = collect($items)->map(function ($item) {
            if (is_array($item)) {
                return [
                    'value' => $item['value'] ?? '?',
                    'title' => $item['title'] ?? '?',
                    'disabled' => false,
                ];
            }
            return [
                'value' => '?',
                'title' => '?',
                'disabled' => true,
            ];
        });


        $this->itemsJson = json_encode($checkedItems);

        $matched = $checkedItems->firstWhere('value', $defaultValue);
        $this->defaultItem = $matched ? json_encode($matched) : null;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.ui.select');
    }
}
