<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nik',50);
            $table->string('nama',50);
            $table->string('email',50)->unique();
            $table->string('alamat',100);
            $table->string('domisili',100)->nullable();
            $table->double('lat')->nullable();
            $table->double('long')->nullable();
            $table->string('kelamin',2);
            $table->string('no_telepon',20);
            $table->string('jabatan',50);
            $table->string('dept',50);
            $table->string('group',50);
            $table->string('section',50);
            $table->string('status_karyawan',50);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token',100)->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
