<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    public function Customers(){
        return $this->belongsTo(Customers::class);
    }

    public function order_details(){
        return $this->hasOne(OrderDetail::class);
    }
}
