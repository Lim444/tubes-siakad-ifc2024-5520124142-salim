<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Krs extends Model
{
    protected $table = 'krs';
    protected $fillable = ['npm', 'kode_matakuliah'];

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'npm', 'npm');
    }

    public function matakuliah(): BelongsTo
    {
        return $this->belongsTo(Matakuliah::class, 'kode_matakuliah', 'kode_matakuliah');
    }
}

