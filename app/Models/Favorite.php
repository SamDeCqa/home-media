<?php

namespace App\Models;

use App\Observers\UuidObserver;
use Illuminate\Database\Eloquent\Attributes\{Fillable, Hidden, ObservedBy};
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['uuid', 'media_id', 'user_id'])]
#[Hidden('id')]
#[ObservedBy(UuidObserver::class)]
class Favorite extends Model
{
    /** @use HasFactory<\Database\Factories\FavoriteFactory> */
    use HasFactory;
}
