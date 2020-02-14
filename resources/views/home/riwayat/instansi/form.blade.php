@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="card">
        @if($aksi == 'ubah')
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan mengubah data {{ kapital($judul) }} {{ $instansi->klpd->nama }} ini?')">
        @else
        <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin akan menambahkan data ini?')">
        @endif
        
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}/{{ $judul }}">RIWAYAT {{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($instansi->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($instansi->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($instansi->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($instansi->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                    <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $instansi->created_at == $instansi->updated_at ? 'Dibuat : '.lastUpdate($instansi->created_at) : 'Diubah : '.lastUpdate($instansi->updated_at) }}"><i class="fas fa-info-circle"></i></a>
                @endif
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    {{ csrf_field() }}
                    {{ $aksi == 'ubah' ? method_field('PUT') : '' }}

                    <div class="row mb-3">
                        <div class="col-sm-2">Instansi
                        @if($errors->has('klpd_id'))
                            <sup class="text-danger"><small>{{ $errors->first('klpd_id')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Instansi .." value="{{ $instansi->klpd->nama }} {!! $instansi->klpd->alias ? '('.$instansi->klpd->alias.')' : '' !!}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <select name="klpd_id" class="form-control {{ $errors->has('klpd_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($klpd as $row)
                                    <option value="{{ $row->id }}" {{ old('klpd_id') == $row->id ? "selected" : "" }}>{{ $row->nama}} {!! $row->alias ? '('.$row->alias.')' : '' !!}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $instansi->klpd->nama }}" readonly></div>
                        <div class="col-sm-6">
                            <!-- <select name="klpd_id" class="form-control {{ $errors->has('klpd_id') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($klpd as $row)
                                    <option value="{{ $row->id }}" {{ $instansi->klpd_id == $row->id ? "selected" : "" }} >{{ $row->nama}} {!! $row->alias ? '('.$row->alias.')' : '' !!}</option>
                                @endforeach
                            </select> -->
                            <input type="text" class="form-control" placeholder="Instansi .." value="{{ $instansi->klpd->nama }} {!! $instansi->klpd->alias ? '('.$instansi->klpd->alias.')' : '' !!}" readonly>
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Unit Kerja
                        @if($errors->has('unit_kerja'))
                            <sup class="text-danger"><small>{{ $errors->first('unit_kerja')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Unit Kerja .." value="{{ $instansi->unit_kerja }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="unit_kerja" class="form-control {{ $errors->has('unit_kerja') ? 'is-invalid' : 'is-warning' }}" placeholder="Unit Kerja .." value="{{ old('unit_kerja') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $instansi->unit_kerja }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="unit_kerja" class="form-control {{ $errors->has('unit_kerja') ? 'is-invalid' : 'is-warning' }}" placeholder="Unit Kerja .." value="{{ $instansi->unit_kerja }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        @php $kat = array('PNS', 'Polri', 'TNI', 'BUMN', 'BUMD', 'Swasta', 'Perseorangan', 'Ormas', 'Pokmas'); @endphp
                        <div class="col-sm-2">Kategori
                        @if($errors->has('kategori'))
                            <sup class="text-danger"><small>{{ $errors->first('kategori')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kategori .." value="{{ $instansi->kategori }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <select name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($kat as $row)
                                    <option value="{{ $row }}" {{ old('kategori') == $row ? "selected" : "" }}>{{ $row }}</option>
                                @endforeach
                            </select>
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" placeholder="Kategori .." value="{{ $instansi->kategori }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="Kategori .." value="{{ $instansi->kategori }}" readonly>
                            <!-- <select name="kategori" class="form-control {{ $errors->has('kategori') ? 'is-invalid' : 'is-warning' }} select2bs4 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
                                <option value="">Pilih .. </option>
                                @foreach($kat as $row)
                                    <option value="{{ $row }}" {{ $instansi->kategori == $row ? "selected" : "" }} >{{ $row }}</option>
                                @endforeach
                            </select> -->
                        </div>
                        @endif
                    </div>
                    
                    <div class="row mb-3">
                        <div class="col-sm-2">Nomor Pegawai/Anggota
                        @if($errors->has('nomor_pegawai'))
                            <sup class="text-danger"><small>{{ $errors->first('nomor_pegawai')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Nomor Pegawai/Anggota .." value="{{ $instansi->nomor_pegawai }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="nomor_pegawai" class="form-control {{ $errors->has('nomor_pegawai') ? 'is-invalid' : 'is-warning' }}" placeholder="Nomor Pegawai/Anggota .." maxlength="18" value="{{ old('nomor_pegawai') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $instansi->nomor_pegawai }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="Nomor Pegawai/Anggota .." value="{{ $instansi->nomor_pegawai }}" readonly>
                            <!-- <input type="text" name="nomor_pegawai" class="form-control {{ $errors->has('nomor_pegawai') ? 'is-invalid' : 'is-warning' }}" placeholder="Nomor Pegawai/Anggota .." maxlength="18" value="{{ $instansi->nomor_pegawai }}"> -->
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Tanggal Bergabung
                        @if($errors->has('tgl_mulai'))
                            <sup class="text-danger"><small>{{ $errors->first('tgl_mulai')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Tanggal .." value="{{ tanggal($instansi->tgl_mulai) }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="tgl_mulai" class="form-control {{ $errors->has('tgl_mulai') ? 'is-invalid' : 'is-warning' }}" placeholder="Tanggal .." data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Tanggal .." data-mask value="{{ old('tgl_mulai') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ tanggal($instansi->tgl_mulai) }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="tgl_mulai" class="form-control {{ $errors->has('tgl_mulai') ? 'is-invalid' : 'is-warning' }}" placeholder="Tanggal .." data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Tanggal .." data-mask value="{{ tanggal($instansi->tgl_mulai) }}">
                        </div>
                        @endif
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Tanggal Berakhir
                        @if($errors->has('tgl_akhir'))
                            <sup class="text-danger"><small>{{ $errors->first('tgl_akhir')}}</small></sup>
                        @endif
                        </div>
                        @if($aksi == 'lihat')
                        <div class="col-sm-10"><input type="text" class="form-control" placeholder="Kosongkan bila masih aktif .." value="{{ $instansi->tgl_akhir == '1970-01-01' ? '' : $instansi->tgl_akhir }}" readonly></div>
                        @elseif($aksi == 'tambah')
                        <div class="col-sm-10">
                            <input type="text" name="tgl_akhir" class="form-control {{ $errors->has('tgl_akhir') ? 'is-invalid' : 'is-warning' }}" placeholder="Kosongkan bila masih aktif .." data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Tanggal .." data-mask value="{{ old('tgl_akhir') }}">
                        </div>
                        @else
                        <div class="col-sm-4"><input type="text" class="form-control" value="{{ $instansi->tgl_akhir == '1970-01-01' ? '' : $instansi->tgl_akhir }}" readonly></div>
                        <div class="col-sm-6">
                            <input type="text" name="tgl_akhir" class="form-control {{ $errors->has('tgl_akhir') ? 'is-invalid' : 'is-warning' }}" placeholder="Kosongkan bila masih aktif .." data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy" placeholder="Tanggal .." data-mask value="{{ $instansi->tgl_akhir == '1970-01-01' ? '' : tanggal($instansi->tgl_akhir) }}">
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
                       <!-- <a href="{{ $link }}/hapus/{{ $user_id }}/{{ $profil_id }}/{{ $instansi_id }}" class="btn btn-xs btn-outline-danger" onclick="return confirm('Yakin hapus {{ kapital($judul) }} {{ $instansi->nama }} ini?')" data-placement="top" data-toggle="tooltip" data-original-title="Hapus"><i class="fa fa-trash-alt"></i></a> -->
                    @endif
                </div>
                <div class="col-sm-6 text-right">
                    @if($aksi == 'lihat')
                        <a href="{{ $link }}/ubah/{{ $user_id }}/{{ $profil_id }}/{{ $instansi_id }}" class="btn btn-sm btn-outline-ubah">Ubah</a>
                        <a href="{{ $link }}/{{ $user_id }}/{{ $profil_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @elseif($aksi == 'tambah')
                        <input type="submit" class="btn btn-sm btn-tambah" value="Tambah">
                        <a href="{{ $link }}/{{ $user_id }}/{{ $profil_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                    @else
                        <input type="submit" class="btn btn-sm btn-ubah" value="Simpan">
                        <a href="{{ $link }}/lihat/{{ $user_id }}/{{ $profil_id }}/{{ $instansi_id }}" class="btn btn-sm btn-lihat">Kembali</a>    
                    @endif
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection