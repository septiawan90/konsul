<div class="card card-success card-outline">
    <div class="card-header p-2">
        <div class="card-title">
        {{ Auth::user()->roles->first()->name }}
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
                <b>SK</b> <a class="float-right">xxx</a>
            </li>
            <li class="list-group-item">
                <b>Masa Berlaku</b> <a class="float-right">xxx</a>
            </li>
        </ul>

        <h5 class="text-center">MENU</h5>
        
        <div class="row">
            <div class="col-sm-4 mb-3">
                <a href="{{ url('operator/bmn/aset') }}" class="btn btn-sm btn-block btn-warning">Aset</a>
            </div>
        </div>

        
    </div><!-- /.card-body -->
</div>