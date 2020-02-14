@php
$user_id 	= Crypt::encrypt(Auth::user()->id);
$profil_id 	= Crypt::encrypt(Auth::user()->profil->id);
@endphp

@extends('layouts.lte')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
			<!-- Main content -->
			<section class="content">
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-4">

							<!-- Profile Image -->
							<div class="card card-primary card-outline">
								<div class="card-body box-profile">
									<div class="text-center">

									<img class="profile-user-img img-fluid img-circle"
										src="{{ Auth::user()->profil->file ? Storage::url(Auth::user()->profil->file) : Storage::url('user.jpg') }}"
										alt="User profile picture">
									</div>

									<h3 class="profile-username text-center">{{ Auth::user()->profil->nama }} <sup><a href="/home/foto/{{ $user_id }}/{{ $profil_id }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Ganti Foto"><i class="fa fa-camera-retro"></i></a></sup></h3>
									@if($message = Session::get('success'))
									<div class="alert alert-success alert-block mt-1 mb-1">
										<button type="button" class="close" data-dismiss="alert">×</button> 
										<strong>{{ $message }}</strong>
									</div>
									@endif
									<p class="text-muted text-center">{{ Auth::user()->email }}</p>

									<ul class="list-group list-group-unbordered mb-3">
										<li class="list-group-item">
											<b>NIK</b> <a class="float-right">{{ Auth::user()->nik }}</a>
										</li>
										<li class="list-group-item">
											<b>HP</b> <a class="float-right">{{ Auth::user()->profil->no_hp }}</a>
										</li>
									</ul>
								</div>
								<!-- /.card-body -->
							</div>
							<!-- /.card -->

							<!-- About Me Box -->
							<div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">Data</h3>
								</div>
								<!-- /.card-header -->
								<div class="card-body">
									<strong><i class="fas fa-book mr-1"></i> Alamat</strong>

									<p class="text-muted">
										{{ Auth::user()->profil->alamat }}
									</p>
									<hr>
									<strong><i class="fas fa-map-marker-alt mr-1"></i> Lokasi</strong>
									<p class="text-muted">
										{{ Auth::user()->profil->kota_id != null ? kapital(Auth::user()->profil->kota->nama) : '' }},
										{{ Auth::user()->profil->kota_id != null ? kapital(Auth::user()->profil->kota->provinsi->nama) : '' }}
									</p>
									<hr>
									<strong><i class="fas fa-envelope mr-1"></i> Alternatif Email</strong>
									<p class="text-muted">
										{{ Auth::user()->profil->email2 }}
									</p>
								</div>
								<!-- /.card-body -->
							</div>
							
						<!-- /.card -->
						</div>
						<!-- /.col -->
						@if(is_null($profil->file) || empty($profil->file) || $instansi->count() == 0 || $pendidikan->count() == 0)
						<div class="col-md-8">
							<div class="row mb-2">
								<div class="col-md-1 text-center">
									{!! $profil->file ? "<i class='fa fa-star text-success'></i>" : "<i class='fa fa-star text-danger'></i>" !!}
								</div>
								<div class="col-md-11">
									<a href="/home/foto/{{ $user_id }}/{{ $profil_id }}" class="btn btn-sm btn-block {!! $profil->file ? 'btn-success' : 'btn-outline-danger' !!}" data-placement="right" data-toggle="tooltip" data-original-title="Unggah Foto">{!! $profil->file ? 'Foto sudah diunggah' : 'Foto belum diunggah'  !!}</a>
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-md-1 text-center">
									{!! $instansi->count() > 0 ? "<i class='fa fa-star text-success'></i>" : "<i class='fa fa-star text-danger'></i>" !!}
								</div>
								<div class="col-md-11">
									<a href="riwayat/instansi/tambah/{{ $user_id }}/{{ $profil_id }}" class="btn btn-sm btn-block {!! $instansi->count() > 0 ? 'btn-success disabled' : 'btn-outline-danger' !!}" data-placement="right" data-toggle="tooltip" data-original-title="Riwayat Instansi">{!! $instansi->count() > 0 ? 'Riwayat Instansi sudah diisi' : 'Riwayat Instansi belum diisi'  !!}</a>
								</div>
							</div>
							<div class="row mb-2">
								<div class="col-md-1 text-center">
									{!! $pendidikan->count() > 0 ? "<i class='fa fa-star text-success'></i>" : "<i class='fa fa-star text-danger'></i>" !!}
								</div>
								<div class="col-md-11">
									<a href="riwayat/pendidikan/tambah/{{ $user_id }}/{{ $profil_id }}" class="btn btn-sm btn-block {!! $pendidikan->count() > 0 ? 'btn-success disabled' : 'btn-outline-danger'  !!}" data-placement="right" data-toggle="tooltip" data-original-title="Riwayat Pendidikan">{!! $pendidikan->count() > 0 ? 'Riwayat Pendidikan sudah diisi' : 'Riwayat Pendidikan belum diisi'  !!}</a>
								</div>
							</div>
						</div>
						@else
						<div class="col-md-4">
							<!-- Riwayat Sertifikasi -->
							@include('home.riwayat.sertifikasi.index')

							<!-- Riwayat Pelatihan -->
							@include('home.riwayat.pelatihan.index')

							<!-- Riwayat Pengalaman PBJ -->
							@include('home.riwayat.pengalaman_pbj.index')

							<!-- Riwayat Instansi -->
							@include('home.riwayat.instansi.index')

							<!-- Riwayat Pendidikan -->
							@include('home.riwayat.pendidikan.index')

							<!-- Riwayat Jabatan -->
							@include('home.riwayat.jabatan.index')

							<!-- Riwayat Pangkat -->
							@include('home.riwayat.pangkat.index')
						</div>
						<!-- /.col -->
						<div class="col-md-4">
							@foreach($model_roles as $role)

								@if($role->name == 'pelaksana ujian') <!-- Role LPP -->
									@include('home.roles.lpp.index')
								@endif

								@if($role->name == 'operator sarana') <!-- Role -->
									@include('home.roles.operator.sarana.index')
								@endif

								@if($role->name == 'operator konsultasi') <!-- Role -->
									@include('home.roles.operator.konsultasi.index')
								@endif

								@if($role->name == 'operator sertifikat') <!-- Role -->
									@include('home.roles.operator.sertifikat.index')
								@endif

								@if($role->name == 'operator bmn') <!-- Role -->
									@include('home.roles.operator.bmn.index')
								@endif

								@if($role->name == 'operator jadwal') <!-- Role -->
									@include('home.roles.operator.jadwal.index')
								@endif

								@if($role->name == 'operator monev') <!-- Role -->
									@include('home.roles.operator.monev.index')
								@endif

								@if($role->name == 'operator legal') <!-- Role -->
									@include('home.roles.operator.legal.index')
								@endif

								@if($role->name == 'petugas') <!-- Role -->
									@include('home.roles.petugas.index')
								@endif

								@if($role->name == 'admin')
									@include('home.roles.admin.index')
								@endif

							@endforeach
							
						</div>


						@endif

					</div>
					<!-- /.row -->
				</div><!-- /.container-fluid -->
			</section>
			<!-- /.content -->
        </div>
    </div>
</div>
@endsection