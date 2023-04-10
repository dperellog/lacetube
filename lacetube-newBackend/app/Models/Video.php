<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Video extends Model
{
    use HasFactory;

    public function activity(): BelongsTo
    {
        return $this->belongsTo(Activity::class, 'activitie');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'video');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }
}
