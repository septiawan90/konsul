<!DOCTYPE html>
<html>
<head>
	<title>Konsultasi Sertifikasi</title>
	<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

	<div class="container">

		<div class="card mt-5">
			<div class="card-header text-center">
				Konsultasi > Tamu <strong>DATA SAMPAH</strong>
			</div>
			<div class="card-body">
				<a href="/tamu" class="btn btn-sm btn-primary">Data Tamu</a>
				|
				<a href="/tamu/kembalikan_semua" class="btn btn-sm btn-warning">Kembalikan Semua</a>
				<br/>
				<br/>
				<table class="table table-bordered">
					<thead>
                        <tr>
                            <th width="5%" style="text-align: center;">NO</th>
                            <th width="15%" style="text-align: center;">NIK</th>
                            <th width="15%" style="text-align: center;">NIP</th>
                            <th style="text-align: center;">Nama</th>
                            <th width="15%" style="text-align: center;">Email</th>
                            <th width="15%" style="text-align: center;">HP</th>
                            <th width="15%" style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 0;
                        ?>
                        @foreach($tamu as $t)
                        <tr>
                            <td style="text-align: center;">{{ ++$no }}</td>
                            <td style="text-align: center;">{{ $t->nik }}</td>
                            <td style="text-align: center;">{{ $t->nip }}</td>
                            <td>{{ $t->nama }}</td>
                            <td>{{ $t->email }}</td>
                            <td>{{ $t->hp }}</td>
                            <td style="text-align: center;">
                                <a href="/tamu/kembalikan/{{ Crypt::encrypt($t->id) }}" class="btn btn-success btn-sm">Kembalikan</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
				</table>
			</div>
		</div>
	</div>	
</body>
</html>