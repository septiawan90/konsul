@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}'>{{ strtoupper($subjudul) }}</a> 
                            <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                        @else
                            <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subjudul) }}
                        @endif
                    @else
                        @if($aksi)
                            <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                        @else
                            {{ strtoupper($subjudul) }}
                        @endif
                    @endif
                @endif
            </h5>
            <div class="card-tools">
                <form action="{{ $link }}/{{ $judul }}/cari/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" method="GET" class="form-inline ml-0 ml-md-3">
                <div class="input-group input-group-sm">
                    <input class="form-control" type="search" name="cari" placeholder="Cari" aria-label="Cari" value="{{ old('cari') }}">
                    <div class="input-group-append">
                    <button class="btn btn-navbar" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-2">
                <div class="col-sm-5"><a href="{{ $link }}/{{ $judul }}/tambah/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-sm btn-outline-success">Tambah</a></div>
                <div class="col-sm-7">{{ $sk->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block mt-0">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        {!! $message !!}
                    </div>
                    @endif
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="20%" class="text-center">Nomor</th>
                                <th width="13%" class="text-center">Tanggal</th>
                                <th class="text-center">Tentang</th>
                                <th width="20%" class="text-center">Role</th>
                                <th width="13%" class="text-center">Kadaluarsa</th>
                                <th width="7%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($sk->currentPage() - 1) * $sk->perPage() + 1;
                            ?>
                            @foreach($sk as $row)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-10">{{ $row->nomor }}</div>
                                        <div class="col-sm-2">
                                        @if($row->file)
                                            <a href="{{ $link }}/{{ $judul }}/unduh/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{Crypt::encrypt($row->id)}}" class="btn btn-xs btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a>
                                        @endif</div>
                                    </div>
                                </td>
                                <td class="text-center">{{ tanggal($row->tanggal) }}</td>
                                <td>{{ $row->tentang }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-sm-8">{{ isset($row->role->name) ? $row->role->name : "" }} {!! $row->akreditasi ? 'Akreditasi <b>'.$row->akreditasi.'</b>' : '' !!}</div>
                                        <div class="col-sm-4 text-right">
                                            <a href="{{ $link }}/penerima/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-outline-info" data-placement="top" data-toggle="tooltip" data-original-title="Penerima SK {{ Statistik::hitungPenerimaSk($row->id) }} Orang">{{ Statistik::hitungPenerimaSk($row->id) }} <i class="fa fa-user"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center">{!! $row->kadaluarsa <= date('Y-m-d') ? tanggal($row->kadaluarsa)." <i class='fa fa-times-circle text-danger'></i>" :  tanggal($row->kadaluarsa)." <i class='fa fa-check-circle text-success'></i>" !!}</td>
                                <td class="text-center">
                                    <a href="{{ $link }}/{{ $judul }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Lihat"><i class="fa fa-paste"></i></a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $sk->currentPage() }} | Jumlah: <b class="text-success">{{ $sk->count() }}</b> / {{ $sk->total() }} Data</small>
            </h5>
            <a href="{{ $link }}/{{ $judul }}/sampah/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}" class="btn btn-xs btn-outline-danger float-right" data-placement="left" data-toggle="tooltip" data-original-title="Data Sampah"><i class="fas fa-trash"></i></a>
        </div>
    </div>
</div>
@endsection