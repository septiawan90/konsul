@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        @if($aksi == 'ubah')
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data {{ kapital($judul) }} {{ $venue->nama }} ini?')">
        @else
        <form method="post" action="{{ $form_action }}">
        @endif
        
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($venue->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($venue->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($venue->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $judul }}/{{ $subjudul }}/{{ Crypt::encrypt($venue->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                    <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $venue->created_at == $venue->updated_at ? 'Dibuat : '.lastUpdate($venue->created_at) : 'Diubah : '.lastUpdate($venue->updated_at) }}"><i class="fas fa-info-circle"></i></a>
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
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode .." value="{{ $venue->kode }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="kode" class="form-control {{ $errors->has('kode') ? 'is-invalid' : 'is-warning' }}" placeholder="Kode .." value="{{ old('kode') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $venue->kode }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="kode" class="form-control {{ $errors->has('kode') ? 'is-invalid' : 'is-warning' }}" placeholder="Kode .." value="{{ $venue->kode }}">
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
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama .." value="{{ $venue->nama }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ old('nama') }}">
                        </div>
                        @else
                            <div class="col-sm-4"><input type="text" class="form-control" value="{{ $venue->nama }}" readonly></div>
                            <div class="col-sm-6">
                                <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ $venue->nama }}">
                            </div>
                        @endif                     
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Alamat
                        @if($errors->has('alamat'))
                                <sup class="text-danger"><small>{{ $errors->first('alamat')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Alamat .." value="{{ $venue->alamat }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="alamat" class="form-control {{ $errors->has('alamat') ? 'is-invalid' : 'is-warning' }}" placeholder="Alamat .." value="{{ old('alamat') }}">
                        </div>
                        @else
                            <div class="col-sm-4"><input type="text" class="form-control" value="{{ $venue->alamat }}" readonly></div>
                            <div class="col-sm-6">
                                <input type="text" name="alamat" class="form-control {{ $errors->has('alamat') ? 'is-invalid' : 'is-warning' }}" placeholder="Alamat .." value="{{ $venue->alamat }}">
                            </div>
                        @endif                     
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Kota
                        @if($errors->has('kota_id'))
                            <sup class="text-danger"><small>{{ $errors->first('kota_id')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kota .." value="{{ $venue->kota->nama }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <select name="kota_id" class="form-control {{ $errors->has('kota_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($pilih as $p)
                                    <option value="{{ $p->id }}">{{ kapital($p->nama) }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                            <div class="col-sm-4"><input type="text" class="form-control" value="{{ $venue->kota }}" readonly></div>
                            <div class="col-sm-6">
                                <select name="kota_id" class="form-control {{ $errors->has('kota_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                    <option value="">Pilih .. </option>
                                    @foreach($pilih as $p)
                                        <option value="{{ $p->id }}" {{ $venue->kota_id == $p->id ? "selected" : "" }} >{{ kapital($p->nama) }}</option>
                                    @endforeach
                                </select>
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
                        <a href="{{ $link }}/{{ $judul }}/hapus/{{ Crypt::encrypt($venue->id) }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Yakin hapus {{ kapital($judul) }} {{ $venue->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus"><i class="fa fa-trash-alt"></i></a>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/{{ $judul }}/ubah/{{ Crypt::encrypt($venue->id) }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                        <a href="{{ $link }}/{{ $judul }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @elseif($aksi == 'tambah')
                        <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                        <a href="{{ $link }}/{{ $judul }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @else
                        <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                        <a href="{{ $link }}/{{ $judul }}/lihat/{{ Crypt::encrypt($venue->id) }}" class="btn btn-sm btn-lihat">Kembali</a>    
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection