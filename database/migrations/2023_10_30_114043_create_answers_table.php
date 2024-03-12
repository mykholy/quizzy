<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('answers', function (Blueprint $table) {
            $table->id('id');
            $table->longText('title')->nullable();
            $table->string('question_type')->nullable();
            $table->longText('answer_two_gap_match')->nullable();
            $table->string('answer_view_format')->nullable();
            $table->integer('answer_order')->nullable();
            $table->text('answer_settings')->nullable();
            $table->unsignedBigInteger('question_id')->nullable();
            $table->foreign('question_id')
                ->references('id')
                ->on('questions')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->string('photo')->nullable();
            $table->boolean('is_correct')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('answers');
    }
};
