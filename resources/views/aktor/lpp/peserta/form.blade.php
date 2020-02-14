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
                <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data ini?')" enctype="multipart/form-data">
                
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        @if($subsubjudul)
                            @if($aksi)
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subsubjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}'>{{ strtoupper($subsubjudul) }}</a>
                                <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                            @else
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($surat->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
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
                        <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $peserta->created_at == $peserta->updated_at ? 'Dibuat : '.lastUpdate($peserta->created_at) : 'Diubah : '.lastUpdate($peserta->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="row mb-3">
                                <div class="col-sm-2">Kode</div>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{ $peserta->kode }}" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Tanggal Daftar</div>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{ tanggal($peserta->created_at) }}" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">NIK</div>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{ maskText($peserta->profil->user->nik) }}" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Nama</div>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{ $peserta->profil->nama }}" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Email</div>
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{ $peserta->profil->user->email }}" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <?php $status = array('verifikasi', 'disetujui', 'ditolak'); ?>
                                <div class="col-sm-2">Status</div>
                                <div class="col-sm-10">
                                    @if($peserta->status == "disetujui")
                                    <input type="text" class="form-control" value="{{ $peserta->status }}" readonly>
                                    @else
                                    <select name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        @foreach($status as $s)
                                        <option value="{{ $s }}" {{ $peserta->status == $s ? "selected" : "" }} >{{ $s }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Kelengkapan Berkas
                                @if($errors->has('file'))
                                    <sup class="text-danger"><small>{{ $errors->first('file')}}</small></sup>
                                @endif
                                </div>
                                <div class="col-sm-10">
                                    @if($peserta->status == "disetujui")
                                    <a href="{{ $link }}/{{ $subsubjudul }}/unduh/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}/{{ Crypt::encrypt($peserta->id) }}" class="btn btn-xs btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a>
                                    @else
                                    <input type="file" name="file" class="form-control-file {{ $errors->has('file') ? 'is-invalid' : 'is-warning' }}" value="{{ old('file') }}">
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6">
                            @if($peserta->status != "disetujui")
                            <a href="{{ $link }}/{{ $subsubjudul }}/batal/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}/{{ Crypt::encrypt($peserta->id) }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Anda yakin akan membatalkan peserta {{ $peserta->profil->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Batalkan Pendaftaran"><i class="fa fa-times"></i></a>
                            @endif
                        </div>
                        <div class="col-sm-6 text-right">
                            @if($peserta->status != "disetujui")
                            <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                            @endif
                            <a href="{{ $link }}/{{ $subsubjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}/{{ $surat_id }}/{{ $kegiatan_id }}" class="btn btn-sm btn-lihat">Kembali</a>    
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection