<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'revo_orders';
protected $fillable = ['table_id', 'user_id','customer_name' ,'status'];

public function items() {
    return $this->hasMany(OrderItem::class, 'order_id');
}

public function table() {
    return $this->belongsTo(Table::class, 'table_id');
}

public function user() {
    return $this->belongsTo(User::class, 'user_id');
}

public function payment()
{
    return $this->hasOne(Payment::class);
}
}
