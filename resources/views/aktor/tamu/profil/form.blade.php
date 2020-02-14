@extends('layouts.lte_tamu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <img src="{{ Storage::url('lkpp.png') }}" alt="lkpp" height="100">
            <div class="card">
                
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/cari">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    </h5>
                    <div class="card-tools"><a href="/" class="btn btn-xs btn-outline-info pb-0 pt-0 mt-0 mb-0">Kembali ke Halaman Utama</a></div>
                </div>

                <div class="card-body">
                    <div class="row">
                    
                        <div class="col-sm-12"> 
                            @if($aksi == 'tambah')
                            <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin dengan data ini?')">
                            {{ csrf_field() }}
                                <div class="row mb-3">
                                    <div class="col-sm-2">NIK
                                    @if($errors->has('nik'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('nik')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" pattern="[0-9]+" name="nik" class="form-control {{ $errors->has('nik') ? 'is-invalid' : 'is-warning' }}" placeholder="NIK .." value="{{ old('nik') }}" minlength="16" maxlength="16" required autocomplete="nik" autofocus>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">NIP
                                    @if($errors->has('nip'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('nip')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" pattern="[0-9]+" name="nip" class="form-control {{ $errors->has('nip') ? 'is-invalid' : 'is-warning' }}" placeholder="NIP .." value="{{ old('nip') }}" minlength="18" maxlength="18" autocomplete="nip">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">Nama
                                    @if($errors->has('nama'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('nama')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" name="nama" class="form-control {{ $errors->has('nama') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama Lengkap Tanpa Gelar .." value="{{ old('nama') }}" required autocomplete="nama">
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm-2">Email
                                    @if($errors->has('email'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('email')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="email" name="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-warning' }}" placeholder="Email .." value="{{ old('email') }}" required autocomplete="email">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-2">HP
                                    @if($errors->has('hp'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('hp')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" pattern="[0-9]+" name="hp" class="form-control {{ $errors->has('hp') ? 'is-invalid' : 'is-warning' }}" placeholder="HP .." value="{{ old('hp') }}" required autocomplete="hp">
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-2">Instansi
                                    @if($errors->has('instansi'))
                                        <br><sup class="text-danger"><small>{{ $errors->first('instansi')}}</small></sup>
                                    @endif
                                    </div>
                                    <div class="col-sm-10">
                                        <input type="text" name="instansi" class="form-control {{ $errors->has('instansi') ? 'is-invalid' : 'is-warning' }}" placeholder="K/L/PD Tanpa Disingkat (Tidak termasuk Unit Kerja).." value="{{ old('instansi') }}" required autocomplete="instansi">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10 text-right">
                                        <input type="submit" class="btn btn-sm btn-tambah" value="Simpan">
                                    </div>
                                </div>
                            </form>                        
                            @elseif($aksi == 'cari')
                            <div class="row">  
                                <div class="col-sm-8">

                                <form method="get" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan melanjutkan ?')" >
                                    <input type="text" pattern="[0-9]+" class="form-control @error('nik') is-invalid @enderror text-center" name="nik" value="{{ old('nik') }}" placeholder="Cari NIK Anda .. " minlength="16" maxlength="16" required autocomplete="nik" autofocus>
                                    @error('nik')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    @if($errors->has('cari'))
                                    <div class="text-danger">
                                        {{ $errors->first('cari')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-4"><input type="submit" class="btn btn-sm pt-2 pb-2 btn-block btn-success" value="CARI NIK"></div>
                                </form>

                                <div class="col-sm-12">
                                    @if($message = Session::get('success'))
                                    <div class="alert alert-warning alert-block mt-3">
                                        <button type="button" class="close" data-dismiss="alert">×</button> 
                                        {{ $message }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="row">  
                                <div class="col-sm-8">
                                <form method="get" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan melanjutkan ?')" >
                                    <input type="text" class="form-control @error('pin') is-invalid @enderror text-center" name="pin" value="{{ old('pin') }}" placeholder="4 Digit PIN dari Email .. " minlength="4" maxlength="4" required autocomplete="pin" autofocus>
                                    @error('pin')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror

                                    @if($errors->has('pin'))
                                    <div class="text-danger">
                                        {{ $errors->first('pin')}}
                                    </div>
                                    @endif
                                </div>
                                <div class="col-sm-4"><input type="submit" class="btn btn-sm pt-2 pb-2 btn-block btn-success" value="Kirim"></div>
                                </form>

                                <div class="col-sm-12">
                                    
                                    <div class="alert alert-warning alert-block mt-3">
                                        <button type="button" class="close" data-dismiss="alert">×</button> 
                                        Masukan 4 digit pin yang telah kami kirimkan ke kotak masuk email Anda.<br>Pin berlaku hanya 1 kali penggunaan.
                                        <br> Anda dapat kembali ke pencarian NIK dengan Klik <a href="/profil/cari" class="btn btn-xs btn-info">disini</a>.
                                    </div>
                                    
                                </div>

                            </div>
                            @endif
                        </div>
                    
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6"><small>Direktorat Sertifikasi Profesi</small></div>
                        <div class="col-sm-6 text-right"></div>
                    </div>
                </div>
             </div> <!-- end card -->
        </div>
    </div>
</div>
@endsection