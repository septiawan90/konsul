@extends('layouts.lte')

@section('content')
<div class="container">
    
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0"><a href="{{ $link }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> {{ $subjudul }}</h5>
            <div class="card-tools">
                <form action="{{ $link }}/cari" method="GET" class="form-inline ml-0 ml-md-3">
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
                <div class="col-sm-12">{{ $provinsi->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" style="text-align: center;">No</th>
                                <th style="text-align: center;">Provinsi</th>
                                <th width="15%" style="text-align: center;">Kota</th>
                                <th width="15%" style="text-align: center;">Kecamatan</th>
                                <th width="15%" style="text-align: center;">Kelurahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($provinsi->currentPage() - 1) * $provinsi->perPage() + 1;
                            ?>
                            @foreach($provinsi as $p)
                            <tr>
                                <td style="text-align: center;">{{ $no++ }}</td>
                                <td>{{ kapital($p->nama) }}</td>
                                <td class="text-center">{{ Statistik::hitungKota($p->id) }}</td>
                                <td class="text-center">{{ Statistik::hitungKecamatan($p->id) }}</td>
                                <td class="text-center">{{ Statistik::hitungKelurahan($p->id) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $provinsi->currentPage() }} | Jumlah: <b class="text-success">{{ $provinsi->count() }}</b> / {{ $provinsi->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection