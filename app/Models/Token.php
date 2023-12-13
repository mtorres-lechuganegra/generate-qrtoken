<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Token extends Model
{
    use HasFactory;

    const TOKEN_LENGTH = 24;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'value',
        'entity_id',
        'entity_type',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relations
    |--------------------------------------------------------------------------
    */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(User::class, UserToken::class, 'token_id', 'id', 'id', 'user_id');
    }

    public function tokenable()
    {
        return $this->morphTo();
    }

    public function products(): MorphToMany
    {
        return $this->morphedByMany(Product::class, 'entity');
    }

    public function services(): MorphToMany
    {
        return $this->morphedByMany(Service::class, 'entity');
    }
}
