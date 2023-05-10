@extends('mahasiswas.layouts')

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center align-items-center">
            <div style="text-align: center">
                <h2 style="margin-top: 20px; ">Jurusan Teknologi Informasi</h2>
                <h3 style="color:darkturquoise ">Kartu Hasil Studi (KHS)</h3>
            </div>
            <div class="card">
                <ul class="list-group list-group-flush"><br>
                    <center>
                        <img width="150px" src="{{ asset('storage/' . $Mahasiswa->featured_image) }}" alt="Foto"
                            style="border-top:3px; border: 4px solid #575D63;">
                    </center><br>
                    <li class="list-group-item"><b>Nama&emsp;: </b>{{ $Mahasiswa->Nama }}</li>
                    <li class="list-group-item"><b>Nim&ensp;&ensp;&ensp;&nbsp;: </b>{{ $Mahasiswa->Nim }}</li>
                    <li class="list-group-item"><b>Kelas&ensp;&ensp;&nbsp;: </b>{{ $Mahasiswa->kelas->nama_kelas }}</li>
                    <li class="list-group-item"><b>Jurusan&nbsp;: </b>{{ $Mahasiswa->Jurusan }}</li>
                </ul><br>
                <div>
                    <table class="table table-hover">
                        <tr>
                            <th>Mata Kuliah</th>
                            <th>SKS</th>
                            <th>Semester</th>
                            <th>Nilai</th>
                        </tr>
                        @foreach ($Mahasiswa_Matakuliah as $MhsMatkul)
                            <tr>
                                <td>{{ $MhsMatkul->matakuliah->nama_matkul }}</td>
                                <td>{{ $MhsMatkul->matakuliah->sks }}</td>
                                <td>{{ $MhsMatkul->matakuliah->semester }}</td>
                                <td>{{ $MhsMatkul->nilai }}</td>
                        @endforeach
                        </tr>
                    </table>

                    <a class="btn btn-secondary mt-3" href="{{ route('mahasiswas.index') }}">Kembali</a>
                    <a class="btn btn-success mt-3" href="{{ route('print_pdf', $Mahasiswa->Nim) }}">Cetak ke PDF</a>
                </div>
                <br>
            </div>
        </div>
    </div>
@endsection