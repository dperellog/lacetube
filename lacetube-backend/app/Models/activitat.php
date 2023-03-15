<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activitat extends Model
{
    use HasFactory;

          /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creatPer',
        'curs_id',
        'titol',
        'slug',
        'contingut',
        'dataFinal'
    ];

    public function Curs() {
        return $this->belongsTo('App\Models\Curs', 'curs_id');
    }

    public function creatPer() {
        return $this->belongsTo('App\Models\User', 'creatPer');
    }

    public function Videos() {
        return $this->hasMany('\App\Models\Video');
    }
}
