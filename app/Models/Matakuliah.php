<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matakuliah extends Model
{
    use HasFactory;
    protected $table = 'matakuliah';
    protected $primaryKey = 'id'; //set primary key

    protected $fillable = [
        'id',
        'nama_matkul',
        'sks',
        'jam',
        'semester'
    ];

    public function mahasiswa_matakuliah()
    {
        return $this->belongsToMany(Mahasiswa::class, Mahasiswa_Matakuliah::class, 'matakuliah_id', 'mahasiswa_id')->withPivot('nilai');
    }
}
