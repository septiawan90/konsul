@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            Subjek <strong>TAMBAH DATA</strong>
        </div>
        <div class="card-body">
            <form method="post" action="/subjek/store">

                {{ csrf_field() }}
                <div class="row mb-3">
                    <div class="col-sm-2">Kode</div>
                    <div class="col-sm-6">
                        <input type="text" name="kode" class="form-control" placeholder="Kode ..">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('kode'))
                            <div class="text-danger">
                                {{ $errors->first('kode')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-sm-2">Subjek</div>
                    <div class="col-sm-6">
                        <input type="text" name="subjek" class="form-control" placeholder="Subjek ..">
                    </div>
                    <div class="col-sm-4">
                        @if($errors->has('subjek'))
                            <div class="text-danger">
                                {{ $errors->first('subjek')}}
                            </div>
                        @endif
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-2"></div>
                    <div class="col-sm-6">
                        <input type="submit" class="btn btn-sm btn-success" value="Simpan">
                        <a href="/subjek" class="btn btn-sm btn-primary">Kembali</a>
                    </div>
                    <div class="col-sm-4"></div>
                </div>
                
            </form>

        </div>
    </div>
</div>
@endsection