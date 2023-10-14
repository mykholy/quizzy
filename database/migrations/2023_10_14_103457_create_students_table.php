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
        Schema::create('students', function (Blueprint $table) {
            $table->id('id');
            $table->string('name', 255);
            $table->string('email', 191)->unique()->index()->nullable();
            $table->string('phone', 191)->unique()->index()->nullable();
            $table->string('password')->nullable();
            $table->string('photo')->default('images/students/avatar.png');
            $table->text('provider_id')->nullable();
            $table->text('provider_type')->nullable();
            $table->text('device_token')->nullable();
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
        Schema::drop('students');
    }
};
