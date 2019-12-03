@extends('layouts.backend')

@section('pageTitle')
Admin

@endsection
@section('xtitle')
<a data-toggle="modal" href="#modal-edit" onclick="prepareAdd()"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add Data</button></a>
<a data-toggle="modal" href="#modal-update_password"><button type="button" class="btn btn-danger"><i class="fa fa-lock"></i> Ubah Password</button></a>
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

            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID User</th>
                <th>Role</th>
                <th>Nama</th>
                <th>No HP</th>
               
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
                    <!-- <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            ID User
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="ID User" class="form-control" name="id_user" id="id_user" value="" required="" onchange="validate()" >
                        </div>
                    </div> -->
                    <div class="form-group hidden">
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="hidden" placeholder="Role" class="form-control" name="id_role" id="id_role" value="3" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Nama
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Name" class="form-control" name="name" id="name" value="" required="" onchange="validate()" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Email
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Email" class="form-control" name="email" id="email" value="" required="" onchange="validate()" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            No HP
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="No HP" class="form-control" name="no_hp" id="no_hp" value="" required="" onchange="validate()" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Password
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="password" placeholder="Password" class="form-control" name="kode" id="kode" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            No Darurat
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="No Darurat" class="form-control" name="no_darurat" id="no_darurat" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div> -->
                    <!-- <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Pesan
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Pesan" class="form-control" name="pesan" id="pesan" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div> -->
                    <!-- <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Status
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select type="text" placeholder="Status" class="form-control select_status" name="status" id="status" required="" onchange="validate()">
                                <option value="00">- Pilih Status -</option>
                            </select>
                        </div>
                    </div> -->
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

<div class="modal fade" id="modal-update_password">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">FORM DATA</h4>
            </div>
            <div class="modal-body">
            <div class="row">
                <form action="" method="PUT" class="form-horizontal" role="form" id="form-data-2">
                <input type='hidden' id='id' name="id" value="{{Auth::user()->id_user}}">
                <input type='hidden' id='_method' value="PUT" name="_method">
                <input type='hidden' id='_token' value="{{csrf_token()}}" name="_token">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Password Baru
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="password" placeholder="Password Baru" class="form-control" name="password1" id="password1" value="" required="" onchange="validatePassword()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Ulangi Password Baru
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="password" placeholder="Ulangi Password Baru" class="form-control" name="password2" id="password2" value="" required="" onchange="validatePassword()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                        </label>
                        <div class="registrationFormAlert col-md-8 col-sm-8 col-xs-12" id="divCheckPasswordMatch">
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <button type="submit" id="buttonSubmitPassword" class="btn btn-primary" disabled="">Submit</button>
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
    var match = 0;
	function prepareAdd(){
		$('#reset').click();
    }

    function checkPasswordMatch() {
        var password = $("#password1").val();
        var confirmPassword = $("#password2").val();

        if (password != confirmPassword){
            $("#divCheckPasswordMatch").html('<div class="alert alert-danger alert-dismissable alert-important">Passwords do not match!</div>');
            document.getElementById("buttonSubmitPassword").disabled = true;
        }
        else{
            $("#divCheckPasswordMatch").html('<div class="alert alert-success alert-dismissable alert-important">Passwords match!</div>');
            match = 1;
            document.getElementById("buttonSubmitPassword").disabled = false;  
        }
    }

    $(document).ready(function () {
       $("#password1, #password2").keyup(checkPasswordMatch);
    });
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

    function validatePassword()
    {
      if(match == 1)
      { 
        
        console.log("benar");
      }
      else{
           
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
"{{ url('backend/admin/create')  }}"
@endsection

@section('updateurl')
"{{ url('backend/admin/detail') }}/"+{{Auth::user()->id_user}}
@endsection

@section('deleteurl')
"{{ url('#') }}"
@endsection

@section('dataurl')
{
   "url": "{{ url('backend/admin/data') }}",
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
"{{ url('backend/admin/detail') }}/"+id
@endsection

@section('leftcolumsfeeze')
1	
@endsection

@section('searchable')

@endsection

@section('col')
[
    { "data": "id_user" },
    { "data": "id_role" },
    { "data": "name" },
    { "data": "no_hp" },
]
@endsection

@section('add_select_status')

@endsection

