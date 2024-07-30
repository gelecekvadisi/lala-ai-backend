<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideIntelligence extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'assistant_id',
        'google_sheets_id',
        'image_name',
        'data',
        'status',
        'user_id',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(GuideIntelligenceCategory::class);
    }
}