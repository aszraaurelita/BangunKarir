<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeIsCompleteColumnTypeInProfilesTable extends Migration
{
    public function up()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->boolean('is_complete')->default(false)->change();
        });
    }

    public function down()
    {
        Schema::table('profiles', function (Blueprint $table) {
            $table->bigInteger('is_complete')->unsigned()->change();
        });
    }
}

