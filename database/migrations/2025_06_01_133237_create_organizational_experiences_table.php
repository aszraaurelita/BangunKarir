<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrganizationalExperiencesTable extends Migration
{
    public function up()
    {
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
    }

    public function down()
    {
        Schema::dropIfExists('organizational_experiences');
    }
}
