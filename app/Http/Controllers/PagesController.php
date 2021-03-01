<?php

namespace App\Http\Controllers;


use App\Models\Acara;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
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
    return view('informasi.kalender_akademik');
  }

  public function simpanKaldik(Request $request)
  {
    $request->validate([
      'nama-acara' => 'required',
      'tgl-mulai' => 'required|date_format:d-m-Y',
      'deskripsi' => 'max:500|nullable',
      'tgl-selesai' => 'nullable|after:tgl-mulai',
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
    $acara->deskripsi = $request->input('deskripsi');

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

  public function hapusAcara($id)
  {
    $acara = Acara::findOrFail($id);
    $acara->delete();
    return redirect('/kaldik')->with('success', 'Acara berhasil dihapus!');
  }

  public function lihatPengumuman()
  {
    return view('informasi.pengumuman');
  }

  public function simpanPengumuman(Request $request)
  {
    $request->validate([
      'judul-pengumuman' => 'required',
      'deskripsi' => 'max:500|required',
    ], [
      'required' => 'Kolom ini harus diisi.',
    ]);

    // SIMPEN DATA ACARA ----------------------------------------------------------------
    $pengumuman = new Acara();
    $pengumuman->judul = $request->input('judul-pengumuman');
    $pengumuman->deskripsi = $request->input('deskripsi');

    $users = User::all();
    Notification::send($users, new \App\Notifications\Pengumuman($pengumuman));

    return redirect('/pengumuman')->with('success', 'Pengumuman berhasil ditambahkan!');
  }

  public function dibacaSemuaPengumuman()
  {
    $id = auth()->user()->id;
    $user = User::find($id);

    foreach ($user->unreadNotifications as $notification) {
      $notification->markAsRead();
    }

    return redirect('/pengumuman')->with('success', 'Semua pengumuman telah ditandai dibaca.');
  }

  public function dibacaPengumuman(Request $request)
  {
    $id = auth()->user()->id;
    $user = User::find($id);

    $user->notifications->where('id', $request->input('id-pengumuman'))->markAsRead();

    return redirect('/pengumuman');
  }
}
