@extends('layouts.lte')

@section('content')
<div class="container">
    
    <div class="card">
        <div class="card-header text-center bg-warning">
            <h5 class="card-title m-0"><a href="{{ $link }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> {{ $subjudul }}</h5>
            <div class="card-tools">
                <a href="{{ $link }}/kembalikan_semua" class="btn btn-xs btn-success pb-0 pt-0">Kembalikan Semua</a>
                <a href="{{ $link }}/hapus_permanen_semua" class="btn btn-xs btn-danger pb-0 pt-0">Hapus Permanen Semua</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <a href="{{ $link }}" class="btn btn-sm btn-outline-primary">Kembali</a>
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
                                <th width="20%" class="text-center">Alamat</th>
                                <th class="text-center">Kontak</th>
                                <th width="7%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($lpp->currentPage() - 1) * $lpp->perPage() + 1;
                            ?>
                            @foreach($lpp as $p)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $p->kode }}</td>
                                <td>{{ $p->alias ? kapital($p->nama).' ('.$p->alias.')' : kapital($p->nama) }} {{ $p->jenis }}</td>
                                <td>{{ $p->alamat }} {{ isset($p->kota->nama) ? kapital($p->kota->nama) : "" }}</td>
                                <td>{{ $p->telp.' '.$p->email }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                    <a href="{{ $link }}/kembalikan/{{ Crypt::encrypt($p->id) }}" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="Kembalikan"><i class="fa fa-recycle"></i></a>
                                    <a href="{{ $link }}/hapus_permanen/{{ Crypt::encrypt($p->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus permanen {{ kapital($judul) }} {{ $p->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus Permanen"><i class="fa fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $lpp->links() }}
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $lpp->currentPage() }} | Jumlah: <b class="text-danger">{{ $lpp->count() }}</b> / {{ $lpp->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection