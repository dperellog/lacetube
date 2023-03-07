<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class curs extends Model
{
    use HasFactory;


    public function professor() {
        return $this->belongsTo('App\Models\usuari', 'profesor_id');
    }

    public function cursPare() {
        return $this->belongsTo('App\Models\curs', 'cursPare');
    }

    public function activitats() {
        return $this->hasMany('\App\Models\activitat');
    }

    public function alumnes() {
        $alumnes= DB::table('curs_usuari')->where('curs_id', $this->id);
    }
    
}
