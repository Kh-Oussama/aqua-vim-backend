<?php

namespace App\Models;

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
}
