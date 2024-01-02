<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamAttemptsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exam_attempts', function (Blueprint $table) {
            $table->id();


            $table->integer('total_questions')->nullable();
            $table->integer('total_answered_questions')->nullable();
            $table->decimal('total_marks', 9, 2)->nullable();
            $table->decimal('earned_marks', 9, 2)->nullable();

            $table->text('attempt_info')->nullable();
            $table->string('attempt_status')->nullable();
            $table->string('attempt_ip')->nullable();
            $table->date('attempt_started_at')->nullable();
            $table->date('attempt_ended_at')->nullable();

            $table->boolean('is_manually_reviewed')->nullable();
            $table->date('manually_reviewed_at')->nullable();

            $table->unsignedBigInteger('exam_id');
            $table->foreign('exam_id')->references('id')->on('exams')->cascadeOnDelete()->cascadeOnUpdate();

            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')
                ->on('subjects')
                ->nullOnDelete();

            $table->unsignedBigInteger('book_id')->nullable();
            $table->foreign('book_id')->references('id')
                ->on('books')
                ->nullOnDelete();

            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')->references('id')->on('students')
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
        Schema::dropIfExists('exam_attempts');
    }
}
