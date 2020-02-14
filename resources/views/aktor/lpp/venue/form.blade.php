@extends('layouts.lte')

@section('content')
<div class="container">
    <!-- top -->
    <div class="row">
        <!-- left -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header text-center">
                <h5 class="card-title m-0"><a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}">SURAT</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2">LPP</div>
                                <div class="col-sm-10">{{ $surat->lpp->nama }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">Nomor</div>
                                <div class="col-sm-8">{{ $surat->nomor }}</div>
                                <div class="col-sm-4">Hari, Tanggal</div>
                                <div class="col-sm-8">{{ hari($surat->tanggal) }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12">Tentang : <br>{{ $surat->tentang }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end left -->
        <!-- right  -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center">
                <h5 class="card-title m-0"><a href="#">JUMLAH</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4">Kegiatan</div>
                                <div class="col-sm-8">{{ $kegiatan->count() }}</div>
                                <div class="col-sm-4">Pendaftar</div>
                                <div class="col-sm-8">{{ Statistik::hitungPendaftarSurat($surat->id) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end right -->
    </div>
    <!-- end top -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">

                <form method="post" action="{{ $form_action }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $aksi }}/{{ Crypt::encrypt($venue->id) }}/{{ $kegiatan_id }}" onSubmit="return confirm('Anda yakin akan menambah data {{ kapital($subsubjudul) }} ini?')">

                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        @if($subsubjudul)
                            @if($aksi)
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                                <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                            @else
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                            @endif
                        @else
                            @if($subjudul)
                                @if($aksi)
                                    <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}'>{{ strtoupper($subjudul) }}</a> 
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
                    <div class="card-tools"></div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="row mb-3">
                                <div class="col-sm-2">Nama
                                @if($errors->has('nama'))
                                        <sup class="text-danger"><small>{{ $errors->first('nama')}}</small></sup>
                                @endif
                                </div>
                                <div class="col-sm-4"><input type="text" class="form-control" value="{{ $venue->nama }}" readonly></div>
                                <div class="col-sm-6">
                                    <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ $venue->nama }}">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Alamat
                                @if($errors->has('alamat'))
                                    <sup class="text-danger"><small>{{ $errors->first('alamat')}}</small></sup>
                                @endif
                                </div>
                                <div class="col-sm-4"><input type="text" class="form-control" value="{{ $venue->alamat }}" readonly></div>
                                <div class="col-sm-6">
                                    <input type="text" name="alamat" class="form-control {{ $errors->has('alamat') ? 'is-invalid' : 'is-warning' }}" placeholder="Alamat .." value="{{ $venue->alamat }}">
                                </div>                 
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Kota
                                @if($errors->has('kota_id'))
                                    <sup class="text-danger"><small>{{ $errors->first('kota_id')}}</small></sup>
                                @endif
                                </div>
                                <div class="col-sm-4"><input type="text" class="form-control" value="{{ $venue->kota }}" readonly></div>
                                <div class="col-sm-6">
                                    <select name="kota_id" class="form-control {{ $errors->has('kota_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">Pilih .. </option>
                                        @foreach($pilih as $p)
                                            <option value="{{ $p->id }}" {{ $venue->kota_id == $p->id ? "selected" : "" }} >{{ kapital($p->nama) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6 text-right">
                            <input type="submit" class="btn btn-sm btn-tambah" value="Simpan">
                            @if($aksi == "tambah")
                                <a href="{{ $link }}/{{ $subjudul }}/tambah/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                            @else
                                <a href="{{ $link }}/{{ $subjudul }}/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                            @endif
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection