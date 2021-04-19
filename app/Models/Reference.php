<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    protected $fillable= [
        'name',
        'category_id',
        'service_id',
    ];

    public function service() {
        return $this->belongsTo('App\Models\Service');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }

}
