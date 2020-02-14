@extends('layouts.lte')

@section('content')
<div class="container">
    
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($kegiatan->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $judul }}/{{ $subjudul }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                <form action="{{ $link }}/{{ $judul }}/cari/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                <div class="col-sm-5"><a href="{{ $link }}/{{ $judul }}/tambah/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}" class="btn btn-sm btn-outline-success">Tambah</a></div>
                <div class="col-sm-7">{{ $surat->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block mt-0">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                            <th width="5%" class="text-center">No</th>
                            <th width="15%" class="text-center">Nomor, Tanggal</th>
                            <th>Tentang</th>
                            <th width="10%" class="text-center">Status</th>
                            <th width="10%" class="text-center">Kegiatan</th>
                            <th width="5%" class="text-center">File</th>
                            <th width="5%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($surat->currentPage() - 1) * $surat->perPage() + 1;
                            ?>
                            @foreach($surat as $s)
                            <tr>
                                <td class="text-center align-middle">{{ $no++ }}</td>
                                <td class="text-center align-middle">{{ $s->nomor }}<br>{{ tanggal($s->tanggal) }}</td>
                                <td class="text-center align-middle">{{ $s->tentang }}</td>
                                <td class="text-center align-middle">{!! $s->status ? ($s->status == 'setuju' ? '<span class="text-success">'.$s->status.'</span>' :  '<span class="text-danger">'.$s->status.'</span>' ) : '<span class="text-info">verifikasi</span>' !!}</td>
                                <td class="text-center align-middle">
                                    @if($s->status == 'setuju')
                                    <a href="{{ $link }}/kegiatan/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ Crypt::encrypt($s->id) }}" class="btn btn-xs btn-outline-success" data-placement="bottom" data-toggle="tooltip" data-original-title="Daftar Kegiatan"><i class="fa fa-plane"></i> {{ Statistik::hitungKegiatan($s->id) }}</a>
                                    @endif
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ $link }}/{{ $judul }}/unduh/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{Crypt::encrypt($s->id)}}" class="btn btn-xs btn-outline-primary" data-placement="bottom" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a>
                                </td>
                                <td class="text-center align-middle">
                                    <a href="{{ $link }}/{{ $judul }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ Crypt::encrypt($s->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Lihat"><i class="fa fa-paste"></i></a>
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
            <small>Hal. ke : {{ $surat->currentPage() }} | Jumlah: <b class="text-success">{{ $surat->count() }}</b> / {{ $surat->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection