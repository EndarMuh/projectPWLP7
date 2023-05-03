@extends('mahasiswas.layouts')

@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <br><br>
                <center>
                    <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2><br>  
                </center>
            </div>
            <div class="float-right my-2">
                
            </div>
            <form class="form-left my-4" method="get" action="{{ route('search') }}">
                <div class="form-group w-80 mb-3">
                    <input type="text" name="search" class="form-control w-50 d-inline" id="search" placeholder="Search">
                    <button type="submit" class="btn btn-primary mb-1">Cari</button>
                    <a class="btn btn-success right" href="{{ route('mahasiswas.create') }}" style="margin-left:9cm"> Input Mahasiswa</a>
                </div>
            </form>
        </div>
    </div>
    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif
    
    <table class="table table-bordered">
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>TTL</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No_Handphone</th>
            <th>Email</th>
            <th width="225px">Action</th>
        </tr>
        @foreach ($mahasiswas as $Mahasiswa)
        <tr>
            <td>{{ $Mahasiswa->Nim }}</td>
            <td>{{ $Mahasiswa->Nama }}</td>
            <td>{{ $Mahasiswa->Tanggal_Lahir }}</td>
            <td>{{ $Mahasiswa->Kelas->nama_kelas }}</td>
            <td>{{ $Mahasiswa->Jurusan }}</td>
            <td>{{ $Mahasiswa->No_Handphone }}</td>
            <td>{{ $Mahasiswa->Email }}</td>
            <td>
                <form action="{{ route('mahasiswas.destroy', $Mahasiswa->Nim) }}" method="POST">
                    <a class="btn btn-info" href="{{ route('mahasiswas.show', $Mahasiswa->Nim) }}">Show</a>
                    <a class="btn btn-primary" href="{{ route('mahasiswas.edit', $Mahasiswa->Nim) }}">Edit</a>
                    <a class="btn btn-warning" href="{{ route('khs', $Mahasiswa->Nim) }}">Nilai</a>
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    {!! $mahasiswas->withQueryString()->links('pagination::bootstrap-5') !!}
@endsection

{{-- @extends('mahasiswas.layouts')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left mt-2">
                <h2>JURUSAN TEKNOLOGI INFORMASI-POLITEKNIK NEGERI MALANG</h2>
            </div>
            <div class="float-right my-2">
                <a class="btn btn-success" href="{{ route('mahasiswas.create') }}"> Input Mahasiswa</a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif

    <table class="table table-bordered">
        <tr>
            <th>Nim</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Jurusan</th>
            <th>No_Handphone</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($mahasiswas as $Mahasiswa)
            <tr>

                <td>{{ $Mahasiswa->Nim }}</td>
                <td>{{ $Mahasiswa->Nama }}</td>
                <td>{{ $Mahasiswa->Kelas }}</td>
                <td>{{ $Mahasiswa->Jurusan }}</td>
                <td>{{ $Mahasiswa->No_Handphone }}</td>
                <td>
                    <form action="{{ route('mahasiswas.destroy', $Mahasiswa->Nim) }}" method="POST">

                        <a class="btn btn-info" href="{{ route('mahasiswas.show', $Mahasiswa->Nim) }}">Show</a>
                        <a class="btn btn-primary" href="{{ route('mahasiswas.edit', $Mahasiswa->Nim) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>
@endsection --}}
