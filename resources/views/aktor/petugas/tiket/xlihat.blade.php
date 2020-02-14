@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-left">
            Konsultasi Sertifikasi
        </div>
        <div class="card-body">
            <div class="row">
                    <div class="col-sm-4">
                        <div class="row mb-3">
                            <div class="col-sm-4">Tiket</div>
                            <div class="col-sm-8">{{ $tiket->nomor }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">Tanggal</div>
                            <div class="col-sm-8">{{ hari($tiket->created_at).', '.date("d-m-Y", strtotime($tiket->created_at)) }}</div>
                        </div>
                    </div>
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
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-12">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">No</th>
                            <th width="20%" style="text-align: center;">Subjek</th>
                            <th style="text-align: center;">Konsultasi</th>
                            <th width="40%" style="text-align: center;">Jawaban</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 0;
                        ?>
                        @foreach($konsultasi as $k)
                        <tr>
                            <td style="text-align: center;">{{ ++$no }}</td>
                            <td>{!! $k->kode.'<br>'.$k->subjek !!}</td>
                            <td>{!! $k->konsultasi !!}</td>
                            <td>{!! $k->jawaban !!}<br><small>({{ $k->nama}})</small></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </div>
</div>
@endsection