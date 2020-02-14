@php $lpp_id = Crypt::encrypt(Auth::user()->owner->lpp->id); @endphp

<div class="card card-success card-outline">
    <div class="card-header p-2">
        <div class="card-title">
            LPP
        </div>
        <div class="card-tools">
            <button type="button" class="btn btn-tool btn-sm" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
            <i class="fas fa-minus"></i></button>
            <button type="button" class="btn btn-tool btn-sm" data-card-widget="remove" data-toggle="tooltip" title="Remove">
            <i class="fas fa-times"></i></button>
        </div>
    </div><!-- /.card-header -->
    <div class="card-body">
        <h5 class="text-center">{{ Auth::user()->owner->lpp->nama }}</h5>
        
        <ul class="list-group list-group-unbordered mb-3">
            <li class="list-group-item">
                <b>SK</b> <a class="float-right">{{ Auth::user()->profil->penerima->sk->nomor }}</a>
            </li>
            <li class="list-group-item">
                <b>Masa Berlaku</b> <a class="float-right">{{ tanggal(Auth::user()->profil->penerima->sk->kadaluarsa) }}</a>
            </li>
        </ul>
        <a href="{{ url('lpp/surat') }}/{{ $user_id }}/{{ $profil_id }}/{{ $lpp_id }}" class="btn btn-sm btn-success">Detil</a>

        
    </div><!-- /.card-body -->
</div>