<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\Berkas;
use App\Models\DaftarUlang;
use App\Models\Negara;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Ortuwali;
use App\Models\Sekolah;
use PhpParser\Node\Stmt\If_;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;


class SantriController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    if (Auth::check()) {
      $negara2 = Negara::all();
      $provinsi2 = Provinsi::all();
      $user2 = Auth::user();

      // dd($auth2);
      return view('santri.data_isi', compact('negara2', 'provinsi2', 'user2'));
    } else {
      return Redirect::to('/login')->with('danger', 'Afwan, Sepertinya anda belum login. Silahkan login terlebih dahulu.');
    }
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function simpanSantri(Request $request)
  {
    $request->validate([
      'nama-santri' => 'required',
      'program' => 'required',
      'jenis-kelamin' => 'required',
      'provinsi-lahir' => 'required',
      'kabupaten-lahir' => 'required',
      'tgl-lahir-santri' => 'required|date_format:Y-m-d|before:today',
      'no-kontak-utama' => 'required',
      'nisn' => 'required|digits:10',
      'nik-santri' => 'required|digits:16',
      'provinsi-domisili' => 'required',
      'kabupaten-domisili' => 'required',
      'kecamatan-domisili' => 'required',
      'alamat-lengkap' => 'required',

      'pend-terakhir' => 'required',
      'provinsi-sekolah' => 'required',
      'kabupaten-sekolah' => 'required',
      'kecamatan-sekolah' => 'required',
      'tahun-lulus' => 'required',
      'tahun-masuk' => 'required',

      'nama-ayah' => 'required',
      'kontak-ayah' => 'required',
      'nama-ibu' => 'required',
      'kontak-ibu' => 'required',
      'wali' => 'required',
      'relasi-wali' => 'required_if:wali,3',
      'nama-wali' => 'required_if:wali,3',
      'kontak-wali' => 'required_if:wali,3',

      'berkas-foto' => 'required|mimes:jpeg,png,jpg|max:2048',
      'berkas-ijazah-depan' => 'required|mimes:jpeg,png,jpg|max:2048',
      'berkas-ijazah-belakang' => 'required|mimes:jpeg,png,jpg|max:2048',
      'berkas-akte' => 'required|mimes:jpeg,png,jpg|max:2048',
      'berkas-kk' => 'required|mimes:jpeg,png,jpg|max:2048',
      'berkas-skb' => 'required|mimes:jpeg,png,jpg|max:2048',
      'berkas-ket-sehat' => 'required|mimes:jpeg,png,jpg|max:2048'
    ], [
      'required' => 'Kolom ini harus diisi.',
      'required_if' => 'Kolom ini harus diisi.',
      'tgl-lahir-santri.before' => 'Mohon isi tanggal lahir anda.',
      'tgl-lahir-santri.date_format' => 'Mohon isi dengan format HH/BB/TTTT.',
      'nisn.digits' => 'NISN harus 10 digit angka.',
      'nik-santri.digits' => 'NIK harus 16 digit angka.',
      'size' => 'Ukuran maksimal file adalah 2 Mb.',
      'mimes' => 'Format file harus .jpg, .jpeg, atau .png.'

    ]);

    // SIMPEN DATA SANTRI ----------------------------------------------------------------
    $santri = new Santri;
    $santri->nama = $request->input('nama-santri');
    $santri->prog_pendidikan_id = (int)$request->input('program');
    $santri->jenis_kelamin = $request->input('jenis-kelamin');

    // $tglLahirSql = date('Y-m-d', strtotime($request->input('tgl-lahir-santri')));
    $santri->tanggal_lahir = $request->input('tgl-lahir-santri');

    $santri->kota_lahir_id = $request->input('kabupaten-lahir');
    $santri->kontak_utama = $request->input('no-kontak-utama');
    $santri->nisn = $request->input('nisn');
    $santri->nik = $request->input('nik-santri');
    $santri->kec_domisili_id = $request->input('kecamatan-domisili');
    $santri->alamat_domisili = $request->input('alamat-lengkap');
    $santri->tahun_masuk = $request->input('tahun-lulus');
    $santri->tahun_lulus = $request->input('tahun-masuk');
    $santri->status = 1;

    // GENERATE NIS -----------------------------------------------------------------------
    $t = $request->input('tahun-masuk');
    $taNis = substr($t, -2);
    $kodeProg = sprintf("%02d", (int)$request->input('program'));
    $preNis = $taNis . $kodeProg;

    if (Santri::where('nis', 'like', $preNis . "%")->exists()) {
      $nisBef = Santri::all()->last()->nis;
      $santri->nis = $nisBef + 1;
    } else {
      $santri->nis = $preNis . "00001";
    }

    // SIMPEN DATA SEKOLAH ----------------------------------------------------------------
    $sekolah = new Sekolah;
    $sekolah->nama = $request->input('pend-terakhir');
    $sekolah->kec_sekolah_id = $request->input('kecamatan-sekolah');
    $sekolah->alamat_sekolah = $request->input('alamat-lengkap-sekolah');

    // GET SIAPA WALINYA ----------------------------------------------------------------
    $waliSantri = $request->input('wali');

    // SIMPEN DATA AYAH ----------------------------------------------------------------
    $ayah = new Ortuwali;
    $ayah->nama = $request->input('nama-ayah');
    $ayah->kontak = $request->input('kontak-ayah');
    $ayah->relasi = "Ayah";
    $ayah->sebagai_wali = ($waliSantri == 1) ? true : false;
    $ayah->save();

    $santri->ayah_id = $ayah->id;

    // SIMPEN DATA IBU ----------------------------------------------------------------
    $ibu = new Ortuwali;
    $ibu->nama = $request->input('nama-ibu');
    $ibu->kontak = $request->input('kontak-ibu');
    $ibu->relasi = "Ibu";
    $ibu->sebagai_wali = ($waliSantri == 2) ? true : false;
    $ibu->save();

    $santri->ibu_id = $ibu->id;

    if ($waliSantri == 3) {
      $wali = new Ortuwali;
      $wali->nama = $request->input('nama-wali');
      $wali->kontak = $request->input('kontak-wali');
      $wali->sebagai_wali = true;
      $wali->save();

      $santri->wali_id = $wali->id;
    } elseif ($waliSantri == 2) {
      $santri->wali_id = $ibu->id;
    } else {
      $santri->wali_id = $ayah->id;
    }

    $sekolah->save();

    // UPLOAD FOTO  ----------------------------------------------------------------
    if ($request->has('berkas-foto')) {
      $namaFoto = $santri->nis . '01' . '.' . $request->file('berkas-foto')->extension();
      $request->file('berkas-foto')->move(public_path('uploads/berkas'), $namaFoto);
      $berkasFoto = new Berkas;
      $berkasFoto->path = $namaFoto;
      $berkasFoto->save();
    }

    // UPLOAD IJAZAH DEPAN  ----------------------------------------------------------------
    if ($request->has('berkas-ijazah-depan')) {
      $namaIjazahDepan = $santri->nis . '02' . '.' . $request->file('berkas-ijazah-depan')->extension();
      $request->file('berkas-ijazah-depan')->move(public_path('uploads/berkas'), $namaIjazahDepan);
      $berkasIjazahDepan = new Berkas;
      $berkasIjazahDepan->path = $namaIjazahDepan;
      $berkasIjazahDepan->save();
    }

    // UPLOAD IJAZAH BELAKANG  ----------------------------------------------------------------
    if ($request->has('berkas-ijazah-belakang')) {
      $namaIjazahBelakang = $santri->nis . '03' . '.' . $request->file('berkas-ijazah-belakang')->extension();
      $request->file('berkas-ijazah-belakang')->move(public_path('uploads/berkas'), $namaIjazahBelakang);
      $berkasIjazahBelakang = new Berkas;
      $berkasIjazahBelakang->path = $namaIjazahBelakang;
      $berkasIjazahBelakang->save();
    }

    // UPLOAD AKTE  ----------------------------------------------------------------
    if ($request->has('berkas-akte')) {
      $namaAkte = $santri->nis . '04' . '.' . $request->file('berkas-akte')->extension();
      $request->file('berkas-akte')->move(public_path('uploads/berkas'), $namaAkte);
      $berkasAkte = new Berkas;
      $berkasAkte->path = $namaAkte;
      $berkasAkte->save();
    }

    // UPLOAD KK  ----------------------------------------------------------------
    if ($request->has('berkas-kk')) {
      $namaKK = $santri->nis . '05' . '.' . $request->file('berkas-kk')->extension();
      $request->file('berkas-kk')->move(public_path('uploads/berkas'), $namaKK);
      $berkasKK = new Berkas;
      $berkasKK->path = $namaKK;
      $berkasKK->save();
    }

    // UPLOAD SKB  ----------------------------------------------------------------
    if ($request->has('berkas-skb')) {
      $namaSKB = $santri->nis . '06' . '.' . $request->file('berkas-skb')->extension();
      $request->file('berkas-skb')->move(public_path('uploads/berkas'), $namaSKB);
      $berkasSKB = new Berkas;
      $berkasSKB->path = $namaSKB;
      $berkasSKB->save();
    }

    // UPLOAD KETERANGAN SEHAT  ----------------------------------------------------------------
    if ($request->has('berkas-ket-sehat')) {
      $namaKetSehat = $santri->nis . '07' . '.' . $request->file('berkas-ket-sehat')->extension();
      $request->file('berkas-ket-sehat')->move(public_path('uploads/berkas'), $namaKetSehat);
      $berkasKetSehat = new Berkas;
      $berkasKetSehat->path = $namaKetSehat;
      $berkasKetSehat->save();
    }

    $santri->pend_terakhir_id = $sekolah->id;

    $santri->save();

    return Redirect::to('/admin/santri')->with('success', 'Data berhasil ditambahkan!');
    // dd($request->input());
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    //
  }
}
