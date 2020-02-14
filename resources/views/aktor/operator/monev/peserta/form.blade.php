@extends('layouts.lte')

@section('content')
<div class="container">
    <!-- top -->
    <div class="row">
        <!-- left -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header text-center">
                <h5 class="card-title m-0"><a href="{{ $link }}/{{ $judul }}">SURAT</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-4">LPP</div>
                            <div class="col-sm-8">{{ kapital($surat->lpp->nama) }}</div>
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
                <h5 class="card-title m-0"><a href="{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($surat->id) }}">KEGIATAN</a></h5>
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
                <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah status peserta {{ $peserta->profil->nama }} ini?')">
                
                <div class="card-header text-center">
                    <h5 class="card-title m-0">
                        <a href="{{ $link }}/{{ $judul }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                        @if($subsubjudul)
                            @if($aksi)
                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($surat->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}'>{{ strtoupper($subsubjudul) }}</a>
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
                                @if($aksi == "lihat")
                                <div class="col-sm-10"><input type="text" class="form-control" value="{{ $peserta->status }}" readonly></div>
                                @else
                                <div class="col-sm-4"><input type="text" class="form-control" value="{{ $peserta->status }}" readonly></div>
                                <div class="col-sm-6">
                                    <select name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        @foreach($status as $s)
                                        <option value="{{ $s }}" {{ $peserta->status == $s ? "selected" : "" }} >{{ $s }}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" name="keterangan" class="form-control mt-2" value="{{ $peserta->keterangan }}" placeholder="Sertakan alasan disini bila ditolak">
                                </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Kelengkapan Berkas</div>
                                <div class="col-sm-10">
                                    @if($peserta->file)
                                    <a href="{{ $link }}/kegiatan/peserta/unduh/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}/{{ Crypt::encrypt($peserta->id) }}" class="btn btn-xs btn-outline-success" data-placement="top" data-toggle="tooltip" data-original-title="Unduh"><i class="fa fa-download"></i></a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6 text-right">
                            @if($aksi == "lihat")
                                <a href="{{ $link }}/kegiatan/peserta/ubah/{{ Crypt::encrypt($surat->id) }}/{{Crypt::encrypt($kegiatan->id) }}/{{ Crypt::encrypt($peserta->id) }}" class="btn btn-sm btn-outline-ubah">Ubah</a>    
                                <a href="{{ $link }}/kegiatan/peserta/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}" class="btn btn-sm btn-lihat">Kembali</a>    
                            @else
                                <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                                <a href="{{ $link }}/kegiatan/peserta/lihat/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}/{{ Crypt::encrypt($peserta->id) }}" class="btn btn-sm btn-lihat">Kembali</a>    
                            @endif
                        </div>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection