@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        @if($aksi == 'ubah')
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data {{ kapital($judul) }} {{ $aset->tahun_perolehan }} ini?')" enctype="multipart/form-data">
        @else
        <form method="post" action="{{ $form_action }}" enctype="multipart/form-data">
        @endif
        
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
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
                @if($aksi == 'ubah' || $aksi =='lihat')
                    <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $aset->created_at == $aset->updated_at ? 'Dibuat : '.lastUpdate($aset->created_at) : 'Diubah : '.lastUpdate($aset->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {{ csrf_field() }}
                    {{ $aksi == 'ubah' ? method_field('PUT') : '' }}

                    <div class="row mb-3">
                        <div class="col-sm-2">Tahun Perolehan
                        @if($errors->has('tahun_perolehan'))
                            <sup class="text-danger"><small>{{ $errors->first('tahun_perolehan')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tahun Perolehan .." value="{{ $aset->tahun_perolehan }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="tahun_perolehan" class="form-control {{ $errors->has('tahun_perolehan') ? 'is-invalid' : 'is-warning' }}" placeholder="Tahun Perolehan .." value="{{ old('tahun_perolehan') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $aset->tahun_perolehan }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="tahun_perolehan" class="form-control {{ $errors->has('tahun_perolehan') ? 'is-invalid' : 'is-warning' }}" placeholder="Tahun Perolehan .." value="{{ $aset->tahun_perolehan }}">
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
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama .." value="{{ $aset->nama }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ old('nama') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $aset->nama }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ $aset->nama }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Merk
                        @if($errors->has('merk'))
                            <sup class="text-danger"><small>{{ $errors->first('merk')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Merk .." value="{{ $aset->merk }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="merk" class="form-control {{ $errors->has('merk') ? 'is-invalid' : 'is-warning' }}" placeholder="Merk .." value="{{ old('merk') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $aset->merk }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="merk" class="form-control {{ $errors->has('merk') ? 'is-invalid' : 'is-warning' }}" placeholder="Merk .." value="{{ $aset->merk }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Kategori
                        @if($errors->has('kategori'))
                            <sup class="text-danger"><small>{{ $errors->first('kategori')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kategori .." value="{{ $aset->kategori }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : 'is-warning' }}" placeholder="Kategori .." value="{{ old('kategori') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $aset->kategori }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : 'is-warning' }}" placeholder="Kategori .." value="{{ $aset->kategori }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Kode BMN
                        @if($errors->has('kode_bmn'))
                            <sup class="text-danger"><small>{{ $errors->first('kode_bmn')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode BMN .." value="{{ $aset->kode_bmn }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="kode_bmn" class="form-control {{ $errors->has('kode_bmn') ? 'is-invalid' : 'is-warning' }}" placeholder="Kode BMN .." value="{{ old('kode_bmn') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $aset->kode_bmn }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="kode_bmn" class="form-control {{ $errors->has('kode_bmn') ? 'is-invalid' : 'is-warning' }}" placeholder="Kode BMN .." value="{{ $aset->kode_bmn }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Nomor Urut
                        @if($errors->has('nomor_urut'))
                            <sup class="text-danger"><small>{{ $errors->first('nomor_urut')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nomor Urut .." value="{{ $aset->nomor_urut }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="nomor_urut" class="form-control {{ $errors->has('nomor_urut') ? 'is-invalid' : 'is-warning' }}" placeholder="Nomor Urut .." value="{{ old('nomor_urut') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $aset->nomor_urut }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="nomor_urut" class="form-control {{ $errors->has('nomor_urut') ? 'is-invalid' : 'is-warning' }}" placeholder="Nomor Urut .." value="{{ $aset->nomor_urut }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Kode Satker
                        @if($errors->has('kode_satker'))
                            <sup class="text-danger"><small>{{ $errors->first('kode_satker')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode Satker .." value="{{ $aset->kode_satker }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="kode_satker" class="form-control {{ $errors->has('kode_satker') ? 'is-invalid' : 'is-warning' }}" placeholder="Kode Satker .." value="{{ old('kode_satker') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $aset->kode_satker }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="kode_satker" class="form-control {{ $errors->has('kode_satker') ? 'is-invalid' : 'is-warning' }}" placeholder="Kode Satker .." value="{{ $aset->kode_satker }}">
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
                        <div class="col-sm-10"><a href="{{ $link }}/{{ $judul }}/unduh/{{ Crypt::encrypt($aset->id) }}" class="btn btn-sm btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="file" name="file" class="form-control-file {{ $errors->has('file') ? 'is-invalid' : 'is-warning' }}" value="{{ old('file') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><a href="{{ $link }}/{{ $judul }}/unduh/{{ Crypt::encrypt($aset->id) }}" class="btn btn-sm btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a></div>
                        <div class="col-sm-6">
                            <input type="file" name="file" class="form-control-file {{ $errors->has('file') ? 'is-invalid' : 'is-warning' }}" value="{{ $aset->file }}">
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
                        <a href="{{ $link }}/{{ $judul }}/hapus/{{ Crypt::encrypt($aset->id) }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Yakin hapus {{ kapital($judul) }} {{ $aset->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus"><i class="fa fa-trash-alt"></i></a>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/{{ $judul }}/ubah/{{ Crypt::encrypt($aset->id) }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                        <a href="{{ $link }}/{{ $judul }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @elseif($aksi == 'tambah')
                        <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                        <a href="{{ $link }}/{{ $judul }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @else
                        <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                        <a href="{{ $link }}/{{ $judul }}/lihat/{{ Crypt::encrypt($aset->id) }}" class="btn btn-sm btn-lihat">Kembali</a>    
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection