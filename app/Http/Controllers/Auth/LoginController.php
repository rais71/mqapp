<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Santri;
use App\Models\DaftarUlang;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class LoginController extends Controller
{
  /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

  // use AuthenticatesUsers;

  /**
   * Where to redirect users after login.
   *
   * @var string
   */
  protected $redirectTo = RouteServiceProvider::HOME;

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    $this->middleware('guest')->except('logout');
  }

  public function login()
  {
    // $role = Role::create(['name' => 'super admin']);
    // $role = Role::create(['name' => 'wali santri']);
    // $permission = Permission::create(['name' => 'daftarulang edit']);
    // $permission = Permission::create(['name' => 'daftarulang hapus']);
    // $permission = Permission::create(['name' => 'santri lihat']);
    // $permission = Permission::create(['name' => 'santri tambah']);
    // $permission = Permission::create(['name' => 'santri edit']);
    // $permission = Permission::create(['name' => 'santri hapus']);

    // $permission = Permission::create(['name' => 'dashboard admin']);
    // $permission = Permission::create(['name' => 'dashboard santri']);

    // $permission = Permission::create(['name' => 'pengumuman lihat']);
    // $permission = Permission::create(['name' => 'pengumuman tambah']);
    // $permission = Permission::create(['name' => 'pengumuman edit']);
    // $permission = Permission::create(['name' => 'pengumuman hapus']);
    // $permission = Permission::create(['name' => 'pengumuman terbit']);

    // $permission = Permission::create(['name' => 'kalender lihat']);
    // $permission = Permission::create(['name' => 'kalender tambah']);
    // $permission = Permission::create(['name' => 'kalender edit']);
    // $permission = Permission::create(['name' => 'kalender hapus']);
    // $permission = Permission::create(['name' => 'kalender terbit']);

    // $permission = Permission::create(['name' => 'sendiri lihat']);
    // $permission = Permission::create(['name' => 'sendiri tambah']);
    // $permission = Permission::create(['name' => 'sendiri edit']);

    // $role = Role::findById(2);
    // $permissions = Permission::findMany([11, 12, 17, 22, 23, 24]);

    // $role->syncPermissions($permissions);

    // $role->revokePermissionTo($permission);

    // $user = User::find(2);

    // $user->can('beranda santri');

    // $user->assignRole('wali santri');

    // $user = new User();
    // $user->password = Hash::make('sapi123');
    // $user->email = 'rais.maraya@gmail.com';
    // $user->name = 'Muhammad Rais';
    // $user->save();
    // $user->assignRole('super admin');



    return view('auth.login');
  }

  public function process_login(Request $request)
  {
    $request->validate([
      'email' => 'required|email',
      'password' => 'required'
    ], [
      'required' => 'Kolom ini harus diisi.',
      'email' => 'Mohon isi dengan email yang benar.'
    ]);

    $credentials = $request->only('email', 'password');

    // $user = User::where('email', $request->email)->first();

    if (Auth::attempt($credentials)) {
      $userid = Auth::user();
      $sudahDu = Santri::where('user_id', $userid->id)->first();
      return view('beranda', compact('sudahDu'));
    } else {
      session()->flash('danger', 'Afwan, Email atau Password Salah.');
      return redirect()->back();
    }
  }

  public function register()
  {
    return view('auth.register');
  }

  public function simpanRegister(Request $request)
  {
    $request->validate([
      'nama-santri' => 'required',
      'email' => 'required|email|unique:users,email',
      'password' => 'required|string|min:6|regex:/[a-zA-Z]/|regex:/[0-9]/',
      'password2' => 'required|same:password',
      'tgl-lahir-santri' => 'date_format:d-m-Y|before:today',
      'nama-ibu' => 'required',
      'setuju' => 'accepted'
    ], [
      'required' => 'Kolom ini harus diisi.',
      'email' => 'Mohon isi dengan email yang benar.',
      'email.unique' => 'Mohon maaf email ini telah terpakai.',
      'tgl-lahir-santri.before' => 'Mohon isi tanggal lahir anda.',
      'tgl-lahir-santri.date_format' => 'Mohon isi dengan format HH-BB-TTTT, Contoh 30/07/1997.',
      'password2.same' => 'Password tidak sama dengan sebelumnya.',
      'password.min' => 'Password harus 6 karakter atau lebih.',
      'password.regex' => 'Dalam password harus terdapat angka dan huruf.',
      'setuju.accepted' => 'Harap menyetujui ini.',
    ]);

    $tglLahir = explode("-", $request->input('tgl-lahir-santri'));
    $tglLahirSql = $tglLahir[2] . "-" . $tglLahir[1] . "-" . $tglLahir[0];

    $verify = DaftarUlang::where('nama', $request->input('nama-santri'))
      ->where('nama_ibu', $request->input('nama-ibu'))
      ->where('tanggal_lahir', $tglLahirSql)
      ->first();

    if ($verify == NULL) {
      return Redirect::to('/register')
        ->with('danger-register', 'gagal')
        ->withInput($request->except('password', 'password2'));
    } else {
      $user = User::create([
        'name' => $request->input('nama-santri'),
        'email' => $request->input('email'),
        'password' => Hash::make($request->input('password')),
      ]);

      $verify->status = 2;
      $verify->user_id = $user->id;
      $verify->save();

      $user->assignRole('wali santri');

      return redirect()->route('login')->with('success-register', 'berhasil');
      // return Redirect::to('/admin/santri')->with('success-register', 'berhasil');
    }

    // $user = new User();
    // $user->nama = $request->input('nama-santri');

    // $user->save();

    // return Redirect::to('/admin/santri/du')->with('sukses', 'Data daftar ulang berhasil ditambahkan!');

    // session()->flash('message', 'Your account is created');

    // return redirect()->route('login');
  }

  public function logout()
  {
    \Auth::logout();

    return redirect()->route('login');
  }
}
