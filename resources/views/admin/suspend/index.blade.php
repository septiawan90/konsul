@extends('layouts.lte')

@section('content')
<div class="container">
    
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        @if($aksi)
                            <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                        @endif
                    </h5>
                    <div class="card-tools">
                        <form action="{{ $link }}/{{ $judul }}/cari" method="GET" class="form-inline ml-0 ml-md-3">
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
                        <div class="col-sm-7">{{ $suspend->links() }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            @if($message = Session::get('success'))
                            <div class="alert alert-success alert-block mt-0">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                {!! $message !!}
                            </div>
                            @endif
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th width="20%" class="text-center">NIK</th>
                                        <th width="25%" class="text-center">Email</th>
                                        <th width="15%" class="text-center">Tanggal</th>
                                        <th width="7%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                    $no = ($suspend->currentPage() - 1) * $suspend->perPage() + 1;
                                    @endphp

                                    @forelse($suspend as $s)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-center">{{ $s->nik }}</td>
                                        <td class="text-center">{{ $s->email }}</td>
                                        <td class="text-center">{{ tanggal($s->created_at) }} {{ date('H:i:s', strtotime($s->created_at)) }}</td>
                                        <td class="text-center">
                                            <form method="post" action="{{ $link }}/{{ $judul }}/kirim_ulang/{{ $s->id }}" onSubmit="return confirm('Anda yakin akan mengirim verifikasi ulang ke email {{ $s->email }} ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-xs btn-outline-info"><i class="fa fa-share-square"></i></button>
                                                <a href="{{ $link }}/{{ $judul }}/hapus/{{ Crypt::encrypt($s->id) }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Yakin hapus user {{ kapital($judul) }} {{ $s->nik }} {{ $s->email }} ini?')" data-placement="right" data-toggle="tooltip" data-original-title="Hapus"><i class="fas fa-ban"></i></a>
                                            </form>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <h5 class="card-title m-0">
                    <small>Hal. ke : {{ $suspend->currentPage() }} | Jumlah: <b class="text-success">{{ $suspend->count() }}</b> / {{ $suspend->total() }} Data</small>
                    </h5>
                    <!-- <a href="{{ $link }}/{{ $subjudul }}/sampah" class="btn btn-xs btn-outline-danger float-right" data-placement="left" data-toggle="tooltip" data-original-title="Data Sampah"><i class="fas fa-trash"></i></a> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection