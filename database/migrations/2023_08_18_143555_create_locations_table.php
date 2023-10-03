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
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('description')->nullable();
            $table->longText('photos')->nullable();
            $table->string('score')->nullable();
            $table->boolean('cost')->default(0);
            $table->text('cost_description')->nullable();
            $table->integer('access')->nullable();
            $table->text('icon')->nullable();
            $table->string('icon_type')->nullable();
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->string('pwps_version')->nullable();
            $table->boolean('qr_enabled')->default(0);
            $table->string('poi_name')->nullable();
            $table->string('parking_type_name')->nullable();
            $table->string('locale')->nullable();
            $table->date('opening_date')->nullable();
            $table->string('hours')->nullable();
            $table->boolean('open247')->default(0);
            $table->boolean('coming_soon')->default(0);
            $table->boolean('under_repair')->default(0);
            $table->boolean('is_active')->default(1);
            $table->string('access_restrictions')->nullable();
            $table->string('parking_attributes')->nullable();
            $table->string('parking_level')->nullable();
            $table->string('overhead_clearance_meters')->nullable();
            $table->unsignedBigInteger('plugshare_location_id')->nullable();
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
        Schema::drop('locations');
    }
};
