@extends('layouts.lte')

@section('content')
<div class="container">
    <!-- top -->
    <div class="row">
        <!-- left -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                    </h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4">Nomor</div>
                            <div class="col-sm-8">{{ $surat->nomor }}</div>
                            <div class="col-sm-4">Hari, Tanggal</div>
                            <div class="col-sm-8">{{ hari($surat->tanggal) }}</div>
                            <div class="col-sm-4">Tentang</div>
                            <div class="col-sm-8">{{ $surat->tentang }}</div>
                        </div>
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end left -->
        <!-- right  -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="card-title m-0"><a href="{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}">KEGIATAN</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4">Kode</div>
                                <div class="col-sm-8">{{ $kegiatan->kode }}</div>
                                <div class="col-sm-4">Hari, Tanggal</div>
                                <div class="col-sm-8">{{ hari($kegiatan->tanggal) }}</div>
                                <div class="col-sm-4">Tanggal Akhir Daftar</div>
                                <div class="col-sm-8 text-danger">{{ hari(date('Y-m-d', strtotime($kegiatan->tanggal.' - 3 days'))) }}</div>
                                <div class="col-sm-4">Lokasi</div>
                                <div class="col-sm-8">{!! $kegiatan->venue->nama.', '.kapital($kegiatan->venue->kota->nama) !!}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end right -->
    </div>
    <!-- end top -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        @if($subsubjudul)
                            @if($aksi)
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($surat->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subsubjudul }}/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                                <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                            @else
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                            @endif
                        @else
                            @if($subjudul)
                                @if($aksi)
                                    <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($surat->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                        <form action="{{ $link }}/{{ $subsubjudul }}/cari/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}/{{ $view }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                        <div class="col-sm-6">
                            @if(date('Y-m-d') < date('Y-m-d', strtotime($kegiatan->tanggal.' - 2 days')))
                            <form method="post" action="{{ $link }}/{{ $subsubjudul }}/tambah/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}" onSubmit="return confirm('Anda yakin akan menambah sebagai peserta?')" class="form-inline">
                                {{ csrf_field() }}
                                <input type="text" name="email" placeholder="Masukan email .." class="form-control {{ $errors->has('email') ? 'is-invalid' : 'is-warning' }} mr-sm-2" value="{{ old('email') }}" required>
                                <input type="submit" class="btn btn-sm {{ $errors->has('email') ? 'btn-danger' : 'btn-success' }}" value="Tambah Peserta">
                            </form>
                            @else
                                <div class="alert alert-info alert-block mt-0 mb-1 pb-0 pt-0 text-center">Pendaftaran telah ditutup.</div>
                            @endif

                            @if($errors->has('email'))
                                <sup class="text-danger"><small>{{ $errors->first('email')}}</small></sup>
                            @endif
                        </div>
                        <div class="col-sm-6 text-right">
                            @if($view == 'table')
                            <a href="{{ $link }}/{{ $subsubjudul }}/card/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}" class="btn btn-xs btn-info" data-placement="left" data-toggle="tooltip" data-original-title="Kartu"><i class="far fa-id-card"></i></a>
                            @endif

                            @if($view == 'card')
                            <a href="{{ $link }}/{{ $subsubjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}" class="btn btn-xs btn-info" data-placement="left" data-toggle="tooltip" data-original-title="Tabel"><i class="fas fa-table"></i></a>
                            @endif
                        </div>

                        @if($message = Session::get('warning'))
                        <div class="col-sm-4">
                            <div class="alert alert-warning alert-block mt-2 mb-1 pb-0 pt-0">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                {!! $message !!}
                            </div>
                        </div>
                        @endif

                        @if($message = Session::get('success'))
                        <div class="col-sm-4">
                            <div class="alert alert-success alert-block mt-2 mb-1 pb-0 pt-0">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                {!! $message !!}
                            </div>
                        </div>
                        @endif

                    </div>
                    
                    @if($view == 'table')
                    <div class="row">
                        <div class="col-lg-12">
                            {{ $peserta->links() }}
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center align-middle">No</th>
                                        <th width="5%" class="text-center align-middle">Kode</th>
                                        <th width="15%" class="text-center align-middle">Daftar</th>
                                        <th width="25%" class="text-center">Nama</th>
                                        <th class="text-center">Email</th>
                                        <th width="5%" class="text-center align-middle">Sesi</th>
                                        <th width="5%" class="text-center align-middle">Berkas</th>
                                        <th width="5%" class="text-center align-middle">Status</th>
                                        <th width="5%" class="text-center align-middle">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $no = ($peserta->currentPage() - 1) * $peserta->perPage() + 1;
                                    @endphp

                                    @foreach($peserta as $p)
                                    <tr>
                                        <td class="text-center">{{ $no++ }}</td>
                                        <td class="text-center">{{ $p->kode }}</td>
                                        <td class="text-center">{{ hari($p->created_at) }}</td>
                                        <td class="text-center">{{ isset($p->profil->nama) ? $p->profil->nama : '' }}</td>
                                        <td class="text-center">{{ isset($p->profil->user->email) ? $p->profil->user->email : '' }}</td>
                                        <td class="text-center">{{ $p->sesi }}</td>
                                        <td class="text-center">-</td>
                                        <td class="text-center">{{ $p->status }}</td>
                                        <td class="text-center">
                                            <a href="{{ $link }}/{{ $subsubjudul }}/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}/{{ Crypt::encrypt($p->id) }}" class="btn btn-xs btn-outline-ubah" data-placement="right" data-toggle="tooltip" data-original-title="Ubah"><i class="fas fa-pencil-alt"></i></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    @if($view == 'card')
                        <!-- card -->
                        @foreach($peserta as $row)
                        <div class="row d-flex align-items-stretch">
                            <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch">
                                <div class="card bg-light">
                                    
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-7">
                                                <small>{{ $row->kode }}</small>
                                                <h2 class="lead">{{ isset($row->profil->nama) ? $row->profil->nama : '' }}</h2>
                                            </div>
                                            <div class="col-5 text-center">
                                                <img src="{{ Auth::user()->profil->file ? Storage::url(Auth::user()->profil->file) : asset('user.jpg') }}" alt="" class="img-fluid">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">Email</div>
                                            <div class="col-8">{{ isset($row->profil->user->email) ? $row->profil->user->email : '' }}</div>
                                            <div class="col-4">Sesi</div>
                                            <div class="col-8">{{ $row->sesi }}</div>
                                            <div class="col-4">Status</div>
                                            <div class="col-8">{{ $row->status }}</div>
                                            <div class="col-4">Terdaftar</div>
                                            <div class="col-8">{{ tanggal($row->created_at) }}</div>
                                            <div class="col-4">Didaftarkan</div>
                                            <div class="col-8">{{ Crypt::decrypt($lpp_id) == $row->created_by ? 'LPP' : 'mandiri' }}</div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-right">
                                            <a href="{{ $link }}/{{ $subsubjudul }}/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}/{{ Crypt::encrypt($row->id) }}" class="btn btn-sm btn-ubah" data-placement="left" data-toggle="tooltip" data-original-title="Ubah"><i class="fas fa-paste"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <!--  -->
                    @endif
                </div>
                <div class="card-footer text-center">
                    <h5 class="card-title m-0">
                    <small>Hal. ke : {{ $peserta->currentPage() }} | Jumlah: <b class="text-success">{{ $peserta->count() }}</b> / {{ $peserta->total() }} Data</small>
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection