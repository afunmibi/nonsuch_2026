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
        Schema::create('billvetting', function (Blueprint $table) {
            $table->id();
            $table->string('pa_code')->index()->nullable();
            $table->string('status')->default('staff_vetted');
            
            // Patient Information
            $table->string('full_name')->nullable();
            $table->string('policy_no')->nullable();
            $table->date('dob')->nullable();
            $table->string('phone_no')->nullable();
            
            // Package & HCP
            $table->string('package_code')->nullable();
            $table->decimal('package_price', 15, 2)->default(0);
            $table->decimal('package_limit', 15, 2)->default(0);
            $table->string('pry_hcp')->nullable();
            $table->string('pry_hcp_code')->nullable();
            $table->string('sec_hcp')->nullable();
            $table->string('sec_hcp_code')->nullable();
            
            // Medical
            $table->longText('diagnosis')->nullable();
            $table->longText('treatment_plan')->nullable();
            $table->longText('further_investigation')->nullable();
            
            // Billing Data
            $table->string('billing_month')->nullable();
            $table->integer('admission_days')->default(0);
            $table->date('admission_date')->nullable();
            $table->date('discharge_date')->nullable();
            
            // Financials
            $table->decimal('hcp_amount_due_grandtotal', 15, 2)->default(0);
            $table->decimal('hcp_amount_claimed_grandtotal', 15, 2)->default(0);
            
            // HCP Details (For CM Level)
            $table->string('sec_hcp_bank_name')->nullable();
            $table->string('sec_hcp_account_number')->nullable();
            $table->string('sec_hcp_account_name')->nullable();
            $table->string('sec_hcp_contact')->nullable();
            $table->string('sec_hcp_email')->nullable();

            // Audit & Workflow
            $table->string('pa_code_approved_by')->nullable();
            $table->string('vetted_by')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('re_checked_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->string('scheduled_for_payment_by')->nullable();
            $table->string('paid_by')->nullable();
            
            $table->foreignId('log_request_id')->nullable();

            // Audit Timestamps
            $table->timestamp('staff_vetted_at')->nullable();
            $table->timestamp('checked_at')->nullable();
            $table->timestamp('re_checked_at')->nullable();
            $table->timestamp('authorized_at')->nullable();
            $table->timestamp('cm_processed_at')->nullable();
            $table->timestamp('paid_at')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('billvetting');
    }
};
