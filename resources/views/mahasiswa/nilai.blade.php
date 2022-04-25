@extends('mahasiswa.layout')
 
@section('content')
    <div class="row"> 
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2 class="text-center mb-3">JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
                <h1 class="text-center mb-4">KARTU HASIL STUDI (KHS)</h1>

                <div class="text-left mt-4">
                    <p><b>Nama  : </b>{{ $mahasiswa->nama }}</p>
                    <p><b>Nim   : </b>{{ $mahasiswa->nim }}</p>
                    <p><b>Kelas : </b>{{ $mahasiswa->kelas->nama_kelas }}</p>
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
        @foreach ($matakuliah as $mk)
                <tr>
                    <td>
                        {{$mk->nama_matkul}}
                    </td>
                    <td>
                        {{$mk->sks}}
                    </td>
                    <td>
                        {{$mk->semester}}
                    </td>
                    <td>
                        {{$mk ->nilai}}
                    </td>
                </tr>
                @endforeach
    </table>
    <a class="btn btn-secondary" href="{{ route('mahasiswa.index') }}">Kembali</a>
@endsection 