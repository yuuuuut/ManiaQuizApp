<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visiter_id');
            $table->unsignedBigInteger('visited_id');
            $table->unsignedBigInteger('quiz_id')->nullable();
            $table->string('action');
            $table->boolean('checked')->default(false);
            $table->BigInteger('check_count')->default(0);
            $table->timestamps();

            $table->foreign('visiter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('visited_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('quiz_id')->references('id')->on('quizzes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
