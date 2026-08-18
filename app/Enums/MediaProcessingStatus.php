<?php

namespace App\Enums;

enum MediaProcessingStatus : string
{
    case PENDING = 'pending';
    case READY = 'ready';
    case FAILED = 'failed';
}
