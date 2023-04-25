<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Course extends Model
{
    use HasFactory;

    //Default values for attributes:
    protected $attributes = [

    ];

    protected $fillable = [
        'teacher_id',
        'name',
        'description',
        'thumbnailURL',
        'year',
        'parent_id'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'parent_id')->withDefault();
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'course_user', 'course','user');
    }

    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class, 'course_id');
    }
}
