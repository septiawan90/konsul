@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header text-left">
            Konsultasi Sertifikasi
        </div>
        <div class="card-body">
            <form method="post" action="/layanan/update/{{ $tiket->id }}/{{ $konsultasi->id }}">
            
            {{ csrf_field() }}
            {{ method_field('PUT') }}
                <div class="row">
                    <div class="col-sm-4">
                        <div class="row mb-3">
                            <div class="col-sm-4">Tiket</div>
                            <div class="col-sm-8">{{ $tiket->nomor }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">Tanggal</div>
                            <div class="col-sm-8">{{ hari($tiket->created_at).', '.date("d-m-Y", strtotime($tiket->created_at)) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row mb-3">
                            <div class="col-sm-4">Nama</div>
                            <div class="col-sm-8">{{ kapital($tamu->nama) }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">NIK</div>
                            <div class="col-sm-8">{{ maskText($tamu->nik) }}</div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">NIP/NRP</div>
                            <div class="col-sm-8">{{ maskText($tamu->nip) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="row mb-3">
                            <div class="col-sm-4">Instansi</div>
                            <div class="col-sm-8">{{ kapital($tamu->instansi) }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-sm-4">Email</div>
                            <div class="col-sm-8">{{ maskEmail($tamu->email) }}</div>
                        </div>

                        <div class="row">
                            <div class="col-sm-4">HP</div>
                            <div class="col-sm-8">{{ maskText($tamu->hp) }}</div>
                        </div>
                    </div>
                </div>

            <div class="row mt-3">
                <div class="col-sm-12">    
                    <div class="row mb-3">
                        <div class="col-sm-2">
                            Subjek
                        </div>
                        <div class="col-sm-10">
                            <select name="subjek_id" class="form-control">
                            @foreach($subjek as $s)
                                <option value="{{ $s->id }}" {{ $tiket->subjek_id == $s->id ? "selected" : "" }}>{{ $s->kode }}:{{ $s->subjek }}</option>
                            @endforeach
                            </select>

                            @if($errors->has('subjek_id'))
                                <div class="text-danger">
                                    {{ $errors->first('subjek_id')}}
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-2">
                            Konsultasi
                        </div>
                        <div class="col-sm-10">
                            {!! $konsultasi->konsultasi !!}
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-2">
                            Jawaban
                        </div>
                        <div class="col-sm-10">
                            <textarea name="jawaban" class="jawaban" placeholder="Jawaban ..">{{ $konsultasi->jawaban }}</textarea>
                            <script src="{{ asset('node_modules/tinymce/tinymce.js') }}"></script>
                            <script>
                                tinymce.init({
                                    selector:'textarea.jawaban',
                                    menubar:false,
                                    plugins:"lists",
                                    toolbar:"numlist bullist",
                                    height: 300
                                });
                            </script>

                                @if($errors->has('jawaban'))
                                <div class="text-danger">
                                    {{ $errors->first('jawaban')}}
                                </div>
                            @endif
                        </div>                                    
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <input type="submit" class="btn btn-sm btn-success" value="Simpan">
                            <a href="/layanan/detil/{{ Crypt::encrypt($tiket->id) }}" class="btn btn-sm btn-primary">Kembali</a>
                        </div>                                    
                    </div>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection