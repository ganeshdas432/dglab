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
        Schema::table('reports', function (Blueprint $table) {
            $table->string('receipt_id')->nullable()->after('id');
            $table->string('patient_name')->nullable()->after('receipt_id');
            $table->date('bill_date')->nullable()->after('patient_name');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn([
                'receipt_id',
                'patient_name',
                'bill_date',
                'file_name',
                'downloaded_at',
            ]);
        });
    }
};
