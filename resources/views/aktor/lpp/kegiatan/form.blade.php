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
                <h5 class="card-title m-0"><a href="#">{{ strtoupper($subjudul) }}</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                @if($aksi == 'ubah')
                                <div class="col-sm-4">Kode</div>
                                <div class="col-sm-8">{{ $kegiatan->kode }}</div>
                                <div class="col-sm-4">Pendaftar</div>
                                <div class="col-sm-8">{{ Statistik::hitungPendaftar($kegiatan->id) }}</div>
                                @else
                                <div class="col-sm-4">Kegiatan</div>
                                <div class="col-sm-8">{{ $kegiatan->count() }}</div>
                                <div class="col-sm-4">Pendaftar</div>
                                <div class="col-sm-8">{{ Statistik::hitungPendaftarSurat($surat->id) }}</div>
                                @endif
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
        <!-- right -->
        <div class="col-lg-12">
            <div class="card">
                @if($aksi == 'ubah')
                <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data {{ kapital($subjudul) }} kode {{ $kegiatan->kode }} ini?')">
                @else
                <form method="post" action="{{ $form_action }}">
                @endif
                
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        @if($subsubjudul)
                            @if($aksi)
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subsubjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}'>{{ strtoupper($subsubjudul) }}</a>
                                <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                            @else
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
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
                    <div class="card-tools">
                        @if($aksi == 'ubah' || $aksi =='lihat')
                            <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $kegiatan->created_at == $kegiatan->updated_at ? 'Dibuat : '.lastUpdate($kegiatan->created_at) : 'Diubah : '.lastUpdate($kegiatan->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {{ csrf_field() }}
                            {{ $aksi == 'ubah' ? method_field('PUT') : '' }}

                            <div class="row mb-3">
                                <div class="col-sm-2">Tanggal
                                @if($errors->has('tanggal'))
                                    <sup class="text-danger"><small>{{ $errors->first('tanggal')}}</small></sup>
                                @endif
                                </div>
                                @if($aksi == 'lihat')
                                    <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tanggal .." value="{{ tanggal($kegiatan->tanggal) }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                <div class="col-sm-10">
                                    <input type="text" name="tanggal" class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : 'is-warning' }}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Tanggal .." value="{{ old('tanggal') }}" data-mask>
                                </div>
                                @else
                                <div class="col-sm-4"><input type="text" class="form-control" value="{{ tanggal($kegiatan->tanggal) }}" readonly></div>
                                <div class="col-sm-6">
                                    <input type="text" name="tanggal" class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : 'is-warning' }}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Tanggal .." value="{{ tanggal($kegiatan->tanggal) }}" data-mask>
                                </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Jam
                                @if($errors->has('jam'))
                                    <sup class="text-danger"><small>{{ $errors->first('jam')}}</small></sup>
                                @endif
                                </div>
                                @if($aksi == 'lihat')
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Jam .." value="{{ $kegiatan->jam }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                <div class="col-sm-10">
                                    <input type="text" name="jam" class="form-control {{ $errors->has('jam') ? 'is-invalid' : 'is-warning' }}" placeholder="Jam .." value="{{ old('jam') }}" data-inputmask="'mask': ['99:99:99', '99:99:99']" data-mask="" im-insert="true">
                                </div>
                                @else
                                <div class="col-sm-4"><input type="text" class="form-control" placeholder="Jam .." value="{{ $kegiatan->jam }}" readonly></div>
                                <div class="col-sm-6">
                                    <input type="text" name="jam" class="form-control {{ $errors->has('jam') ? 'is-invalid' : 'is-warning' }}" placeholder="Jam .." value="{{ $kegiatan->jam }}" data-inputmask="'mask': ['99:99:99', '99:99:99']" data-mask="" im-insert="true">
                                </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Kuota Peserta
                                @if($errors->has('kuota'))
                                    <sup class="text-danger"><small>{{ $errors->first('kuota')}}</small></sup>
                                @endif
                                </div>
                                @if($aksi == 'lihat')
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kuota .." value="{{ $kegiatan->kuota }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                <div class="col-sm-10">
                                    <input type="text" name="kuota" class="form-control {{ $errors->has('kuota') ? 'is-invalid' : 'is-warning' }}" placeholder="Kuota .." minlength="1" maxlength="3" value="{{ old('kuota') }}">
                                </div>
                                @else
                                <div class="col-sm-4"><input type="text" class="form-control" value="{{ $kegiatan->kuota }}" readonly></div>
                                <div class="col-sm-6">
                                    <input type="text" name="kuota" class="form-control {{ $errors->has('kuota') ? 'is-invalid' : 'is-warning' }}" placeholder="Kuota .." minlength="1" maxlength="3" value="{{ $kegiatan->kuota }}">
                                </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Sesi
                                @if($errors->has('sesi'))
                                    <sup class="text-danger"><small>{{ $errors->first('sesi')}}</small></sup>
                                @endif
                                </div>
                                @if($aksi == 'lihat')
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Sesi .." value="{{ $kegiatan->sesi }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                <div class="col-sm-10">
                                    <input type="text" name="sesi" class="form-control {{ $errors->has('sesi') ? 'is-invalid' : 'is-warning' }}" placeholder="Sesi .." value="{{ old('sesi') }}">
                                </div>
                                @else
                                <div class="col-sm-4"><input type="text" class="form-control" value="{{ $kegiatan->sesi }}" readonly></div>
                                <div class="col-sm-6">
                                    <input type="text" name="sesi" class="form-control {{ $errors->has('sesi') ? 'is-invalid' : 'is-warning' }}" placeholder="Sesi .." value="{{ $kegiatan->sesi }}">
                                </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Lokasi
                                @if($errors->has('venue_id'))
                                    <sup class="text-danger"><small>{{ $errors->first('venue_id')}}</small></sup>
                                @endif
                                </div>
                                @if($aksi == 'lihat')
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Venue .." value="{{ $kegiatan->venue->nama }} ({{ kapital($kegiatan->venue->kota->nama) }})" readonly></div>
                                @elseif($aksi == 'tambah')
                                <div class="col-sm-10">
                                    <select name="venue_id" class="form-control {{ $errors->has('venue_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">Pilih .. </option>
                                        @foreach($pilih as $p)
                                            <option value="{{ $p->id }}">{{ $p->nama}} ({{ kapital($p->kota) }})</option>
                                        @endforeach
                                    </select>
                                    @if(session()->has('message'))
                                        <div class="alert alert-info mt-2 mb-0 pt-1 pb-1">
                                            {!! session()->get('message') !!}
                                        </div>
                                    @endif
                                    <small>klik <a href="{{ $link }}/venue/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/tambah/foo1/foo2">disini</a> bila lokasi belum tersedia pada pilihan.</small>
                                </div>
                                @else
                                <div class="col-sm-4"><input type="text" class="form-control" value="{{ $kegiatan->venue->nama }} ({{ kapital($kegiatan->venue->kota->nama) }})" readonly></div>
                                <div class="col-sm-6">
                                    <select name="venue_id" class="form-control {{ $errors->has('venue_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">Pilih .. </option>
                                        @foreach($pilih as $p)
                                            <option value="{{ $p->id }}" {{ $kegiatan->venue_id == $p->id ? "selected" : "" }} >{{ $p->nama}} ({{ kapital($p->kota) }})</option>
                                        @endforeach
                                    </select>
                                    @if(session()->has('message'))
                                        <div class="alert alert-info mt-2 mb-0 pt-1 pb-1">
                                            {!! session()->get('message') !!}
                                        </div>
                                    @endif
                                    <small>klik <a href="{{ $link }}/venue/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/ubah/foo1/{{ $kegiatan_id }}">disini</a> bila lokasi belum tersedia pada pilihan.</small>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            @if($aksi == 'lihat' && Statistik::hitungPendaftar($kegiatan->id) == 0 )
                                <a href="{{ $link }}/{{ $subjudul }}/hapus/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Yakin hapus {{ kapital($subjudul) }} {{ $kegiatan->kode }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus"><i class="fa fa-trash-alt"></i></a>
                            @endif
                        </div>
                        <div class="col-sm-6 text-right">
                            @if($aksi == 'lihat')
                                <a href="{{ $link }}/{{ $subjudul }}/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                                <a href="{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                            @elseif($aksi == 'tambah')
                                <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                                <a href="{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                            @else
                                <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                                <a href="{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}" class="btn btn-sm btn-lihat">Kembali</a>
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