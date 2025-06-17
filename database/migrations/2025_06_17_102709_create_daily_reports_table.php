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
        Schema::create('daily_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained();
            $table->date('report_date');
            $table->time('check_in')->nullable();
            $table->time('check_out')->nullable();
            $table->text('activities');
            $table->text('obstacles')->nullable();
            $table->text('solutions')->nullable();
            $table->string('attachment')->nullable(); // Lampiran (gambar/dokumen)
            $table->decimal('latitude', 10, 7)->nullable(); // Untuk validasi lokasi
            $table->decimal('longitude', 10, 7)->nullable(); // Untuk validasi lokasi
            $table->boolean('is_approved')->default(false);
            $table->text('supervisor_comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_reports');
    }
};
