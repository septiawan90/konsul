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
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" style="text-align: center;">NO</th>
                                <th style="text-align: center;">TAMU</th>
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
                            
                            @php
                            $no = ($tamu->currentPage() - 1) * $tamu->perpage() + 1;
                            @endphp

                            @foreach($tamu as $t)
                            <tr>
                                <td style="text-align: center;">{{ $no++ }}</td>
                                <td>{{ kapital($t->nama)  }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "01") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "02") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "03") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "04") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "05") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "06") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "07") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "08") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "09") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "10") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "11") }}</td>
                                <td style="text-align: center;">{{ Statistik::hitungTamu($t->id, "12") }}</td>
                                <td style="text-align: center;"><b>{{ Statistik::hitungTamuTahun($t->id) }}<b></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
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