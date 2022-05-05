<?php

namespace App\Models;
use App\Models\Mahasiswa;
use App\Models\Matakuliah;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class Mahasiswa_Matakuliah extends Model
{
    use HasFactory;
    protected $table = 'mahasiswa_matakuliah';
    protected $primaryKey = 'id';
    
    public function matakuliah(){
        return $this->belongsTo(matakuliah::class);
    }
    public function mahasiswa(){
        return $this->belongsTo(Mahasiswa::class);
    }
    public function mahasiswa_matakuliah(){
        return $this->belongsToMany(Mahasiswa::class, Mahasiswa_Matakuliah::class, 'mahasiswa_id','matakuliah_id')->withPivot('nilai');
    }
}
