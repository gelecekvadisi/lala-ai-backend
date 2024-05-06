<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'price',
        'status',
        'duration',
        'subtitle',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'double',
        'features' => 'json',
        'status' => 'integer',
    ];

    public function users():HasMany
    {
        return $this->hasMany(User::class, 'plan_id');
    }

    public function subscribers()
    {
        return $this->hasMany(Subscribe::class, 'plan_id');
    }
}
