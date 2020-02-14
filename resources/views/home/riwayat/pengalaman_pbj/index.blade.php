<div class="card card-primary card-outline">
    <div class="card-header p-2">
        <div class="card-title">
            Riwayat Pengalaman PBJ
        </div>
        <div class="card-tools mr-1">
            <a href="riwayat/pengalaman_pbj/{{ $user_id }}/{{ $profil_id }}" class="btn btn-xs btn-outline-primary">Detil</a>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">

        @forelse($pengalaman_pbj as $row)

        <i class="fas fa-suitcase mr-1"></i> {{ $row->tahun }}
        <div class="row text-muted">
            <div class="col-sm-4">Pelaku PBJ</div>
            <div class="col-sm-8"><span class="float-right text-right">{{ $row->pelaku_pbj->nama }}</span></div>
        </div>
        <div class="row text-muted">
            <div class="col-sm-4">Kode Paket</div>
            <div class="col-sm-8"><span class="float-right text-right">{{ $row->kode_paket }}</span></div>
        </div>
        <div class="row text-muted">
            <div class="col-sm-4">Nama Paket</div>
            <div class="col-sm-8"><span class="float-right text-right">{{ $row->nama_paket }}</span></div>
        </div>
        <div class="row text-muted">
            <div class="col-sm-4">Nilai Paket</div>
            <div class="col-sm-8"><span class="float-right text-right">{{ $row->nilai_paket }}</span></div>
        </div>
        <hr>
        
        @empty
            Belum disii.
        @endforelse
        
        
    </div><!-- /.card-body -->
</div>