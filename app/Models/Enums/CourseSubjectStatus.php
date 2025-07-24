<?php

namespace App\Models\Enums;

enum CourseSubjectStatus: string
{
    case NOT_STARTED = 'not_started';
    case STARTED = 'started';
    case FINISHED = 'finished';
}
