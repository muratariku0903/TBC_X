<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnToTopicLikeTable extends Migration
{
    public function up()
    {
        Schema::table('topic_likes', function (Blueprint $table) {
            $table->foreignId('topic_id')->constrained('topics');
            $table->foreignId('user_id')->constrained('users');
        });
    }

    public function down()
    {
        Schema::table('topic_likes', function (Blueprint $table) {
            $table->dropColumn('topic_id');
            $table->dropColumn('user_id');
        });
    }
}
