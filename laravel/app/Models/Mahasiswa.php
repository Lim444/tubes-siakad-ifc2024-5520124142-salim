<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mahasiswa extends Model
{
    protected $table = 'mahasiswa';
    protected $primaryKey = 'npm';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['npm', 'nidn', 'nama'];

    public function dosen(): BelongsTo
    {
        return $this->belongsTo(Dosen::class, 'nidn', 'nidn');
    }

    public function krs(): HasMany
    {
        return $this->hasMany(Krs::class, 'npm', 'npm');
    }
}