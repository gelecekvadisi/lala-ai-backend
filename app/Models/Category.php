<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
        'status',
        'up_category',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'status' => 'integer',
    ];

    public function assistants()
    {
        return $this->hasMany(Suggestion::class);
    }

    /**
     * Üst kategori ilişkisi
     */
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'up_category');
    }

    /**
     * Alt kategoriler ilişkisi
     */
    public function subCategories()
    {
        return $this->hasMany(Category::class, 'up_category');
    }
}
