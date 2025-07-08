<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Add the new column
            $table->string('mobile_no')->nullable()->after('id');
        });

        // Copy data from receipt_id to mobile_no
        DB::statement('UPDATE reports SET mobile_no = receipt_id');

        Schema::table('reports', function (Blueprint $table) {
            // Drop the old column
            $table->dropColumn('receipt_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            // Add back the old column
            $table->string('receipt_id')->nullable()->after('id');
        });

        // Copy data from mobile_no to receipt_id
        DB::statement('UPDATE reports SET receipt_id = mobile_no');

        Schema::table('reports', function (Blueprint $table) {
            // Drop the new column
            $table->dropColumn('mobile_no');
        });
    }
};