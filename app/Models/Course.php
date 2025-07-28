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
        'is_published',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_published' => 'boolean',
    ];

    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
