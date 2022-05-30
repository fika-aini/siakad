<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Kelas;
use App\Models\Mahasiswa_Matakuliah;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Psy\TabCompletion\Matcher\FunctionsMatcher;
use PDF;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        /*$mahasiswa = $mahasiswa = DB::table('mahasiswa')->get(); // Mengambil semua isi tabel
        $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);
        return view('mahasiswa.index', compact('mahasiswa'))
            ->with('i', (request()->input('page', 1) - 1) * 5);*/
        $mahasiswa = Mahasiswa::with('kelas')->get();
        $paginate = Mahasiswa::orderBy('id_mahasiswa', 'asc')->paginate(3);
        //return view('mahasiswa.index',['mahasiswa' => $mahasiswa, 'paginate' => $paginate]);
        return view('mahasiswa.index',['mahasiswa' => $paginate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kelas = Kelas::all();
        return view('mahasiswa.create', ['kelas' => $kelas]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->file('foto')) {
            $image_name = $request->file('foto')->store('fotos', 'public');
        } else {
            $image_name = 'default.jpg';
        }
          //melakukan validasi data
          $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            
        ]);
              $mahasiswa = new Mahasiswa;
              $mahasiswa->nim = $request->get('Nim');
              $mahasiswa->nama = $request->get('Nama');
              $mahasiswa->jurusan = $request->get('Jurusan');
              $mahasiswa->kelas_id = $request->get('Kelas');
              $mahasiswa->foto = $image_name;
              $mahasiswa->save();

        //fungsi eloquent untuk menambah data
        //Mahasiswa::create($request->all());

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();
        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        //$Mahasiswa = Mahasiswa::find($Nim);
        //return view('mahasiswa.detail', compact('Mahasiswa'));
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        return view('mahasiswa.detail', ['Mahasiswa' => $Mahasiswa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($Nim)
    {
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        //$Mahasiswa = DB::table('mahasiswa')->where('nim', $Nim)->first();;
        //return view('mahasiswa.edit', compact('Mahasiswa'));
        $Mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        // $Mahasiswa = Mahasiswa::with('kelas')->find($Nim);
        $kelas = Kelas::all();
        return view('mahasiswa.edit', compact('Mahasiswa', 'kelas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
        ]);
        //fungsi eloquent untuk mengupdate data inputan kita
        $mahasiswa = Mahasiswa::with('kelas')->where('nim', $Nim)->first();
        if ($mahasiswa->foto && file_exists(storage_path('app/public/' . $mahasiswa->foto))) {
            Storage::delete('public/' . $mahasiswa->foto);  
        }
        $image_name = $request->file('foto')->store('fotos', 'public');
        $mahasiswa->nim = $request->get('Nim');
        $mahasiswa->nama = $request->get('Nama');
        $mahasiswa->kelas_id = $request->get('Kelas');
        $mahasiswa->jurusan = $request->get('Jurusan');
        $mahasiswa->foto = $image_name;
        $mahasiswa->save();
  

        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswa->kelas()->associate($kelas);
        $mahasiswa->save();

        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswa.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswa.index')
            -> with('success', 'Mahasiswa Berhasil Dihapus');
    }
    public function cari(Request $request){
        $cari = $request->cari;
        
        $mahasiswa = Mahasiswa::with('kelas')
        ->where('nama','like', "%" . $cari ."%")
        ->paginate(3);

        return view('mahasiswa.index',['mahasiswa'=>$mahasiswa]);
    }

    public function nilai($nim){
        $mhs = Mahasiswa_Matakuliah::with('matakuliah')->where('mahasiswa_id',$nim)->get();
        $mhs->mahasiswa = Mahasiswa::with('kelas')->where('Nim',$nim)->first();
        return view('mahasiswa.nilai', ['mhs' => $mhs]);
        // $matkul = Mahasiswa_Matakuliah::with('matakuliah')->where('mahasiswa_id',($mhs->id_mahasiswa))->get();
        // return view('mahasiswa.nilai',['mahasiswa' => $mhs, 'matakuliah' => $matkul]);
        
        // $Mahasiswa = Mahasiswa::with('kelas')->where('nim',$Nim)->first();
        // return view('mahasiswa.nilai', ['Mahasiswa' => $Mahasiswa]);
    }
    public function cetak($nim)
    {
        $mhs = Mahasiswa_Matakuliah::with('matakuliah')->where('mahasiswa_id',$nim)->get();
        $mhs->mahasiswa = Mahasiswa::with('kelas')->where('Nim',$nim)->first();
        $pdf = PDF::loadview('mahasiswa.cetak', ['mhs' => $mhs]);
        return $pdf->stream();
    }
}