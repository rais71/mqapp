<?php

namespace App\Providers;

use App\Models\Santri;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    //
  }

  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    view()->composer('*', function ($view) {
      $user = Auth::user();
      if (!empty($user)) {
        if (strlen($user->name) > 17) {
          $user->name = ucwords(strtolower(substr($user->name, 0, 17))) . "...";
        } else {
          $user->name = ucwords(strtolower($user->name));
        }
        $santri = Santri::where('user_id', $user->id)->first();
      }

      if (!empty($santri)) {
        if (strlen($santri->nama) > 17) {
          $santri->nama = ucwords(strtolower(substr($santri->nama, 0, 17))) . "...";
        } else {
          $santri->nama = ucwords(strtolower($santri->nama));
        }
      }

      if (!empty($user)) {
        if ($santri == Null) {
          $view->with('nama', $user->name);
        } else {
          $view->with('nama', $santri->nama);
        }
      }
    });
  }
}
