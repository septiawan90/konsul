@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="row">
        <!-- left -->
        <div class="col-sm-4">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">{{ strtoupper($judul) }}</a> <i class="fas fa-arrow-circle-right lihat"></i> <span class="lihat">Owner</span>
                    </h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">Owner</div>
                        <div class="col-sm-8">{{ isset($lpp->profil->nama) ? $lpp->profil->nama : "" }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">Email</div>
                        <div class="col-sm-8">{{ isset($lpp->profil->user->email) ? $lpp->profil->user->email : "" }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">HP</div>
                        <div class="col-sm-8">{{ isset($lpp->profil->hp) ? $lpp->profil->hp : "" }}</div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="card-title m-0"><a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">{{ strtoupper($judul) }}</a> <i class="fas fa-arrow-circle-right lihat"></i> <span class="lihat">Akreditasi</span></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-4">Nomor</div>
                        <div class="col-sm-8">???</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">Tanggal</div>
                        <div class="col-sm-8">???</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">Akreditasi</div>
                        <div class="col-sm-8">A/B/C</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4">Berlaku</div>
                        <div class="col-sm-8">tanggal kadaluarsa</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- right -->
        <div class="col-sm-8">
            <div class="card">
                <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data LPP ini?')" >
                
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        @if($subsubjudul)
                            @if($aksi)
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $lpp_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ $lpp_id }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                                <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                            @else
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $lpp_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                            @endif
                        @else
                            @if($subjudul)
                                @if($aksi)
                                    <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $judul }}/{{ $subjudul }}/{{ $lpp_id }}'>{{ strtoupper($subjudul) }}</a> 
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
                            <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $lpp->created_at == $lpp->updated_at ? 'Dibuat : '.lastUpdate($lpp->created_at) : 'Diubah : '.lastUpdate($lpp->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {{ csrf_field() }}
                            {{ $aksi == 'ubah' ? method_field('PUT') : '' }}

                            <div class="row mb-3">
                                <div class="col-sm-2">Owner
                                    @if($errors->has('profil_id'))
                                        <sup class="text-danger"><small>{{ $errors->first('profil_id')}}</small></sup>
                                    @endif
                                </div>
                                @if($aksi == 'lihat')
                                    <div class="col-sm-10"><input type="text" class="form-control" value="{{ isset($lpp->profil->user->nik) ? $lpp->profil->user->nik.' - '.kapital($lpp->profil->nama) : '' }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                    <div class="col-sm-10">
                                        {{ $owner->user->nik }} - {{ $owner->nama }}
                                    </div>
                                @else
                                    <div class="col-sm-4"><input type="text" class="form-control" value="{{ isset($lpp->profil->user->nik) ? kapital($lpp->profil->user->nik) : '' }}" readonly></div>
                                    <div class="col-sm-6">
                                        <select name="profil_id" class="form-control select2bs4 select2-hidden-accessible {{ $errors->has('profil_id') ? 'is-invalid' : 'is-warning' }}" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">Pilih .. </option>
                                        @foreach($owner as $row)
                                            <option value="{{ isset($row->profil->id) ? $row->profil->id : '' }}" {{ $lpp->profil_id == (isset($row->profil->id) ? $row->profil->id : '') ? "selected" : "" }} >{{ $row->nik }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Kode
                                    @if($errors->has('kode'))
                                        <sup class="text-danger"><small>{{ $errors->first('kode')}}</small></sup>
                                    @endif
                                </div>
                                @if($aksi == 'lihat')
                                    <div class="col-sm-10"><input type="text" class="form-control" value="{{ $lpp->kode }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                    <div class="col-sm-10">
                                        <input type="text" name="kode" class="form-control {{ $errors->has('kode') ? 'is-invalid' : 'is-warning' }}" placeholder="Kode .." value="{{ old('kode') }}">
                                    </div>
                                @else
                                    <div class="col-sm-4"><input type="text" class="form-control" value="{{ $lpp->kode }}" readonly></div>
                                    <div class="col-sm-6">
                                        <input type="text" name="kode" class="form-control {{ $errors->has('kode') ? 'is-invalid' : 'is-warning' }}" placeholder="Kode .." value="{{ $lpp->kode }}">
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Alias
                                    @if($errors->has('alias'))
                                        <sup class="text-danger"><small>{{ $errors->first('alias')}}</small></sup>
                                    @endif
                                </div>
                                @if($aksi == 'lihat')
                                    <div class="col-sm-10"><input type="text" class="form-control" value="{{ $lpp->alias }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                    <div class="col-sm-10">
                                        <input type="text" name="alias" class="form-control {{ $errors->has('alias') ? 'is-invalid' : 'is-warning' }}" placeholder="Alias .." value="{{ old('alias') }}">
                                    </div>
                                @else
                                    <div class="col-sm-4"><input type="text" class="form-control" value="{{ $lpp->alias }}" readonly></div>
                                    <div class="col-sm-6">
                                        <input type="text" name="alias" class="form-control {{ $errors->has('alias') ? 'is-invalid' : 'is-warning' }}" placeholder="Alias .." value="{{ $lpp->alias }}">
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
                                    <div class="col-sm-10"><input type="text" class="form-control" value="{{ $lpp->nama }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                    <div class="col-sm-10">
                                        <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ old('nama') }}">
                                    </div>
                                @else
                                    <div class="col-sm-4"><input type="text" class="form-control" value="{{ $lpp->nama }}" readonly></div>
                                    <div class="col-sm-6">
                                        <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ $lpp->nama }}">
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Telp
                                    @if($errors->has('telp'))
                                        <sup class="text-danger"><small>{{ $errors->first('telp')}}</small></sup>
                                    @endif
                                </div>
                                @if($aksi == 'lihat')
                                    <div class="col-sm-10"><input type="text" class="form-control" value="{{ $lpp->telp }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                    <div class="col-sm-10">
                                        <input type="text" name="telp" class="form-control {{ $errors->has('telp') ? 'is-invalid' : 'is-warning' }}" placeholder="Telp .." value="{{ old('telp') }}">
                                    </div>
                                @else
                                    <div class="col-sm-4"><input type="text" class="form-control" value="{{ $lpp->telp }}" readonly></div>
                                    <div class="col-sm-6">
                                        <input type="text" name="telp" class="form-control {{ $errors->has('telp') ? 'is-invalid' : 'is-warning' }}" placeholder="Telp .." value="{{ $lpp->telp }}">
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
                                    <div class="col-sm-10"><input type="text" class="form-control" value="{{ $lpp->email }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-warning' }}" placeholder="Email .." value="{{ old('email') }}">
                                    </div>
                                @else
                                    <div class="col-sm-4"><input type="text" class="form-control" value="{{ $lpp->email }}" readonly></div>
                                    <div class="col-sm-6">
                                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-warning' }}" placeholder="Email .." value="{{ $lpp->email }}">
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
                                    <div class="col-sm-10"><textarea row="4" class="form-control" readonly>{{ $lpp->alamat }}</textarea></div>
                                @elseif($aksi == 'tambah')
                                    <div class="col-sm-10">
                                        <textarea row="4" name="alamat" class="form-control {{ $errors->has('alamat') ? 'is-invalid' : 'is-warning' }}" placeholder="Alamat ..">{{ old('alamat') }}</textarea>
                                    </div>
                                @else
                                    <div class="col-sm-4"><textarea row="4" class="form-control" readonly>{{ $lpp->alamat }}</textarea></div>
                                    <div class="col-sm-6">
                                        <textarea row="4" name="alamat" class="form-control {{ $errors->has('alamat') ? 'is-invalid' : 'is-warning' }}" placeholder="Alamat ..">{{ $lpp->alamat }}</textarea>
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
                                    <div class="col-sm-10"><input type="text" class="form-control" value="{{ isset($lpp->kota->nama) ? kapital($lpp->kota->nama) : '' }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                    <div class="col-sm-10">
                                        <select name="kota_id" class="form-control select2bs4 select2-hidden-accessible {{ $errors->has('kota_id') ? 'is-invalid' : 'is-warning' }}" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="" selected>Pilih .. </option>
                                        @foreach($pilih as $p)
                                            <option value="{{ $p->id }}">{{ kapital($p->nama) }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="col-sm-4"><input type="text" class="form-control" value="{{ isset($lpp->kota->nama) ? kapital($lpp->kota->nama) : '' }}" readonly></div>
                                    <div class="col-sm-6">
                                        <select name="kota_id" class="form-control select2bs4 select2-hidden-accessible {{ $errors->has('kota_id') ? 'is-invalid' : 'is-warning' }}" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">Pilih .. </option>
                                        @foreach($pilih as $p)
                                            <option value="{{ $p->id }}" {{ $lpp->kota_id == $p->id ? "selected" : "" }} >{{ kapital($p->nama) }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Jenis
                                    @if($errors->has('jenis_id'))
                                        <sup class="text-danger"><small>{{ $errors->first('jenis_id')}}</small></sup>
                                    @endif
                                </div>
                                @if($aksi == 'lihat')
                                    <div class="col-sm-10"><input type="text" class="form-control" value="{{ isset($lpp->jenis->nama) ? kapital($lpp->jenis->nama) : '' }}" readonly></div>
                                @elseif($aksi == 'tambah')
                                    <div class="col-sm-10">
                                        <select name="jenis_id" class="form-control select2bs4 select2-hidden-accessible {{ $errors->has('jenis_id') ? 'is-invalid' : 'is-warning' }}" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">Pilih .. </option>
                                        @foreach($pilih2 as $j)
                                            <option value="{{ $j->id }}">{{ kapital($j->nama) }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                @else
                                    <div class="col-sm-4"><input type="text" class="form-control" value="{{ isset($lpp->jenis->nama) ? kapital($lpp->jenis->nama) : '' }}" readonly></div>
                                    <div class="col-sm-6">
                                        <select name="jenis_id" class="form-control select2bs4 select2-hidden-accessible {{ $errors->has('jenis_id') ? 'is-invalid' : 'is-warning' }}" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">Pilih .. </option>
                                        @foreach($pilih2 as $j)
                                            <option value="{{ $j->id }}" {{ $lpp->jenis_id == $j->id ? "selected" : "" }} >{{ kapital($j->nama) }}</option>
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
                                <!-- <a href="{{ $link }}/{{ $judul }}/hapus/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $lpp_id }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Anda yakin akan menghapus LPP ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus"><i class="fa fa-trash-alt"></i></a> -->
                            @endif
                        </div>
                        <div class="col-sm-6 text-right">
                            @if($aksi == 'lihat')
                                <a href="{{ $link }}/{{ $judul }}/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $lpp_id }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                                <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                            @elseif($aksi == 'tambah')
                                <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                                <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                            @else
                                <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                                <a href="{{ $link }}/{{ $judul }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $lpp_id }}" class="btn btn-sm btn-lihat">Kembali</a>    
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