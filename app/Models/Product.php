<?php

namespace App\Models;

use Carbon\Carbon;
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
        'productsCategory_id',
        'pdf_path',
        'image_path',
    ];

    public function subcategory() {
        return $this->belongsTo('App\Models\ProductsSubcategory','productsSubcategory_id');
    }

    public function category() {
        return $this->belongsTo('App\Models\ProductsCategory','productsCategory_id');
    }

    public function mark() {
        return $this->belongsTo('App\Models\Mark','mark_id');
    }

    public function images() {
        return $this->hasMany('App\Models\ProductsImages','product_id');

    }

    public function getCreatedAtAttribute($created_at){
        return Carbon::parse($created_at)->diffForHumans();
    }

    public function getUpdatedAtAttribute($updated_at){
        return Carbon::parse($updated_at)->diffForHumans();
    }


}
