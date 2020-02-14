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
                    Mulai Konsultasi
                </div>
                <div class="card-body" align="center">
                    <form action="/tamu/telusur" method="GET">
                        
                        <div class="col-sm-4 mb-3">
                            <input type="text" name="cari" class="form-control text-center" placeholder="Cari NIK Anda .. " value="{{ old('cari') }}">

                            @if($errors->has('cari'))
                            <div class="text-danger">
                                {{ $errors->first('cari')}}
                            </div>
                            @endif
                        </div>
                        <div class="col-sm-2" align="left">
                            <input type="submit" class="btn btn-sm btn-block btn-success" value="CARI">
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </body>
</html>