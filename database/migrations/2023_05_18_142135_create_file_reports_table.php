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
        Schema::create('file_reports', function (Blueprint $table) {
            $table->bigIncrements('id')->startingValue(1000);
            $table->bigInteger('file_entry_id')->unsigned();
            $table->string('ip')->nullable();
            $table->string('name');
            $table->string('email');
            $table->integer('reason');
            $table->text('details');
            $table->boolean('is_viewed')->default(false);
            $table->foreign("file_entry_id")->references("id")->on('file_entries')->onDelete('cascade');
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
        Schema::dropIfExists('file_reports');
    }
};