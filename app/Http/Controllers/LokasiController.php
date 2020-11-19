<?php

namespace App\Http\Controllers;

use App\Models\Negara;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
  public function index()
  {
    $negara2 = Negara::get();
    return dd($negara2[1]);
  }

  public function provinsi()
  {
    $provinsi = provinsi::all();
    return view('indonesia', compact('provinsi'));
  }

  public function kabupaten()
  {
    $provinsi_id = Input::get('province_id');
    $kabupaten = kabupaten::where('province_id', '=', $provinsi_id)->get();
    return response()->json($kabupaten);
  }

  public function kecamatan()
  {
    $kabupaten_id = Input::get('kabupaten_id');
    $kecamatan = kecamatan::where('regency_id', '=', $kabupaten_id)->get();
    return response()->json($kecamatan);
  }
}
