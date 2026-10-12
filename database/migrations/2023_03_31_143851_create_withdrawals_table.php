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
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->bigIncrements('id')->startingValue(1000);
            $table->bigInteger('user_id')->unsigned();
            $table->decimal('downloads_earnings', 18, 9);
            $table->decimal('referrals_earnings', 18, 9);
            $table->decimal('total', 18, 9);
            $table->string('method');
            $table->text('account');
            $table->tinyInteger('status')->default(1)->comment('1:Pending 2:Returned 3:Approved 4:Completed 5:Cancelled	');
            $table->boolean('is_viewed')->default(false);
            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('withdrawals');
    }
};
