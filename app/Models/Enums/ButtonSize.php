<?php

namespace App\Models\Enums;

enum ButtonSize: string
{
    case DEFAULT = 'default';
    case SMALL = 'small';
    case LARGE = 'large';
    case ICON = 'icon';
}
