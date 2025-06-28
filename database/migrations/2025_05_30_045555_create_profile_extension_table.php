<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pengalaman Organisasi
        Schema::create('organizational_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_organisasi');
            $table->string('jabatan');
            $table->date('tanggal_masuk');
            $table->date('tanggal_selesai')->nullable();
            $table->text('deskripsi_kegiatan');
            $table->timestamps();
        });

        // Proyek Kuliah / Lomba
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_proyek');
            $table->text('deskripsi_proyek');
            $table->date('tanggal_pelaksanaan');
            $table->string('tautan')->nullable();
            $table->timestamps();
        });

        // Magang / Freelance
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_perusahaan');
            $table->string('posisi');
            $table->text('deskripsi_kerja');
            $table->string('lama_waktu');
            $table->timestamps();
        });

        // Skills
        Schema::create('user_skills', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_skill');
            $table->enum('tipe', ['soft_skill', 'hard_skill']);
            $table->timestamps();
        });

        // Sertifikat & Kursus
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_sertifikat');
            $table->string('penyelenggara');
            $table->year('tahun');
            $table->text('deskripsi')->nullable();
            $table->string('file_sertifikat')->nullable();
            $table->timestamps();
        });

        // Penghargaan / Pencapaian
        Schema::create('achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_penghargaan');
            $table->string('penyelenggara');
            $table->year('tahun');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });

        // Portofolio
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->enum('jenis', ['teks', 'gambar', 'video']);
            $table->text('deskripsi');
            $table->string('file_path')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('portfolios');
        Schema::dropIfExists('achievements');
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('user_skills');
        Schema::dropIfExists('work_experiences');
        Schema::dropIfExists('projects');
        Schema::dropIfExists('organizational_experiences');
    }
};
