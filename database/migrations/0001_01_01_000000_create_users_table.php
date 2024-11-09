<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('telephone')->unique();
            $table->string('password');
            $table->string('email')->unique();
            $table->string('cni')->unique();
            $table->date('date_naissance');
            $table->string('nom');
            $table->string('prenom');
            $table->string('qrcode')->nullable();
            $table->enum('statut_compte', ['actif', 'inactif'])->default('inactif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
