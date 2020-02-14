@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            Petugas
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <a href="/petugas/tambah" class="btn btn-sm btn-primary">Tambah</a>
                    |
                    <a href="/petugas/sampah" class="btn btn-sm btn-danger">Sampah</a>
                </div>
                <div class="col-sm-4">
                    <form action="/petugas/cari" method="GET" class="form-inline">
                        <input type="text" name="cari" class="form-control mr-2" placeholder="Cari .." value="{{ old('cari') }}">
                        <input type="submit" class="btn btn-sm btn-primary" value="CARI">
                    </form>
                </div>
            </div>

            
            <div class="row mb-2">
                <div class="col-sm-12">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">NO</th>
                            <th width="15%" style="text-align: center;">NIK</th>
                            <th width="15%" style="text-align: center;">NIP</th>
                            <th style="text-align: center;">Nama</th>
                            <th width="15%" style="text-align: center;">Email</th>
                            <th width="15%" style="text-align: center;">HP</th>
                            <th width="15%" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = ($petugas->currentPage() - 1) * $petugas->perPage() + 1;
                        ?>
                        @foreach($petugas as $p)
                        <tr>
                            <td style="text-align: center;">{{ $no++ }}</td>
                            <td style="text-align: center;">{{ $p->nik ? maskText($p->nik) : ""}}</td>
                            <td style="text-align: center;">{{ $p->nip ? maskText($p->nip) : ""}}</td>
                            <td>{{ kapital($p->nama) }}</td>
                            <td>{{ maskEmail($p->email)}}</td>
                            <td>{{ $p->hp ? maskText($p->hp) : ""}}</td>
                            <td style="text-align: center;">
                                <a href="/petugas/ubah/{{ Crypt::encrypt($p->id) }}" class="btn btn-sm btn-warning">Ubah</a>
                                <a href="/petugas/hapus/{{ Crypt::encrypt($p->id) }}" class="btn btn-sm btn-danger">Hapus</a>
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
                        <td>: {{ $petugas->currentPage() }}</td>
                        <td rowspan="2" width="30%">{{ $petugas->links() }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>: {{ $petugas->count() }} / {{ $petugas->total() }} Data</td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection