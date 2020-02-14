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
        <div class="col-md-8">
            <img src="{{ Storage::url('lkpp.png') }}" alt="lkpp" height="100">
            <div class="card">
                <div class="card-header">{{ __('Selangkah lagi ...') }} <i class="fa fa-running"></i></div>

                <div class="card-body">
                    @if(session('resent'))
                        <div class="alert alert-success" role="alert">
                            {{ __('Link verifikasi akun terbaru sudah di kirim ke alamat email.') }}
                        </div>
                    @endif

                    <h3 class="text-center"><i class="fa fa-star text-warning"></i> <i class="fa fa-2x fa-star text-warning"></i> <i class="fa fa-4x fa-crown mb-4 text-warning"></i> <i class="fa fa-2x fa-star text-warning"></i> <i class="fa fa-star text-warning"></i><br>Anda telah buat akun, selangkah lagi!</h3>
                    <hr>
                    <div class="text-center">
                        Silahkan periksa kotak masuk pada email <b>{{ Auth::user()->email }}</b> yang anda gunakan pada pembuatan akun ini untuk melakukan verifikasi, kemudian lengkapi profil Anda.
                    </div>
                    
                    <div class="text-center">
                    Bila belum menerima tautan dimaksud pada kotak masuk email anda, silahkan 
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('Klik disini untuk mengirim ulang tautan ke email Anda.') }}</button>
                    </form>
                    </div>
                </div>

                <div class="card-footer">
                    <a class="btn btn-xs btn-outline-info" href="{{ url('/') }}"> {{ __('Halaman Utama') }}</a>          
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
