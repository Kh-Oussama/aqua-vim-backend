<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'description',
        'mark_id',
        'debit_max',
        'hmt_max',
        'power',
        'liquid_temperature',
        'engine_description',
        'pump_description',
        'voltage_description',
        'productsSubcategory_id',
        'pdf_path',
        'image_path',
    ];

        public function productSubcategory() {
        return $this->belongsTo('App\Models\ProductsSubcategory');
    }

    public function mark() {
        return $this->belongsTo('App\Models\Mark','mark_id');
    }

    public function images() {
        return $this->hasMany('App\Models\ProductsImages','product_id');

    }



}
