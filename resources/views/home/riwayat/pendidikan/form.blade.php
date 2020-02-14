@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        @if($aksi == 'ubah')
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data {{ kapital($judul) }} {{ $pendidikan->strata->nama }} ini?')">
        @else
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan menambahkan data ini?')">
        @endif
        
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}">RIWAYAT {{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($pendidikan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($pendidikan->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($pendidikan->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($pendidikan->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                    <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $pendidikan->created_at == $pendidikan->updated_at ? 'Dibuat : '.lastUpdate($pendidikan->created_at) : 'Diubah : '.lastUpdate($pendidikan->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {{ csrf_field() }}
                    {{ $aksi == 'ubah' ? method_field('PUT') : '' }}

                    <div class="row mb-3">
                        <div class="col-sm-2">Strata
                        @if($errors->has('strata_id'))
                            <sup class="text-danger"><small>{{ $errors->first('strata_id')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Strata .." value="{{ $pendidikan->strata->nama }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <select name="strata_id" class="form-control {{ $errors->has('strata_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($strata as $row)
                                    <option value="{{ $row->id }}">{{ $row->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $pendidikan->strata->nama }}" readonly></div>
                        <div class="col-sm-6">
                            <select name="strata_id" class="form-control {{ $errors->has('strata_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($strata as $row)
                                    <option value="{{ $row->id }}" {{ $pendidikan->strata_id == $row->id ? "selected" : "" }} >{{ $row->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Tahun Lulus
                        @if($errors->has('thn_lulus'))
                            <sup class="text-danger"><small>{{ $errors->first('thn_lulus')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tahun Lulus .." value="{{ $pendidikan->thn_lulus }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="thn_lulus" class="form-control {{ $errors->has('thn_lulus') ? 'is-invalid' : 'is-warning' }}" placeholder="Tahun Lulus .." minlength="4" maxlength="4" onkeypress="return isNumber(event)" value="{{ old('thn_lulus') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $pendidikan->thn_lulus }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="thn_lulus" class="form-control {{ $errors->has('thn_lulus') ? 'is-invalid' : 'is-warning' }}" placeholder="Tahun Lulus .." minlength="4" maxlength="4" onkeypress="return isNumber(event)" value="{{ $pendidikan->thn_lulus }}">
                        </div>
                        @endif
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-2">Institusi
                        @if($errors->has('institusi'))
                            <sup class="text-danger"><small>{{ $errors->first('institusi')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Sekolah/Kampus/Universitas .." value="{{ $pendidikan->institusi }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="institusi" class="form-control {{ $errors->has('institusi') ? 'is-invalid' : 'is-warning' }}" placeholder="Sekolah/Kampus/Universitas .." value="{{ old('institusi') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $pendidikan->institusi }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="institusi" class="form-control {{ $errors->has('institusi') ? 'is-invalid' : 'is-warning' }}" placeholder="Sekolah/Kampus/Universitas .." value="{{ $pendidikan->institusi }}">
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
                        <a href="{{ $link }}/hapus/{{ $user_id }}/{{ $profil_id }}/{{ $pendidikan_id }}" class="btn btn-sm btn-outline-danger" onclick="return confirm('Yakin hapus {{ kapital($judul) }} {{ $pendidikan->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus"><i class="fa fa-trash-alt"></i></a>
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $pendidikan_id }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                        <a href="{{ $link }}/{{ $user_id }}/{{ $profil_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @elseif($aksi == 'tambah')
                        <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                        <a href="{{ $link }}/{{ $user_id }}/{{ $profil_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @else
                        <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                        <a href="{{ $link }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $pendidikan_id }}" class="btn btn-sm btn-lihat">Kembali</a>    
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