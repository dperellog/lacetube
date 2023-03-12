<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activitat extends Model
{
    use HasFactory;

    public function curs() {
        return $this->belongsTo('App\Models\curs', 'curs_id');
    }

    public function creatPer() {
        return $this->belongsTo('App\Models\User', 'creatPer');
    }

    public function videos() {
        return $this->hasMany('\App\Models\video');
    }
}
