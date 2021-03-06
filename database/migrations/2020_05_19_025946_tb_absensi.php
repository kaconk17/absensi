<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TbAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_absensi', function (Blueprint $table) {
            $table->uuid('id_absensi')->primary();
            $table->uuid('id_user');
            $table->foreign('id_user')->references('id')->on('users');
            $table->date('tanggal');
            $table->time('jam');
            $table->double('lat');
            $table->double('long');
            $table->decimal('jarak',8,2);
            $table->string('status',50);
            $table->string('keterangan',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_absensi');
    }
}
