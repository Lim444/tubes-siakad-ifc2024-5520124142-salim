<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Matakuliah extends Model
{
    protected $table = 'matakuliah';
    protected $primaryKey = 'kode_matakuliah';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['kode_matakuliah', 'nama_matakuliah', 'sks'];

    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class, 'kode_matakuliah', 'kode_matakuliah');
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'kode_matakuliah', 'kode_matakuliah');
    }

    public function getDosenPengajarAttribute(): string
    {
        $nama = $this->jadwal
            ->pluck('dosen.nama')
            ->filter()
            ->unique()
            ->implode(', ');

        return $nama !== '' ? $nama : '-';
    }
}