<div class="card card-primary card-outline">
    <div class="card-header p-2">
        <div class="card-title">
            Riwayat Instansi
        </div>
        <div class="card-tools mr-1">
            <a href="riwayat/instansi/{{ $user_id }}/{{ $profil_id }}" class="btn btn-xs btn-outline-primary">Detil</a>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">
        
        @forelse($instansi as $row)

        <i class="fas fa-building mr-1"></i> {{ $row->klpd->nama }} {{ $row->klpd->alias ? '('.$row->klpd->alias.')' : '' }}
        <div class="row text-muted">
            <div class="col-sm-4">Nomor</div>
            <div class="col-sm-8"><span class="float-right text-right">{{ $row->nomor_pegawai }}</span></div>
        </div>
        <div class="row text-muted">
            <div class="col-sm-4">Masa Aktif</div>
            <div class="col-sm-8"><span class="float-right text-right">{{ tanggal($row->tgl_mulai) }} {{ $row->tgl_akhir != '1970-01-01' ? 's.d '.tanggal($row->tgl_akhir) : 's.d Sekarang' }}</span></div>
        </div>
        <hr>
        
        @empty
        <div class="col-sm-12 text-center"><label>Belum dibuat</label></div>
        @endforelse
        
        
    </div><!-- /.card-body -->
</div>