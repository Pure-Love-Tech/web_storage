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
        Schema::create('file_entries', function (Blueprint $table) {
            $table->bigIncrements('id')->startingValue(1000);
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('parent_id')->unsigned()->nullable();
            $table->bigInteger('storage_provider_id')->unsigned()->nullable();
            $table->string('ip')->nullable();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('filename');
            $table->string('mime', 100)->nullable();
            $table->bigInteger('size')->unsigned()->default(0);
            $table->string('extension', 10)->nullable();
            $table->enum('type', ['folder', 'file']);
            $table->string('password')->nullable();
            $table->text('path')->nullable();
            $table->text('path_ids')->nullable();
            $table->bigInteger('downloads')->unsigned()->default(0);
            $table->boolean('visibility')->default(true)->comment('0:private 1:public');
            $table->datetime('expiry_at')->nullable();
            $table->boolean('is_viewed')->default(false);
            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
            $table->foreign("parent_id")->references("id")->on('file_entries')->onDelete('cascade');
            $table->foreign("storage_provider_id")->references("id")->on('storage_providers')->onDelete('cascade');
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
        Schema::dropIfExists('file_entries');
    }
};