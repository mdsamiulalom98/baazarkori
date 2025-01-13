<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boost extends Model
{
    use HasFactory;
    public function seller()
    {
        return $this->belongsTo(Seller::class, 'user_id')->where('user_type','seller'); 
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'user_id')->where('user_type','customer'); 
    }
}
