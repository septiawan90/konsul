@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-center">
            MANAJEMENT <strong>ROLE</strong>xxxxx
        </div>
        <div class="card-body">
            
            <div class="row mb-3">
                <div class="col-sm-4 text-right">Tambah Role</div>
                <div class="col-sm-4">
                    <form role="form" action="{{ route('role.store') }}" method="POST">
                        @csrf
                        <input type="text" name="name" class="form-control {{ $errors->has('name') ? 'is-invalid':'' }}" id="name" required>
                    </form>
                </div>
                <div class="col-sm-4">
                    @if(session('error'))
                        {!! session('error') !!}
                    @endif

                    @if (session('success'))
                        {!! session('success') !!}
                    @endif
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-sm-12">
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center">#</th>
                                <th>Role</th>
                                <th width="10%" class="text-center">Guard</th>
                                <th width="20%" class="text-center">Created At</th>
                                <th width="10%" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = ($role->currentPage() - 1) * $role->perPage() + 1;
                            ?>
                            @foreach($role as $row)
                            <tr>
                                <td class="text-center">{{ $no++ }}</td>
                                <td>{{ $row->name }}</td>
                                <td class="text-center">{{ $row->guard_name }}</td>
                                <td class="text-center">{{ $row->created_at }}</td>
                                <td class="text-center">
                                    <form action="{{ route('role.destroy', $row->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <table width="100%">
                    <tr>
                        <td width="10%">Halaman ke</td>
                        <td width="40%">: {{ $role->currentPage() }}</td>
                        <td rowspan="3">{{ $role->links() }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>: {{ $role->total() }} Data</td>
                    </tr>
                    <tr>
                        <td>Per Halaman</td>
                        <td>: {{ $role->perPage() }} Data</td>
                    </tr>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection