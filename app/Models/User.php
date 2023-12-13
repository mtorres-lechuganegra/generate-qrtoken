<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'dni',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function tokens()
    {
        return $this->hasManyThrough(Token::class, UserToken::class, 'user_id', 'id', 'id', 'token_id');
    }

    public function userItems()
    {
        return $this->hasMany(UserItem::class);
    }

    public function products()
    {
        return $this->morphedByMany(Product::class, 'entity', 'user_items', 'user_id', 'entity_id');
    }

    public function services()
    {
        return $this->morphedByMany(Service::class, 'entity', 'user_items', 'user_id', 'entity_id');
    }
}
