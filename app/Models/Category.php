<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Wajib ditambahkan agar Laravel tahu nama tabel yang dipakai
    protected $table = 'revo_categories';

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
