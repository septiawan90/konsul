@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center disabled bg-warning">
            <h5 class="card-title m-0"><a href="{{ $link }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> {{ $subjudul }}</h5>
            <div class="card-tools">
                <a href="{{ $link }}/kembalikan_semua" class="btn btn-xs btn-success pb-0 pt-0">Kembalikan Semua</a>
                <a href="{{ $link }}/hapus_permanen_semua" class="btn btn-xs btn-danger pb-0 pt-0">Hapus Permanen Semua</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-5"><a href="{{ $link }}" class="btn btn-sm btn-outline-lihat">Kembali</a></div>
                <div class="col-sm-7">{{ $jenis->links() }}</div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="10%" class="text-center">Kode</th>
                                <th class="text-center">Nama</th>
                                <th width="20%" class="text-center">Fungsi</th>
                                <th width="7%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($jenis->currentPage() - 1) * $jenis->perPage() + 1;
                            ?>
                            @foreach($jenis as $f)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $f->kode }}</td>
                                <td class="text-center">{{ $f->nama }}</td>
                                <td class="text-center">{{ $f->fungsi }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                    <a href="{{ $link }}/kembalikan/{{ Crypt::encrypt($f->id) }}" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="Kembalikan"><i class="fa fa-recycle"></i></a>
                                    <a href="{{ $link }}/hapus_permanen/{{ Crypt::encrypt($f->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus permanen {{ $judul }} {{ $f->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus Permanen"><i class="fa fa-trash-alt"></i></a>
                                    </div>
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
            <small>Hal. ke : {{ $jenis->currentPage() }} | Jumlah: <b class="text-danger">{{ $jenis->count() }}</b> / {{ $jenis->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection