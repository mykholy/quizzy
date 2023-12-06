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
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('type')->nullable();
            $table->text('question_types')->nullable();
            $table->string('level')->nullable();
            $table->string('type_assessment')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->default('images/exams/avatar.png');
            $table->string('semester')->nullable();
            $table->decimal('points', 8, 2)->unsigned()->nullable();
            $table->string('time')->nullable();

            $table->unsignedBigInteger('subject_id')->nullable();
            $table->foreign('subject_id')->references('id')
                ->on('subjects')
                ->nullOnDelete();

            $table->unsignedBigInteger('book_id')->nullable();
            $table->foreign('book_id')->references('id')
                ->on('books')
                ->nullOnDelete();

            $table->unsignedBigInteger('unit_id')->nullable();
            $table->foreign('unit_id')->references('id')
                ->on('units')
                ->nullOnDelete();

            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->foreign('lesson_id')->references('id')
                ->on('lessons')
                ->nullOnDelete();

            $table->boolean('is_active')->default(true);
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
        Schema::drop('exams');
    }
};
