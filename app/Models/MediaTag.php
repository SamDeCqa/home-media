<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\{Fillable, Hidden};
use Illuminate\Database\Eloquent\Factories\HasFactory;

#[Fillable(['tag_id', 'media_id'])]
#[Hidden('id')]
class MediaTag extends Model
{
    use HasFactory;
}
