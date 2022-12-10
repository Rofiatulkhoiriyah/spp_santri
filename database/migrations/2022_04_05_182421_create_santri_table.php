<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSantriTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('santri', function (Blueprint $table) {
            $table->timestamp('CreatedAt')->nullable();
            $table->timestamp('UpdatedAt')->nullable();
            $table->timestamp('DeletedAt')->nullable();
            $table->char('Oid', 38);
            $table->char('Pengguna', 38);
            $table->boolean('Aktif')->default(true);
            $table->string('Nama', 100);
            $table->string('NIK', 20)->nullable();
            $table->string('NIS', 50)->nullable();
            $table->date('TglLahir')->nullable();
            $table->string('JenisKelamin', 50)->nullable();
            $table->string('Agama', 50)->nullable();
            $table->string('Hobi', 255)->nullable();
            $table->string('CitaCita', 255)->nullable();
            $table->string('NoHp', 15)->nullable();
            $table->date('TglMasuk');

            $table->primary('Oid');
            $table->foreign('Pengguna')->references('Oid')->on('pengguna')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('santri');
    }
}
