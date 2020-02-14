@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-left">
            Riwayat Konsultasi
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-sm-4">
                    <div class="row mb-3">
                        <div class="col-sm-4">Nama</div>
                        <div class="col-sm-8">{{ kapital($tamu->nama) }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4">NIK</div>
                        <div class="col-sm-8">{{ maskText($tamu->nik) }}</div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">NIP/NRP</div>
                        <div class="col-sm-8">{{ maskText($tamu->nip) }}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row mb-3">
                        <div class="col-sm-4">Instansi</div>
                        <div class="col-sm-8">{{ kapital($tamu->instansi) }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-4">Email</div>
                        <div class="col-sm-8">{{ maskEmail($tamu->email) }}</div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4">HP</div>
                        <div class="col-sm-8">{{ maskText($tamu->hp) }}</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="row mb-3 mt-4">
                        <form action="/layanan/cari_tiket/{{ Crypt::encrypt($tamu->id) }}" method="GET" class="form-inline ml-5">
                            <input type="text" name="cari" class="form-control mr-2" placeholder="Cari .." value="{{ old('cari') }}">
                            <input type="submit" class="btn btn-sm btn-primary" value="CARI">
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">No</th>
                            <th style="text-align: center;">Tanggal</th>
                            <th style="text-align: center;">Tiket</th>
                            <th width="30%" style="text-align: center;">Jumlah Subjek</th>
                            <th width="15%" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = ($konsultasi->currentPage() - 1) * $konsultasi->perPage() + 1;
                        ?>
                        @foreach($konsultasi as $k)
                        <tr>
                            <td style="text-align: center;">{{ $no++ }}</td>
                            <td style="text-align: center;">{{ date("d-m-Y", strtotime($k->tiket->created_at)) }}</td>
                            <td style="text-align: center;">{{ $k->tiket->nomor }}</td>
                            <td style="text-align: center;">{{ Statistik::hitungTiketSubjek($k->tiket_id) }}</td>
                            <td style="text-align: center;">
                                <a href="/layanan/detil/{{ Crypt::encrypt($k->tiket_id) }}" class="btn btn-sm btn-warning">Detil</a>
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
                        <td>: {{ $konsultasi->currentPage() }}</td>
                        <td rowspan="2" width="30%">{{ $konsultasi->links() }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>: {{ $konsultasi->count() }} / {{ $konsultasi->total() }} Data</td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection