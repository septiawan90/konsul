@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center disabled bg-warning">
            <h5 class="card-title m-0"><a href="{{ $link }}">
                <a href="{{ $link }}/aset">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($aset->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($aset->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($aset->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($aset->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                                <th width="13%" class="text-center">Tahun</th>
                                <th width="20%" class="text-center">Nama</th>
                                <th width="13%" class="text-center">Merk</th>
                                <th class="text-center">Kategori</th>
                                <th width="20%" class="text-center">Kode</th>
                                <th width="7%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($aset->currentPage() - 1) * $aset->perPage() + 1;
                            ?>
                            @foreach($aset as $a)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $a->tahun_perolehan }}</td>
                                <td>{{ $a->nama }}</td>
                                <td class="text-center">{{ $a->merk }}</td>
                                <td class="text-center">{{ $a->kategori }}</td>
                                <td class="text-center">{{ $a->kode_bmn }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                    <a href="{{ $link }}/{{ $judul }}/kembalikan/{{ Crypt::encrypt($a->id) }}" class="btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="Kembalikan"><i class="fa fa-recycle"></i></a>
                                    <a href="{{ $link }}/{{ $judul }}/hapus_permanen/{{ Crypt::encrypt($a->id) }}" class="btn btn-xs btn-danger" onclick="return confirm('Yakin hapus permanen aset {{ $a->nomor }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus Permanen"><i class="fa fa-trash-alt"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $aset->links() }}
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $aset->currentPage() }} | Jumlah: <b class="text-danger">{{ $aset->count() }}</b> / {{ $aset->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection