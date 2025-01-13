<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Seller extends Authenticatable
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [
      'password', 'remember_token',
    ];

    public function seller_area()
    {
        return $this->belongsTo(District::class,'area','id');
    }
    public function orders()
    {
        return $this->hasMany(OrderDetails::class, 'seller_id', 'id')->latest();
    }
    
    public function withdraws()
    {
        return $this->hasMany(SellerWithdraw::class, 'seller_id', 'id')->latest();
    }
    public function deducts()
    {
        return $this->hasMany(Sellerdeduct::class, 'seller_id');
    }
    public function addamount()
    {
        return $this->hasMany(Selleraddamount::class, 'seller_id');
    }
    public function products()
{
    return $this->hasMany(Product::class);
}
}
