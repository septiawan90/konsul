<style>

.full-height {
    height: 80vh;
}

.flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
}

.position-ref {
    position: relative;
}

.top-right {
    position: absolute;
    right: 10px;
    top: 18px;
}

.content {
    text-align: center;
}

.title {
    font-size: 80px;
}

.subtitle {
    font-size: 20px;
}

</style>

@extends('layouts.lte_tamu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="flex-center position-ref full-height">
            <div class="content">
                <img src="{{ Storage::url('lkpp.png') }}" alt="lkpp" height="150">

                <div class="title">
                    Layanan Sertifikasi PBJ
                </div>

                <div class="subtitle">
                    Direktorat Sertifikasi Profesi
                </div>
                <hr>
                <div class="row mt-5">
                    <div class="col-sm-12">
                        <a href="profil/cari" class="btn btn-sm btn-info mb-2" style="color: white">KONSULTASI SERTIFIKASI</a><br>
                        <span class="text-muted">Tanpa perlu Buat Akun atau Login<br> Hanya klik tombol "Konsultasi Sertifikasi" di atas untuk menyampaikan pertanyaan, saran, atau konsultasi Anda<br>kepada Kami seputar Layanan Sertifikasi PBJ <i class="far fa-laugh-wink"></i>.</span>
                    </div>
                </div>

                @if(Route::has('login'))
                <div class="row mt-5">
                    <div class="col-sm-12">
                    @auth
                        <a class="btn btn-sm btn-outline-info" href="{{ url('/home') }}"> {{ __('Home') }}</a> 
                        <a class="btn btn-sm btn-outline-danger" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Keluar</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                    @else
                        
                        @if (Route::has('register'))
                        <div class="row mb-2">
                            <div class="col-sm-4" style="text-align:right"><a class="btn btn-sm btn-outline-success" href="{{ route('register') }}"> {{ __('Buat Akun') }}</a></div>
                            <div class="col-sm-8 text-muted" style="text-align:left"><small><i class="fa fa-arrow-circle-left"></i></small> Langkah mudah untuk mengawali pengalaman Anda.</div>
                        </div>
                        @endif
                        <div class="row">
                            <div class="col-sm-4" style="text-align:right"><a class="btn btn-sm btn-outline-primary" href="{{ route('login') }}"> {{ __('Masuk') }}</a></div>
                            <div class="col-sm-8 text-muted" style="text-align:left"><small><i class="fa fa-arrow-circle-left"></i></small> Sudah punya Akun? Silahkan Masuk.</div>
                        </div>
                    @endauth
                    </div>
                </div>
                @endif

            </div>
            
        </div>
    </div>
</div>
@endsection