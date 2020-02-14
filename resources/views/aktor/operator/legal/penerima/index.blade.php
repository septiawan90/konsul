@extends('layouts.lte')

@section('content')
<div class="container">
    <!-- top -->
    <div class="row">
        <!-- left -->
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-center">
                <h5 class="card-title m-0"><a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}">SK</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">Nomor</div>
                                <div class="col-sm-8">{{ $sk->nomor }}</div>
                                <div class="col-sm-4">Hari, Tanggal</div>
                                <div class="col-sm-8">{{ hari($sk->tanggal) }}</div>
                                <div class="col-sm-4">Tentang</div>
                                <div class="col-sm-8">{{ $sk->tentang }}</div>
                            </div>
                        </div>

                        <!-- right  -->
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">Role</div>
                                <div class="col-sm-8">{{ $sk->role->name }} {!! $sk->akreditasi ? '<span class="float-right">[Akreditasi <b>'.$sk->akreditasi.'</b>]</span>' : '' !!}</div>
                                <div class="col-sm-4">Kadaluarsa</div>
                                <div class="col-sm-8">{!! $sk->kadaluarsa <= date('Y-m-d') ? tanggal($sk->kadaluarsa)." <i class='fa fa-times-circle text-danger'></i>" :  tanggal($sk->kadaluarsa)." <i class='fa fa-check-circle text-success'></i>" !!}</div>
                                <div class="col-sm-4">File</div>
                                <div class="col-sm-8"><a href="{{ $link }}/{{ $judul }}/unduh/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}" class="btn btn-xs btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a></div>
                            </div>
                        </div>
                        <!-- end right -->
                    </div>
                </div>
            </div>
        </div>
        <!-- end left -->
    </div>
    <!-- end top -->

    <div class="row">
        <div class="col-lg-12">
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
                        <form action="{{ $link }}/{{ $subjudul }}/cari/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                        <div class="col-sm-5">
                            <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan menambah sebagai penerima SK ?')" class="form-inline">
                                {{ csrf_field() }}
                                <input type="email" name="email" placeholder="Masukan email .." class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-warning' }} mr-sm-2" value="{{ old('email') }}" required>
                                <input type="submit" class="btn btn-sm {{ $errors->has('email') ? 'btn-danger' : 'btn-success' }}" value="Tambah Penerima">
                            </form>
                        </div>
                        <div class="col-sm-7">{{ $penerima->links() }}</div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-12">
                            @if($message = Session::get('success'))
                            <div class="alert alert-success alert-block mt-0">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                {!! $message !!}
                            </div>
                            @endif

                            @if($message = Session::get('error'))
                            <div class="alert alert-danger alert-block mt-0">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                {!! $message !!}
                            </div>
                            @endif

                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center">No</th>
                                        <th class="text-center">Nama</th>
                                        <th width="25%" class="text-center">Email</th>
                                        <th width="15%" class="text-center">NIK</th>
                                        <th width="15%" class="text-center">NIP</th>
                                        <th width="7%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = ($penerima->currentPage() - 1) * $penerima->perPage() + 1;
                                    @endphp

                                    @forelse($penerima as $row)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td>{{ $row->profil->nama }}</td>
                                        <td class="text-center">{{ $row->profil->user->email }}</td>
                                        <td class="text-center">{{ $row->profil->user->nik }}</td>
                                        <td class="text-center">{{ $row->profil->nip }}</td>
                                        <td class="text-center">
                                            <a href="{{ $link }}/{{ $subjudul }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-outline-info" data-placement="top" data-toggle="tooltip" data-original-title="Lihat"><i class="fas fa-paste"></i></a>
                                            <a href="{{ $link }}/{{ $subjudul }}/hapus/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-outline-danger" data-placement="right" data-toggle="tooltip" data-original-title="Hapus"><i class="fas fa-ban"></i></a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Tidak ada data</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-center">
                    <h5 class="card-title m-0">
                    <small>Hal. ke : {{ $penerima->currentPage() }} | Jumlah: <b class="text-success">{{ $penerima->count() }}</b> / {{ $penerima->total() }} Data</small>
                    </h5>
                    <!-- <a href="{{ $link }}/{{ $subjudul }}/sampah" class="btn btn-xs btn-outline-danger float-right" data-placement="left" data-toggle="tooltip" data-original-title="Data Sampah"><i class="fas fa-trash"></i></a> -->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection