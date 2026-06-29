<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Jadwal extends Model
{
    protected $table = 'jadwal';
    protected $fillable = ['kode_matakuliah', 'nidn', 'kelas', 'hari', 'jam_mulai', 'jam_selesai'];

    public function matakuliah(): BelongsTo
    {
        return $this->belongsTo(Matakuliah::class, 'kode_matakuliah', 'kode_matakuliah');
    }

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function getWaktuAttribute(): string
    {
        $mulai = $this->jam_mulai ? \Carbon\Carbon::parse($this->jam_mulai)->format('H:i') : '--:--';
        $selesai = $this->jam_selesai ? \Carbon\Carbon::parse($this->jam_selesai)->format('H:i') : '--:--';

        return $mulai . ' - ' . $selesai;
    }
}