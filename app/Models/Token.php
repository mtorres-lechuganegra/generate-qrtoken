<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Token extends Model
{
    use HasFactory;

    const TOKEN_LENGTH = 24;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'value',
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
}
