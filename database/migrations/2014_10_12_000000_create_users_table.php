<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('firstname', 50)->nullable();
            $table->string('lastname', 50)->nullable();
            $table->string('username', 50)->unique()->nullable();
            $table->string('email', 100)->unique()->nullable();
            $table->string('mobile', 50)->unique()->nullable();
            $table->bigInteger('referred_by')->unsigned()->nullable();
            $table->decimal('downloads_earnings', 18, 9)->default(0);
            $table->decimal('referrals_earnings', 18, 9)->default(0);
            $table->text('address')->nullable();
            $table->string('avatar');
            $table->bigInteger('withdrawal_method_id')->unsigned()->nullable();
            $table->text('withdrawal_account')->nullable();
            $table->string('password')->nullable();
            $table->string('facebook_id')->unique()->nullable();
            $table->string('google_id')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->boolean('google2fa_status')->default(false)->comment('0: Disabled, 1: Active');
            $table->text('google2fa_secret')->nullable();
            $table->boolean('status')->default(true)->comment('0: Banned, 1: Active');
            $table->rememberToken();
            $table->boolean('is_viewed')->default(false);
            $table->foreign("referred_by")->references("id")->on('users')->onDelete('set null');
            $table->foreign("withdrawal_method_id")->references("id")->on('withdrawal_methods')->onDelete('set null');
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
        Schema::dropIfExists('users');
    }
}
