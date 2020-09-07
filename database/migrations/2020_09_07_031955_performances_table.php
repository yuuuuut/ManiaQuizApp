<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PerformancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('performances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->BigInteger('number_of_quizzes')->default(0);
            $table->BigInteger('number_of_answers')->default(0);
            $table->BigInteger('number_of_correct_answers')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('performances');
    }
}
