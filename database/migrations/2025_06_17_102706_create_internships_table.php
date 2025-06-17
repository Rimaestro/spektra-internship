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
        Schema::create('internships', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('users');
            $table->foreignId('company_id')->constrained();
            $table->foreignId('supervisor_id')->nullable()->constrained('users'); // Dosen pembimbing
            $table->foreignId('field_supervisor_id')->nullable()->constrained('users'); // Pembimbing lapangan
            $table->foreignId('coordinator_id')->nullable()->constrained('users'); // Koordinator PKL
            $table->date('start_date');
            $table->date('end_date');
            $table->string('position'); // Posisi/jabatan selama PKL
            $table->string('department'); // Departemen/divisi
            $table->enum('status', ['pending', 'approved', 'rejected', 'ongoing', 'completed', 'canceled'])->default('pending');
            $table->text('job_description')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->string('internship_letter')->nullable(); // Surat PKL
            $table->string('acceptance_letter')->nullable(); // Surat penerimaan dari perusahaan
            $table->string('completion_letter')->nullable(); // Surat keterangan selesai PKL
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('internships');
    }
};
