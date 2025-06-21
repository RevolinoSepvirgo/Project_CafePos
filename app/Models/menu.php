<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model // ← Huruf M harus kapital
{
    use HasFactory;

    // Tambahkan ini untuk menghubungkan ke tabel yang di-rename
    protected $table = 'revo_menus';

    protected $fillable = [
        'name',
        'category_id',
        'price',
        'image',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
