<?php

namespace App\Models\Enums;

enum UserSubjectStatus: string
{
    case NOT_STARTED = 'not_started';
    case IN_PROGRESS = 'in_progress';
    case FINISHED = 'finished';
}
