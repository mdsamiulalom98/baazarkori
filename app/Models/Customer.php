<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Customer extends Authenticatable
{
    use HasFactory;

    protected $guard = 'customer';
    protected $fillable = [
        'name', 'email', 'password',
    ];
    protected $hidden = [
      'password', 'remember_token',
    ];

    public function cust_area()
    {
        return $this->belongsTo(District::class,'area');
    }
    public function orders()
    {
        return $this->hasMany(Order::class,'customer_id');
    }
    public function deducts()
    {
        return $this->hasMany(Customerdeduct::class, 'customer_id');
    }
    public function addamount()
    {
        return $this->hasMany(Customeraddamount::class, 'customer_id');
    }
    
     public function wholesell()
    {
        return $this->hasOne(WholesellCustomer::class, 'customer_id')->latest();
    }
    public function withdraw_slip()
    {
        return $this->hasOne(WholesellCustomer::class, 'customer_id')->select('customer_id','sender_number','transaction','payment_method');
    }
}
