@extends('layouts.lte')

@section('content')
<div class="container">
    
    <div class="card">
        <div class="card-header text-center">
            <h5 class="card-title m-0">
                <a href="{{ $link }}">{{ strpos($judul, "_") ? str_replace("_", " ", strtoupper($judul)) : strtoupper($judul) }}</a> 
                @if($subsubjudul)
                    @if($aksi)
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($sk->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ $subsubjudul }}/{{ Crypt::encrypt($sk->id) }}/{{ Crypt::encrypt($penerima->id) }}'>{{ strtoupper($subsubjudul) }}</a>
                        <small><i class="fas fa-frog {{ $aksi }}"></i></small> <span class="{{ $aksi }}">{{ strtoupper($aksi) }}</span>
                    @else
                        <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $subjudul }}/{{ Crypt::encrypt($sk->id) }}'>{{ strtoupper($subjudul) }}</a> <small><i class='fas fa-arrow-circle-right'></i></small> {{ strtoupper($subsubjudul) }}
                    @endif
                @else
                    @if($subjudul)
                        @if($aksi)
                            <small><i class='fas fa-arrow-circle-right'></i></small> <a href='{{ $link }}/{{ $judul }}/{{ $subjudul }}/{{ Crypt::encrypt($sk->id) }}'>{{ strtoupper($subjudul) }}</a> 
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
                <form action="{{ route('users.cari') }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                <div class="col-sm-5"></div>
                <div class="col-sm-7">{{ $users->links() }}</div>
            </div>
            
            <div class="row">
                <div class="col-lg-12">
                    @if($message = Session::get('success'))
                    <div class="alert alert-success alert-block mt-0">
                        <button type="button" class="close" data-dismiss="alert">×</button> 
                        {!! $message !!}
                    </div>
                    @endif
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">No</th>
                                <th width="15%" class="text-center">NIK</th>
                                <th class="text-center">Nama</th>
                                <th width="25%" class="text-center">Email</th>
                                <th width="15%" class="text-center">Role</th>
                                <th width="7%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $no = ($users->currentPage() - 1) * $users->perPage() + 1;
                            @endphp

                            @forelse($users as $row)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $row->nik }}</td>
                                <td class="text-center">{{ isset($row->profil->nama) ? kapital($row->profil->nama) : '' }}</td>
                                <td class="text-center">{{ $row->email }}</td>
                                <td class="text-center">
                                    @foreach($row->getRoleNames() as $role)
                                    <label for="" class="badge badge-info">{{ $role }}</label>
                                    @endforeach
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('users.roles', $row->id) }}" class="btn btn-outline-info btn-xs"><i class="fa fa-user-secret"></i></a>
                                    <a href="{{ route('users.edit', $row->id) }}" class="btn btn-outline-warning btn-xs"><i class="fa fa-edit"></i></a>
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
            <small>Hal. ke : {{ $users->currentPage() }} | Jumlah: <b class="text-success">{{ $users->count() }}</b> / {{ $users->total() }} Data</small>
            </h5>
        </div>
    </div>
</div>
@endsection