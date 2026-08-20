<?php

namespace App\Enums;

enum MediaType : string
{
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case DOCUMENT = 'document';
    case IMAGE = 'image';
}
