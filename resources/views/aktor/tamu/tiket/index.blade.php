@extends('layouts.lte_tamu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- top -->
            <div class="row">
                <!-- left -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="card-title m-0"><a href="#">PROFIL</a></h5>
                            <div class="card-tools"><a href="/" class="btn btn-xs btn-outline-info pb-0 pt-0 mt-0 mb-0">Kembali ke Halaman Utama</a></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">Nama</div>
                                        <div class="col-sm-9">{{ kapital($profil->nama) }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">NIK</div>
                                        <div class="col-sm-9">{{ maskText($profil->nik) }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">NIP/NRP</div>
                                        <div class="col-sm-9">{{ maskText($profil->nip) }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="row mb-3">
                                        <div class="col-sm-3">Instansi</div>
                                        <div class="col-sm-9">{{ kapital($profil->instansi) }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-3">Email</div>
                                        <div class="col-sm-9">{{ maskEmail($profil->email) }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-3">HP</div>
                                        <div class="col-sm-9">{{ maskText($profil->hp) }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end left -->
                
            </div>
            <!-- end top -->

            <div class="row">
                <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header text-center">
                                <h5 class="card-title m-0">
                                    <a href="#">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                                    @if($subsubjudul)
                                        @if($aksi)
                                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($profil->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                                            <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                                        @else
                                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($profil->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                                        @endif
                                    @else
                                        @if($subjudul)
                                            @if($aksi)
                                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='/{{ $subjudul }}/{{ Crypt::encrypt($profil->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                                    <form action="/{{ $subjudul }}/cari/{{ Crypt::encrypt($profil->id) }}" method="GET" class="form-inline ml-0 ml-md-3">
                                        <div class="input-group input-group-sm">
                                            <input class="form-control" type="search" name="cari" placeholder="Cari Tiket" aria-label="Cari" value="{{ old('cari') }}">
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
                                    <div class="col-sm-8">
                                        <a href="/{{ $subjudul }}/tambah/{{ Crypt::encrypt($profil->id) }}" class="btn btn-sm btn-outline-success">Buat Tiket</a>
                                    </div>
                                    <div class="col-sm-4">{{ $tiket->links() }}</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">No</th>
                                                    <th class="text-center">Hari, Tanggal</th>
                                                    <th class="text-center">Tiket</th>
                                                    <th width="30%" class="text-center">Jumlah Subjek</th>
                                                    <th width="15%" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no = ($tiket->currentPage() - 1) * $tiket->perPage() + 1;
                                                @endphp

                                                @forelse($tiket as $t)
                                                <tr>
                                                    <td class="text-center">{{ $no++ }}</td>
                                                    <td class="text-center">{{ hari($t->created_at) }}</td>
                                                    <td class="text-center">{{ $t->nomor }}</td>
                                                    <td class="text-center">{{ Statistik::hitungTiketSubjek($t->id) }}</td>
                                                    <td class="text-center">
                                                        <a href="/konsultasi/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($t->id) }}" class="btn btn-xs btn-outline-lihat" data-placement="right" data-toggle="tooltip" data-original-title="Detil"><i class="fa fa-paste"></i></a>
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data</td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <h5 class="card-title m-0">
                                    <small>Hal. ke : {{ $tiket->currentPage() }} | Jumlah: <b class="text-success">{{ $tiket->count() }}</b> / {{ $tiket->total() }} Data</small>
                                </h5>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div>
    </div>
</div>
@endsection