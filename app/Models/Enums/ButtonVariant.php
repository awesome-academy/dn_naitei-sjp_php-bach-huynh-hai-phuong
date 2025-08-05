<?php

namespace App\Models\Enums;

enum ButtonVariant: string
{
    case DEFAULT = 'default';
    case DESTRUCTIVE = 'destructive';
    case OUTLINE = 'outline';
    case SECONDARY = 'secondary';
    case GHOST = 'ghost';
    case LINK = 'link';
}
