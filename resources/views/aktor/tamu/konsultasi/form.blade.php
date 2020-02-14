@extends('layouts.lte_tamu')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <!-- top -->
            <div class="row">
                <!-- left -->
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-center">
                            <h5 class="card-title m-0"><a href="#">PROFIL</a></h5>
                            <div class="card-tools"><a href="/" class="btn btn-xs btn-outline-info pb-0 pt-0 mt-0 mb-0">Kembali ke Halaman Utama</a></div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- -->
                                <div class="col-sm-4">
                                    <div class="row mb-3">
                                        <div class="col-sm-4">Tiket</div>
                                        <div class="col-sm-8">{{ $tiket->nomor }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">Hari, Tanggal</div>
                                        <div class="col-sm-8">{{ hari($tiket->created_at) }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row mb-3">
                                        <div class="col-sm-4">Nama</div>
                                        <div class="col-sm-8">{{ kapital($profil->nama) }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">NIK</div>
                                        <div class="col-sm-8">{{ maskText($profil->nik) }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">NIP/NRP</div>
                                        <div class="col-sm-8">{{ maskText($profil->nip) }}</div>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="row mb-3">
                                        <div class="col-sm-4">Instansi</div>
                                        <div class="col-sm-8">{{ kapital($profil->instansi) }}</div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-sm-4">Email</div>
                                        <div class="col-sm-8">{{ maskEmail($profil->email) }}</div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">HP</div>
                                        <div class="col-sm-8">{{ maskText($profil->hp) }}</div>
                                    </div>
                                </div>
                                <!--  -->
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
                                    <a href="#">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                                    @if($subsubjudul)
                                        @if($aksi)
                                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='/{{ $subjudul }}/{{ Crypt::encrypt($profil->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='/{{ $subsubjudul }}/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($tiket->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                                            <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                                        @else
                                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($profil->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                                        @endif
                                    @else
                                        @if($subjudul)
                                            @if($aksi)
                                                <small><i class='fas fa-arrow-circle-right'></i></small> <a href='/{{ $subjudul }}/{{ Crypt::encrypt($profil->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                                <div class="card-tools"></div>
                            </div>
                            <div class="card-body">

                                <form method="post" action="{{ $form_action }}">

                                {{ csrf_field() }}
                                {{ $aksi == 'ubah' ? method_field('PUT') : '' }}

                                <div class="row mb-2">
                                    <div class="col-sm-8"></div>
                                    <div class="col-sm-4"></div>
                                </div>
                                
                                <div class="row">
                                    <div class="col-lg-12">
                                        <!--  -->
                                        <div class="row mb-3">
                                            <div class="col-sm-2">Subjek
                                            @if($errors->has('subjek_id'))
                                                <sup class="text-danger"><small>{{ $errors->first('subjek_id')}}</small></sup>
                                            @endif
                                            </div>
                                            <div class="col-sm-10">
                                            @if($aksi == 'ubah')
                                                <select name="subjek_id" class="form-control {{ $errors->has('subjek_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                    <option value="">Pilih subjek ..</option>
                                                    @foreach($subjek as $s)
                                                        <option value="{{ $s->id }}" {{ $konsultasi->subjek_id == $s->id ? "selected" : "" }}>{{ $s->kode }}:{{ $s->nama }}</option>
                                                    @endforeach
                                                </select>
                                            @else
                                                <select name="subjek_id" class="form-control {{ $errors->has('subjek_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                                    <option value="">Pilih subjek ..</option>
                                                    @foreach($subjek as $s)
                                                        <option value="{{ $s->id }}">{{ $s->kode }}:{{ $s->nama }}</option>
                                                    @endforeach
                                                </select>
                                            @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-sm-2">Konsultasi
                                            @if($errors->has('konsultasi'))
                                                <sup class="text-danger"><small>{{ $errors->first('konsultasi')}}</small></sup>
                                            @endif
                                            </div>
                                            <div class="col-sm-10">
                                            @if($aksi == 'ubah')
                                                <textarea name="konsultasi" class="konsultasi" placeholder="Konsultasi ..">{!! $konsultasi->konsultasi !!}</textarea>
                                            @else
                                                <textarea name="konsultasi" class="konsultasi" placeholder="Konsultasi ..">{!! old('konsultasi') !!}</textarea>
                                            @endif
                                                <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
                                                <script>
                                                    tinymce.init({
                                                        selector:'textarea.konsultasi',
                                                        menubar:false,
                                                        plugins:"lists",
                                                        toolbar:"numlist bullist",
                                                        height: 300
                                                    });
                                                </script>
                                            </div>
                                        </div>
                                        <!--  -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer float-right">
                                <div class="row">
                                    <div class="col-sm-6"></div>
                                    <div class="col-sm-6 text-right">
                                        @if($aksi == 'lihat')
                                            <a href="/konsultasi/ubah/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($tiket->id) }}/{{ Crypt::encrypt($konsultasi->id) }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                                            <a href="/konsultasi/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($tiket->id) }}" class="btn btn-sm btn-lihat">Kembali</a>
                                        @elseif($aksi == 'tambah')
                                            <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                                            <a href="/konsultasi/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($tiket->id) }}" class="btn btn-sm btn-lihat">Kembali</a>
                                        @else
                                            <input type="submit" class="btn btn-sm btn-success" value="Simpan">
                                            <a href="/konsultasi/{{ Crypt::encrypt($profil->id) }}/{{ Crypt::encrypt($tiket->id) }}" class="btn btn-sm btn-primary">Kembali</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection