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
        Schema::table('billvetting', function (Blueprint $table) {
            // Check if columns don't already exist before adding
            if (!Schema::hasColumn('billvetting', 'sec_hcp_bank_name')) {
                $table->string('sec_hcp_bank_name')->nullable()->after('sec_hcp_code');
            }
            if (!Schema::hasColumn('billvetting', 'sec_hcp_account_number')) {
                $table->string('sec_hcp_account_number')->nullable()->after('sec_hcp_bank_name');
            }
            if (!Schema::hasColumn('billvetting', 'sec_hcp_account_name')) {
                $table->string('sec_hcp_account_name')->nullable()->after('sec_hcp_account_number');
            }
            if (!Schema::hasColumn('billvetting', 'sec_hcp_contact')) {
                $table->string('sec_hcp_contact')->nullable()->after('sec_hcp_account_name');
            }
            if (!Schema::hasColumn('billvetting', 'sec_hcp_email')) {
                $table->string('sec_hcp_email')->nullable()->after('sec_hcp_contact');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('billvetting', function (Blueprint $table) {
            $table->dropColumn([
                'sec_hcp_bank_name',
                'sec_hcp_account_number',
                'sec_hcp_account_name',
                'sec_hcp_contact',
                'sec_hcp_email'
            ]);
        });
    }
};
