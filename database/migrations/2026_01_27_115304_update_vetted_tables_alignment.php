<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Update Vetted Services
        Schema::table('vetted_services', function (Blueprint $table) {
            // Drop the old field that caused the 1364 error if it exists
            if (Schema::hasColumn('vetted_services', 'hcp_amount_due')) {
                $table->dropColumn('hcp_amount_due');
            }
            if (Schema::hasColumn('vetted_services', 'hcp_amount_claimed')) {
                $table->dropColumn('hcp_amount_claimed');
            }

            // Ensure vetted_by is nullable to prevent crashes
            $table->string('vetted_by')->nullable()->change();
            $table->longText('remarks')->nullable()->change();
        });

        // 2. Update Vetted Drugs
        Schema::table('vetted_drugs', function (Blueprint $table) {
            // Drop the old field if it exists
            if (Schema::hasColumn('vetted_drugs', 'hcp_amount_claimed')) {
                $table->dropColumn('hcp_amount_claimed');
            }

            // Ensure vetted_by is nullable
            $table->string('vetted_by')->nullable()->change();
            $table->longText('remarks')->nullable()->change();
        });
    }

    public function down(): void
    {
        // Logic to reverse changes if necessary
        Schema::table('vetted_services', function (Blueprint $table) {
            $table->decimal('hcp_amount_due', 15, 2)->after('qty');
        });
    }
};