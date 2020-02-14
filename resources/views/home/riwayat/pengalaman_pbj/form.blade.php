@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        @if($aksi == 'ubah')
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data {{ kapital($judul) }} {{ $pengalaman_pbj->pelaku_pbj->nama }} ini?')">
        @else
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan menambahkan data ini?')">
        @endif
        
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}">RIWAYAT {{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($pengalaman_pbj->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($pengalaman_pbj->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($pengalaman_pbj->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($pengalaman_pbj->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                    <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $pengalaman_pbj->created_at == $pengalaman_pbj->updated_at ? 'Dibuat : '.lastUpdate($pengalaman_pbj->created_at) : 'Diubah : '.lastUpdate($pengalaman_pbj->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {{ csrf_field() }}
                    {{ $aksi == 'ubah' ? method_field('PUT') : '' }}

                    <div class="row mb-3">
                        <div class="col-sm-2">Tahun
                        @if($errors->has('tahun'))
                            <sup class="text-danger"><small>{{ $errors->first('tahun')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tahun .." value="{{ $pengalaman_pbj->tahun }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="tahun" class="form-control {{ $errors->has('tahun') ? 'is-invalid' : 'is-warning' }}" placeholder="Tahun .." minlength="4" maxlength="4" onkeypress="return isNumber(event)" value="{{ old('tahun') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $pengalaman_pbj->tahun }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="tahun" class="form-control {{ $errors->has('tahun') ? 'is-invalid' : 'is-warning' }}" placeholder="Tahun .." minlength="4" maxlength="4" onkeypress="return isNumber(event)" value="{{ $pengalaman_pbj->tahun }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Pelaku PBJ
                        @if($errors->has('pelaku_pbj_id'))
                            <sup class="text-danger"><small>{{ $errors->first('pelaku_pbj_id')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Pelaku PBJ" value="{{ isset($pengalaman_pbj->pelaku_pbj_id->nama) ? $pengalaman_pbj->pelaku_pbj_id->nama : '' }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <select name="pelaku_pbj_id" class="form-control {{ $errors->has('pelaku_pbj_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($pelaku_pbj as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ isset($pengalaman_pbj->pelaku_pbj_id->nama) ? $pengalaman_pbj->pelaku_pbj_id->nama : '' }}" readonly></div>
                        <div class="col-sm-6">
                            <select name="pelaku_pbj_id" class="form-control {{ $errors->has('pelaku_pbj_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($pelaku_pbj as $row)
                                    <option value="{{ $row->id }}" {{ $pengalaman_pbj->pelaku_pbj_id == $row->id ? "selected" : "" }} >{{ $row->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-2">Kode Paket
                        @if($errors->has('kode_paket'))
                            <sup class="text-danger"><small>{{ $errors->first('kode_paket')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kode Paket .." value="{{ $pengalaman_pbj->kode_paket }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="kode_paket" class="form-control {{ $errors->has('kode_paket') ? 'is-invalid' : 'is-warning' }}" placeholder="Kode Paket .." value="{{ old('kode_paket') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $pengalaman_pbj->kode_paket }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="kode_paket" class="form-control {{ $errors->has('kode_paket') ? 'is-invalid' : 'is-warning' }}" placeholder="Kode Paket .." value="{{ $pengalaman_pbj->kode_paket }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Nama Paket
                        @if($errors->has('nama_paket'))
                            <sup class="text-danger"><small>{{ $errors->first('nama_paket')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nama Paket .." value="{{ $pengalaman_pbj->nama_paket }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="nama_paket" class="form-control {{ $errors->has('nama_paket') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama Paket .." value="{{ old('nama_paket') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $pengalaman_pbj->nama_paket }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="nama_paket" class="form-control {{ $errors->has('nama_paket') ? 'is-invalid' : 'is-warning' }}" placeholder="Nama Paket .." value="{{ $pengalaman_pbj->nama_paket }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Nilai Paket
                        @if($errors->has('nilai_paket'))
                            <sup class="text-danger"><small>{{ $errors->first('nilai_paket')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nilai Paket .." value="{{ $pengalaman_pbj->nilai_paket }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="nilai_paket" class="form-control {{ $errors->has('nilai_paket') ? 'is-invalid' : 'is-warning' }}" placeholder="Nilai Paket .." value="{{ old('nilai_paket') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $pengalaman_pbj->nilai_paket }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="nilai_paket" class="form-control {{ $errors->has('nilai_paket') ? 'is-invalid' : 'is-warning' }}" placeholder="Nilai Paket .." value="{{ $pengalaman_pbj->nilai_paket }}">
                        </div>
                        @endif
                    </div>

                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/hapus/{{ $user_id }}/{{ $profil_id }}/{{ $pengalaman_pbj_id }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Yakin hapus {{ kapital($judul) }} {{ $pengalaman_pbj->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus"><i class="fa fa-trash-alt"></i></a>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $pengalaman_pbj_id }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                        <a href="{{ $link }}/{{ $user_id }}/{{ $profil_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @elseif($aksi == 'tambah')
                        <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                        <a href="{{ $link }}/{{ $user_id }}/{{ $profil_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @else
                        <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                        <a href="{{ $link }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $pengalaman_pbj_id }}" class="btn btn-sm btn-lihat">Kembali</a>    
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection

<script>
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
}
        return true;
}
</script>