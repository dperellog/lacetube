<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video_old extends Model
{
    use HasFactory;

      /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creatPer',
        'activitat_id',
        'titol',
        'descripcio',
        'media'
    ];

    public function creatPer() {
        return $this->belongsTo('App\Models\User', 'creatPer');
    }

    public function activitat() {
        return $this->belongsTo('App\Models\activitat', 'activitat_id');
    }

    public function Comentaris() {
        return $this->hasMany('\App\Models\Comentari');
    }
}
