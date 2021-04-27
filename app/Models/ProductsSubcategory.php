<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductsSubcategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'productsCategory_id',
        'title',
        'image_path'
    ];

    public function productsCategory() {
        return $this->belongsTo('App\Models\ProductsCategory');
    }

    public function products() {
        return $this->hasMany('App\Models\Product','productsSubcategory_id');

    }

    public function getCreatedAtAttribute($created_at){
        return Carbon::parse($created_at)->diffForHumans();
    }

    public function getUpdatedAtAttribute($updated_at){
        return Carbon::parse($updated_at)->diffForHumans();
    }
}
