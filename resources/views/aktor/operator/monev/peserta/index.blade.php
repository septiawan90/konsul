@extends('layouts.lte')

@section('content')
<div class="container">
    <!-- top -->
    <div class="row">
        <!-- left -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                <h5 class="card-title m-0"><a href="{{ $link }}/{{ $judul }}">SURAT</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4">LPP</div>
                            <div class="col-sm-8">{{ kapital($surat->lpp->nama) }}</div>
                            <div class="col-sm-4">Nomor</div>
                            <div class="col-sm-8">{{ $surat->nomor }}</div>
                            <div class="col-sm-4">Hari, Tanggal</div>
                            <div class="col-sm-8">{{ hari($surat->tanggal) }}</div>
                            <div class="col-sm-4">Tentang</div>
                            <div class="col-sm-8">{{ $surat->tentang }}</div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end left -->
        <!-- right  -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                <h5 class="card-title m-0"><a href="{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($surat->id) }}">KEGIATAN</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4">Kode</div>
                                <div class="col-sm-8">{{ $kegiatan->kode }}</div>
                                <div class="col-sm-4">Hari, Tanggal</div>
                                <div class="col-sm-8">{{ hari($kegiatan->tanggal) }}</div>
                                <div class="col-sm-4">Tanggal Akhir Daftar</div>
                                <div class="col-sm-8 text-danger">{{ hari(date('Y-m-d', strtotime($kegiatan->tanggal.' - 3 days'))) }}</div>
                                <div class="col-sm-4">Lokasi</div>
                                <div class="col-sm-8">{!! $kegiatan->venue->nama.', '.kapital($kegiatan->venue->kota->nama) !!}</div>
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
                        <form action="{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/cari/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                        <div class="col-sm-6">{{ $peserta->links() }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center align-middle">No</th>
                                        <th width="5%" class="text-center align-middle">Kode</th>
                                        <th width="15%" class="text-center align-middle">Daftar</th>
                                        <th width="25%" class="text-center">Nama</th>
                                        <th width="5%" class="text-center align-middle">Sesi</th>
                                        <th width="5%" class="text-center align-middle">Berkas</th>
                                        <th width="10%" class="text-center align-middle">Status</th>
                                        <th width="5%" class="text-center align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $no = ($peserta->currentPage() - 1) * $peserta->perPage() + 1;
                                    ?>
                                    @foreach($peserta as $p)
                                    <tr>
                                        <td class="text-center align-middle">{{ $no++ }}</td>
                                        <td class="text-center align-middle">{{ $p->kode }}</td>
                                        <td class="text-center align-middle">{{ hari($p->created_at) }}</td>
                                        <td class="text-center align-middle">{{ isset($p->profil->nama) ? $p->profil->nama : '' }}<br>{{ isset($p->profil->user->email) ? $p->profil->user->email : '' }}</td>
                                        <td class="text-center align-middle">{{ $p->sesi }}</td>
                                        <td class="text-center align-middle">
                                        @if($p->file)
                                            <a href="{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/unduh/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}/{{Crypt::encrypt($p->id)}}" class="btn btn-xs btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a>
                                        @endif</td>
                                        <td class="text-center align-middle {{ $p->status == 'verifikasi' ? 'text-warning' : ($p->status == 'disetujui' ? 'text-success' : 'text-danger') }}">{!! $p->status == "ditolak" ? $p->status."<br><small>(".$p->keterangan.")</small>" : $p->status !!}</td>
                                        <td class="text-center align-middle">
                                            <a href="{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/lihat/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}/{{ Crypt::encrypt($p->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Lihat"><i class="fas fa-user"></i></a>
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
                    <small>Hal. ke : {{ $peserta->currentPage() }} | Jumlah: <b class="text-success">{{ $peserta->count() }}</b> / {{ $peserta->total() }} Data</small>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection