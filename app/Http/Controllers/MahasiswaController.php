<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Matakuliah;
use App\Models\Mahasiswa_Matakuliah;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MahasiswaController;
use Illuminate\Http\Request;
Route::resource('mahasiswa', MahasiswaController::class);
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //fungsi eloquent menampilkan data menggunakan pagination
        $mahasiswas = Mahasiswa::all(); // Mengambil 5 isi tabel
        // $posts = Mahasiswa::orderBy('Nim', 'desc')->paginate(6);
        return view('mahasiswas.index', compact('mahasiswas'));
        // ->with('i', (request()->input('page', 1) - 1) * 5);
    }
    public function create()
    {
        $kelas = Kelas::all(); //mendapatkan data dari tabel kelas
        return view('mahasiswas.create',['kelas' => $kelas]);
    }
    public function store(Request $request)
    {
        if ($request->file('image')) {
            $image_name = $request->file('image')->store('images', 'public');
        }
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Tanggal_Lahir' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
        ]);

        //fungsi eloquent untuk menambah data
        $mahasiswas = new Mahasiswa;
        $mahasiswas->Nim = $request->get('Nim');
        $mahasiswas->Nama = $request->get('Nama');
        $mahasiswas->featured_image = $image_name; //menambahkan foto
        $mahasiswas->Tanggal_Lahir = $request->get('Tanggal_Lahir');
        $mahasiswas->Jurusan = $request->get('Jurusan');
        $mahasiswas->No_Handphone = $request->get('No_Handphone');
        $mahasiswas->Email = $request->get('Email');

        // fungsi eloquent untuk menambah data dengan relasi belongs to
        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswas->kelas()->associate($kelas);
        $mahasiswas->save();

        //jika data berhasil ditambahkan, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Ditambahkan');
    }
    public function show($Nim)
    {
        //menampilkan detail data dengan menemukan/berdasarkan Nim Mahasiswa
        $Mahasiswa = Mahasiswa::find($Nim);
        return view('mahasiswas.detail', compact('Mahasiswa'));
    }
    public function edit($Nim)
    {   
        //menampilkan detail data dengan menemukan berdasarkan Nim Mahasiswa untuk diedit
        $Mahasiswa = Mahasiswa::find($Nim);
        $kelas = Kelas::all();
        return view('mahasiswas.edit', compact('Mahasiswa', 'kelas'));
    }
    public function update(Request $request, $Nim)
    {
        //melakukan validasi data
        $request->validate([
            'Nim' => 'required',
            'Nama' => 'required',
            'Tanggal_Lahir' => 'required',
            'Kelas' => 'required',
            'Jurusan' => 'required',
            'No_Handphone' => 'required',
            'Email' => 'required',
        ]);
        //fungsi eloquent untuk mengupdate data inputan kita
        $mahasiswas = Mahasiswa::find($Nim);


        if ($mahasiswas->featured_image && file_exists(storage_path('app/public/' . $mahasiswas->featured_image))) {
            Storage::delete('public/' . $mahasiswas->featured_image);
        }
        $image_name = $request->file('image')->store('images', 'public');

        $mahasiswas->Nim = $request->get('Nim');
        $mahasiswas->Nama = $request->get('Nama');
        $mahasiswas->featured_image = $image_name;
        $mahasiswas->Tanggal_Lahir = $request->get('Tanggal_Lahir');
        $mahasiswas->Jurusan = $request->get('Jurusan');
        $mahasiswas->No_Handphone = $request->get('No_Handphone');
        $mahasiswas->Email = $request->get('Email');


        $kelas = new Kelas;
        $kelas->id = $request->get('Kelas');

        $mahasiswas->kelas()->associate($kelas);
        $mahasiswas->save();
        //jika data berhasil diupdate, akan kembali ke halaman utama
        return redirect()->route('mahasiswas.index')
            ->with('success', 'Mahasiswa Berhasil Diupdate');
    }
    public function destroy($Nim)
    {
        //fungsi eloquent untuk menghapus data
        Mahasiswa::find($Nim)->delete();
        return redirect()->route('mahasiswas.index')->with('success', 'Mahasiswa Berhasil Dihapus');
    }

    public function search(Request $request)
    {
        $keyword = $request->search;
        $mahasiswas = Mahasiswa::where('Nama', 'like', '%' . $keyword . '%')->paginate(5);
        return view('mahasiswas.index', compact('mahasiswas'))->with('i', (request()->input('page', 1) - 1) * 5);
    }

    public function khs($Nim)
    {
        //$Mahasiswa = Mahasiswa::find($nim);
        $Mahasiswa = Mahasiswa::find($Nim);
        $Matakuliah = Matakuliah::all();
        //$MataKuliah = $Mahasiswa->MataKuliah()->get();
        $Mahasiswa_Matakuliah = Mahasiswa_Matakuliah::where('mahasiswa_id', '=', $Nim)->get();
        return view('mahasiswas.khs', ['Mahasiswa' => $Mahasiswa], ['Mahasiswa_Matakuliah' => $Mahasiswa_Matakuliah], ['Matakuliah' => $Matakuliah], compact('Mahasiswa_Matakuliah'));
    }

    public function print_pdf($Nim)
    {
        $Mahasiswa = Mahasiswa::find($Nim);
        $Matakuliah = Matakuliah::all();
        $Mahasiswa_Matakuliah = Mahasiswa_Matakuliah::where('mahasiswa_id', '=', $Nim)->get();
        $pdf = PDF::loadView('mahasiswas.khs_pdf', compact('Mahasiswa', 'Mahasiswa_Matakuliah'));
        return $pdf->stream();
        // return $pdf->download('KHS-' . $Mahasiswa->Nama . '.pdf');
    }
};