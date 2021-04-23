<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;
    protected $fillable= [
        'name',
        'state',
        'image_path',
        'category_id',
        'service_id',
    ];
    public function getCreatedAtAttribute($created_at){
        return Carbon::parse($created_at)->diffForHumans();
    }

    public function getUpdatedAtAttribute($updated_at){
        return Carbon::parse($updated_at)->diffForHumans();
    }

    public function service() {
        return $this->belongsTo('App\Models\Service');
    }

    public function category() {
        return $this->belongsTo('App\Models\Category');
    }
}
