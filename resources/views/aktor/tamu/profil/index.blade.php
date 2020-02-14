@extends('layouts.lte_tamu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <img src="{{ Storage::url('lkpp.png') }}" alt="lkpp" height="100">
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="card-title m-0"><a href="{{ $link }}">
                            <a href="#">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a>
                        </h5>
                        <div class="card-tools"><a href="/" class="btn btn-xs btn-outline-info pb-0 pt-0 mt-0 mb-0">Kembali ke Halaman Utama</a></div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-2">
                            <div class="col-sm-5"></div>
                            <div class="col-sm-7"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="text-align: center;">NO</th>
                                            <th width="15%" style="text-align: center;">NIK</th>
                                            <th width="15%" style="text-align: center;">NIP</th>
                                            <th style="text-align: center;">Nama</th>
                                            <th width="15%" style="text-align: center;">Email</th>
                                            <th width="15%" style="text-align: center;">HP</th>
                                            <th width="15%" style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = ($profil->currentPage() - 1) * $profil->perPage() + 1;
                                        @endphp

                                        @forelse($profil as $t)
                                        <tr>
                                            <td style="text-align: center;">{{ $no++ }}</td>
                                            <td style="text-align: center;">{{ $t->nik ? maskText($t->nik) : "" }}</td>
                                            <td style="text-align: center;">{{ $t->nip ? maskText($t->nip) : "" }}</td>
                                            <td>{{ kapital($t->nama) }}</td>
                                            <td>{{ maskEmail($t->email) }}</td>
                                            <td>{{ $t->hp ? maskText($t->hp) : "" }}</td>
                                            <td style="text-align: center;">
                                                <a href="/tiket/tambah/{{ Crypt::encrypt($t->id) }}" class="btn btn-sm btn-outline-success mb-1">Buat Tiket</a>
                                                <a href="/tiket/{{ Crypt::encrypt($t->id) }}" class="btn btn-sm btn-outline-primary">Riwayat</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center align-middle">Tidak ada data, buat <a href="{{ $link }}/tambah" class="btn btn-sm btn-outline-success">Buat Profil</a> ?</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-12"><small>Direktorat Sertifikasi Profesi</small></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection