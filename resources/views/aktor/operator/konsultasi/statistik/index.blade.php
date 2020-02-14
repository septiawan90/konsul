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
            <div class="row mb-2"></div>
            
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" style="text-align: center;">KODE</th>
                                <th style="text-align: center;">SUBJEK</th>
                                <th style="text-align: center;">JAN</th>
                                <th style="text-align: center;">FEB</th>
                                <th style="text-align: center;">MAR</th>
                                <th style="text-align: center;">APR</th>
                                <th style="text-align: center;">MEI</th>
                                <th style="text-align: center;">JUN</th>
                                <th style="text-align: center;">JUL</th>
                                <th style="text-align: center;">AGU</th>
                                <th style="text-align: center;">SEP</th>
                                <th style="text-align: center;">OKT</th>
                                <th style="text-align: center;">NOV</th>
                                <th style="text-align: center;">DES</th>
                                <th style="text-align: center;">TOT</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjek as $s)
                            <tr>
                                <td style="text-align: center;">{{ $s->kode }}</td>
                                <td>{{ $s->subjek  }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "01") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "02") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "03") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "04") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "05") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "06") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "07") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "08") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "09") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "10") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "11") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungSubjek($s->id, "12") }}</td>
                                <td style="text-align: center;"><b>{{ Statistik::hitungSubjekTahun($s->id) }}</b></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">{{ strtoupper($judul) }} berdasarkan {{ strtoupper($subjudul) }}
        </div>
    </div>
</div>
@endsection