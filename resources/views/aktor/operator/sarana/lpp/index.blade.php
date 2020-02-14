@extends('layouts.lte')

@section('content')
<div class="container">
    
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $lpp_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ $lpp_id }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $lpp_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $judul }}/{{ $subjudul }}/{{ $lpp_id }}'>{{ strtoupper($subjudul) }}</a> 
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
                <div class="col-sm-5"><a href="{{ $link }}/{{ $judul }}/cari_owner/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-sm btn-outline-success">Tambah</a></div>
                <div class="col-sm-7">{{ $lpp->links() }}</div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="10%" class="text-center">Kode</th>
                                <th class="text-center">Nama</th>
                                <th width="20%" class="text-center">Alamat</th>
                                <th width="20%" class="text-center">Kontak</th>
                                <th width="7%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = ($lpp->currentPage() - 1) * $lpp->perPage() + 1;
                            @endphp

                            @foreach($lpp as $row)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $row->kode }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-4">LPP</div>
                                        <div class="col-sm-8">{{ kapital($row->nama) }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">Alias</div>
                                        <div class="col-sm-8">{{ $row->alias }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">Jenis</div>
                                        <div class="col-sm-8">{{ isset($row->jenis->nama) ? $row->jenis->nama : "" }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">Akreditasi</div>
                                        <div class="col-sm-8">Akr + Tgl Berlaku</div>
                                    </div>
                                </td>
                                <td>{{ $row->alamat }}<br>{{ isset($row->kota->nama) ? kapital($row->kota->nama) : "" }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-4">Owner</div>
                                        <div class="col-sm-8">{{ isset($row->profil->nama) ? $row->profil->nama : "" }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">Telp.</div>
                                        <div class="col-sm-8">{{ $row->telp }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">Email</div>
                                        <div class="col-sm-8">{{ $row->email }}</div>
                                    </div>    
                                </td>
                                <td class="text-center">
                                    <a href="{{ $link }}/{{ $judul }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Lihat"><i class="fa fa-paste"></i></a>                                    
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
            <small>Hal. ke : {{ $lpp->currentPage() }} | Jumlah: <b class="text-success">{{ $lpp->count() }}</b> / {{ $lpp->total() }} Data</small>
            </h5>
            <a href="{{ $link }}/{{ $judul }}/sampah" class="btn btn-xs btn-outline-danger float-right" data-placement="left" data-toggle="tooltip" data-original-title="Data Sampah"><i class="fas fa-trash"></i></a>
        </div>
    </div>
</div>
@endsection