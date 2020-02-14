@extends('layouts.lte')

@section('content')
<div class="container">
    <!-- top -->
    <div class="row">
        <!-- left -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                    </h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2">LPP</div>
                                <div class="col-sm-10">{{ $surat->lpp->nama }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">Nomor</div>
                                <div class="col-sm-8">{{ $surat->nomor }}</div>
                                <div class="col-sm-4">Hari, Tanggal</div>
                                <div class="col-sm-8">{{ hari($surat->tanggal) }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12">Tentang : <br>{{ $surat->tentang }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end left -->
        <!-- right  -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center">
                <h5 class="card-title m-0"><a href="#">JUMLAH</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4">Kegiatan</div>
                                <div class="col-sm-8">{{ Statistik::hitungKegiatan($surat->id) }}</div>
                                <div class="col-sm-4">Pendaftar</div>
                                <div class="col-sm-8">{{ Statistik::hitungPendaftarSurat($surat->id) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end right -->
    </div>
    <!-- end top -->

    <div class="row">
        <!-- right -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        @if($subsubjudul)
                            @if($aksi)
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subsubjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}'>{{ strtoupper($subsubjudul) }}</a>
                                <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                            @else
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                            @endif
                        @else
                            @if($subjudul)
                                @if($aksi)
                                    <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}'>{{ strtoupper($subjudul) }}</a> 
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
                        <form action="{{ $link }}/{{ $subjudul }}/cari/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                        <div class="col-sm-5"><a href="{{ $link }}/{{ $subjudul }}/tambah/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}" class="btn btn-sm btn-outline-success">Tambah</a></div>
                        <div class="col-sm-7">{{ $kegiatan->links() }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            @if($message = Session::get('success'))
                            <div class="alert alert-success alert-block mt-0">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                <strong>{{ $message }}</strong>
                            </div>
                            @endif
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th rowspan="2" width="3%" class="text-center align-middle">No</th>
                                        <th rowspan="2" width="5%" class="text-center align-middle">Kode Kegiatan</th>
                                        <th rowspan="2" width="10%" class="text-center align-middle">Hari, Tanggal</th>
                                        <th colspan="2" class="text-center">Lokasi</th>
                                        <th colspan="2" width="20%" class="text-center">Peserta</th>
                                        <th rowspan="2" width="5%" class="text-center align-middle">Status Kegiatan</th>
                                        <th rowspan="2" width="3%" class="text-center align-middle">Aksi</th>
                                    </tr>
                                    <tr>
                                        <th width="12%" class="text-center">Venue</th>
                                        <th width="12%" class="text-center">Kota/Kab</th>
                                        <th width="5%" class="text-center">Sesi</th>
                                        <th width="5%" class="text-center">Daftar/Usul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = ($kegiatan->currentPage() - 1) * $kegiatan->perPage() + 1;
                                    ?>
                                    @foreach($kegiatan as $k)
                                    <tr>
                                        <td class="text-center align-middle">{{ $no++ }}</td>
                                        <td class="text-center align-middle">{{ $k->kode }}</td>
                                        <td class="text-center align-middle">{!! hari($k->tanggal).'<br>'.$k->jam !!}</td>
                                        <td class="align-middle">{{ $k->venue->nama }}</td>
                                        <td class="align-middle">{{ isset($k->venue->kota->nama) ? kapital($k->venue->kota->nama) : "" }}</td>
                                        <td class="text-center align-middle">{{ $k->sesi }}</td>
                                        <td class="align-middle">
                                            <div class="row">
                                                <div class="col-sm-8 text-right">
                                                    {{ Statistik::hitungPendaftar($k->id) }} / {{ $k->usulan }}
                                                </div>
                                                <div class="col-sm-4">
                                                @if(date('Y-m-d') < date('Y-m-d', strtotime($k->tanggal.' - 2 days')))
                                                    <a href="{{ $link }}/peserta/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ Crypt::encrypt($k->id) }}" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="Lihat Peserta"><i class="fa fa-users"></i></a>
                                                @else
                                                    <a href="{{ $link }}/peserta/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ Crypt::encrypt($k->id) }}" class="btn btn-xs btn-outline-danger" data-placement="top" data-toggle="tooltip" data-original-title="Lihat Peserta"><i class="fa fa-users"></i></a>
                                                @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">{{ $k->status }}</td>
                                        <td class="text-center align-middle">
                                            <a href="{{ $link }}/{{ $subjudul }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ Crypt::encrypt($k->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Lihat"><i class="fa fa-paste"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <h5 class="card-title m-0">
                    <small>Hal. ke : {{ $kegiatan->currentPage() }} | Jumlah: <b class="text-success">{{ $kegiatan->count() }}</b> / {{ $kegiatan->total() }} Data</small>
                    </h5>
                </div>
            </div>
        </div>
        <!-- end right -->
    </div>
</div>
@endsection