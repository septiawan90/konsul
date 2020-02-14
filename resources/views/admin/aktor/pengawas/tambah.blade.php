<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
        <title>Konsultasi Sertifikasi</title>
    </head>
    <body>
        <div class="container">
            <div class="card mt-5">
                <div class="card-header text-center">
                    Konsultasi > Tamu <strong>TAMBAH DATA</strong>
                </div>
                <div class="card-body">
                    <form method="post" action="/tamu/store">
                        {{ csrf_field() }}

                        <div class="row mb-2">
                            <div class="col-sm-2">
                                NIK **
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="nik" class="form-control" placeholder="No. KTP ..">
                            </div>
                            <div class="col-sm-4">
                                @if($errors->has('nik'))
                                    <div class="text-danger">
                                        {{ $errors->first('nik')}}
                                    </div>
                                @endif
                            </div>                        
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-2">
                                NIP
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="nip" class="form-control" placeholder="NIP ..">
                            </div>
                            <div class="col-sm-4">
                                @if($errors->has('nip'))
                                    <div class="text-danger">
                                        {{ $errors->first('nip')}}
                                    </div>
                                @endif
                            </div>                        
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-2">
                                Nama **
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap Tanpa Gelar ..">
                            </div>
                            <div class="col-sm-4">
                                @if($errors->has('nama'))
                                    <div class="text-danger">
                                        {{ $errors->first('nama')}}
                                    </div>
                                @endif
                            </div>                        
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-2">
                                Email **
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="email" class="form-control" placeholder="Email ..">
                            </div>
                            <div class="col-sm-4">
                                @if($errors->has('email'))
                                    <div class="text-danger">
                                        {{ $errors->first('email')}}
                                    </div>
                                @endif
                            </div>                        
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-2">
                                HP **
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="hp" class="form-control" placeholder="HP ..">
                            </div>
                            <div class="col-sm-4">
                                @if($errors->has('hp'))
                                    <div class="text-danger">
                                        {{ $errors->first('hp')}}
                                    </div>
                                @endif
                            </div>                        
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-2">
                                Instansi
                            </div>
                            <div class="col-sm-6">
                                <input type="text" name="instansi" class="form-control" placeholder="Instansi tanpa disingkat ..">
                            </div>
                            <div class="col-sm-4">
                                @if($errors->has('instansi'))
                                    <div class="text-danger">
                                        {{ $errors->first('instansi')}}
                                    </div>
                                @endif
                            </div>                        
                        </div>

                        <div class="row mb-2">
                            <div class="col-sm-2">
                            </div>
                            <div class="col-sm-6">
                                <input type="submit" class="btn btn-sm btn-success" value="Simpan">
                            </div>
                            <div class="col-sm-4">
                                
                            </div>                        
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </body>
</html>