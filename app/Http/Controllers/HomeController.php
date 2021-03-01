<?php

namespace App\Http\Controllers;

use App\Models\Acara;
use App\Models\DaftarUlang;
use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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

  /**
   * Show the application dashboard.
   *
   * @return \Illuminate\Contracts\Support\Renderable
   */
  public function index()
  {
    $userid = Auth::user();
    $sudahDu = Santri::where('user_id', $userid->id)->first();
    $hitungUser = User::all()->count();
    $hitungDaftarAkun = DaftarUlang::whereNotNull('user_id')->count();
    $hitungSemuaDaftarUlang = DaftarUlang::all()->count();
    $hitungSemuaSantri = Santri::all()->count();
    $hitungAcaraBulanIni = Acara::whereYear('awal', '=', date('Y'))
      ->whereMonth('awal', '=', date('m'))->count();
    return view('beranda')->with(compact('sudahDu', 'hitungUser', 'hitungSemuaDaftarUlang', 'hitungDaftarAkun', 'hitungSemuaSantri', 'hitungAcaraBulanIni'));
  }
}
