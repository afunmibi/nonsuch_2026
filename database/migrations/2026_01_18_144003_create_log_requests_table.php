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
        Schema::create('log_requests', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('policy_no');
            $table->string('phone_no');
            $table->string('package_code');
            $table->decimal('package_price', 8, 2);
            $table->decimal('package_limit', 8, 2);
            $table->string('package_description');
            $table->string('pry_hcp');
            $table->string('pry_hcp_code');
            $table->string('sec_hcp');
            $table->string('sec_hcp_code');
            $table->string('dob');
            $table->longText('diagnosis');
            $table->longText('treatment_plan');
            $table->longText('further_investigation');
            $table->string('pa_code')->nullable()->foreignkey();
            $table->string('pa_code_status')->nullable();
            $table->string('pa_code_rejection_reason')->nullable();
            $table->string('staff_id')->nullable();
            $table->string('pa_code_approved_by')->nullable();
            $table->string('vetted_by')->nullable();
            $table->string('checked_by')->nullable();
            $table->string('re_checked_by')->nullable();
            $table->string('approved_by')->nullable();
            $table->decimal('hcp_amount_claimed_grandtotal', 8, 2)->nullable();
            $table->decimal('hcp_amount_due_grandtotal', 8, 2)->nullable();
            $table->string('scheduled_for_payment_by')->nullable();
            $table->string('paid_by')->nullable();

            $table->timestamps();

            $table->index(['pa_code', 'pa_code_status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('log_requests');
    }
};
