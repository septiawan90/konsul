<div class="card card-success card-outline">
    <div class="card-header p-2">
        <div class="card-title">
        {{ kapital($role->name) }}
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">
        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>SK</b> <a class="float-right">{{ $role->nomor }}</a>
            </li>
            <li class="list-group-item">
                <b>Masa Berlaku</b> <a class="float-right">{{ tanggal($role->kadaluarsa) }}</a>
            </li>
        </ul>

        @if($role->kadaluarsa > date('Y-m-d'))
        <h5 class="text-center">MENU</h5>
        <div class="row">
            <div class="col-sm-4 mb-3">
                <a href="{{ url('operator/konsultasi/subjek') }}" class="btn btn-xs btn-primary">Subjek</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 mb-3">
                Statistik<br>
                <a href="{{ url('operator/konsultasi/statistik/petugas') }}" class="btn btn-xs btn-primary">Petugas</a>
                <a href="{{ url('operator/konsultasi/statistik') }}" class="btn btn-xs btn-primary">Subjek</a>
                <a href="{{ url('operator/konsultasi/statistik/tamu') }}" class="btn btn-xs btn-primary">Tamu</a>
                <a href="{{ url('operator/konsultasi/statistik/tamu_subjek') }}" class="btn btn-xs btn-primary">Tamu Subjek</a>							
                <a href="{{ url('operator/konsultasi/statistik/tiket') }}" class="btn btn-xs btn-primary">Tiket</a>
            </div>
        </div>
        @else
        Tidak Aktif
        @endif

        
    </div><!-- /.card-body -->
</div>