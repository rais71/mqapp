<?php

use Illuminate\Database\Seeder;
use App\Models\User;


class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    $roles = [
      [
        'id' => 1,
        'name' => "super admin",
        'guard_name' => "web",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ],
      [
        'id' => 2,
        'name' => "wali santri",
        'guard_name' => "web",
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s'),
      ]
    ];

    foreach ($roles as $role) {
      DB::table('roles')->insert($role);
    }

    $permissions = [
      ['id' => '2', 'name' => 'daftarulang lihat', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '3', 'name' => 'daftarulang tambah', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '4', 'name' => 'daftarulang edit', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '5', 'name' => 'daftarulang hapus', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '6', 'name' => 'santri lihat', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '7', 'name' => 'santri tambah', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '8', 'name' => 'santri edit', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '9', 'name' => 'santri hapus', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '10', 'name' => 'beranda admin', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '11', 'name' => 'beranda santri', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '12', 'name' => 'pengumuman lihat', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '13', 'name' => 'pengumuman tambah', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '14', 'name' => 'pengumuman edit', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '15', 'name' => 'pengumuman hapus', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '16', 'name' => 'pengumuman terbit', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '17', 'name' => 'kalender lihat', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '18', 'name' => 'kalender tambah', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '19', 'name' => 'kalender edit', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '20', 'name' => 'kalender hapus', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '21', 'name' => 'kalender terbit', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '22', 'name' => 'sendiri lihat', 'guard_name' => 'web', 'created_at' => date('Y-m-d H:i:s'), 'updated_at' => date('Y-m-d H:i:s')],
      ['id' => '23', 'name' => 'sendiri tambah', 'guard_name' => 'web', 'created_at' => '2020-11-19 09:03:05', 'updated_at' => '2020-11-19 09:03:05'],
      ['id' => '24', 'name' => 'sendiri edit', 'guard_name' => 'web', 'created_at' => '2020-11-19 09:03:05', 'updated_at' => '2020-11-19 09:03:05']
    ];

    foreach ($permissions as $permission) {
      DB::table('permissions')->insert($permission);
    }

    $role_has_permissions = [
      ['permission_id' => '2', 'role_id' => '1'],
      ['permission_id' => '3', 'role_id' => '1'],
      ['permission_id' => '4', 'role_id' => '1'],
      ['permission_id' => '5', 'role_id' => '1'],
      ['permission_id' => '6', 'role_id' => '1'],
      ['permission_id' => '7', 'role_id' => '1'],
      ['permission_id' => '8', 'role_id' => '1'],
      ['permission_id' => '9', 'role_id' => '1'],
      ['permission_id' => '10', 'role_id' => '1'],
      ['permission_id' => '11', 'role_id' => '2'],
      ['permission_id' => '12', 'role_id' => '1'],
      ['permission_id' => '12', 'role_id' => '2'],
      ['permission_id' => '13', 'role_id' => '1'],
      ['permission_id' => '14', 'role_id' => '1'],
      ['permission_id' => '15', 'role_id' => '1'],
      ['permission_id' => '16', 'role_id' => '1'],
      ['permission_id' => '17', 'role_id' => '1'],
      ['permission_id' => '17', 'role_id' => '2'],
      ['permission_id' => '18', 'role_id' => '1'],
      ['permission_id' => '19', 'role_id' => '1'],
      ['permission_id' => '20', 'role_id' => '1'],
      ['permission_id' => '21', 'role_id' => '1'],
      ['permission_id' => '22', 'role_id' => '2'],
      ['permission_id' => '23', 'role_id' => '2'],
      ['permission_id' => '24', 'role_id' => '2']
    ];
    foreach ($role_has_permissions as $role_has_permission) {
      DB::table('role_has_permissions')->insert($role_has_permission);
    }

    //   DB::table('users')->insert([
    //     'name' => 'Muhammmad Rais',
    //     'email' => 'rais.maraya@gmail.com',
    //     'password' => bcrypt('sapi123'),
    //   ]);

    //   DB::table('model_has_roles')->insert([
    //     'name' => 'User1',
    //     'email' => 'user1@email.com',
    //     'password' => bcrypt('password'),
    // ]);
  }
}
