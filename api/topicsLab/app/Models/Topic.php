<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->withCount('likes');
    }

    public function topic_likes()
    {
        return $this->hasMany(TopicLike::class);
    }

    public static function scopeSimpleAllList($query)
    {
        return $query->select(['id', 'title', 'created_at', 'img']);
    }
}
