@extends('layouts.backend')

@section('pageTitle')
Ambulance

@endsection
@section('xtitle')
<a data-toggle="modal" href="#modal-edit" onclick="prepareAdd()"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add Data</button></a>
<div id="loadingTable" class="text-center">
    <img src="{{ asset('assets/image/loading.gif') }}">
</div>
@endsection
@section('content')
<!-- <script src="{{URL::to('plugin/ckeditor/ckeditor.js')}}"></script>
<script src="{{URL::to('plugin/ckeditor/config.js')}}"></script> -->
<div class="table-responsive displayNone">       
    <table class="table table-striped table-bordered" id="data-table" style="width:100%">
        <thead>
            <tr>
                <th>ID Ambulan</th>
                <th>Username</th>
                <th>Kode</th>
                <th>Nopol</th>
                <th>Nama RS</th>
                <th>Alamat RS</th>
                <th>No Telp RS</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID Ambulan</th>
                <th>Username</th>
                <th>Kode</th>
                <th>Nopol</th>
                <th>Nama RS</th>
                <th>Alamat RS</th>
                <th>No Telp RS</th>
                <th>Action</th>
            </tr>
        </tfoot>
    </table>
</div>

<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM DATA</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <form action="" method="POST" class="form-horizontal" role="form" id="form-data">
                <input type='hidden' id='id' name="id">
                <input type='hidden' id='_method' value="POST" name="_method">
                <input type='hidden' id='_token' value="{{csrf_token()}}" name="_token">
                    <div class="form-group">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="hidden" placeholder="ID Ambulan" class="form-control" name="id_ambulan" id="id_ambulan" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Username
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Username" class="form-control" name="username" id="username" value="" required="" onchange="validate()" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Kode
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Kode" class="form-control" name="kode" id="kode" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Nopol
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Nomor Polisi Ambulan" class="form-control" name="no_pol_ambulan" id="no_pol_ambulan" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Nama RS
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Nama RS" class="form-control" name="nama_rs" id="nama_rs" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Alamat RS
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Alamat RS" class="form-control" name="alamat_rs" id="alamat_rs" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            No Telp RS
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="No Telp RS" class="form-control" name="no_telp_rs" id="no_telp_rs" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                        	<button type="submit" id="buttonSubmit" class="btn btn-primary">Submit</button>
                            <input type="reset" value="Reset" class="btn btn-default hidden" id="reset">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="close">Close</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            
            <div class="modal-footer hidden">
                
            </div>
        </div>
    </div>
</div>
@endsection

@section('customjs')

<script type="text/javascript" src="{{ URL::to('js/select2.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/select2.min.css') }}">
<script type="text/javascript">
	function prepareAdd(){
		$('#id').val('');
		$('#reset').click();
    }
</script>
<script type="text/javascript">
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $(".select2").select2();
    });

    function loaddata(arg) {
        
    }
</script>
<style type="text/css">
    .select2-container--default .select2-selection--single { min-height: 34px; padding-top: 2px; }
    .select2-container--default .select2-selection--single .select2-selection__arrow { height: 34px !important; }
    .select2 { width: 100% !important; }
</style>

<script type="text/javascript">
    
</script>

<script type="text/javascript">
    function validate()
    {
      
    }
</script>
@endsection

@section('id')
'id'
@endsection

@section('orderbycustom')
order: [
    [ 0, "desc" ]
],
@endsection

@section('redirect')
"{{ url('#') }}"
@endsection

@section('storeurl')
"{{ url('backend/ambulance/create') }}"
@endsection

@section('updateurl')
"{{ url('backend/ambulance/detail') }}/"+id
@endsection

@section('deleteurl')
"{{ url('backend/ambulance/delete') }}/"+id
@endsection

@section('dataurl')
{
   "url": "{{ url('backend/ambulance/data') }}",
   "type": "POST",
   "data":{
         "_token": "{{ csrf_token() }}"
    },
}
@endsection

@section('serverside')
true
@endsection

@section('prepareediturl')
"{{ url('backend/ambulance/detail') }}/"+id
@endsection

@section('leftcolumsfeeze')
1	
@endsection

@section('searchable')
{ searchable: false, targets: [] },
@endsection

@section('col')
[
    { "data": "id_ambulan" },
    { "data": "username" },
    { "data": "kode" },
    { "data": "no_pol_ambulan" },
    { "data": "nama_rs" },
    { "data": "alamat_rs" },
    { "data": "no_telp_rs" },
    { "data": "action" },
]
@endsection

