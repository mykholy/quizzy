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
        Schema::create('stations', function (Blueprint $table) {
            $table->id('id');
            $table->text('name')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('cost')->nullable();
            $table->text('cost_description')->nullable();
            $table->text('manufacturer')->nullable();
            $table->text('model')->nullable();
            $table->string('pwps_version')->nullable();
            $table->boolean('qr_enabled')->default(0);
            $table->text('outlets')->nullable();
            $table->string('hours')->nullable();
            $table->text('pre_charge_instructions')->nullable();
            $table->string('available')->nullable();
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->on('locations')->references('id')->cascadeOnUpdate()->cascadeOnDelete();

            $table->unsignedBigInteger('plugshare_location_id')->nullable();
            $table->unsignedBigInteger('plugshare_station_id')->nullable();
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
        Schema::drop('stations');
    }
};
