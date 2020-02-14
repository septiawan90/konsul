@extends('layouts.lte')

@section('content')
<div class="container">
    <!-- top -->
    <div class="row">
        <!-- left -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header text-center">
                <h5 class="card-title m-0"><a href="{{ $link }}/surat">SURAT</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2">LPP</div>
                                <div class="col-sm-10">{{ kapital($surat->lpp->nama) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
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
                                <div class="col-sm-8">{{ $kegiatan->count() }}</div>
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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        @if($subsubjudul)
                            @if($aksi)
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($surat->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                                <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                            @else
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($surat->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                            @endif
                        @else
                            @if($subjudul)
                                @if($aksi)
                                    <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($surat->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                        <form action="{{ $link }}/kegiatan/cari/{{ Crypt::encrypt($surat->id) }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6">{{ $kegiatan->links() }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center align-middle">No</th>
                                        <th width="5%" class="text-center align-middle">Kode Kegiatan</th>
                                        <th class="text-center align-middle">Kegiatan</th>
                                        <th width="10%" class="text-center align-middle">Peserta</th>
                                        <th width="5%" class="text-center align-middle">Status Kegiatan</th>
                                        <th width="15%" class="text-center align-middle">Pengawas</th>
                                        <th width="5%" class="text-center align-middle">Aksi</th>
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
                                        <td>
                                            <div class="row">
                                                <div class="col-sm-4">Hari, Tanggal</div>
                                                <div class="col-sm-8">{{ hari($k->tanggal) }}</div>
                                                <div class="col-sm-4">Jam</div>
                                                <div class="col-sm-8">{{ $k->jam }}</div>
                                                <div class="col-sm-4">Sesi</div>
                                                <div class="col-sm-8">{{ $k->sesi }}</div>
                                                <div class="col-sm-4">Lokasi</div>
                                                <div class="col-sm-8">{{ $k->venue->nama }}</div>
                                                <div class="col-sm-4"></div>
                                                <div class="col-sm-8">{{ isset($k->venue->kota->nama) ? kapital($k->venue->kota->nama) : "" }}</div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle">
                                            <div class="row">
                                                <div class="col-sm-8 text-right pr-1">
                                                    {{ Statistik::hitungPendaftar($k->id) }}</b>/{{ $k->usulan }}
                                                </div>
                                                <div class="col-sm-4 text-left pl-0">
                                                @if(date('Y-m-d') < date('Y-m-d', strtotime($k->tanggal.' - 2 days')))
                                                    <a href="{{ $link }}/kegiatan/peserta/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($k->id) }}" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="Lihat Peserta"><i class="fa fa-users"></i></a>
                                                @else
                                                    <a href="{{ $link }}/kegiatan/peserta/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($k->id) }}" class="btn btn-xs btn-outline-danger" data-placement="top" data-toggle="tooltip" data-original-title="Lihat Peserta"><i class="fa fa-users"></i></a>
                                                @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center align-middle {{ $k->status == 'ditolak' ? 'text-danger' : ($k->status == 'disetujui' ? 'text-success' : 'text-warning') }}">{{ $k->status }}</td>
                                        <td class="text-center align-middle">{{ isset($k->pengawas1->profil->nama) ? $k->pengawas1->profil->nama : '' }} {!! isset($k->pengawas2->profil->nama) ? '<br>'.$k->pengawas2->profil->nama : '' !!}</td>
                                        <td class="text-center align-middle">
                                            <a href="{{ $link }}/kegiatan/lihat/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($k->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Lihat"><i class="fa fa-paste"></i></a>
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
    </div>
</div>
@endsection