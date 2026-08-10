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
        Schema::create('earning_statistics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('earning_statistic_id')->unsigned()->nullable();
            $table->string('ip')->nullable();
            $table->string('country')->nullable();
            $table->float('payout_rate')->nullable();
            $table->enum('earning_source', ['download', 'referral']);
            $table->decimal('earnings', 18, 9)->default(0);
            $table->bigInteger('referral_id')->unsigned()->nullable();
            $table->bigInteger('file_entry_id')->unsigned()->nullable();
            $table->longText('file_entry_details')->nullable();
            $table->string('referer_domain')->nullable();
            $table->text('referer_details')->nullable();
            $table->integer('downloads')->unsigned()->default(1);
            $table->boolean('status')->comment('0:Invalid 1:Valid');
            $table->string('status_reason')->nullable();
            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
            $table->foreign("earning_statistic_id")->references("id")->on('earning_statistics')->onDelete('cascade');
            $table->foreign("referral_id")->references("id")->on('referrals')->onDelete('cascade');
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
        Schema::dropIfExists('earning_statistics');
    }
};