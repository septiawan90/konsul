@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center disabled bg-warning">
            <h5 class="card-title m-0"><a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> {{ $subjudul }}</h5>
            <div class="card-tools">
                <a href="{{ $link }}/{{ $judul }}/kembalikan_semua/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-xs btn-success pb-0 pt-0">Kembalikan Semua</a>
                <a href="{{ $link }}/{{ $judul }}/hapus_permanen_semua/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-xs btn-danger pb-0 pt-0">Hapus Permanen Semua</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-lg-12">
                    <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-sm btn-outline-primary">Kembali</a>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%" class="text-center">Nomor</th>
                                <th width="13%" class="text-center">Tanggal</th>
                                <th class="text-center">Tentang</th>
                                <th width="20%" class="text-center">Profesi</th>
                                <th width="13%" class="text-center">Kadaluarsa</th>
                                <th width="7%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = ($sk->currentPage() - 1) * $sk->perPage() + 1;
                            @endphp

                            @forelse($sk as $row)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-10">{{ $row->nomor }}</div>
                                        <div class="col-sm-2">@if($row->file)
                                            <a href="{{ $link }}/{{ $judul }}/unduh/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{Crypt::encrypt($row->id)}}" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a>
                                        @endif</div>
                                    </div>
                                </td>
                                <td class="text-center">{{ tanggal($row->tanggal) }}</td>
                                <td>{{ $row->tentang }}</td>
                                <td>{{ isset($row->profesi->nama) ? $row->profesi->nama : "" }}</td>
                                <td class="text-center">{{ tanggal($row->kadaluarsa) }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                    <a href="{{ $link }}/{{ $judul }}/kembalikan/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="Kembalikan"><i class="fa fa-recycle"></i></a>
                                    <a href="{{ $link }}/{{ $judul }}/hapus_permanen/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus permanen sk {{ $row->nomor }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus Permanen"><i class="fa fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $sk->links() }}
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $sk->currentPage() }} | Jumlah: <b class="text-danger">{{ $sk->count() }}</b> / {{ $sk->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection