@extends('layouts.lte')

@section('content')
<div class="container">
    
    <div class="card">
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
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {{ csrf_field() }}
                    <form action="{{ $link }}/{{ $judul }}/telusur/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" method="GET">

                    <div class="row mb-3">
                        <div class="col-sm-4"></div>
                        <div class="col-sm-4">
                            <div class="input-group input-group-md">
                                <input type="text" class="form-control text-center {{ $errors->has('cari') ? 'is-invalid' : '' }}" name="cari" placeholder="Masukan 16 Digit NIK Pemohon .." value="{{ old('cari') }}" data-inputmask='"mask": "9999999999999999"' data-mask>
                                <span class="input-group-append">
                                    <input type="submit" class="btn {{ $errors->has('cari') ? 'btn-danger' : 'btn-info' }} btn-flat" value="Cari">
                                </span>
                            </div>
                            @if($errors->has('cari'))
                            <div class="text-danger text-center">
                                {{ $errors->first('cari')}}
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-4"></div>
                    </div>
                    </form>

                </div>
            </div>    
                    
        </div>
        <div class="card-footer text-center">
            
        </div>
    </div>
</div>
@endsection