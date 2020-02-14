@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0"><a href="{{ $link }}">
                <a href="{{ $link }}/aset">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($layanan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($layanan->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($layanan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($layanan->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                <form action="{{ $link }}/aset/cari" method="GET" class="form-inline ml-0 ml-md-3">
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
                <div class="col-sm-5"></div>
                <div class="col-sm-7">{{ $layanan->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%"class="text-center">No</th>
                                <th width="10%" class="text-center">Tanggal</th>
                                <th width="10%" class="text-center">Tiket</th>
                                <th width="20%" class="text-center">Nama</th>
                                <th width="5%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = ($layanan->currentPage() - 1) * $layanan->perPage() + 1;
                            @endphp

                            @foreach($layanan as $l)
                            <tr>
                                <td class="text-center align-middle">{{ $no++ }}</td>
                                <td class="text-center align-middle">{{ hari($l->created_at) }}</td>
                                <td class="text-center align-middle">{{ $l->nomor }}</td>
                                <td>{{ kapital($l->tamu->nama) }}
                                    <br>{{ maskEmail($l->tamu->email) }}
                                    <br>{{ $l->tamu->nik ? maskText($l->tamu->nik) : ""}}
                                    <br>{{ $l->tamu->nip ? maskText($l->tamu->nip) : ""}}
                                    <br>{{ kapital($l->tamu->instansi) }}
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ $link }}/{{ $judul }}/detil/{{ Crypt::encrypt($l->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Lihat"><i class="fa fa-paste"></i></a>
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
            <small>Hal. ke : {{ $layanan->currentPage() }} | Jumlah: <b class="text-success">{{ $layanan->count() }}</b> / {{ $layanan->total() }} Data</small>
            </h5>
            <a href="{{ $link }}/{{ $judul }}/sampah" class="btn btn-xs btn-outline-danger float-right" data-placement="left" data-toggle="tooltip" data-original-title="Data Sampah"><i class="fas fa-trash"></i></a>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-left">
            Konsultasi Sertifikasi
        </div>
        <div class="card-body">
            <form method="post" action="/konsultasi/store">
            {{ csrf_field() }}
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

                        <div class="row">
                            <div class="col-sm-12">
                                <a href="/layanan/riwayat/{{ Crypt::encrypt($tamu->id) }}" class="btn btn-sm btn-primary">Riwayat</a>
                                <a href="/layanan/lihat/{{ Crypt::encrypt($tiket->id) }}" class="btn btn-sm btn-warning">Lihat</a>
                            </div>
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
                <div class="row mt-3">
                    

                    <div class="col-sm-12">
                        <div class="row mb-2">
                            <div class="col-sm-12">
                                <table class="table table-bordered table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <th width="5%" style="text-align: center;">No</th>
                                            <th width="30%" style="text-align: center;">Konsultasi</th>
                                            <th width="30%" style="text-align: center;">Jawaban</th>
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
                                            <td>
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        {!! !empty($k->subjek->subjek) ? $k->subjek->kode."<br>".$k->subjek->subjek : "" !!}
                                                    </div>
                                                    <div class="col-sm-4" align="right">
                                                        <small>{{ !empty($k->subjek->subjek) ? date("H:i:s", strtotime($k->created_at)) : "" }}</small>
                                                    </div>
                                                </div>
                                                <div class="row mt-3">
                                                    <div class="col-sm-12">
                                                        {!! $k->konsultasi !!}
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @if(empty($k->petugas->nama))
                                                    
                                                @else
                                                    {!! $k->jawaban !!}<br><br><small>{{ $k->petugas->nama }} - {{ date("H:i:s",strtotime($k->jawaban_at)) }}</small>
                                                @endif
                                            </td>
                                            <td style="text-align: center;">
                                                @if(empty($k->konsultasi))
                                                    
                                                @else
                                                <a href="/layanan/jawab/{{ Crypt::encrypt($tiket->id) }}/{{ Crypt::encrypt($k->id) }}">Jawab</a> 
                                                @endif
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
            </form>

        </div>
    </div>
</div>
@endsection