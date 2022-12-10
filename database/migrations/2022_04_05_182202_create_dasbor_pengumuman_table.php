<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDasborPengumumanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dasbor_pengumuman', function (Blueprint $table) {
            $table->timestamp('CreatedAt')->nullable();
            $table->timestamp('UpdatedAt')->nullable();
            $table->timestamp('DeletedAt')->nullable();
            $table->char('Oid', 38);
            $table->string('Judul', 100)->nullable();
            $table->text('Deskripsi')->nullable();
            $table->boolean('Tampilkan')->default(false);

            $table->primary('Tampilkan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dasbor_pengumuman');
    }
}
