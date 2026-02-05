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
        Schema::create('hcp_hospitals', function (Blueprint $table) {
            $table->id();
            $table->string('hcp_name');
            $table->string('hcp_code')->unique();
            $table->string('hcp_location');
            $table->string('hcp_contact');
            $table->string('hcp_email')->unique();
            $table->string('hcp_account_number')->unique();
            $table->string('hcp_account_name');
            $table->string('hcp_bank_name');
            $table->string('hcp_accreditation_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hcp_hospitals');
    }
};
