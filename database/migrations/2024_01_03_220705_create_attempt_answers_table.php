<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttemptAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attempt_answers', function (Blueprint $table) {
            $table->id();


            $table->decimal('question_mark', 9, 2)->nullable();
            $table->decimal('achieved_mark', 9, 2)->nullable();
            $table->decimal('minus_mark', 9, 2)->nullable();

            $table->longText('given_answer')->nullable();
            $table->boolean('is_correct')->nullable();


            $table->unsignedBigInteger('exam_attempt_id');
            $table->foreign('exam_attempt_id')->references('id')->on('exam_attempts')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('question_id');
            $table->foreign('question_id')->references('id')->on('questions')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('exam_id');
            $table->foreign('exam_id')->references('id')->on('exams')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')
                ->on('students')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
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
        Schema::dropIfExists('attempt_answers');
    }
}
