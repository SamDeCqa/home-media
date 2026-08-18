<?php

namespace App\Models;

use App\Observers\UuidObserver;
use Database\Factories\MediaFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\{BelongsTo, BelongsToMany};

#[Fillable(['uuid', 'name', 'path', 'content_type', 'description', 'user_id', 'byte_size', 'metadata', 'is_favorite', 'is_private'])]
#[Hidden('id')]
#[ObservedBy(UuidObserver::class)]
class Media extends Model
{
    /** @use HasFactory<MediaFactory> */
    use HasFactory;

    public function description(): Attribute
    {
        return Attribute::make(
            fn($description) => ucfirst($description),
            fn($description) => ucfirst($description)
        );
    }

    protected function casts(): array
    {
        return [
            'is_favorite' => 'boolean',
            'is_private' => 'boolean',
        ];
    }

    public function getRouteKeyName()
    {
        return 'uuid';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function category(): BelongsToMany
    {
        /**
         * Media iweze kuwa katika categories nyingi mfano kama Ni Picha ya Graduu 
         * ya mtu inaweza ikawepo kwenye album ya 'Julius' pia ikawepo kwenye album 
         * ya 'graduations'
         */
        return $this->belongsToMany(Category::class, 'media_categories');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'media_tags');
    }

    //SCOPES
    #[Scope]
    public function favorites(Builder $query)
    {
        return $query->where('is_favorite', true);
    }
}
