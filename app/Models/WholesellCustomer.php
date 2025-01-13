<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WholesellCustomer extends Model
{
    use HasFactory;
    protected $guarded = [];
       public function customer() {
        return $this->hasOne(Customer::class, 'id', 'customer_id')->select('id', 'name', 'phone', 'seller_type');
    }
       public function package() {
        return $this->hasOne(RegistrationCharge::class, 'id', 'package_id')->select('id', 'title', 'days', 'charge');
    }
}
