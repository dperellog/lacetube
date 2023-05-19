<?php

namespace App\Pivots;

use Illuminate\Database\Eloquent\Relations\Pivot;

/**
 * Model made to relate many-to-many user and courses.
 */
class CourseUser extends Pivot
{
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }

    public function activities(){
        return $this->hasMany(Action::class, 'course');
    }
}
