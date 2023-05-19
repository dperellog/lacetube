<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory;


    protected $dates = [
        'converted_for_downloading_at',
        'converted_for_streaming_at',
    ];

    protected $guarded = [];

    /**
     * Relate to activity.
     */
    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activity_id');
    }

    /**
     * Relate to all comments of the video.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'video_id');
    }

    /**
     * Relate to video owner user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the teacher of the task where video has been uploaded.
     */
    public function teacher()
    {
        return $this->activity->teacher();
    }
}
