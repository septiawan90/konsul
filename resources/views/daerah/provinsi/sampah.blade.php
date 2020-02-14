@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            Subjek
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-8">
                    <a href="/subjek" class="btn btn-sm btn-primary">Data Subjek</a>
                    |
                    <a href="/subjek/kembalikan_semua" class="btn btn-sm btn-warning">Kembalikan Semua</a>
                </div>
                <div class="col-sm-4">
                    <!-- <form action="/subjek/cari_sampah" method="GET" class="form-inline">
                        <input type="text" name="cari" class="form-control mr-2" placeholder="Cari .." value="{{ old('cari') }}">
                        <input type="submit" class="btn btn-sm btn-primary" value="CARI">
                    </form> -->
                </div>
            </div>
            
            <div class="row mb-2">
                <div class="col-sm-12">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align: center;">No</th>
                            <th width="10%" style="text-align: center;">Kode</th>
                            <th>Subjek</th>
                            <th width="15%" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = ($subjek->currentPage() - 1) * $subjek->perpage() + 1;
                        ?>
                        @foreach($subjek as $s)
                        <tr>
                            <td style="text-align: center;">{{ $no++ }}</td>
                            <td style="text-align: center;">{{ $s->kode }}</td>
                            <td>{{ $s->subjek }}</td>
                            <td style="text-align: center;">
                                <a href="/subjek/kembalikan/{{ Crypt::encrypt($s->id) }}" class="btn btn-success btn-sm">Kembalikan</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-sm-12">
                    <table width="100%">
                    <tr>
                        <td width="10%">Halaman ke</td>
                        <td>: {{ $subjek->currentPage() }}</td>
                        <td rowspan="2" width="30%">{{ $subjek->links() }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>: {{ $subjek->count() }} / {{ $subjek->total() }} Data</td>
                    </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection