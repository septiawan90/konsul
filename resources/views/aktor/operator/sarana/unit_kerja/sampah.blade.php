@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center disabled bg-warning">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($unit_kerja->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($unit_kerja->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($unit_kerja->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $judul }}/{{ $subjudul }}/{{ Crypt::encrypt($unit_kerja->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                <a href="{{ $link }}/{{ $judul }}/kembalikan_semua" class="btn btn-xs btn-success pb-0 pt-0">Kembalikan Semua</a>
                <a href="{{ $link }}/{{ $judul }}/hapus_permanen_semua" class="btn btn-xs btn-danger pb-0 pt-0">Hapus Permanen Semua</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <a href="{{ $link }}/{{ $judul }}" class="btn btn-sm btn-outline-primary">Kembali</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="10%" class="text-center">Kode</th>
                                <th class="text-center">Nama</th>
                                <th width="7%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($unit_kerja->currentPage() - 1) * $unit_kerja->perPage() + 1;
                            ?>
                            @foreach($unit_kerja as $d)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $d->kode }}</td>
                                <td class="text-center">{{ $d->nama }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                    <a href="{{ $link }}/{{ $judul }}/kembalikan/{{ Crypt::encrypt($d->id) }}" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="Kembalikan"><i class="fa fa-recycle"></i></a>
                                    <a href="{{ $link }}/{{ $judul }}/hapus_permanen/{{ Crypt::encrypt($d->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus permanen Unit Kerja {{ $d->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus Permanen"><i class="fa fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $unit_kerja->links() }}
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $unit_kerja->currentPage() }} | Jumlah: <b class="text-danger">{{ $unit_kerja->count() }}</b> / {{ $unit_kerja->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection