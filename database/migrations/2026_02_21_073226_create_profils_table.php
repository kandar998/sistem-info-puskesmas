<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('nama_puskesmas');
            $table->text('alamat');
            $table->string('telepon');
            $table->string('email');
            $table->text('deskripsi');
            $table->string('logo')->nullable();
            $table->string('foto_background')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
