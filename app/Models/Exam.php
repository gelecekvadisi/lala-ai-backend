<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_name',
        'assistant_id',
        'sinif_duzeyi',
        'soru_sayisi',
        'zorluk_seviyesi',
        'konu',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($exam) {
            // Transaction içinde ID oluşturma işlemi yapılır
            DB::beginTransaction();
            try {
                do {
                    //  010000 - 999999
                    $exam->id = str_pad(mt_rand(10000, 999999), 6, '0', STR_PAD_LEFT);
                } while (Exam::where('id', $exam->id)->exists());

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
    }
}
