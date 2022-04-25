<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa_Matakuliah extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa_matakuliah';
    protected $fillable = [
        'mahasiswa_id'
    ];
    
    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class,'mahasiswa_id','id_mahasiswa');
    }
    public function matakuliah(){
        return $this->belongsTo(Matakuliah::class,'id');
    }
}
