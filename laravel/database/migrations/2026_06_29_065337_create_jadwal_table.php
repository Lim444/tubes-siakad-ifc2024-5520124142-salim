<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jadwal', function (Blueprint $table) {
            $table->id();
            $table->char('kode_matakuliah', 8);
            $table->foreign('kode_matakuliah')->references('kode_matakuliah')->on('matakuliah')->onDelete('cascade');
            $table->char('nidn', 10);
            $table->foreign('nidn')->references('nidn')->on('dosen')->onDelete('cascade');
            $table->string('kelas', 10);
            $table->string('hari', 10);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('jadwal');
    }
};
