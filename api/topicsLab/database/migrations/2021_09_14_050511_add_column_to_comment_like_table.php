<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToCommentLikeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('comment_likes', function (Blueprint $table) {
            $table->foreignId('comment_id')->constrained('comments');
            $table->foreignId('user_id')->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('comment_likes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropForeign(['topic_id']);
        });
    }
}
