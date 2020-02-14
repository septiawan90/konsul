@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $user_id }}/{{ $profil_id }}">RIWAYAT {{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($pendidikan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($pendidikan->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($pendidikan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($pendidikan->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                <form action="{{ $link }}/cari/{{ $user_id }}/{{ $profil_id }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                <div class="col-sm-5"><a href="{{ $link }}/tambah/{{ $user_id }}/{{ $profil_id }}" class="btn btn-sm btn-outline-success">Tambah</a></div>
                <div class="col-sm-7">{{ $pendidikan->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    @if($message = Session::get('success'))
                        <div class="alert alert-success alert-block mt-0 mb-2">
                            <button type="button" class="close" data-dismiss="alert">×</button> 
                            {{ $message }}
                        </div>
                    @endif
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%" class="text-center">Tahun Lulus</th>
                                <th width="20%" class="text-center">Strata</th>
                                <th class="text-center">Institusi</th>
                                <th width="1%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = ($pendidikan->currentPage() - 1) * $pendidikan->perPage() + 1;
                            @endphp

                            @forelse($pendidikan as $row)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $row->thn_lulus }}</td>
                                <td class="text-center">{{ $row->strata->nama }}</td>
                                <td class="text-center">{{ $row->institusi }}</td>
                                <td class="text-center">
                                    <a href="{{ $link }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Lihat"><i class="fa fa-paste"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $pendidikan->currentPage() }} | Jumlah: <b class="text-success">{{ $pendidikan->count() }}</b> / {{ $pendidikan->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection