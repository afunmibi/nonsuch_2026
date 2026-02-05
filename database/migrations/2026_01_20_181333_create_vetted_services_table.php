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
    Schema::create('vetted_services', function (Blueprint $table) {
    $table->id();
    $table->string('pa_code')->index();
    $table->string('service_name');
    $table->decimal('tariff', 15, 2)->default(0);
    $table->integer('qty')->default(1);
    $table->decimal('hcp_amount_due_total_services', 15, 2)->default(0);
    $table->decimal('hcp_amount_claimed_total_services', 15, 2)->default(0);
    $table->text('remarks')->nullable();
    $table->string('vetted_by')->nullable();
    $table->string('checked_by')->nullable();
    $table->timestamps();
// Indexing for performance on large datasets
           
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vetted_services');
    }
};
