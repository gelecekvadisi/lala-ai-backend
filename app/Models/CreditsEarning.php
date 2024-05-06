<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CreditsEarning extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'price',
        'user_id',
        'credits',
        'platform',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'double',
        'credits' => 'double',
        'user_id' => 'integer',
    ];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
