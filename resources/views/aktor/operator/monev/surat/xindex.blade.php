@extends('layouts.lte')

@section('content')
<div class="container">
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
                        <form action="{{ $link }}/{{ $judul }}/cari" method="GET" class="form-inline ml-0 ml-md-3">
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
                        <div class="col-sm-6">{{ $surat->links() }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="20%" class="text-center">Dari</th>
                                        <th width="15%" class="text-center">Nomor, Tanggal
                                        <th>Tentang</th>
                                        <th width="10%" class="text-center">Kegiatan</th>
                                        <th width="5%" class="text-center">File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    $no = ($surat->currentPage() - 1) * $surat->perPage() + 1;
                                    ?>
                                    @foreach($surat as $s)
                                    <tr>
                                        <td class="text-center align-middle">{{ $no++ }}</td>
                                        <td class="align-middle">{{ kapital($s->lpp->nama) }}</td>
                                        <td class="align-middle">{{ $s->nomor }}<br>{{ tanggal($s->tanggal) }}</td>
                                        <td class="align-middle">{{ $s->tentang }}</td>
                                        <td class="text-center align-middle">
                                            <a href="{{ $link }}/kegiatan/{{ Crypt::encrypt($s->id) }}" class="btn btn-xs btn-outline-success"><i class="fa fa-paste"></i> {{ Statistik::hitungKegiatan($s->id) }}</a>
                                        </td>
                                        <td class="text-center align-middle">
                                            <a href="{{ $link }}/{{ $judul }}/unduh/{{Crypt::encrypt($s->id)}}" class="btn btn-xs btn-outline-primary"><i class="fa fa-download"></i></a>
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
                    <small>Hal. ke : {{ $surat->currentPage() }} | Jumlah: <b class="text-success">{{ $surat->count() }}</b> / {{ $surat->total() }} Data</small>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection