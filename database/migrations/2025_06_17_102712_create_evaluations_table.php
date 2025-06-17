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
        Schema::create('evaluations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('internship_id')->constrained();
            $table->foreignId('evaluator_id')->constrained('users'); // Bisa dosen atau pembimbing lapangan
            $table->enum('evaluator_type', ['supervisor', 'field_supervisor']);
            $table->decimal('discipline_score', 5, 2)->nullable(); // Kedisiplinan
            $table->decimal('teamwork_score', 5, 2)->nullable(); // Kerjasama
            $table->decimal('initiative_score', 5, 2)->nullable(); // Inisiatif
            $table->decimal('responsibility_score', 5, 2)->nullable(); // Tanggung jawab
            $table->decimal('problem_solving_score', 5, 2)->nullable(); // Pemecahan masalah
            $table->decimal('communication_score', 5, 2)->nullable(); // Komunikasi
            $table->decimal('technical_skill_score', 5, 2)->nullable(); // Keterampilan teknis
            $table->decimal('final_score', 5, 2)->nullable(); // Nilai akhir (calculated)
            $table->string('grade')->nullable(); // Nilai huruf (A, B, C, etc.)
            $table->text('comment')->nullable(); // Komentar evaluator
            $table->text('strength')->nullable(); // Kelebihan mahasiswa
            $table->text('weakness')->nullable(); // Kelemahan/area pengembangan
            $table->boolean('is_final')->default(false); // Apakah sudah final
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluations');
    }
};
