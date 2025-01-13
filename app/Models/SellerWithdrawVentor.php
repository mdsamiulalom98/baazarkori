<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SellerWithdrawVentor extends Model
{
    use HasFactory;
     public function withdraw_details()
    {
        return $this->hasMany(SellerWithdrawDetails::class, 'withdraw_id');
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class,'seller_id')->select('id','name','phone', 'withdraw');
    }
}
