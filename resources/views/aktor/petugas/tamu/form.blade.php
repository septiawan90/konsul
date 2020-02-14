@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card">
                
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/cari">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    </h5>
                    <div class="card-tools"></div>
                </div>

                <div class="card-body">
                    <div class="row">
                    
                        <div class="col-sm-12"> 
                            <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin dengan data ini?')">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                                <div class="row mb-3">
                                    <div class="col-sm-2">NIK
                                    @if($errors->has('nik'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('nik')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="NIK .." value="{{ $tamu->nik }}" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" pattern="[0-9]+" name="nik" class="form-control {{ $errors->has('nik') ? 'is-invalid' : 'is-warning' }}" placeholder="NIK .." value="{{ $tamu->nik }}" minlength="16" maxlength="16" required autocomplete="nik" autofocus>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">NIP
                                    @if($errors->has('nip'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('nip')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="NIP .." value="{{ $tamu->nip }}" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" pattern="[0-9]+" name="nip" class="form-control {{ $errors->has('nip') ? 'is-invalid' : 'is-warning' }}" placeholder="NIP .." value="{{ $tamu->nip }}" minlength="18" maxlength="18" autocomplete="nip">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">Nama
                                    @if($errors->has('nama'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('nama')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="Nama lengkap tanpa gelar .." value="{{ $tamu->nama }}" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama Lengkap Tanpa Gelar .." value="{{ $tamu->nama }}" required autocomplete="nama">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">Email
                                    @if($errors->has('email'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('email')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="Email .." value="{{ $tamu->email }}" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-warning' }}" placeholder="Email .." value="{{ $tamu->email }}" required autocomplete="email">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-2">HP
                                    @if($errors->has('hp'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('hp')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="HP .." value="{{ $tamu->hp }}" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" pattern="[0-9]+" name="hp" class="form-control {{ $errors->has('hp') ? 'is-invalid' : 'is-warning' }}" placeholder="HP .." value="{{ $tamu->hp }}" required autocomplete="hp">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-2">Instansi
                                    @if($errors->has('instansi'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('instansi')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" class="form-control" placeholder="Instansi .." value="{{ $tamu->nik }}" readonly>
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" name="instansi" class="form-control {{ $errors->has('instansi') ? 'is-invalid' : 'is-warning' }}" placeholder="K/L/PD Tanpa Disingkat (Tidak termasuk Unit Kerja).." value="{{ $tamu->instansi }}" required autocomplete="instansi">
                                    </div>
                                </div>
                            </form>
                        </div>
                    
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6"><small>Direktorat Sertifikasi Profesi</small></div>
                        <div class="col-sm-6 text-right">
                            <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                            <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-sm btn-lihat">Kembali</a>    
                        </div>
                    </div>
                </div>
             </div> <!-- end card -->
        </div>
    </div>
</div>
@endsection