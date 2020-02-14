@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        @if($aksi == 'ubah')
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data Sertifikat {{ $tingkat_dasar->nomor }} ini?')" enctype="multipart/form-data">
        @else
        <form method="post" action="{{ $form_action }}" enctype="multipart/form-data">
        @endif
        
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($tingkat_dasar->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($tingkat_dasar->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($tingkat_dasar->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $judul }}/{{ $subjudul }}/{{ Crypt::encrypt($tingkat_dasar->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                    <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $tingkat_dasar->created_at == $tingkat_dasar->updated_at ? 'Dibuat : '.lastUpdate($tingkat_dasar->created_at) : 'Diubah : '.lastUpdate($tingkat_dasar->updated_at) }}"><i class="fas fa-info-circle"></i></a>
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
                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nomor .." value="{{ $tingkat_dasar->nomor }}" readonly></div>
                        @else
                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nomor .." value="{{ $tingkat_dasar->nomor }}" readonly></div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Seri
                        @if($errors->has('seri'))
                            <sup class="text-danger"><small>{{ $errors->first('seri')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Seri .." value="{{ $tingkat_dasar->seri }}" readonly></div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" placeholder="Seri .." value="{{ $tingkat_dasar->seri }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="seri" class="form-control {{ $errors->has('seri') ? 'is-invalid' : 'is-warning' }}" placeholder="Seri .." value="{{ $tingkat_dasar->seri }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">NIK
                        @if($errors->has('nik'))
                            <sup class="text-danger"><small>{{ $errors->first('nik')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="NIK .." value="{{ $tingkat_dasar->nik }}" readonly></div>
                        @else
                            <div class="col-sm-4"><input type="text" class="form-control" placeholder="NIK .." value="{{ $tingkat_dasar->nik }}" readonly></div>
                            <div class="col-sm-6">
                                <input type="text" name="nik" class="form-control {{ $errors->has('nik') ? 'is-invalid' : 'is-warning' }}" placeholder="NIK .." value="{{ $tingkat_dasar->nik }}">
                            </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">NIP
                        @if($errors->has('nip'))
                            <sup class="text-danger"><small>{{ $errors->first('nip')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="NIP .." value="{{ $tingkat_dasar->nip }}" readonly></div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" placeholder="NIP .." value="{{ $tingkat_dasar->nip }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="nip" class="form-control {{ $errors->has('nip') ? 'is-invalid' : 'is-warning' }}" placeholder="NIP .." value="{{ $tingkat_dasar->nip }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Email
                        @if($errors->has('email'))
                            <sup class="text-danger"><small>{{ $errors->first('email')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Email .." value="{{ $tingkat_dasar->email }}" readonly></div>
                        @else
                            <div class="col-sm-4"><input type="text" class="form-control" placeholder="Email .." value="{{ $tingkat_dasar->email }}" readonly></div>
                            <div class="col-sm-6">
                                <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-warning' }}" placeholder="Email .." value="{{ $tingkat_dasar->email }}">
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
                            @if($tingkat_dasar->file)
                                <div class="col-sm-10"><a href="{{ $link }}/unduh/{{ Crypt::encrypt($tingkat_dasar->id) }}" class="btn btn-sm btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a></div>
                            @endif
                        @else
                        <div class="col-sm-4">
                            @if($tingkat_dasar->file)
                            <a href="{{ $link }}/{{ $judul }}/unduh/{{ Crypt::encrypt($tingkat_dasar->id) }}" class="btn btn-sm btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a></div>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <input type="file" name="file" class="form-control-file {{ $errors->has('tentang') ? 'is-invalid' : 'is-warning' }}" value="{{ $tingkat_dasar->file }}">
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6 text-right">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/{{ $judul }}/ubah/{{ Crypt::encrypt($tingkat_dasar->id) }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                        <a href="{{ $link }}/{{ $judul }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @else
                        <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                        <a href="{{ $link }}/{{ $judul }}/lihat/{{ Crypt::encrypt($tingkat_dasar->id) }}" class="btn btn-sm btn-lihat">Kembali</a>    
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection