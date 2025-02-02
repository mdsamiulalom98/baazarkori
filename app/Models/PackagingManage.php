<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackagingManage extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function category()
    {
        return $this->hasOne(PackagingCategory::class,'id','category_id')->select('id','name');
    }
}
