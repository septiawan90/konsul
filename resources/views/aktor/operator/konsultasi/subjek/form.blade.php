@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        @if($aksi == 'ubah')
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data {{ kapital($judul) }} {{ $subjek->nama }} ini?')">
        @else
        <form method="post" action="{{ $form_action }}">
        @endif
        
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($subjek->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($subjek->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($subjek->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($subjek->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                    <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $subjek->created_at == $subjek->updated_at ? 'Dibuat : '.lastUpdate($subjek->created_at) : 'Diubah : '.lastUpdate($subjek->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {{ csrf_field() }}
                    {{ $aksi == 'ubah' ? method_field('PUT') : '' }}

                    <div class="row mb-3">
                        <div class="col-sm-2">Kode
                        @if($errors->has('kode'))
                            <sup class="text-danger"><small>{{ $errors->first('kode')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tahun Perolehan .." value="{{ $subjek->kode }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="kode" class="form-control {{ $errors->has('kode') ? 'is-invalid' : 'is-warning' }}" placeholder="Tahun Perolehan .." value="{{ old('kode') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $subjek->kode }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="kode" class="form-control {{ $errors->has('kode') ? 'is-invalid' : 'is-warning' }}" placeholder="Tahun Perolehan .." value="{{ $subjek->kode }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Nama
                        @if($errors->has('nama'))
                            <sup class="text-danger"><small>{{ $errors->first('nama')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama .." value="{{ $subjek->nama }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ old('nama') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $subjek->nama }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ $subjek->nama }}">
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
                        <a href="{{ $link }}/{{ $judul }}/hapus/{{ Crypt::encrypt($subjek->id) }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Anda yakin akan hapus {{ kapital($judul) }} {{ $subjek->kode }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus"><i class="fa fa-trash-alt"></i></a>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/{{ $judul }}/ubah/{{ Crypt::encrypt($subjek->id) }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                        <a href="{{ $link }}/{{ $judul }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @elseif($aksi == 'tambah')
                        <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                        <a href="{{ $link }}/{{ $judul }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @else
                        <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                        <a href="{{ $link }}/{{ $judul }}/lihat/{{ Crypt::encrypt($subjek->id) }}" class="btn btn-sm btn-lihat">Kembali</a>    
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection