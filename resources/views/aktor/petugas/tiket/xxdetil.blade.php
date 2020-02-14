@extends('layouts.lte')

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
                                <!-- -->
                                <div class="col-sm-4">
                                    <div class="row mb-3">
                                        <div class="col-sm-4">Tiket</div>
                                        <div class="col-sm-8">{{ $tiket->nomor }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">Hari, Tanggal</div>
                                        <div class="col-sm-8">{{ hari($tiket->created_at) }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row mb-3">
                                        <div class="col-sm-4">Nama</div>
                                        <div class="col-sm-8">{{ kapital($profil->nama) }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">NIK</div>
                                        <div class="col-sm-8">{{ maskText($profil->nik) }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">NIP/NRP</div>
                                        <div class="col-sm-8">{{ maskText($profil->nip) }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row mb-3">
                                        <div class="col-sm-4">Instansi</div>
                                        <div class="col-sm-8">{{ kapital($profil->instansi) }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">Email</div>
                                        <div class="col-sm-8">{{ maskEmail($profil->email) }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">HP</div>
                                        <div class="col-sm-8">{{ maskText($profil->hp) }}</div>
                                    </div>
                                </div>
                                <!--  -->
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
                                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='/tiket/{{ Crypt::encrypt($profil->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='/{{ $subsubjudul }}/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($tiket->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                                            <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                                        @else
                                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='/tiket/{{ Crypt::encrypt($profil->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                                        @endif
                                    @else
                                        @if($subjudul)
                                            @if($aksi)
                                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='/tiket/{{ Crypt::encrypt($profil->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                                    <form action="/konsultasi/cari/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($tiket->id) }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                                    <div class="col-sm-5"><a href="/konsultasi/tambah/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($tiket->id) }}" class="btn btn-sm btn-outline-success">Tambah</a></div>
                                    <div class="col-sm-7">{{ $konsultasi->links() }}</div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <table class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="5%" class="text-center">No</th>
                                                    <th class="text-center">Subjek</th>
                                                    <th width="33%" class="text-center">Konsultasi</th>
                                                    <th width="33%" class="text-center">Jawaban</th>
                                                    <th width="5%" class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                $no = ($konsultasi->currentPage() - 1) * $konsultasi->perPage() + 1;
                                                @endphp

                                                @forelse($konsultasi as $k)
                                                <tr>
                                                    <td class="text-center align-middle">{{ $no++ }}</td>
                                                    <td class="text-center align-middle">{!! isset($k->subjek->nama) ? $k->subjek->kode.'<br>'.$k->subjek->nama : ''  !!}</td>
                                                    <td class="text-center align-middle">{!! $k->konsultasi !!}</td>
                                                    <td class="text-center align-middle">{!! $k->jawaban !!}</td>
                                                    <td class="text-center align-middle">
                                                        @if(is_null($k->jawaban) || empty($k->jawaban))
                                                        <a href="/konsultasi/ubah/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($tiket->id) }}/{{ Crypt::encrypt($k->id) }}" class="btn btn-xs btn-outline-ubah" data-placement="right" data-toggle="tooltip" data-original-title="Ubah"><i class="fa fa-pencil-alt"></i></a>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="5" class="text-center">Tidak ada data</td>
                                                </tr>
                                                @endforelse
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
    </div>
</div>
@endsection