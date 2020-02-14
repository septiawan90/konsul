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
                            <tr>
                                <td style="text-align: center;"><?php echo $jan->count() != 0 ? $jan->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $feb->count() != 0 ? $feb->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $mar->count() != 0 ? $mar->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $apr->count() != 0 ? $apr->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $mei->count() != 0 ? $mei->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $jun->count() != 0 ? $jun->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $jul->count() != 0 ? $jul->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $agu->count() != 0 ? $agu->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $sep->count() != 0 ? $sep->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $okt->count() != 0 ? $okt->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $nov->count() != 0 ? $nov->count() : "" ; ?></td>
                                <td style="text-align: center;"><?php echo $des->count() != 0 ? $des->count() : "" ; ?></td>
                                <td style="text-align: center;"><b><?php echo $thn->count(); ?></b></td>
                            </tr>
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