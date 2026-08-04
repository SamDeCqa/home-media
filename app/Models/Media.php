<?php

namespace App\Models;

use App\Observers\UuidObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\{Fillable, Hidden, ObservedBy};
use Illuminate\Database\Eloquent\Casts\Attribute;

#[Fillable(['uuid', 'name', 'path', 'content_type', 'description', 'user_id', 'category_id', 'byte_size', 'metadata'])]
#[Hidden('id')]
#[ObservedBy(UuidObserver::class)]
class Media extends Model
{
    /** @use HasFactory<\Database\Factories\MediaFactory> */
    use HasFactory;

    public function description(): Attribute
    {
        return Attribute::make(
            fn($description) => ucfirst($description),
            fn($description) => ucfirst($description)
        );
    }
}
