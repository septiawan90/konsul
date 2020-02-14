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
                <a href="#" data-placement="left" data-toggle="tooltip" data-original-title="{{ $sk->created_at == $sk->updated_at ? 'Dibuat : '.lastUpdate($sk->created_at) : 'Diubah : '.lastUpdate($sk->updated_at) }}"><i class="fas fa-info-circle"></i></a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-sm-2">Nama</div>
                        <div class="col-sm-10">{{ $penerima->profil->nama }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">Email</div>
                        <div class="col-sm-10">{{ $penerima->profil->user->email }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">NIK</div>
                        <div class="col-sm-10">{{ $penerima->profil->user->nik }}</div>
                    </div>

                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="13%" class="text-center">Nomor</th>
                                <th width="13%" class="text-center">Tanggal</th>
                                <th class="text-center">Tentang</th>
                                <th width="13%" class="text-center">Profesi</th>
                                <th width="13%" class="text-center">Kadaluarsa</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                            @endphp

                            @foreach($profesi as $row)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $row->nomor }}</td>
                                <td class="text-center">{{ tanggal($row->tanggal) }}</td>
                                <td class="text-center">{{ $row->tentang }}</td>
                                <td class="text-center">{{ $row->role->name }}</td>
                                <td class="text-center">{!! $row->kadaluarsa <= date('Y-m-d') ? tanggal($row->kadaluarsa)." <i class='fa fa-times-circle text-danger'></i>" :  tanggal($row->kadaluarsa)." <i class='fa fa-check-circle text-success'></i>" !!}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col-sm-6"></div>
                <div class="col-sm-6 text-right">
                    <a href="{{ $link }}/{{ $subjudul }}/{{ $user_id }}/{{ $profil_id }}/{{ $profesi_id }}/{{ $sk_id }}" class="btn btn-sm btn-lihat">Kembali</a>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>
@endsection