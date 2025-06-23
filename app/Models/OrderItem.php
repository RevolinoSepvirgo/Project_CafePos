<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $table = 'revo_order_items';
protected $fillable = ['order_id', 'menu_id', 'quantity', 'subtotal'];

public function order() {
    return $this->belongsTo(Order::class, 'order_id');
}

public function menu() {
    return $this->belongsTo(Menu::class, 'menu_id');
}
}
