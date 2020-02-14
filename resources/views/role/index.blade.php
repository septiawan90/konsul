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
                <form action="{{ route('role.cari') }}" method="GET" class="form-inline ml-0 ml-md-3">
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
                <div class="col-sm-5"><a href="{{ $judul }}/tambah" class="btn btn-sm btn-outline-tambah">Tambah</a>
                    <!-- <form role="form" action="{{ route('role.store') }}" method="POST">
                        @csrf
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                    </form> -->
                </div>
                <div class="col-sm-7">{{ $role->links() }}</div>
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
                                <th width="5%" class="text-center">#</th>
                                <th width="10%" class="text-center">Kode</th>
                                <th class="text-center">Role</th>
                                <th class="text-center">Unit Kerja</th>
                                <th width="10%" class="text-center">Guard</th>
                                <th width="13%" class="text-center">Dibuat</th>
                                <th width="5%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php 
                            $no = ($role->currentPage() - 1) * $role->perPage() + 1;
                            @endphp

                            @forelse($role as $row)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td class="text-center">{{ $row->kode }}</td>
                                <td class="text-center">{{ $row->name }}</td>
                                <td class="text-center">{{ isset($row->unit_kerja->nama) ? $row->unit_kerja->nama : '' }}</td>
                                <td class="text-center">{{ $row->guard_name }}</td>
                                <td class="text-center">{{ tanggal($row->created_at) }}</td>
                                <td class="text-center">
                                    <!-- <form action="{{ route('role.destroy', $row->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-outline-danger btn-xs"><i class="fa fa-trash"></i></button>
                                        
                                    </form> -->
                                    <a href="/role/lihat/{{ Crypt::encrypt($row->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Lihat"><i class="fa fa-paste"></i></a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="card-footer text-center">
            <h5 class="card-title m-0">
            <small>Hal. ke : {{ $role->currentPage() }} | Jumlah: <b class="text-success">{{ $role->count() }}</b> / {{ $role->total() }} Data</small>
            </h5>
            <a href="{{ $judul }}/sampah" class="btn btn-xs btn-outline-danger float-right" data-placement="left" data-toggle="tooltip" data-original-title="Data Sampah"><i class="fas fa-trash"></i></a>
        </div>
    </div>
</div>
@endsection