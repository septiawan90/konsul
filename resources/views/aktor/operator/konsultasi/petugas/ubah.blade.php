@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            Petugas <strong>UBAH DATA</strong>
        </div>
        <div class="card-body">
            
            <form method="post" action="/petugas/update/{{ $petugas->id }}">

                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row mb-3">
                    <div class="col-sm-2">NIK</div>
                    <div class="col-sm-6">
                        <input type="text" name="nik" class="form-control" placeholder="No. KTP .." value="{{ $petugas->nik }}">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('nik'))
                            <div class="text-danger">
                                {{ $errors->first('nik')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2">NIP/NRP</div>
                    <div class="col-sm-6">
                        <input type="text" name="nip" class="form-control" placeholder="NIP/NRP .." value="{{ $petugas->nip }}">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('nip'))
                            <div class="text-danger">
                                {{ $errors->first('nip')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2">Nama</div>
                    <div class="col-sm-6">
                        <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Tanpa Gelar .." value="{{ $petugas->nama }}">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('nama'))
                            <div class="text-danger">
                                {{ $errors->first('nama')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2">Email</div>
                    <div class="col-sm-6">
                        <input type="text" name="email" class="form-control" placeholder="Email .." value="{{ $petugas->email }}">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('email'))
                            <div class="text-danger">
                                {{ $errors->first('email')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2">HP</div>
                    <div class="col-sm-6">
                        <input type="text" name="hp" class="form-control" placeholder="Nomor HP .." value="{{ $petugas->hp }}">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('hp'))
                            <div class="text-danger">
                                {{ $errors->first('hp')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <input type="submit" class="btn btn-sm btn-success" value="Simpan">
                        <a href="/petugas" class="btn btn-sm btn-primary">Kembali</a>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection