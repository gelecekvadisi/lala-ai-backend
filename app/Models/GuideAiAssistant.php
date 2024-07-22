<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Exception;

class GuideAiAssistant extends Model
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
        'inputs',
        'instructions_generator',
        'spreadsheet_name',
        'spreadsheet_id',
        'status',



        // 'sinif_duzeyi',
        // 'soru_sayisi',
        // 'zorluk_seviyesi',
        // 'konu',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'integer',
    ];

    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = 'id';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($GuideAiAssistant) {
            // Transaction içinde ID oluşturma işlemi yapılır
            DB::beginTransaction();
            try {
                do {
                    //  010000 - 999999
                    $GuideAiAssistant->id = str_pad(mt_rand(10000, 999999), 6, '0', STR_PAD_LEFT);
                } while (GuideAiAssistant::where('id', $GuideAiAssistant->id)->exists());

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }
        });
    }

    public static function generateId() {
        $tempId = null;
            do {
                //  010000 - 999999
                $tempId = str_pad(mt_rand(10000, 999999), 6, '0', STR_PAD_LEFT);
            } while (GuideAiAssistant::where('id', $tempId)->exists());
            return $tempId;
    }
}
