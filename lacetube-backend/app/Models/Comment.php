<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'video_id',
        'stars',
        'description',
        'user_id'
    ];

    /**
     * Relate with comment user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relationship with video where coment is.
     */
    public function video(): BelongsTo
    {
        return $this->belongsTo(Video::class, 'video_id');
    }

    /**
     * Get wether comment has been made by the task teacher or not. Returns boolean.
     */
    public function getisTeacherAttribute()
    {
        return $this->user->id == $this->video->teacher->id;
    }
}
