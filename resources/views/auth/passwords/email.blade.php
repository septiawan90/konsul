@extends('layouts.lte_tamu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <img src="{{ Storage::url('lkpp.png') }}" alt="lkpp" height="100">
            <div class="card">
                <div class="card-header">{{ __('Lupa Password') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-group row mb-2">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Email') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Kirim Tautan') }}
                                </button>

                                @if (session('status'))
                                    <div class="alert alert-success mt-2" role="alert">
                                        {{ session('status') }} <i class="fa fa-mug-hot"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a class="btn btn-xs btn-outline-info" href="{{ url('/') }}"> {{ __('Halaman Utama') }}</a> 
                    <a class="btn btn-xs btn-outline-primary" href="{{ route('login') }}"> {{ __('Masuk') }}</a>  
                    <a class="btn btn-xs btn-outline-success" href="{{ route('register') }}"> {{ __('Buat Akun') }}</a>  
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
