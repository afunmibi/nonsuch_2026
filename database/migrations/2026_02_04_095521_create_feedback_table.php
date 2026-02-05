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
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('pa_code')->nullable();
            $table->string('policy_no');
            $table->enum('type', ['feedback', 'complaint', 'review'])->default('feedback');
            $table->integer('rating')->nullable(); // 1 to 5
            $table->text('comment');
            $table->unsignedBigInteger('user_id')->nullable(); // Who logged it
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};
