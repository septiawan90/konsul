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

									<h3 class="profile-username text-center">{{ Auth::user()->profil->nama }} <sup><a href="/foto/{{ Crypt::encrypt(Auth::user()->profil->id) }}" class="btn btn-xs btn-outline-info" data-placement="right" data-toggle="tooltip" data-original-title="Ganti Foto"><i class="fa fa-camera-retro"></i></a></sup></h3>

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
										{{ kapital(Auth::user()->profil->kota->nama) }},
										{{ kapital(Auth::user()->profil->kota->provinsi->nama) }}
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
						<div class="col-md-8">
                            <div class="card card-primary card-outline">
								<div class="card-header">
									<h3 class="card-title">Foto <i class="fa fa-camera-retro"></i></h3>
                                </div>
                                <form method="post" action="{{ $form_action }}" onSubmit="return confirm('Anda yakin dengan foto ini?')" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
								<!-- /.card-header -->
								<div class="card-body">
									<input type="file" name="file" class="form-control-file {{ $errors->has('file') ? 'is-invalid' : 'is-warning' }}" value="{{ old('file') }}">
									@if($errors->has('file'))
										<sup class="text-danger"><small>{{ $errors->first('file')}}</small></sup>
									@endif
                                </div>
                                <div class="card-footer pb-1 pt-1">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <input type="submit" class="btn btn-sm btn-tambah" value="Simpan">
                                        </div>
                                    </div>
                                </div>
                                </form>
								<!-- /.card-body -->
                            </div>
						</div>
						<!-- /.col -->

					</div>
					<!-- /.row -->
				</div><!-- /.container-fluid -->
			</section>
			<!-- /.content -->
        </div>
    </div>
</div>
@endsection