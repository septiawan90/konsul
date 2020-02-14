@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($tingkat_dasar->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($tingkat_dasar->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($tingkat_dasar->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $judul }}/{{ $subjudul }}/{{ Crypt::encrypt($tingkat_dasar->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                <!-- <div class="col-sm-5"><a href="{{ $link }}/tambah" class="btn btn-sm btn-outline-success">Tambah</a></div> -->
                <div class="col-sm-12">{{ $tingkat_dasar->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    @if($message = Session::get('sukses'))
                    <div class="alert alert-success alert-block mt-0">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="15%" class="text-center">Seri Blanko</th>
                                <th class="text-center">Nomor Sertifikat</th>
                                <th width="15%" class="text-center">NIK</th>
                                <th width="15%" class="text-center">NIP</th>
                                <th width="15%" class="text-center">Email</th>
                                <th width="5%" class="text-center">File</th>
                                <th width="5%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($tingkat_dasar->currentPage() - 1) * $tingkat_dasar->perPage() + 1;
                            ?>
                            @foreach($tingkat_dasar as $td)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $td->seri }}</td>
                                <td class="text-center">{{ $td->nomor }}</td>
                                <td class="text-center">{{ $td->nik }}</td>
                                <td class="text-center">{{ $td->nip }}</td>
                                <td class="text-center">{{ $td->email }}</td>
                                <td class="text-center">
                                    @if($td->file)
                                    <a href="{{ $link }}/{{ $judul }}/unduh/{{Crypt::encrypt($td->id)}}" class="btn btn-sm btn-success">Unduh</a>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ $link }}/{{ $judul }}/lihat/{{ Crypt::encrypt($td->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Lihat"><i class="fa fa-paste"></i></a>
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
            <small>Hal. ke : {{ $tingkat_dasar->currentPage() }} | Jumlah: <b class="text-success">{{ $tingkat_dasar->count() }}</b> / {{ number_format($tingkat_dasar->total(), 0,",",".") }} Data</small>
            </h5>
            <!-- <a href="{{ $link }}/sampah" class="btn btn-xs btn-outline-danger float-right" data-placement="left" data-toggle="tooltip" data-original-title="Data Sampah"><i class="fas fa-trash"></i></a> -->
        </div>
    </div>
</div>
@endsection