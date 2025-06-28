<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Hapus kolom fakultas jika ada
            if (Schema::hasColumn('profiles', 'fakultas')) {
                $table->dropColumn('fakultas');
            }
        });
    }

    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            // Tambahkan kembali kolom fakultas jika rollback
            $table->string('fakultas')->nullable()->after('prodi');
        });
    }
};
