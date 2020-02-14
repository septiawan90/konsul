<div class="card card-primary card-outline">
    <div class="card-header p-2">
        <div class="card-title">
            Riwayat Sertifikasi
        </div>
        <div class="card-tools mr-1">
            <a href="riwayat/sertifikasi/{{ $user_id }}/{{ $profil_id }}" class="btn btn-xs btn-outline-primary">Detil</a>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">
        
        @forelse($sertifikasi as $row)

        <i class="fas fa-calendar-alt mr-1"></i> {{ tanggal($row->kegiatan->tanggal) }} <span class="float-right">{{ $row->kode }}</span>
        <div class="row text-muted">
            <div class="col-sm-4">Lokasi</div>
            <div class="col-sm-8"><span class="float-right text-right">{{ kapital($row->kegiatan->venue->nama) }}<br>{{ kapital($row->kegiatan->venue->kota->nama) }}</span></div>
        </div>
        <div class="row text-muted">
            <div class="col-sm-4">Pelaksana</div>
            <div class="col-sm-8"><span class="float-right text-right">{{ kapital($row->kegiatan->surat->lpp->nama) }}</span></div>
        </div>
        <div class="row text-muted">
            <div class="col-sm-4">Status</div>
            <div class="col-sm-8"><span class="float-right text-right">Lulus/Tidak Lulus + Skor + Sertifikat</span></div>
        </div>
        <hr>
        
        @empty
            Belum disii.
        @endforelse
        
        
    </div><!-- /.card-body -->
</div>