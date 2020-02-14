@extends('layouts.lte_tamu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <img src="{{ Storage::url('lkpp.png') }}" alt="lkpp" height="100">
            <div class="card">
                
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/cari">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a>
                        <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subjudul) }}
                    </h5>
                    <div class="card-tools"><a href="/" class="btn btn-xs btn-outline-info pb-0 pt-0 mt-0 mb-0">Kembali ke Halaman Utama</a></div>
                </div>

                <div class="card-body">
                    <div class="row">
                    
                        <div class="col-sm-12"> 
                            <div class="row">  
                                @php 
                                if(nikGender($profil->nik == 'pria')) 
                                $yth = "Bapak";
                                else
                                $yth = "Ibu";
                                @endphp

                                <div class="col-sm-8">Yth. {{ $yth }} <b>{{ kapital($profil->nama) }}</b>, <br>sebelum melanjutkan konsultasi sertifikasi, harap membuat nomor tiket terlebih dahulu dengan mengklik tombol hijau "Buat Tiket" disamping ini. Terima Kasih. </div>
                                <div class="col-sm-4">
                                    <form method="post" action="/tiket/store/{{ Crypt::encrypt($profil->id) }}" onSubmit="return confirm('Anda yakin akan melanjutkan ?')" >
                                    {{ csrf_field() }}
                                        <input type="text" name="nomor" class="form-control mb-2 mt-3" style="text-align: center;" value="{{ uniqid() }}" readonly>
                                        <input type="submit" class="btn btn-sm pt-2 pb-2 btn-block btn-success" value="BUAT TIKET">
                                    </form>
                                </div>
                                
                            </div>
                        </div>
                    
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6"><a href="/{{ $judul }}/cari" onclick="return confirm('Kembali ke halaman pencarian NIK, akan mengharuskan Anda untuk membuat PIN baru. Lanjutkan?')">Cari NIK</a></div>
                        <div class="col-sm-6"></div>
                    </div>
                </div>
             </div> <!-- end card -->
        </div>
    </div>
</div>
@endsection