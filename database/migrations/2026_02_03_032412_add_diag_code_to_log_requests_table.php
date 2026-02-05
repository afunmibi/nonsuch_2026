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
        Schema::table('log_requests', function (Blueprint $table) {
            $table->string('diag_code')->nullable()->after('diagnosis');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_requests', function (Blueprint $table) {
            $table->dropColumn('diag_code');
        });
    }
};
