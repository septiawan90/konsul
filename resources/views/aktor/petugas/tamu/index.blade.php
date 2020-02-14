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
                            <form action="{{ $link }}/tamu/cari/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" method="GET" class="form-inline ml-0 ml-md-3">
                            <div class="input-group input-group-sm">
                                <input class="form-control" type="search" name="cari" placeholder="Cari" aria-label="Cari" value="{{ old('cari') }}">
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
                        <div class="row mb-2">
                            <div class="col-sm-5"></div>
                            <div class="col-sm-7"></div>
                        </div>
                        
                        <div class="row">
                            <div class="col-lg-12">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%" class="text-center">NO</th>
                                            <th width="15%" class="text-center">NIK</th>
                                            <th width="15%" class="text-center">NIP</th>
                                            <th class="text-center">Nama</th>
                                            <th width="15%" class="text-center">Email</th>
                                            <th width="15%" class="text-center">HP</th>
                                            <th width="15%" class="text-center">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                        $no = ($tamu->currentPage() - 1) * $tamu->perPage() + 1;
                                        @endphp

                                        @forelse($tamu as $t)
                                        <tr>
                                            <td class="text-center">{{ $no++ }}</td>
                                            <td class="text-center">{{ $t->nik ? maskText($t->nik) : "" }}</td>
                                            <td class="text-center">{{ $t->nip ? maskText($t->nip) : "" }}</td>
                                            <td>{{ kapital($t->nama) }}</td>
                                            <td>{{ maskEmail($t->email) }}</td>
                                            <td>{{ $t->hp ? maskText($t->hp) : "" }}</td>
                                            <td class="text-center">
                                                <a href="/petugas/tamu/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ Crypt::encrypt($t->id) }}" class="btn btn-xs btn-outline-success">Ubah</a>
                                                <a href="/petugas/tamu/riwayat/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ Crypt::encrypt($t->id) }}" class="btn btn-xs btn-outline-primary">Riwayat</a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="7" class="text-center align-middle">Tidak ada data.</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <h5 class="card-title m-0">
                            <small>Hal. ke : {{ $tamu->currentPage() }} | Jumlah: <b class="text-success">{{ $tamu->count() }}</b> / {{ $tamu->total() }} Data</small>
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection