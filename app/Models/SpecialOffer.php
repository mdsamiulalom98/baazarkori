<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialOffer extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function product(){
        return $this->hasOne(Product::class, 'id','product_id')->select('id', 'name', 'slug', 'new_price','whole_sell_price', 'old_price','stock','sold');
    }
    // public function image(){
    //     return $this->hasOne(Product::class, 'id','product_id')->select('id', 'name', 'slug', 'new_price','whole_sell_price', 'old_price','stock','sold');
    // }
    // public function images(){
    //     return $this->hasMany(CampaignReview::class, 'campaign_id')->select('id','image','campaign_id');
    // }

}
