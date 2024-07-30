<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuideIntelligenceCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'google_sheet_name',
        'image_name',
        'inputs',
        'instructions_generator',
        'google_sheets_columns',
        'status',
    ];
}
