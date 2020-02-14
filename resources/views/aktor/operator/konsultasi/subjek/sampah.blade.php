@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/subjek">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($subjek->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($subjek->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($subjek->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($subjek->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                <form action="{{ $link }}/subjek/cari_sampah" method="GET" class="form-inline ml-0 ml-md-3">
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
                <div class="col-sm-5"><a href="{{ $link }}/subjek" class="btn btn-sm btn-outline-primary">Kembali</a></div>
                <div class="col-sm-7">{{ $subjek->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    @if($message = Session::get('success'))
                    <div class="col-sm-12">
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                            {!! $message !!}
                        </div>
                    </div>
                    @endif
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" style="text-align: center;">No</th>
                                <th width="15%" style="text-align: center;">Kode</th>
                                <th>Subjek</th>
                                <th width="15%" style="text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = ($subjek->currentPage() - 1) * $subjek->perPage() + 1;
                            @endphp

                            @forelse($subjek as $s)
                            <tr>
                                <td style="text-align: center;">{{ $no++ }}</td>
                                <td style="text-align: center;">{{ $s->kode }}</td>
                                <td>{{ $s->nama }}</td>
                                <td style="text-align: center;">
                                    <a href="{{ $link }}/{{ $judul }}/kembalikan/{{ Crypt::encrypt($s->id) }}" class="btn btn-outline-info btn-xs" onclick="return confirm('Anda yakin akan mengembalikan {{ kapital($judul) }} {{ $s->kode }} ini?')" data-placement="right" data-toggle="tooltip" data-original-title="Kembalikan"><i class="fa fa-trash-restore"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $subjek->currentPage() }} | Jumlah: <b class="text-success">{{ $subjek->count() }}</b> / {{ $subjek->total() }} Data</small>
            </h5>
            <a href="{{ $link }}/{{ $judul }}/kembalikan_semua" class="btn btn-xs btn-outline-warning float-right" onclick="return confirm('Anda yakin akan mengembalikan semua data ini?')" data-placement="left" data-toggle="tooltip" data-original-title="Kembalikan Semua"><i class="fas fa-undo"></i></a>
        </div>
    </div>
</div>
@endsection