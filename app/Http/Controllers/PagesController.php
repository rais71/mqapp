<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use Illuminate\Http\Request;

class PagesController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('auth');
  }

  public function lihatKaldik()
  {
    return view('kalender_akademik');
  }

  public function simpanKaldik(Request $request)
  {
    $request->validate([
      'nama-acara' => 'required',
      'tgl-mulai' => 'required|date_format:d-m-Y',
      'tgl-selesai' => 'after:tgl-mulai',
      'warna-bg' => 'required'
    ], [
      'required' => 'Kolom ini harus diisi.',
      'tgl-akhir.after' => 'Mohon pilih tanggal setelah Tanggal Mulai.',
      'date_format' => 'Mohon isi dengan format HH-BB-TTTT.',
    ]);

    // SIMPEN DATA ACARA ----------------------------------------------------------------
    $acara = new Acara();
    $acara->judul = $request->input('nama-acara');
    $acara->awal = $request->input('tgl-mulai');
    $acara->warna = $request->input('warna-bg');

    if ($request->has('tgl-selesai')) {
      $acara->akhir = $request->input('tgl-selesai');
    } else {
      $acara->akhir = NULL;
    }

    if ($request->has('ulangi-hari')) {
      $acara->ulang = date('w', strtotime($request->input('tgl-mulai')));
      $acara->akhir = NULL;
    } else {
      $acara->ulang = 7;
    }

    $acara->url = $request->input('url');

    $acara->save();

    return redirect('/kaldik')->with('success', 'Acara berhasil ditambahkan!');
  }

  public function dataKaldik()
  {
    $acara = Acara::all();
    $acara->makeHidden(['created_at', 'updated_at']);
    return response()->json($acara);
  }

  public function lihatPengumuman()
  {
    return view('pengumuman');
  }
}
