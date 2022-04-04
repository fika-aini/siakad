<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        $mahasiswa = DB::table('mahasiswa')->paginate(3);
        return view('welcome',compact('mahasiswa'));
    }
    public function cari(Request $request)
	{
		// menangkap data pencarian
		$cari = $request->cari;
 
    	// mengambil data dari table pegawai sesuai pencarian data
		$mahasiswa = DB::table('mahasiswa')
		->where('nama','like',"%".$cari."%")
		->paginate();
 
    	// mengirim data mahasiswa ke view index
		return view('welcome',['mahasiswa' => $mahasiswa]);
 
	}
}
