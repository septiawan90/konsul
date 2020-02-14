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
                <div class="col-sm-12">{{ $kelurahan->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="30%" class="text-center">Nama</th>
                                <th width="20%" class="text-center">Kecamatan</th>
                                <th width="20%" class="text-center">Kota</th>
                                <th class="text-center">Provinsi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($kelurahan->currentPage() - 1) * $kelurahan->perpage() + 1;
                            ?>
                            @foreach($kelurahan as $k)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ kapital($k->nama) }}</td>
                                <td class="text-center">{{ kapital($k->kecamatan->nama) }}</td>
                                <td class="text-center">{{ kapital($k->kecamatan->kota->nama) }}</td>
                                <td class="text-center">{{ kapital($k->kecamatan->kota->provinsi->nama) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $kelurahan->currentPage() }} | Jumlah: <b class="text-success">{{ $kelurahan->count() }}</b> / {{ $kelurahan->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection