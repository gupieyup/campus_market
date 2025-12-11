<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * Migration ini OPSIONAL - hanya jika Anda ingin menambahkan field
     * untuk menyimpan alasan penolakan dan informasi KTP
     */
    public function up(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            // Alasan penolakan jika ditolak
            if (!Schema::hasColumn('sellers', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('verification_status');
            }
            
            // NIK/Nomor KTP (opsional)
            if (!Schema::hasColumn('sellers', 'nik')) {
                $table->string('nik', 16)->nullable()->after('phone');
            }
            
            // File foto KTP (opsional)
            if (!Schema::hasColumn('sellers', 'ktp_image')) {
                $table->string('ktp_image')->nullable()->after('shop_image');
            }
            
            // Tanggal verifikasi
            if (!Schema::hasColumn('sellers', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('verification_status');
            }
            
            // User ID yang melakukan verifikasi (admin)
            if (!Schema::hasColumn('sellers', 'verified_by')) {
                $table->unsignedBigInteger('verified_by')->nullable()->after('verified_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sellers', function (Blueprint $table) {
            $columns = ['rejection_reason', 'nik', 'ktp_image', 'verified_at', 'verified_by'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('sellers', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};