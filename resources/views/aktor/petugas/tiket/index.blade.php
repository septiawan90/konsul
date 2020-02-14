@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($tiket->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($tiket->id) }}/'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($tiket->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($tiket->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                <form action="{{ $link }}/{{ $judul }}/cari/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                <div class="col-sm-7">{{ $tiket->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%"class="text-center">No</th>
                                <th width="17%" class="text-center">Tiket, Tanggal</th>
                                <th width="17%" class="text-center">NIK | NRP</th>
                                <th class="text-center">Nama</th>
                                <th width="30%" class="text-center">Instansi</th>
                                <th width="5%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = ($tiket->currentPage() - 1) * $tiket->perPage() + 1;
                            @endphp

                            @foreach($tiket as $t)
                            <tr>
                                <td class="text-center align-middle">{{ $no++ }}</td>
                                <td class="text-center align-middle"><b class="text-success">{{ $t->nomor }}</b><br>{{ hari($t->created_at) }}</td>
                                <td class="text-center align-middle">{{ $t->tamu->nik ? maskText($t->tamu->nik) : ""}}<br>{{ $t->tamu->nip ? maskText($t->tamu->nip) : ""}}</td>
                                <td class="text-center align-middle">{{ kapital($t->tamu->nama) }}
                                    <br>{{ maskEmail($t->tamu->email) }}
                                </td>
                                <td class="text-center align-middle">{{ kapital($t->tamu->instansi) }}</td>
                                <td class="text-center align-middle">
                                    <a href="{{ $link }}/konsultasi/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ Crypt::encrypt($t->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Konsultasi"><i class="fa fa-paste"></i></a>
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
            <small>Hal. ke : {{ $tiket->currentPage() }} | Jumlah: <b class="text-success">{{ $tiket->count() }}</b> / {{ $tiket->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection