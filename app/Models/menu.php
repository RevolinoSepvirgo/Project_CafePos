<?php

namespace App\Models;

use Database\Seeders\CategorySeeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class menu extends Model
{
     use HasFactory;

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
