@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        
        @if($aksi == 'ubah')
        <form method="post" action="{{ route('users.update', $users->id) }}" onSubmit="return confirm('Anda yakin akan mengubah data Users {{ $users->nama }} ini?')">
        @else
        <form method="post" action="{{ route('users.store') }}">
        @endif
        
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($sk->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($sk->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($sk->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $judul }}/{{ $subjudul }}/{{ Crypt::encrypt($sk->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                    <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $users->created_at == $users->updated_at ? 'Dibuat : '.lastUpdate($users->created_at) : 'Diubah : '.lastUpdate($users->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {{ csrf_field() }}
                    {{ $aksi == 'ubah' ? method_field('PUT') : '' }}

                    <div class="row mb-3">
                        <div class="col-sm-2">Nama
                        @if($errors->has('nama'))
                            <sup class="text-danger"><small>{{ $errors->first('nama')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama .." value="{{ $users->profil->nama }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ old('nama') }}" required>
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $users->profil->nama }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama .." value="{{ $users->profil->nama }}" required>
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
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Email .." value="{{ $users->email }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-warning' }}" placeholder="Email .." value="{{ old('email') }}" required>
                        </div>
                        @else
                            <div class="col-sm-4"><input type="text" class="form-control" value="{{ $users->email }}" readonly></div>
                            <div class="col-sm-6">
                                <input type="text" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-warning' }}" placeholder="Email .." value="{{ $users->email }}">
                            </div>
                        @endif                     
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Password
                        @if($errors->has('password'))
                            <sup class="text-danger"><small>{{ $errors->first('password')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="password" class="form-control" placeholder="Password .." readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : 'is-warning' }}" placeholder="Password .." value="{{ old('password') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="password" class="form-control" readonly></div>
                        <div class="col-sm-6">
                            <input type="password" name="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : 'is-warning' }}" placeholder="Password .." value="{{ old('password') }}">
                            <small class="text-info">Biarkan kosong, jika tidak ingin mengganti password</small>
                        </div>
                        @endif
                    </div>

                    @if($aksi == 'tambah')
                    <div class="row mb-3">
                        <div class="col-sm-2">Role
                        @if($errors->has('role'))
                            <sup class="text-danger"><small>{{ $errors->first('role')}}</small></sup>
                        @endif
                        </div>
                        <div class="col-sm-10">
                            <select name="role" class="form-control {{ $errors->has('role') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih</option>
                                @foreach ($role as $row)
                                <option value="{{ $row->name }}">{{ $row->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                    
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    @if($aksi == 'lihat')
                    <form action="{{ route('users.destroy', $row->id) }}" method="POST" onSubmit="return confirm('Yakin hapus {{ kapital($judul) }} {{ $users->nama }} ini?')">
                        @csrf
                        <input type="hidden" name="_method" value="DELETE">
                        <button class="btn btn-outline-danger btn-xs"><i class="fa fa-trash"></i></button>
                    </form>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/ubah/{{ Crypt::encrypt($users->id) }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                        <a href="{{ $link }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @elseif($aksi == 'tambah')
                        <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                        <a href="{{ $link }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @else
                        <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                        <a href="{{ $link }}" class="btn btn-sm btn-lihat">Kembali</a>    
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection