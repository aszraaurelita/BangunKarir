<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('photo')->nullable();
            $table->string('nim')->unique();
            $table->string('prodi');
            $table->integer('semester');
            $table->text('ringkasan_pribadi')->nullable();
            $table->string('kontak_email');
            $table->string('riwayat_prodi');
            $table->year('tahun_masuk');
            $table->decimal('ipk', 3, 2);
            $table->string('bidang_minat');
            $table->string('perusahaan_impian');
            $table->boolean('is_complete')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('profiles');
    }
};
