<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerProfit extends Model
{
    use HasFactory;
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id')->latest();
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'id')->select('id','name');
    }
}
