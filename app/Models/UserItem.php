<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class UserItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'entity_id',
        'entity_type',
    ];

    public function entity()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopeGetModel($query, $model)
    {
        return $query->where('entity_type', $model);
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
