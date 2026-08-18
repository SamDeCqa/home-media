<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Table('media_categories')]
class MediaCategory extends Model
{
    /** @use HasFactory<\Database\Factories\MediaCategoryFactory> */
    use HasFactory;
}
