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
        Schema::table('hcp_bill_uploads', function (Blueprint $table) {
            $table->foreignId('hcp_id')->nullable()->constrained('hcp_hospitals')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('hcp_bill_uploads', function (Blueprint $table) {
            $table->dropForeign(['hcp_id']);
            $table->dropColumn('hcp_id');
        });
    }
};
