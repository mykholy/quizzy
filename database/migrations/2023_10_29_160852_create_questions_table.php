<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('id');
            $table->text('name')->nullable();
            $table->string('type')->nullable();
            $table->string('level')->nullable();
            $table->text('description')->nullable();
            $table->string('photo')->nullable();
            $table->string('file')->nullable();
            $table->decimal('points')->unsigned()->default(0);
            $table->string('time')->nullable();
            $table->boolean('is_active')->default(true);

            $table->unsignedBigInteger('lesson_id')->nullable();
            $table->foreign('lesson_id')->references('id')
                ->on('lessons')
                ->nullOnDelete();



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
        Schema::drop('questions');
    }
};
