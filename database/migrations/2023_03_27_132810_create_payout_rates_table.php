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
        Schema::create('payout_rates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('country_id')->unsigned()->unique()->nullable();
            $table->string('flag');
            $table->float('amount')->default(0);
            $table->foreign("country_id")->references("id")->on('countries')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('payout_rates');
    }
};