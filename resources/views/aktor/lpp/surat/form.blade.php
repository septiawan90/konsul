@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        @if($aksi == 'ubah')
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data {{ kapital($judul) }} {{ $surat->nomor }} ini?')" enctype="multipart/form-data">
        @else
        <form method="post" action="{{ $form_action }}" enctype="multipart/form-data">
        @endif
        
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($kegiatan->id) }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                @if($aksi == 'ubah' || $aksi =='lihat')
                    <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $surat->created_at == $surat->updated_at ? 'Dibuat : '.lastUpdate($surat->created_at) : 'Diubah : '.lastUpdate($surat->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {{ csrf_field() }}
                    {{ $aksi == 'ubah' ? method_field('PUT') : '' }}

                    <div class="row mb-3">
                        <div class="col-sm-2">Nomor
                        @if($errors->has('nomor'))
                            <sup class="text-danger"><small>{{ $errors->first('nomor')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nomor .." value="{{ $surat->nomor }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="nomor" class="form-control {{ $errors->has('nomor') ? 'is-invalid' : 'is-warning' }}" placeholder="Nomor .." value="{{ old('nomor') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $surat->nomor }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="nomor" class="form-control {{ $errors->has('nomor') ? 'is-invalid' : 'is-warning' }}" placeholder="Nomor .." value="{{ $surat->nomor }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Tanggal
                        @if($errors->has('tanggal'))
                            <sup class="text-danger"><small>{{ $errors->first('tanggal')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tanggal .." value="{{ tanggal($surat->tanggal) }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="tanggal" class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : 'is-warning' }}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Tanggal .." value="{{ old('tanggal') }}" data-mask>
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ tanggal($surat->tanggal) }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="tanggal" class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : 'is-warning' }}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Tanggal .." value="{{ tanggal($surat->tanggal) }}" data-masurat>
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Tentang
                        @if($errors->has('tentang'))
                            <sup class="text-danger"><small>{{ $errors->first('tentang')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tentang .." value="{{ $surat->tentang }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="tentang" class="form-control {{ $errors->has('tentang') ? 'is-invalid' : 'is-warning' }}" placeholder="Tentang .." value="{{ old('tentang') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $surat->tentang }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="tentang" class="form-control {{ $errors->has('tentang') ? 'is-invalid' : 'is-warning' }}" placeholder="Tentang .." value="{{ $surat->tentang }}">
                        </div>
                        @endif
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-2">File
                        @if($errors->has('file'))
                            <sup class="text-danger"><small>{{ $errors->first('file')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><a href="{{ $link }}/{{ $judul }}/unduh/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ Crypt::encrypt($surat->id) }}" class="btn btn-sm btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="file" name="file" class="form-control-file {{ $errors->has('file') ? 'is-invalid' : 'is-warning' }}" value="{{ old('file') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><a href="{{ $link }}/{{ $judul }}/unduh/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ Crypt::encrypt($surat->id) }}" class="btn btn-sm btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a></div>
                        <div class="col-sm-6">
                            <input type="file" name="file" class="form-control-file {{ $errors->has('file') ? 'is-invalid' : 'is-warning' }}" value="{{ $surat->file }}">
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/{{ $judul }}/hapus/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ Crypt::encrypt($surat->id) }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Yakin hapus {{ kapital($judul) }} Nomor {{ $surat->nomor }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus"><i class="fa fa-trash-alt"></i></a>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/{{ $judul }}/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ Crypt::encrypt($surat->id) }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @elseif($aksi == 'tambah')
                        <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @else
                        <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                        <a href="{{ $link }}/{{ $judul }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ Crypt::encrypt($surat->id) }}" class="btn btn-sm btn-lihat">Kembali</a>    
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection