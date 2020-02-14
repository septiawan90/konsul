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

        <div class="row">
            <div class="col-sm-12">
                <a href="{{ url('petugas/tiket/'.$user_id.'/'.$profil_id.'/'.Crypt::encrypt($role->profesi_id)) }}" class="btn btn-xs btn-primary">Tiket</a>
                <a href="{{ url('petugas/tamu/'.$user_id.'/'.$profil_id.'/'.Crypt::encrypt($role->profesi_id)) }}" class="btn btn-xs btn-primary">Tamu</a>
            </div>
        </div>
    </div><!-- /.card-body -->
</div>