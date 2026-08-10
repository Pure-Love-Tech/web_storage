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
        Schema::create('plans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('alias');
            $table->string('short_description')->nullable();
            $table->unsignedBigInteger('storage_space')->comment('Megabyte')->nullable();
            $table->unsignedBigInteger('max_file_size')->comment('Megabyte')->nullable();
            $table->unsignedBigInteger('file_expiry_days')->comment('Days')->nullable();
            $table->unsignedBigInteger('download_waiting_time')->comment('Seconds')->nullable();
            $table->boolean('advertisements')->comment('0:Hidden 1:Visible')->default(false);
            $table->boolean('download_captcha')->comment('0:Hidden 1:Visible')->default(false);
            $table->longText('plans')->nullable();
            $table->boolean('upload_status')->default(true);
            $table->integer('sort_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('plans');
    }
};