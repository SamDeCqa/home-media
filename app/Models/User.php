<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Observers\UuidObserver;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'password', 'is_verified', 'profile_photo', 'cover_photo', 'uuid'])]
#[Hidden(['id', 'password', 'remember_token'])]
#[ObservedBy(UuidObserver::class)]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean'
        ];
    }

    public function name()  : Attribute
    {
        return Attribute::make(
            fn($name) => ucwords($name),
            fn($name) => ucwords($name)
        );
    }

    public function role () : HasOne
    {
        return $this->hasOne(Role::class);
    }

    public function media () : HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function categories () : HasMany
    {
        return $this->hasMany(Category::class);
    }

    public function tags () : HasMany
    {
        return $this->hasMany(Tag::class);
    }

    //SCOPES
    #[Scope]
    public function favourites(Builder $query){
        return $query->media()->where('is_favourite', true);
    }

    #[Scope]
    public function verified(Builder $query, bool $condtition){
        return $query->where('is_verified', $condtition);
    }
}
