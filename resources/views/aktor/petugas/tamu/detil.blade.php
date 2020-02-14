@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
                <div class="card">
                    <div class="card-header text-center">
                        <h5 class="card-title m-0">
                            <a href="{{ $link }}/tamu/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                            @if($subsubjudul)
                                @if($aksi)
                                    <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($aset->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($aset->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                                    <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                                @else
                                    <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($aset->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                                @endif
                            @else
                                @if($subjudul)
                                    @if($aksi)
                                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($aset->id) }}'>{{ strtoupper($subjudul) }}</a> 
                                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                                    @else
                                        <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subjudul) }}
                                    @endif
                                @else
                                    @if($aksi)
                                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                                    @else
                                        {{ strtoupper($subjudul) }}
                                    @endif
                                @endif
                            @endif
                        </h5>
                        <div class="card-tools">
                            <form action="{{ $link }}/tamu/cari_tiket/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $tamu_id }}" method="GET" class="form-inline ml-0 ml-md-3">
                            <div class="input-group input-group-sm">
                                <input class="form-control" type="search" name="cari" placeholder="Cari Tiket .. " aria-label="Cari" value="{{ old('cari') }}">
                                <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">Nama</div>
                                    <div class="col-sm-8">{{ kapital($tamu->nama) }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">NIK</div>
                                    <div class="col-sm-8">{{ maskText($tamu->nik) }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">NIP/NRP</div>
                                    <div class="col-sm-8">{{ maskText($tamu->nip) }}</div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="row mb-3">
                                    <div class="col-sm-4">Instansi</div>
                                    <div class="col-sm-8">{{ kapital($tamu->instansi) }}</div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">Email</div>
                                    <div class="col-sm-8">{{ maskEmail($tamu->email) }}</div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">HP</div>
                                    <div class="col-sm-8">{{ maskText($tamu->hp) }}</div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="text-align: center;">No</th>
                                            <th width="30%" style="text-align: center;">Konsultasi</th>
                                            <th width="30%" style="text-align: center;">Jawaban</th>
                                            <th width="15%" style="text-align: center;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = ($konsultasi->currentPage() - 1) * $konsultasi->perPage() + 1;
                                        @endphp

                                        @foreach($konsultasi as $k)
                                        <tr>
                                            <td style="text-align: center;">{{ $no++ }}</td>
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        {!! !empty($k->subjek->subjek) ? $k->subjek->kode."<br>".$k->subjek->subjek : "" !!}
                                                    </div>
                                                    <div class="col-sm-4" align="right">
                                                        <small>{{ !empty($k->subjek->subjek) ? date("H:i:s", strtotime($k->created_at)) : "" }}</small>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-12">
                                                        {!! $k->konsultasi !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if(empty($k->petugas->nama))
                                                    
                                                @else
                                                    {!! $k->jawaban !!}<br><br><small>{{ $k->petugas->nama }} - {{ date("H:i:s",strtotime($k->jawaban_at)) }}</small>
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if(empty($k->konsultasi))
                                                    
                                                @else
                                                <a href="/layanan/jawab/{{ Crypt::encrypt($tiket->id) }}/{{ Crypt::encrypt($k->id) }}">Jawab</a> 
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <h5 class="card-title m-0">
                            <small>Hal. ke : {{ $konsultasi->currentPage() }} | Jumlah: <b class="text-success">{{ $konsultasi->count() }}</b> / {{ $konsultasi->total() }} Data</small>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection