<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagihanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->timestamp('CreatedAt')->nullable();
            $table->timestamp('UpdatedAt')->nullable();
            $table->timestamp('DeletedAt')->nullable();
            $table->char('Oid', 38);
            $table->char('Santri', 38);
            $table->date('Periode');
            $table->date('TglBayar')->nullable();
            $table->decimal('Jumlah', 16, 2);
            $table->string('Jenis', 100);
            $table->enum('Status', ['Lunas', 'Belum Lunas']);

            $table->primary('Oid');
            $table->foreign('Santri')->references('Oid')->on('santri')->onDelete('RESTRICT')->onUpdate('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagihan');
    }
}
