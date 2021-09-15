<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopicLike extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function like_exist($user_id, $topic_id)
    {
        $exist = TopicLike::where('user_id', '=',  $user_id)->where('topic_id', '=', $topic_id)->first();

        if ($exist) {
            return true;
        } else {
            return false;
        }
    }
}
