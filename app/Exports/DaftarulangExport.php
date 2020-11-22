<?php

namespace App\Exports;

use App\Models\DaftarUlang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DaftarulangExport implements FromCollection, WithHeadings
{
  /**
   * @return \Illuminate\Support\Collection
   */
  public function collection()
  {
    return DaftarUlang::all()->map(function ($du) {
      return [
        'nama' => $du->nama,
        'prog_pendidikan_id' => $du->prog_pendidikan_id,
        'jenis_kelamin' => $du->jenis_kelamin,
        'tanggal_lahir' => $du->tanggal_lahir,
        'nama_ibu' => $du->nama_ibu,
        'tahun_ajaran' => $du->tahun_ajaran,
        'status' => $du->status,
      ];
    });
  }
  // nama	prog_pendidikan_id	jenis_kelamin	tanggal_lahir	nama_ibu	tahun_ajaran	status
  public function headings(): array
  {
    return [
      'Nama', 'Program', 'Jenis Kelamin', 'Tanggal Lahir', 'Nama Ibu', 'Tahun Masuk', 'Status',
    ];
  }
}
