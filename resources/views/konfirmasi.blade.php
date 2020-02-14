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
                <div class="card-header">{{ __('Lengkapi data diri Anda di bawah ini ...') }}</div>
                    <div class="card-body">
                        <form method="POST" action="/konfirmasi/update/{{ Crypt::encrypt($user_id) }}" onSubmit="return confirm('Bersama ini Saya menyatakan bahwa data tersebut adalah benar dan dapat dipertanggung jawabkan.')">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

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
                                        <label for="nama" class="col-md-4 col-form-label text-md-right">{{ __('Nama') }}</label>

                                        <div class="col-md-8">
                                            <input id="nama" type="text" placeholder="Sesuai KTP dan tanpa gelar .." class="form-control @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" required 
                                            autocomplete="nama" autofocus onkeydown="return /[a-z, ]/i.test(event.key)">

                                            @error('nama')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label for="no_hp" class="col-md-4 col-form-label text-md-right">{{ __('No. HP') }}</label>

                                        <div class="col-md-8">
                                            <input id="no_hp" type="text" maxlength ="15" placeholder="08xxx .." class="form-control @error('no_hp') is-invalid @enderror" name="no_hp" value="{{ old('no_hp') }}" required
                                            onkeypress="return isNumber(event)">

                                            @error('no_hp')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="kota_id" class="col-md-4 col-form-label text-md-right">{{ __('Kota') }}</label>

                                        <div class="col-md-8">
                                        <select name="kota_id" class="form-control {{ $errors->has('kota_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                            <option value="">Pilih .. </option>
                                            @foreach($kota as $k)
                                                <option value="{{ $k->id }}">{{ kapital($k->nama) }}</option>
                                            @endforeach
                                        </select>

                                            @error('kota_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="alamat" class="col-md-4 col-form-label text-md-right">{{ __('Alamat') }}</label>

                                        <div class="col-md-8">
                                            <textarea rows="3" cols="50" id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" placeholder="Komplek/Jl/RT/RW/No .." required 
                                            autocomplete="alamat">{{ old('alamat') }}</textarea>

                                            @error('alamat')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
    
                                </div>
                                <!-- right column -->
                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <div class="col-md-4 text-right">
                                            <i class="fa fa-mail-bulk fa-4x text-primary"></i>
                                        </div>
                                        <div class="col-md-8 text-center text-muted">
                                            Alternatif email diperlukan sebagai upaya kami untuk tetap berbagi informasi, berkomunikasi dan menjangkau Anda. <i class="far fa-smile-wink"></i>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Alternatif Email') }}</label>

                                        <div class="col-md-8">
                                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" placeholder="selain {{ Auth::user()->email }}" name="email" value="{{ old('email') }}" required autocomplete="email">

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
                                            <input id="email-confirm" type="email" class="form-control" name="email_confirmation" placeholder="Sesuaikan dengan isian email alternatif .." required autocomplete="new-email">
                                        </div>
                                    </div>

                                    <div class="form-group row mb-0">
                                        <div class="col-md-8 offset-md-4">
                                            <button type="submit" class="btn btn-block btn-primary">
                                                {{ __('Kirim') }}
                                            </button>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer">
                        <a class="btn btn-xs btn-outline-info" href="{{ url('/') }}"> {{ __('Halaman Utama') }}</a>
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