@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        @if($aksi == 'ubah')
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data SK {{ $sk->nomor }} ini?')" enctype="multipart/form-data">
        @else
        <form method="post" action="{{ $form_action }}" enctype="multipart/form-data">
        @endif
        
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}'>{{ strtoupper($subjudul) }}</a> 
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
                    <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $sk->created_at == $sk->updated_at ? 'Dibuat : '.lastUpdate($sk->created_at) : 'Diubah : '.lastUpdate($sk->updated_at) }}"><i class="fas fa-info-circle"></i></a>
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
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nomor .." value="{{ $sk->nomor }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="nomor" class="form-control {{ $errors->has('nomor') ? 'is-invalid' : 'is-warning' }}" placeholder="Nomor .." value="{{ old('nomor') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $sk->nomor }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="nomor" class="form-control {{ $errors->has('nomor') ? 'is-invalid' : 'is-warning' }}" placeholder="Nomor .." value="{{ $sk->nomor }}">
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
                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tanggal .." value="{{ tanggal($sk->tanggal) }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="tanggal" class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : 'is-warning' }}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Tanggal .." value="{{ old('tanggal') }}" data-mask>
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ tanggal($sk->tanggal) }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="tanggal" class="form-control {{ $errors->has('tanggal') ? 'is-invalid' : 'is-warning' }}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Tanggal .." value="{{ tanggal($sk->tanggal) }}" data-mask>
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
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tentang .." value="{{ $sk->tentang }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="tentang" class="form-control {{ $errors->has('tentang') ? 'is-invalid' : 'is-warning' }}" placeholder="Tentang .." value="{{ old('tentang') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $sk->tentang }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="tentang" class="form-control {{ $errors->has('tentang') ? 'is-invalid' : 'is-warning' }}" placeholder="Tentang .." value="{{ $sk->tentang }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Kadaluarsa
                        @if($errors->has('kadaluarsa'))
                            <sup class="text-danger"><small>{{ $errors->first('kadaluarsa')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                            <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kadaluarsa .." value="{{ tanggal($sk->kadaluarsa) }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="kadaluarsa" class="form-control {{ $errors->has('kadaluarsa') ? 'is-invalid' : 'is-warning' }}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Kadaluarsa .." value="{{ old('kadaluarsa') }}" data-mask>
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ tanggal($sk->kadaluarsa) }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="kadaluarsa" class="form-control {{ $errors->has('kadaluarsa') ? 'is-invalid' : 'is-warning' }}" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Kadaluarsa .." value="{{ tanggal($sk->kadaluarsa) }}" data-mask>
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Role
                        @if($errors->has('role_id'))
                            <sup class="text-danger"><small>{{ $errors->first('role_id')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Role .." value="{{ $sk->role->name }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <select name="role_id" class="form-control {{ $errors->has('role_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($role as $p)
                                    <option value="{{ $p->id }}">{{ $p->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $sk->role->name }}" readonly></div>
                        <div class="col-sm-6">
                            <select name="role_id" class="form-control {{ $errors->has('role_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($role as $p)
                                    <option value="{{ $p->id }}" {{ $sk->role_id == $p->id ? "selected" : "" }} >{{ $p->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        @php $akre = array('A', 'B', 'C'); @endphp
                        <div class="col-sm-2">Akreditasi
                        @if($errors->has('akreditasi'))
                            <sup class="text-danger"><small>{{ $errors->first('akreditasi')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="LPP/Pelaksana Ujian .." value="{{ $sk->akreditasi }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <select name="akreditasi" class="form-control {{ $errors->has('akreditasi') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($akre as $akreditasi)
                                    <option value="{{ $akreditasi }}">{{ $akreditasi}}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" placeholder="LPP/Pelaksana Ujian .." value="{{ $sk->akreditasi }}" readonly></div>
                        <div class="col-sm-6">
                            <select name="akreditasi" class="form-control {{ $errors->has('akreditasi') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($akre as $akreditasi)
                                    <option value="{{ $akreditasi }}" {{ $sk->akreditasi == $akreditasi ? "selected" : "" }} >{{ $akreditasi}}</option>
                                @endforeach
                            </select>
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
                        <div class="col-sm-10"><a href="{{ $link }}/{{ $judul }}/unduh/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}" class="btn btn-sm btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="file" name="file" class="form-control-file {{ $errors->has('file') ? 'is-invalid' : 'is-warning' }}" value="{{ old('file') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><a href="{{ $link }}/{{ $judul }}/unduh/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}" class="btn btn-sm btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a></div>
                        <div class="col-sm-6">
                            <input type="file" name="file" class="form-control-file {{ $errors->has('file') ? 'is-invalid' : 'is-warning' }}" value="{{ $sk->file }}">
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
                        <a href="{{ $link }}/{{ $judul }}/hapus/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Yakin hapus {{ kapital($judul) }} {{ $sk->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus"><i class="fa fa-trash-alt"></i></a>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/{{ $judul }}/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @elseif($aksi == 'tambah')
                        <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @else
                        <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                        <a href="{{ $link }}/{{ $judul }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}" class="btn btn-sm btn-lihat">Kembali</a>    
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection