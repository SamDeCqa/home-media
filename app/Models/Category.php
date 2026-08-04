<?php

namespace App\Models;

use App\Observers\UuidObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\{Fillable, Hidden, ObservedBy};
use Illuminate\Database\Eloquent\Casts\Attribute;

#[Fillable(['name', 'user_id', 'uuid'])]
#[Hidden('id')]
#[ObservedBy(UuidObserver::class)]
class Category extends Model
{
    public function name(): Attribute
    {
        return Attribute::make(
            fn($name) => ucwords($name),
            fn($name) => strtolower($name)
        );
    }
}
