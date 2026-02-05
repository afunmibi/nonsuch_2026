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
        Schema::create('enrolments', function (Blueprint $table) {
            $table->id();
            $table->string('policy_no')->unique();
            $table->string('organization_name');
            $table->string('full_name');
            $table->string('phone_no');
            $table->string('email')->unique();
            $table->string('dob');
            $table->longText('address');
            $table->string('location');
            $table->string('photograph');
            $table->string('package_code');
            $table->longText('package_description');
            $table->decimal('package_price', 8, 2);
            $table->decimal('package_limit', 8, 2);
            $table->string('pry_hcp');
            
            $table->string('dependants_1_name')->nullable();
            $table->string('dependants_1_dob')->nullable();
            $table->string('dependants_1_photograph')->nullable();
            $table->string('dependants_1_status')->nullable();
            $table->string('dependants_2_name')->nullable();
            $table->string('dependants_2_dob')->nullable();
            $table->string('dependants_2_photograph')->nullable();
            $table->string('dependants_2_status')->nullable();
            $table->string('dependants_3_name')->nullable();
            $table->string('dependants_3_dob')->nullable();
            $table->string('dependants_3_photograph')->nullable();
            $table->string('dependants_3_status')->nullable();
            $table->string('dependants_4_name')->nullable();
            $table->string('dependants_4_dob')->nullable();
            $table->string('dependants_4_photograph')->nullable();
            $table->string('dependants_4_status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrolments');
    }
};
