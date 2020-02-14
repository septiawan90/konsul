@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            LPP <strong>UBAH DATA</strong>
        </div>
        <div class="card-body">
            <form method="post" action="/lpp/update/{{ $lpp->id }}">

                {{ csrf_field() }}
                {{ method_field('PUT') }}

                <div class="row mb-2">
                    <div class="col-sm-2">
                        Kode
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="kode" class="form-control" placeholder="Kode .." value="{{ $lpp->kode }}">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('kode'))
                            <div class="text-danger">
                                {{ $errors->first('kode')}}
                            </div>
                        @endif
                    </div>                        
                </div>

                <div class="row mb-2">
                    <div class="col-sm-2">
                        Alias
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="alias" class="form-control" placeholder="Alias .." value="{{ $lpp->alias }}">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('alias'))
                            <div class="text-danger">
                                {{ $errors->first('alias')}}
                            </div>
                        @endif
                    </div>                        
                </div>

                <div class="row mb-2">
                    <div class="col-sm-2">
                        Nama
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="nama" class="form-control" placeholder="Nama .." value="{{ $lpp->nama }}">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('nama'))
                            <div class="text-danger">
                                {{ $errors->first('nama')}}
                            </div>
                        @endif
                    </div>                        
                </div>

                <div class="row mb-2">
                    <div class="col-sm-2">
                        Alamat
                    </div>
                    <div class="col-sm-6">
                        <input type="text" name="alamat" class="form-control" placeholder="Alamat tanpa disingkat .." value="{{ $lpp->alamat }}">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('alamat'))
                            <div class="text-danger">
                                {{ $errors->first('alamat')}}
                            </div>
                        @endif
                    </div>                        
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2">Kota</div>
                    <div class="col-sm-6">
                        <select name="kota_id" class="form-control">
                             <option value="">Pilih .. </option>
                            @foreach($kota as $k)
                                <option value="{{ $k->id }}" {{ $lpp->kota_id ==  $k->id ? "selected" : "" }}>{{ kapital($k->nama) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('kota_id'))
                            <div class="text-danger">
                                {{ $errors->first('kota_id')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-2">
                    </div>
                    <div class="col-sm-6">
                        <input type="submit" class="btn btn-sm btn-success" value="Simpan">
                        <a href="/lpp" class="btn btn-sm btn-primary">Kembali</a>
                    </div>
                    <div class="col-sm-4">
                        
                    </div>                        
                </div>
            </form>
        </div>
    </div>
</div>
@endsection