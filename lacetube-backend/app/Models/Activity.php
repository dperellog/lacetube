<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activity extends Model
{
    use HasFactory;
    protected $attributes = [

    ];

    protected $fillable = [
        'name',
        'description',
        'end_date',
        'course_id'
    ];

    /**
     * Relationship with its course.
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    /**
     * Relate with activity videos.
     */
    public function videos(): HasMany
    {
        return $this->hasMany(Video::class, 'activity_id');
    }

    /**
     * Relate with teacher user.
     */
    public function teacher()
    {
        return $this->course->teacher();
    }

    /**
     * Relate with students user.
     */
    public function students()
    {
        return $this->course->students();
    }

}
