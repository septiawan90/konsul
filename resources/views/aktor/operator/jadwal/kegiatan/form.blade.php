@extends('layouts.lte')

@section('content')
<div class="container">
    <!-- top -->
    <div class="row">
        <!-- left -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header text-center">
                <h5 class="card-title m-0"><a href="{{ $link }}/surat">SURAT</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-2">LPP</div>
                                <div class="col-sm-10">{{ kapital($surat->lpp->nama) }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-4">Nomor</div>
                                <div class="col-sm-8">{{ $surat->nomor }}</div>
                                <div class="col-sm-4">Hari, Tanggal</div>
                                <div class="col-sm-8">{{ hari($surat->tanggal) }}</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-12">Tentang : <br>{{ $surat->tentang }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end left -->
        <!-- right  -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header text-center">
                <h5 class="card-title m-0"><a href="#">JUMLAH</a></h5>
                    <div class="card-tools"></div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-4">Kegiatan</div>
                                <div class="col-sm-8">{{ $kegiatan->count() }}</div>
                                <div class="col-sm-4">Pendaftar</div>
                                <div class="col-sm-8">{{ Statistik::hitungPendaftarSurat($surat->id) }}</div>
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
        <!-- right -->
        <div class="col-lg-12">
            <div class="card">
                @if($aksi == 'ubah')
                <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data {{ kapital($subjudul) }} ini?')">
                @else
                <form method="post" action="{{ $form_action }}">
                @endif
                
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
                        @if($aksi == 'ubah' || $aksi =='lihat')
                            <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $kegiatan->created_at == $kegiatan->updated_at ? 'Dibuat : '.lastUpdate($kegiatan->created_at) : 'Diubah : '.lastUpdate($kegiatan->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                        @endif
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="row mb-3">
                                <div class="col-sm-2">Kode</div>
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode .." value="{{ $kegiatan->kode }}" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Tanggal</div>
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tanggal .." value="{{ tanggal($kegiatan->tanggal) }}" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Jam</div>
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Jam .." value="{{ $kegiatan->jam }}" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Usulan Peserta</div>
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Usulan .." value="{{ $kegiatan->usulan }}" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Sesi</div>
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Sesi .." value="{{ $kegiatan->sesi }}" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Lokasi</div>
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Venue .." value="{{ $kegiatan->venue->nama }} ({{ kapital($kegiatan->venue->kota->nama) }})" readonly></div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Status</div>
                                @if($aksi == 'lihat')
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Status .." value="{{ $kegiatan->status }}" readonly></div>
                                @else
                                <?php $status = array('verifikasi', 'disetujui', 'ditolak'); ?>
                                <div class="col-sm-4"><input type="text" class="form-control" placeholder="Status .." value="{{ $kegiatan->status }}" readonly></div>
                                <div class="col-sm-6">
                                    @if($kegiatan->status == "disetujui")
                                    <input type="text" class="form-control" value="{{ $kegiatan->status }}" readonly>
                                    @else
                                    <select name="status" class="form-control {{ $errors->has('status') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        @foreach($status as $s)
                                        <option value="{{ $s }}" {{ $kegiatan->status == $s ? "selected" : "" }} >{{ $s }}</option>
                                        @endforeach
                                    </select>
                                    @endif
                                </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Keterangan</div>
                                @if($aksi == 'lihat')
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Keterangan .." value="{{ $kegiatan->keterangan }}" readonly></div>
                                @else
                                <div class="col-sm-4"><input type="text" class="form-control" placeholder="Keterangan .." value="{{ $kegiatan->keterangan }}" readonly></div>
                                <div class="col-sm-6"><input type="text" name="keterangan" class="form-control" placeholder="Keterangan .." value="{{ $kegiatan->keterangan }}"></div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Pengawas #1</div>
                                @if($aksi == 'lihat')
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Pengawas #1 .." value="{{ isset($kegiatan->pengawas1->profil->nama) ? $kegiatan->pengawas1->profil->nama : '' }}" readonly></div>
                                @else
                                <div class="col-sm-4"><input type="text" class="form-control" placeholder="Pengawas #1 .." value="{{ isset($kegiatan->pengawas1->profil->nama) ? $kegiatan->pengawas1->profil->nama : '' }}" readonly></div>
                                <div class="col-sm-6">
                                    <select name="pengawas1_id" class="form-control {{ $errors->has('pengawas1_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">Pilih .. </option>
                                        @foreach($pengawas as $p)
                                            <option value="{{ $p->id }}" {{ $p->id == $kegiatan->pengawas1_id ? "selected" : "" }}>{{ $p->profil->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-2">Pengawas #2</div>
                                @if($aksi == 'lihat')
                                <div class="col-sm-10"><input type="text" class="form-control" placeholder="Pengawas #2 .." value="{{ isset($kegiatan->pengawas2->profil->nama) ? $kegiatan->pengawas2->profil->nama : '' }}" readonly></div>
                                @else
                                <div class="col-sm-4"><input type="text" class="form-control" placeholder="Pengawas #2 .." value="{{ isset($kegiatan->pengawas2->profil->nama) ? $kegiatan->pengawas2->profil->nama : '' }}" readonly></div>
                                <div class="col-sm-6">
                                    <select name="pengawas2_id" class="form-control {{ $errors->has('pengawas2_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                        <option value="">Pilih .. </option>
                                        @foreach($pengawas as $p)
                                            <option value="{{ $p->id }}" {{ $p->id == $kegiatan->pengawas2_id ? "selected" : "" }}>{{ $p->profil->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-sm-6"></div>
                        <div class="col-sm-6 text-right">
                            @if($aksi == 'lihat')
                                <a href="{{ $link }}/kegiatan/ubah/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                                <a href="{{ $link }}/kegiatan/{{ Crypt::encrypt($surat->id) }}" class="btn btn-sm btn-lihat">Kembali</a>
                            @else
                                <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                                <a href="{{ $link }}/kegiatan/lihat/{{ Crypt::encrypt($surat->id) }}/{{ Crypt::encrypt($kegiatan->id) }}" class="btn btn-sm btn-lihat">Kembali</a>    
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