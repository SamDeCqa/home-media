<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\{Fillable, Hidden};
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['type'])]
#[Hidden('id')]
class Role extends Model
{
    /** @use HasFactory<\Database\Factories\RoleFactory> */
    use HasFactory;

    public function type()  : Attribute
    {
        return Attribute::make(
            fn($type) => ucwords($type),
            fn($type) => strtolower($type)
        );
    }

    public function users () : HasMany
    {
        return $this->hasMany(User::class);
    }
}
