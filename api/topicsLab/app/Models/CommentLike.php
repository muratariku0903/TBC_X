<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentLike extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comment()
    {
        return $this->belongsTo(Comment::class);
    }

    public function like_exist($user_id, $comment_id)
    {
        $exist = CommentLike::where('user_id', '=',  $user_id)->where('comment_id', '=', $comment_id)->first();

        if ($exist) {
            return true;
        } else {
            return false;
        }
    }
}
