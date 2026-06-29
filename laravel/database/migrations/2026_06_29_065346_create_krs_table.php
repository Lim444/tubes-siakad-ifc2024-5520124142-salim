<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('krs', function (Blueprint $table) {
            $table->id();
            $table->char('npm', 10);
            $table->foreign('npm')->references('npm')->on('mahasiswa')->onDelete('cascade');
            $table->char('kode_matakuliah', 8);
            $table->foreign('kode_matakuliah')->references('kode_matakuliah')->on('matakuliah')->onDelete('cascade');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('krs');
    }
};
