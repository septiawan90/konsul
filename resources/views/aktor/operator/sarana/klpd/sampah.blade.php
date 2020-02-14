@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center disabled bg-warning">
            <h5 class="card-title m-0"><a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> {{ $subjudul }}</h5>
            <div class="card-tools">
                <a href="{{ $link }}/{{ $judul }}/kembalikan_semua/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-xs btn-success pb-0 pt-0" onclick="return confirm('Anda yakin akan mengembalikan semua data sampah ini?')">Kembalikan Semua</a>
                <a href="{{ $link }}/{{ $judul }}/hapus_permanen_semua/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-xs btn-danger pb-0 pt-0" onclick="return confirm('Anda yakin akan menghapus permanen semua data sampah ini?')">Hapus Permanen Semua</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-5"><a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-sm btn-outline-lihat">Kembali</a></div>
                <div class="col-sm-7">{{ $klpd->links() }}</div>
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
                                <th width="10%" class="text-center">Kode</th>
                                <th class="text-center">Nama</th>
                                <th width="20%" class="text-center">Alias</th>
                                <th width="7%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($klpd->currentPage() - 1) * $klpd->perPage() + 1;
                            ?>
                            @foreach($klpd as $row)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $row->kode }}</td>
                                <td class="text-center">{{ $row->nama }}</td>
                                <td class="text-center">{{ $row->alias }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                    <a href="{{ $link }}/{{ $judul }}/kembalikan/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-success" onclick="return confirm('Anda yakin akan mengembalikan data sampah {{ $row->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Kembalikan"><i class="fa fa-recycle"></i></a>
                                    <a href="{{ $link }}/{{ $judul }}/hapus_permanen/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Anda yakin akan hapus permanen data sampah {{ $row->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus Permanen"><i class="fa fa-trash-alt"></i></a>
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
            <small>Hal. ke : {{ $klpd->currentPage() }} | Jumlah: <b class="text-danger">{{ $klpd->count() }}</b> / {{ $klpd->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection