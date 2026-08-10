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
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id')->startingValue(1000);
            $table->bigInteger('user_id')->unsigned();
            $table->float('price', 10, 2);
            $table->unsignedBigInteger('interval');
            $table->bigInteger('payment_gateway_id')->unsigned()->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payer_id')->nullable();
            $table->string('payer_email')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0:Unpaid 1:Pending 2:Paid 3:Cancelled');
            $table->string('proof')->nullable();
            $table->boolean('is_viewed')->default(false);
            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
            $table->foreign("payment_gateway_id")->references("id")->on('payment_gateways')->onDelete('cascade');
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
        Schema::dropIfExists('transactions');
    }
};