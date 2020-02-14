@extends('layouts.lte_email')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            
            <div class="card">
                
                <div class="card-header text-center">
                    <h5 class="card-title m-0">{{ $details['title'] }}</h5>
                    <div class="card-tools"></div>
                </div>

                <div class="card-body">
                    <div class="row">
                
                        <div class="alert alert-success text-center"><b><h1>{{ $details['body'] }}</h1></b></div>
                    
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