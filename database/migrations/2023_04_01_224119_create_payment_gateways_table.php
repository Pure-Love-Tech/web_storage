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
        Schema::create('payment_gateways', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('alias');
            $table->string('logo');
            $table->text('handler');
            $table->longText('credentials')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_manual')->default(0);
            $table->longText('instructions')->nullable();
            $table->boolean('status')->default(0)->comment('0:Disabled 1:Active');
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
        Schema::dropIfExists('payment_gateways');
    }
};
