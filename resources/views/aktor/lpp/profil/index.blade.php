@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            LPP
        </div>
        <div class="card-body">
        <div class="row mb-2">
                <div class="col-sm-8">
                    <!-- <a href="/lpp/tambah" class="btn btn-sm btn-primary">Tambah</a>
                    |
                    <a href="/lpp/sampah" class="btn btn-sm btn-danger">Sampah</a> -->
                </div>
                <div class="col-sm-4">
                    <form action="/lpp/cari" method="GET" class="form-inline">
                        <input type="text" name="cari" class="form-control mr-2" placeholder="Cari Nama / Kota .." value="{{ old('cari') }}">
                        <input type="submit" class="btn btn-sm btn-primary" value="CARI">
                    </form>
                </div>
            </div>
            
            <div class="row mb-2">
                <div class="col-sm-12">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">No</th>
                            <th width="5%" style="text-align: center;">Kode</th>
                            <th width="15%" style="text-align: center;">Alias</th>
                            <th style="text-align: center;">Nama</th>
                            <th width="35%" style="text-align: center;">Alamat</th>
                            <th width="15%" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = ($lpp->currentPage() - 1) * $lpp->perPage() + 1;
                        ?>
                        @foreach($lpp as $l)
                        <tr>
                            <td style="text-align: center;">{{ $no++ }}</td>
                            <td style="text-align: center;">{{ $l->kode }}</td>
                            <td style="text-align: center;">{{ $l->alias }}</td>
                            <td>{{ kapital($l->nama) }}</td>
                            <td>{{ $l->alamat }} {{ isset($l->kota->nama) ? kapital($l->kota->nama) : 'xxx' }}</td>
                            <td style="text-align: center;">
                                <a href="/lpp/ubah/{{ Crypt::encrypt($l->id) }}" class="btn btn-sm btn-warning mb-1">Ubah</a>
                                <!-- <a href="/lpp/hapus/{{ Crypt::encrypt($l->id) }}" class="btn btn-sm btn-danger">Hapus</a> -->
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-12">
                    <table width="100%">
                    <tr>
                        <td width="10%">Halaman ke</td>
                        <td>: {{ $lpp->currentPage() }}</td>
                        <td rowspan="2" width="30%">{{ $lpp->links() }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>: {{ $lpp->count() }} / {{ $lpp->total() }} Data</td>
                    </tr>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</div>
@endsection