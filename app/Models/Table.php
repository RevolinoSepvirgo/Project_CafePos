<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    protected $table = 'revo_tables';
    protected $fillable = ['name', 'status', 'capacity'];

}
