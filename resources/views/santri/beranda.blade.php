<div class="card">
  <div class="card-header">
    <h4>Ahlan wa sahlan</h4>
  </div>
  <div class="card-body">
    <p style="text-align: right">السَّلاَمُ عَلَيْكُمْ وَرَحْمَةُ اللهِ وَبَرَكَاتُهُ.</p>
    @if ($sudahDu == Null)
    <p>Alhamdulillah anda berhasil registrasi akun anda. Segala informasi mengenai Pondok Pesantren Madinatul Qur'an
      dapat anda akses di aplikasi ini, mulai dari pengumuman, kalender akademik, infomasi program dan masih banyak
      lagi.</p>
    <p>Sepertinya anda belum melengkapi data diri, silahkan lengkapi data anda untuk menyelesaikan presedur daftar
      ulang dengan menekan tombol dibawah.</p>
    <div class="text-center">
      <a href="/santri/data_isi" class="btn btn-lg btn-primary">Lengkapi data diri</a>
    </div>
    @else
    <p>Alhamdulilah, Anda telah melengkapi data diri anda.</p>
    @endif
  </div>
  {{-- <div class="card-footer bg-whitesmoke">
    This is card footer
  </div> --}}
</div>