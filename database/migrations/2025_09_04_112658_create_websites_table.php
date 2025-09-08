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
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
              
              $table->string('url');
              $table->string('username')->nullable();
              $table->string('password')->nullable();
              $table->string('website_up_down')->nullable();
              $table->string('website_status')->nullable();
              $table->text('token_id')->nullable();
              $table->text('title')->nullable();
              $table->text('logo')->nullable();
              $table->json('data')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
