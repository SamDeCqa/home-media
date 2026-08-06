<?php

namespace App\Models;

use App\Observers\UuidObserver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\{Fillable, Hidden, ObservedBy};
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, HasMany};

#[Fillable(['name', 'user_id', 'uuid', 'is_private'])]
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

    protected function casts(): array
    {
        return [
            'is_private' => 'boolean',
        ];
    }
    


    public function getRouteKeyName()
    {
        return 'uuid';
    }


    public function user () : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function media () : HasMany
    {
        return $this->hasMany(Media::class);
    }
}
