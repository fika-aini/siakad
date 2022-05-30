@extends('mahasiswa.layout')
 
@section('content')
    <div class="row"> 
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h5 class="text-center">JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h5>
                <h4 class="text-center">KARTU HASIL STUDI (KHS)</h4>
                
                <div class="text-left">
                    <p><b>Nama  : </b>{{ $mhs->mahasiswa->nama }}</p>
                    <p><b>Nim   : </b>{{ $mhs->mahasiswa->nim }}</p>
                    <p><b>Kelas : </b>{{ $mhs->mahasiswa->kelas->nama_kelas }}</p>
                </div>
            </div>
        </div>
    </div>
   
    <table class="table table-bordered">
            <tr>
                <th>Mata Kuliah</th>
                <th>SKS</th>
                <th>Semester</th>
                <th>Nilai</th>
            </tr>
            @foreach ($mhs as $mk)
                <tr>
                    <td>{{ $mk->matakuliah->nama_matkul }}</td>
                    <td>{{ $mk->matakuliah->sks }}</td>
                    <td>{{ $mk->matakuliah->semester }}</td>
                    <td>{{ $mk->nilai }}</td>
                </tr>
            @endforeach
        </table>
@endsection 