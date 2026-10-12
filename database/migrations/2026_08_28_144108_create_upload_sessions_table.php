<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('upload_sessions', function (Blueprint $table) {
            $table->id();

            $table->uuid('token')->unique();

            $table->unsignedBigInteger('user_id')->nullable()->index();
            $table->unsignedBigInteger('storage_provider_id')->index();
            $table->unsignedBigInteger('file_entry_id')->nullable()->index();

            $table->text('r2_upload_id');
            $table->string('object_key', 1024);

            $table->string('filename');
            $table->string('original_name');

            $table->string('name');
            $table->string('mime')->nullable();
            $table->string('extension')->nullable();

            $table->unsignedBigInteger('size');

            $table->unsignedBigInteger('part_size');
            $table->unsignedInteger('total_parts');

            $table->unsignedBigInteger('parent_id')->nullable();

            $table->boolean('visibility')->default(true);
            $table->string('password')->nullable();
            $table->text('description')->nullable();

            $table->string('ip', 45)->nullable()->index();

            $table->string('status', 30)->default('initiated')->index();

            $table->text('error')->nullable();

            $table->timestamp('expires_at')->nullable()->index();
            $table->timestamp('completed_at')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('upload_sessions');
    }
};
