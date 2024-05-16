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
        Schema::create('counselings', function (Blueprint $table) {
            $table->id();
            $table->integer('counselor_id');
            $table->integer('client_id');
            $table->string('content');
            $table->integer('status');
            $table->timestamp('counseling_at');
            $table->string('counseling_url');
            $table->string('schedule_url');
            $table->timestamps();
            // Soft delete
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('counselings');
    }
};
