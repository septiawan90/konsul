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
        
        <div class="row mb-3">
            <div class="col-sm-12">
                Data<br>
                <a href="{{ url('joperator/sarana/jenis/') }}/{{ $user_id }}/{{ $profil_id }}/{{ Crypt::encrypt($role->profesi_id) }}" class="btn btn-xs btn-primary">Jenis</a>
                <a href="{{ url('operator/sarana/klpd/') }}/{{ $user_id }}/{{ $profil_id }}/{{ Crypt::encrypt($role->profesi_id) }}" class="btn btn-xs btn-primary">KLPD</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-12">
                Aktor<br>
                <a href="{{ url('operator/sarana/petugas') }}/{{ $user_id }}/{{ $profil_id }}/{{ Crypt::encrypt($role->profesi_id) }}" class="btn btn-xs btn-warning">Petugas</a>
                <a href="{{ url('operator/sarana/tamu') }}/{{ $user_id }}/{{ $profil_id }}/{{ Crypt::encrypt($role->profesi_id) }}" class="btn btn-xs btn-warning">Tamu</a>
                <a href="{{ url('operator/sarana/lpp') }}/{{ $user_id }}/{{ $profil_id }}/{{ Crypt::encrypt($role->profesi_id) }}" class="btn btn-xs btn-primary">LPP</a>
                <a href="{{ url('operator/sarana/pengawas') }}/{{ $user_id }}/{{ $profil_id }}/{{ Crypt::encrypt($role->profesi_id) }}" class="btn btn-xs btn-warning">Pengawas</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-12">
                Daerah<br>
                <a href="{{ url('provinsi') }}" class="btn btn-xs btn-primary">Provinsi</a>
                <a href="{{ url('kota') }}" class="btn btn-xs btn-primary">Kota/Kab</a>
                <a href="{{ url('kecamatan') }}" class="btn btn-xs btn-primary">Kecamatan</a>
                <a href="{{ url('kelurahan') }}" class="btn btn-xs btn-primary">Kelurahan</a>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-sm-12">
                Acara<br>
                <a href="{{ url('operator/sarana/unit_kerja') }}/{{ $user_id }}/{{ $profil_id }}/{{ Crypt::encrypt($role->profesi_id) }}" class="btn btn-xs btn-primary">Unit Kerja</a>
                <a href="{{ url('operator/sarana/profesi') }}/{{ $user_id }}/{{ $profil_id }}/{{ Crypt::encrypt($role->profesi_id) }}" class="btn btn-xs btn-primary">Profesi</a>
                <a href="{{ url('operator/sarana/venue') }}/{{ $user_id }}/{{ $profil_id }}/{{ Crypt::encrypt($role->profesi_id) }}" class="btn btn-xs btn-primary">Venue</a>
            </div>
        </div>

        
    </div><!-- /.card-body -->
</div>