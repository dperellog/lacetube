<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Curs extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'profesor_id',
        'nom',
        'slug',
        'descripcio',
        'any',
        'cursPare'
    ];

    public function professor() {
        return $this->belongsTo('App\Models\User', 'profesor_id');
    }

    public function cursPare() {
        return $this->belongsTo('App\Models\Curs', 'cursPare');
    }

    public function activitats() {
        return $this->hasMany('\App\Models\activitat');
    }

    public function alumnes() {
        return DB::table('curs_usuari')->where('curs_id', $this->id)->get();
    }

}
