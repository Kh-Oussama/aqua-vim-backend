<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date',
    ];

    public function getCreatedAtAttribute($created_at){
        return Carbon::parse($created_at)->diffForHumans();
    }

    public function getUpdatedAtAttribute($updated_at){
        return Carbon::parse($updated_at)->diffForHumans();
    }
}
