<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'price',
        'description',
        'image',
        'video_file',
        'video_filename',
        'video_mime_type',
        'video_size',
        'video_duration',
        'is_published',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_published' => 'boolean',
        'video_size' => 'integer',
    ];

    protected $appends = [
        'image_url',
        'video_url',
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
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
     * Get the image URL
     */
    public function getImageUrlAttribute($value)
    {
        if ($this->image) {
            return asset('storage/course-images/' . $this->image);
        }
        
        return $value;
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
