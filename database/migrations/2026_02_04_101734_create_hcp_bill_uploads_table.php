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
        Schema::create('hcp_bill_uploads', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Link to the user (hcp role)
            $table->string('hcp_name');
            $table->string('hcp_code')->nullable();
            $table->string('billing_month');
            $table->string('hmo_officer')->nullable();
            $table->decimal('amount_claimed', 15, 2);
            $table->string('file_path');
            $table->string('status')->default('Pending'); // Pending, Vetting, Paid, Rejected
            $table->text('remarks')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hcp_bill_uploads');
    }
};
