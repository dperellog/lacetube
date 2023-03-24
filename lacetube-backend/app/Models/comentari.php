<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentari extends Model
{
    use HasFactory;

          /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'creatPer',
        'valoracio',
        'video_id',
        'descripcio',
    ];

    public function creatPer() {
        return $this->belongsTo('App\Models\User', 'creatPer');
    }

    public function Video() {
        return $this->belongsTo('App\Models\Video', 'Video_id');
    }

}
