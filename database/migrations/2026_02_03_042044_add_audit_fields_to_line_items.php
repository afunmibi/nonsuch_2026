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
        Schema::table('vetted_services', function (Blueprint $table) {
            $table->string('re_checked_by')->nullable()->after('checked_by');
            $table->string('approved_by')->nullable()->after('re_checked_by');
            $table->string('paid_by')->nullable()->after('approved_by');
        });

        Schema::table('vetted_drugs', function (Blueprint $table) {
            $table->string('re_checked_by')->nullable()->after('checked_by');
            $table->string('approved_by')->nullable()->after('re_checked_by');
            $table->string('paid_by')->nullable()->after('approved_by');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vetted_services', function (Blueprint $table) {
            $table->dropColumn(['re_checked_by', 'approved_by', 'paid_by']);
        });

        Schema::table('vetted_drugs', function (Blueprint $table) {
            $table->dropColumn(['re_checked_by', 'approved_by', 'paid_by']);
        });
    }
};
