<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Berkas;
use App\Models\DaftarUlang;
use App\Models\Negara;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Ortuwali;
use App\Models\Santri;
use App\Models\Sekolah;
use Illuminate\Http\Request;

use App\Imports\DaftarulangImport;
use App\Exports\DaftarulangExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Stmt\If_;
use File;

class AdminController extends Controller
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

  public function semuaSantri()
  {
    $santri2 = Santri::all();
    return view('admin.santri_semua', compact('santri2'));
  }

  public function semuaDaftarUlang()
  {
    $du2 = DaftarUlang::all();
    return view('admin.daftar_ulang_semua', compact('du2'));
  }

  public function tambahDaftarUlang()
  {
    return view('admin.daftar_ulang_tambah');
  }

  public function hapusTerpilihDaftarUlang(Request $request)
  {
    // $ids = $request->ids;
    // DaftarUlang::whereIn('id', $ids)->delete();
    // return response()->json(['success' => 'Data telah dihapus!']);
    // dd($request->cbdu);

    $duid = $request->cbdu;
    if ($duid != Null) {
      foreach ($duid as $du) {
        DaftarUlang::where('id', $du)->delete();
      }
      return redirect('/admin/santri/du')->with('success', 'Data terpilih berhasi dihapus!');
    } else {
      return redirect('/admin/santri/du')->with('danger', 'Tidak ada data terpilih untuk dihapus!');
    }
  }

  public function importDaftarUlang(Request $request)
  {
    $request->validate([
      'import-daftarulang' => 'required|mimes:xls,xlsx|max:2048'
    ], [
      'required' => 'Kolom ini harus diisi.',
      'size' => 'Ukuran maksimal file adalah 2 Mb.',
      'mimes' => 'Format file harus .xls atau .xlsx.'
    ]);

    $file = $request->file('import-daftarulang');
    Excel::import(new DaftarulangImport, $file);

    $showErrorlist = true;

    return redirect('/admin/santri/du')
      ->with('success', 'Data berhasil di import!')
      ->with(compact('showErrorlist'));
  }

  public function importDownloadContoh()
  {
    $file = public_path() . "/downloads/contoh-imports.xlsx";
    return response()->download($file);
  }

  public function exportDaftarUlang()
  {
    return Excel::download(new DaftarulangExport, 'MQAPP - Daftar Ulang.xlsx');
  }

  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function tambahSantri()
  {
    $negara2 = Negara::all();
    $provinsi2 = Provinsi::all();

    return view('admin.santri_tambah', compact('negara2', 'provinsi2'));
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
      'tgl-lahir-santri' => 'required|date_format:d-m-Y|before:today',
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
      'tgl-lahir-santri.date_format' => 'Mohon isi dengan format HH-BB-TTTT.',
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

    // return view('admin.santri_tambah')->with('success', 'Data berhasil ditambahkan!');

    return Redirect::to('/admin/santri')->with('success', 'Data berhasil ditambahkan!');
    // dd($request->input());
  }

  public function simpanDaftarUlang(Request $request)
  {
    $request->validate([
      'nama-santri' => 'required',
      'program' => 'required',
      'jenis-kelamin' => 'required',
      'tgl-lahir-santri' => 'required|date_format:d-m-Y|before:today',
      'nama-ibu' => 'required',
      'tahun-ajaran' => 'required'
    ], [
      'required' => 'Kolom ini harus diisi.',
      'tgl-lahir-santri.before' => 'Mohon isi tanggal lahir anda.',
      'tgl-lahir-santri.date_format' => 'Mohon isi dengan format HH-BB-TTTT.',
    ]);

    // $tglLhr = explode("-", $request->input('tgl-lahir-santri'));
    // $tgl_lahir_reformat = $tglLhr[2] . "/" . $tglLhr[1] . "/" . $tglLhr[0];

    // SIMPEN DATA DAFTAR ULANG ----------------------------------------------------------------
    $daftarUlang = new DaftarUlang();
    $daftarUlang->nama = $request->input('nama-santri');
    $daftarUlang->prog_pendidikan_id = (int)$request->input('program');
    $daftarUlang->jenis_kelamin = $request->input('jenis-kelamin');
    $daftarUlang->tanggal_lahir = $request->input('tgl-lahir-santri');
    $daftarUlang->nama_ibu = $request->input('nama-ibu');
    $daftarUlang->tahun_ajaran = $request->input('tahun-ajaran');
    $daftarUlang->status = 1;

    $daftarUlang->save();

    return Redirect::to('/admin/santri/du')->with('success', 'Data daftar ulang berhasil ditambahkan!');
    // dd($request->input());
  }

  /**
   * Display the specified resources.
   *
   * @param  \App\Admin  $admin
   * @return \Illuminate\Http\Response
   */
  public function detailSantri($id)
  {
    $santri = Santri::findOrFail($id);
    $santri->provLahir = Provinsi::find(substr($santri->kota_lahir_id, 0, 2))->nama;
    $santri->kabLahir = Kabupaten::find($santri->kota_lahir_id)->nama;
    $santri->provDomisili = Provinsi::find(substr($santri->kec_domisili_id, 0, 2))->nama;
    $santri->kabDomisili = Kabupaten::find(substr($santri->kec_domisili_id, 0, 4))->nama;
    $santri->kecDomisili = Kecamatan::find($santri->kec_domisili_id)->nama;

    $sekolah = Sekolah::findOrFail($santri->pend_terakhir_id);
    $santri->namaPendTerakhir = $sekolah->nama;
    $santri->provPendTerakhir = Provinsi::find(substr($sekolah->kec_sekolah_id, 0, 2))->nama;
    $santri->kabPendTerakhir = Kabupaten::find(substr($sekolah->kec_sekolah_id, 0, 4))->nama;
    $santri->kecPendTerakhir = Kecamatan::find($sekolah->kec_sekolah_id)->nama;
    $santri->alamatPendTerakhir = ($sekolah->alamat_sekolah != "") ? $sekolah->alamat_sekolah : '-';

    $ayah = Ortuwali::findOrFail($santri->ayah_id);
    $santri->namaAyah = $ayah->nama;
    $santri->kontakAyah = $ayah->kontak;
    $santri->pekerjaanAyah = ($ayah->pekerjaan != "") ? $ayah->pekerjaan : '-';
    $santri->isWaliAyah = $ayah->sebagai_wali;

    $ibu = Ortuwali::findOrFail($santri->ibu_id);
    $santri->namaIbu = $ibu->nama;
    $santri->kontakIbu = $ibu->kontak;
    $santri->pekerjaanIbu = ($ibu->pekerjaan != "") ? $ibu->pekerjaan : '-';;
    $santri->isWaliIbu = $ibu->sebagai_wali;

    //Siapa Wali Santri -----------------
    if ($santri->isWaliAyah) {
      $santri->wali = "Ayah";
    } elseif ($santri->isWaliIbu) {
      $santri->wali = "Ibu";
    } else {
      $wali = Ortuwali::findOrFail($santri->wali_id);
      $santri->wali = $wali->relasi;
      $santri->namaWali = $wali->nama;
      $santri->kontakWali = $wali->kontak;
      $santri->pekerjaanWali = ($wali->pekerjaan != "") ? $wali->pekerjaan : '-';;
    }

    //Badge Status Santri -----------------
    if ($santri->status == "Aktif") {
      $santri->statusBadge = "badge-success";
    } elseif ($santri->status == "Sudah Lulus") {
      $santri->statusBadge = "badge-info";
    } elseif ($santri->status == "Keluar" || $santri->status == "Dikeluarkan") {
      $santri->statusBadge = "badge-danger";
    } else {
      $santri->statusBadge = "badge-secondary";
    }

    //Berkas Santri -----------------
    $namaBerkasFoto = $santri->nis . '01' . '.%';
    $berkasFoto = Berkas::where('path', 'like', $namaBerkasFoto)->first();
    $santri->berkasFoto = $berkasFoto->path;

    $namaBerkasIjazahDepan = $santri->nis . '02' . '.%';
    $berkasIjazahDepan = Berkas::where('path', 'like', $namaBerkasIjazahDepan)->first();
    $santri->berkasIjazahDepan = $berkasIjazahDepan->path;

    $namaBerkasIjazahBelakang = $santri->nis . '03' . '.%';
    $berkasIjazahBelakang = Berkas::where('path', 'like', $namaBerkasIjazahBelakang)->first();
    $santri->berkasIjazahBelakang = $berkasIjazahBelakang->path;

    $namaBerkasAkte = $santri->nis . '04' . '.%';
    $berkasAkte = Berkas::where('path', 'like', $namaBerkasAkte)->first();
    $santri->berkasAkte = $berkasAkte->path;

    $namaBerkasKK = $santri->nis . '05' . '.%';
    $berkasKK = Berkas::where('path', 'like', $namaBerkasKK)->first();
    $santri->berkasKK = $berkasKK->path;

    $namaBerkasSKB = $santri->nis . '06' . '.%';
    $berkasSKB = Berkas::where('path', 'like', $namaBerkasSKB)->first();
    $santri->berkasSKB = $berkasSKB->path;

    $namaBerkasSKS = $santri->nis . '07' . '.%';
    $berkasSKS = Berkas::where('path', 'like', $namaBerkasSKS)->first();
    $santri->berkasSKS = $berkasSKS->path;

    return view('admin.santri_detail', compact('santri'));
    // dd($kabLahir);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Admin  $admin
   * @return \Illuminate\Http\Response
   */
  public function edit(Admin $admin)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Admin  $admin
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Admin $admin)
  {
    //
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Admin  $admin
   * @return \Illuminate\Http\Response
   */
  public function hapusSantri($id)
  {
    $santri = Santri::findOrFail($id);

    $sekolah = Sekolah::findOrFail($santri->pend_terakhir_id);
    $ayah = Ortuwali::findOrFail($santri->ayah_id);
    $ibu = Ortuwali::findOrFail($santri->ibu_id);
    $wali = Ortuwali::findOrFail($santri->wali_id);

    for ($i = 1; $i <= 7; $i++) {
      $namaBerkasDB = $santri->nis . '0' . $i . '%';
      $berkas = Berkas::where('path', 'like', $namaBerkasDB)->first();

      if (File::exists(public_path('uploads/berkas/' . $berkas->path))) {
        File::delete(public_path('uploads/berkas/' . $berkas->path));
        $berkas->delete();
      }
    }

    $sekolah->delete();
    $ayah->delete();
    $ibu->delete();
    $wali->delete();
    $santri->delete();

    return Redirect::to('/admin/santri')->with('success', 'Data berhasil dihapus!');
  }

  /**
   * Handle pemilihan lokasi.
   */
  public function provinsi()
  {
    $provinsi = provinsi::all();
    return view('indonesia', compact('provinsi'));
  }

  public function kabupaten()
  {
    // $provinsi_id = Input::get('provinsi_id');
    $provinsi_id = Request('provinsi_id');
    $kabupaten = kabupaten::where('provinsi_id', '=', $provinsi_id)->get();
    return response()->json($kabupaten);
  }

  public function kecamatan()
  {
    $kabupaten_id = Request('kabupaten_id');
    $kecamatan = kecamatan::where('kabupaten_id', '=', $kabupaten_id)->get();
    return response()->json($kecamatan);
  }
}
