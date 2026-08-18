<?php

namespace App\Enums;

enum DisksEnum : string
{
    case LOCAL = 'local';
    case S3 = 's3';
    case PUBLIC = 'public';
}
