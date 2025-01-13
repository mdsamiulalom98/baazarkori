<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;
    protected $guarded = [];
     public function category()
    {
        return $this->hasOne(VideoCategory::class,'id','category_id')->select('id','name');
    }
}
