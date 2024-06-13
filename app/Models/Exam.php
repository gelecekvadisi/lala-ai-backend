<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image_name',
        'assistant_id',
        'sinif_duzeyi',
        'soru_sayisi',
        'zorluk_seviyesi',
        'konu',
        // 'fields',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'fields' => 'array',
        'status' => 'integer',
    ];
}
