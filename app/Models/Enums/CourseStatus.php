<?php

namespace App\Models\Enums;

enum CourseStatus: string
{
    case DRAFT = 'draft';
    case STARTED = 'started';
    case FINISHED = 'finished';
}
