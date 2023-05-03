<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Mahasiswa;

class Matakuliah extends Model
{
    use HasFactory;
    protected $table = 'matakuliah';

    public function matakuliah() {
        return $this->belongsToMany(Mahasiswa_Matakuliah::class);
    }

    public function mahasiswas_matakuliah() {
        return $this->belongsToMany(Mahasiswa_Matakuliah::class);
    }
}
