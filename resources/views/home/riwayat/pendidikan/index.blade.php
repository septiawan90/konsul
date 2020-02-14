<div class="card card-primary card-outline">
    <div class="card-header p-2">
        <div class="card-title">
            Riwayat Pendidikan
        </div>
        <div class="card-tools mr-1">
            <a href="riwayat/pendidikan/{{ $user_id }}/{{ $profil_id }}" class="btn btn-xs btn-outline-primary">Detil</a>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">

        @forelse($pendidikan as $row)

        <i class="fas fa-suitcase mr-1"></i> {{ $row->strata->nama }}
        <div class="row text-muted">
            <div class="col-sm-4"> Institusi</div>
            <div class="col-sm-8"><span class="float-right text-right">{{ $row->institusi }}</span></div>
        </div>
        <div class="row text-muted">
            <div class="col-sm-4"> Tahun Lulus</div>
            <div class="col-sm-8"><span class="float-right text-right">{{ $row->thn_lulus }}</span></div>
        </div>
        <hr>
        
        @empty
            Belum disii.
        @endforelse
        
        
    </div><!-- /.card-body -->
</div>