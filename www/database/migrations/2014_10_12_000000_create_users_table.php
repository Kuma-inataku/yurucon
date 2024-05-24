<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('status');
            $table->rememberToken();
            $table->timestamps();

            // todo: ZoomAPI検証用カラム。あとで削除
            $table->longText('zoom_code')->nullable()->default(null);
            $table->longText('access_token')->nullable()->default(null);
            $table->longText('refresh_token')->nullable()->default(null);
            $table->timestamp('zoom_expires_in', 0)->nullable()->default(null);
            // Soft delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
