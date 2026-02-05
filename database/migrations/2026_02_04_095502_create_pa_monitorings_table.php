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
        Schema::create('pa_monitorings', function (Blueprint $table) {
            $table->id();
            $table->string('pa_code')->unique();
            $table->string('policy_no');
            $table->string('full_name');
            $table->string('phone_no')->nullable();
            $table->string('diagnosis')->nullable();
            $table->text('treatment_received')->nullable();
            $table->integer('days_spent')->default(0);
            $table->text('remarks')->nullable();
            $table->string('monitoring_status')->default('Admitted'); // Admitted, Discharged, Transferred
            $table->unsignedBigInteger('monitored_by')->nullable();
            $table->timestamps();
            
            $table->foreign('monitored_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pa_monitorings');
    }
};
