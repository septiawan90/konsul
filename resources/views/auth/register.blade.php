@extends('layouts.lte_tamu')

@section('content')

<style type="text/css">
#bg {
    position: fixed; 
    top: 0; 
    left: 0; 
        
    /* Preserve aspet ratio */
    min-width: 100%;
    min-height: 100%;
}
</style>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <img src="{{ Storage::url('lkpp.png') }}" alt="lkpp" height="100">

            <div class="card">
                <div class="card-header bg-success">{{ __('SERTIFIKASI PROFESI') }} <span class="float-right">{{ __('Buat Akun') }}</span></div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" onSubmit="return confirm('Bersama ini Saya menyatakan bahwa NIK dan Email adalah benar dan dapat dipertanggung jawabkan.\n\nPastikan email Anda benar dan aktif untuk mendapatkan tautan aktivasi yang akan Kami kirimkan ke email Anda. Terima Kasih.')">
                        @csrf

                            @if(session()->has('message'))
                            <div class="form-group row">
                                <div class="col-md-12 alert alert-success">
                                {{ session()->get('message') }}
                                </div>
                            </div>
                            @endif

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-8 text-center">
                                            <h1><i class="fa fa-envelope-open-text fa-2x text-muted"></i></h1>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('NIK') }}</label>

                                        <div class="col-md-8">
                                            <input id="nik" type="text" class="form-control @error('nik') is-invalid @enderror" name="nik" value="{{ old('nik') }}" placeholder="16 digit .." minlength="16" maxlength="16" required autocomplete="nik" autofocus onkeypress="return isNumber(event)">

                                            @error('nik')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="nik-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Konfirmasi NIK') }}</label>

                                        <div class="col-md-8">
                                            <input id="nik-confirm" type="text" class="form-control" name="nik_confirmation" value="{{ old('nik-confirm') }}" placeholder="Sesuaikan kembali dengan isian NIK .." onPaste="return false" minlength="16" maxlength="16" required autocomplete="new-nik" onkeypress="return isNumber(event)">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                                        <div class="col-md-8">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Pastikan email Anda benar dan aktif .." required autocomplete="email">

                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="email-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Konfirmasi Email') }}</label>

                                        <div class="col-md-8">
                                            <input id="email-confirm" type="email" class="form-control" name="email_confirmation" value="{{ old('email-confirm') }}" placeholder="Sesuaikan kembali dengan isian email .." onPaste="return false"  required autocomplete="new-email">
                                        </div>
                                    </div>
                                </div>
                                <!-- right column -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-4">
                                        </div>
                                        <div class="col-md-8 text-center">
                                            <h1><i class="fa fa-user-lock fa-2x text-muted"></i></h1>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Password') }}</label>

                                        <div class="col-md-8">
                                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Minimal 8 karakter .." required autocomplete="new-password">

                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Konfirmasi Password') }}</label>

                                        <div class="col-md-8">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Sesuaikan kembali dengan isian password .." required autocomplete="new-password">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-block btn-success">
                                                {{ __('Buat Akun') }}
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="card-footer">
                        
                        <a class="btn btn-xs btn-outline-info" href="{{ url('/') }}"> {{ __('Halaman Utama') }}</a>
                        <a class="btn btn-xs btn-outline-primary" href="{{ route('login') }}"> {{ __('Masuk') }}</a>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
}
        return true;
}
</script>