<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    public function creatPer() {
        return $this->belongsTo('App\Models\User', 'creatPer');
    }

    public function activitat() {
        return $this->belongsTo('App\Models\activitat', 'activitat_id');
    }

    public function comentaris() {
        return $this->hasMany('\App\Models\comentari');
    }
}
