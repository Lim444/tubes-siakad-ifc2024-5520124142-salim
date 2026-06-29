<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dosen extends Model
{
    protected $table = 'dosen';
    protected $primaryKey = 'nidn';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nidn', 'nama'];

    public function mahasiswa(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'nidn', 'nidn');
    }

    public function jadwal(): HasMany
    {
        return $this->hasMany(Jadwal::class, 'nidn', 'nidn');
    }
}