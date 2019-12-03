@extends('layouts.backend')

@section('pageTitle')
Pengguna

@endsection
@section('xtitle')
<!-- <a data-toggle="modal" href="#modal-edit" onclick="prepareAdd()"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add Data</button></a> -->
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
                <th>ID User</th>
                <th>Role</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>No Darurat</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID User</th>
                <th>Role</th>
                <th>Nama</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>No Darurat</th>
                <th>Status</th>
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
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            ID User
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="ID User" class="form-control" name="id_user" id="id_user" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Role
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Role" class="form-control" name="id_role" id="id_role" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Nama
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Name" class="form-control" name="name" id="name" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Email
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Email" class="form-control" name="email" id="email" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            No HP
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Penolong" class="form-control" name="no_hp" id="no_hp" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Alamat
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Alamat" class="form-control" name="alamat" id="alamat" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            No Darurat
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="No Darurat" class="form-control" name="no_darurat" id="no_darurat" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Pesan
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Pesan" class="form-control" name="pesan" id="pesan" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Status
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select type="text" placeholder="Status" class="form-control select_status" name="status" id="status" required="" onchange="validate()">
                                <option value="00">- Pilih Status -</option>
                            </select>
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
      if($('#status').val() != "00")
      { 
        document.getElementById("buttonSubmit").disabled = false;
        console.log("benar");
      }
      else{
        document.getElementById("buttonSubmit").disabled = true;     
      }
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
"{{ url('#') }}"
@endsection

@section('updateurl')
"{{ url('backend/pengguna/detail') }}/"+id
@endsection

@section('deleteurl')
"{{ url('#') }}"
@endsection

@section('dataurl')
{
   "url": "{{ url('backend/pengguna/data') }}",
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
"{{ url('backend/pengguna/detail') }}/"+id
@endsection

@section('leftcolumsfeeze')
1	
@endsection

@section('searchable')
{ searchable: false, targets: [6],
          render : function (data, type, row) {
             return data == '1' ? 'Aktif' : 'Tidak Aktif'
          }
}
@endsection

@section('col')
[
    { "data": "id_user" },
    { "data": "id_role" },
    { "data": "name" },
    { "data": "no_hp" },
    { "data": "alamat" },
    { "data": "no_darurat" },
    { "data": "status" },
    { "data": "action" },
]
@endsection

@section('add_select_status')
$('.select_status').empty();
$('.select_status').append('<option value="1">Aktif</option>');
$('.select_status').append('<option value="0">Tidak Aktif</option>');
@endsection

