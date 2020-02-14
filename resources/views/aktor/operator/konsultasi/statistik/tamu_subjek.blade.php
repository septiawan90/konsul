<style>
    thead th{
        position: -webkit-sticky;
        position: sticky;
        top:0;
        background: #fff;   
    }

    thead th:first-child{
        left:0;
        z-index:1;
    }

    tbody th{
        position: -webkit-sticky;
        position: sticky;
        left:0;
        background: #f8fafc;
        border-right: 1px solid #CCC;
    }
</style>

@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="#">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subjudul) }}
            </h5>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-5"></div>
                <div class="col-sm-7">{{ $tamu->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    <div style="overflow-x:auto;">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th style="text-align: center; vertical-align:middle; background:#f8fafc;"><span class="pl-5 pr-5">TAMU</span></th>
                                    @foreach($subjek as $h)
                                        <th style="text-align: center; vertical-align:top;">
                                            <div class="col-sm-12" style="background:#f0f0f0">{!! $h->kode !!}</div>
                                            <div class="col-sm-12" style="font-weight:100">{!! $h->subjek !!}</div>
                                        </th>
                                    @endforeach
                                    <th style="text-align: center; vertical-align:middle;">TOTAL</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                @php
                                $no = ($tamu->currentPage() - 1) * $tamu->perpage() + 1;
                                @endphp

                                @foreach($tamu as $t)
                                <tr>
                                    <th>
                                        <div class="row">

                                            <div class="col-sm-4 pl-2 text-right">
                                                {{ $no++}}
                                            </div>
                                            <div class="col-sm-8 pl-0 text-left">
                                                {{ kapital($t->nama)  }}
                                            </div>
                                        </div>
                                    </th>
                                    @foreach($subjek as $s)
                                        <td class="text-center" style="vertical-align:middle;">{{ Statistik::hitungTamuSubjek($s->id, $t->id) }}</td>
                                    @endforeach
                                    <td class="text-center" style="vertical-align:middle;"><b>{{ Statistik::hitungTamuSubjekTahun($t->id) }}</b></td>
                                </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $tamu->currentPage() }} | Jumlah: <b class="text-success">{{ $tamu->count() }}</b> / {{ $tamu->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection