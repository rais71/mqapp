<?php

namespace App\Imports;

use App\Models\DaftarUlang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithBatchInserts;

class DaftarulangImport implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts
{
  /**
   * @param array $row
   *
   * @return \Illuminate\Database\Eloquent\Model|null
   */
  public function model(array $row)
  {
    $program = $row['program'];
    if ($program == "SD") {
      $program = 1;
    } elseif ($program == "SMP") {
      $program = 2;
    } elseif ($program == "SMA") {
      $program = 3;
    } elseif ($program == "Pend. Tahfidz (B)") {
      $program = 4;
    } elseif ($program == "Pend. Tahfidz (M)") {
      $program = 5;
    } elseif ($program == "Mahad Aly") {
      $program = 6;
    } else {
      $program = '?';
    }

    $jk = $row['jenis_kelamin'];
    if ($jk == "Laki-laki") {
      $jk = 1;
    } elseif ($jk == "Perempuan") {
      $jk = 2;
    } else {
      $jk = '?';
    }

    return new DaftarUlang([
      'nama'                => $row['nama'],
      'prog_pendidikan_id'  => $program,
      'jenis_kelamin'       => $jk,
      'tanggal_lahir'       => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir'])->format('d/m/Y'),
      'nama_ibu'            => $row['nama_ibu'],
      'tahun_ajaran'        => strval($row['tahun_masuk']),
      'status'              => 1,
    ]);
  }

  public function rules(): array
  {
    return [
      '*.nama' => ['required'],
      '*.program' => ['required', 'regex:/^(SD|SMP|SMA|Pend.\sTahfidz\s\(B\)|Pend.\sTahfidz\s\(M\)|Mahad\sAly)$/'],
      '*.jenis_kelamin' => ['required', 'regex:/^(Laki-laki|Perempuan)$/'],
      '*.tanggal_lahir' => ['required'],
      '*.nama_ibu' => ['required'],
      '*.tahun_masuk' => ['required', 'digits:4'],
    ];
  }

  /**
   * @return array
   */
  public function customValidationMessages()
  {
    return [
      'nama.required' => 'Terdapat cell kosong pada "Nama".',
      'program.required' => 'Terdapat cell kosong pada "Program".',
      'jenis_kelamin.required' => 'Terdapat cell kosong pada "Jenis Kelamin".',
      'tanggal_lahir.required' => 'Terdapat cell kosong pada "Tanggal Lahir".',
      'nama_ibu.required' => 'Terdapat cell kosong pada "Nama Ibu".',
      'tahun_masuk.required' => 'Terdapat cell kosong pada "Tahun Masuk".',
      'program.regex' => 'Terdapat kesalahan pada "Program".',
      'jenis_kelamin.regex' => 'Terdapat kesalahan pada "Jenis Kelamin".',
      'tahun_masuk.digits' => 'Terdapat kesalahan pada "tahun_masuk".',
    ];
  }

  public function batchSize(): int
  {
    return 1000;
  }
}
