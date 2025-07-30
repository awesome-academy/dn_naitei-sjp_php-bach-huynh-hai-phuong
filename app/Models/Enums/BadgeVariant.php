<?php

namespace App\Models\Enums;

enum BadgeVariant: string
{
    case DEFAULT = 'default';
    case DESTRUCTIVE = 'destructive';
    case OUTLINE = 'outline';
    case SECONDARY = 'secondary';
}
