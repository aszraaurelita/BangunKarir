<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkExperiencesTable extends Migration
{
    public function up()
    {
        Schema::create('work_experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nama_perusahaan');
            $table->string('posisi');
            $table->text('deskripsi_kerja');
            $table->string('lama_waktu'); // contoh: "6 bulan"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('work_experiences');
    }
}
