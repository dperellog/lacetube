<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class comentari extends Model
{
    use HasFactory;

    public function creatPer() {
        return $this->belongsTo('App\Models\User', 'creatPer');
    }

    public function video() {
        return $this->belongsTo('App\Models\video', 'video_id');
    }
    
}
