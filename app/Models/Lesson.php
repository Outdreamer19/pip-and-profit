<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video_url',
        'video_file',
        'video_filename',
        'video_mime_type',
        'video_size',
        'video_duration',
        'thumbnail',
        'order',
        'is_free',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'video_size' => 'integer',
    ];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the video URL (either uploaded file or external URL)
     */
    public function getVideoUrlAttribute($value)
    {
        if ($this->video_file) {
            return asset('storage/videos/' . $this->video_file);
        }
        
        return $value;
    }

    /**
     * Get the thumbnail URL
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/thumbnails/' . $this->thumbnail);
        }
        
        return null;
    }
}
