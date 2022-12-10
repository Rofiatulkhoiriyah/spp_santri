<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePrimaryKeyToDasborPengumumanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dasbor_pengumuman', function (Blueprint $table) {
            $table->dropPrimary('Tampilkan');
            $table->primary('Oid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dasbor_pengumuman', function (Blueprint $table) {
            $table->dropPrimary('Oid');
            $table->primary('Tampilkan');
        });
    }
}
