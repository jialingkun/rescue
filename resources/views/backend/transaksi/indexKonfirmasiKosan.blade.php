@extends('layouts.backend')

@section('pageTitle')
Konfirmasi Kos-kosan / Pemondokan

@endsection
@section('xtitle')
<div id="loadingTable" class="text-center">
    <img src="{{ asset('assets/image/loading.gif') }}">
</div>
@endsection
@section('content')
<script src="{{URL::to('plugin/ckeditor/ckeditor.js')}}"></script>
<script src="{{URL::to('plugin/ckeditor/config.js')}}"></script>
<div class="table-responsive displayNone">       
    <table class="table table-striped table-bordered" id="data-table" style="width:100%">
        <thead>
            <tr>
            	<th>ID</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Alamat</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Nomor Telp</th>
                <th>Harga</th>
                <th>Data</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
            	<th>ID</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Alamat</th>
                <th>Kecamatan</th>
                <th>Desa</th>
                <th>Nomor Telp</th>
                <th>Harga</th>
                <th>Data</th>                
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
                <!-- <input type='hidden' id='_method' value="POST" name="_method"> -->
                <input type='hidden' id='_token' value="{{csrf_token()}}" name="_token">
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Nama
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Nama" class="form-control" name="nama" id="nama" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name" required="">
                            Kecamatan
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control select2" name="kecamatan" id="kecamatan" onchange="validate()" disabled="">
                                <option value="00">- Pilih Kecamatan -</option>
                            </select>
                            <input type="hidden" name="kecamatan_id" id="kecamatan_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Desa
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control select2" name="desa" id="desa" required="" onchange="validate()" disabled="">
                                <option value="00">- Pilih Desa -</option>
                            </select>
                            <input type="hidden" name="desa_id" id="desa_id" >
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
                            Nomor Telepon
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Nomor Telepon" class="form-control" name="telp" id="telp" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Harga
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Harga" class="form-control" name="harga" id="harga" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Data
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea type="text" placeholder="Data" class="form-control" name="data" id="data" value="" onchange="validate()" required="" readonly=""></textarea>
                        </div>
                        <!-- <div class="col-md-8 col-sm-8 col-xs-12">
                            <textarea type="text" class="form-control" id="editor" name="editor" value="" required=""></textarea>
                        </div> -->
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Status
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <select class="form-control" name="flag" id="flag" required="" onchange="validate()">
                                <option value="0">Pengajuan</option>
                                <option value="1">Terima</option>
                                <option value="2">Tolak</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <button type="submit" id="buttonSubmit" class="btn btn-primary" disabled="">Submit</button>
                            <input type="reset" value="Reset" class="btn btn-default hidden" id="reset">
                            <button type="button" class="btn btn-danger" data-dismiss="modal" id="close">Close</button>
                        </div>
                    </div>
                </form>
                <!-- <script type="text/javascript">
                    CKEDITOR.replace('editor');
                </script> -->
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
        document.getElementById("buttonSubmit").disabled = true; 
        document.getElementById("id").value='';
        $.ajax({
            type: "GET",
            url: "{{ url('/') }}/api/informasi/kecamatan/all",
            dataType: "json",
            success: function (data) {
                $('#kecamatan').empty();
                $('#kecamatan').append('<option value="00">- Pilih Kecamatan -</option>');
                var obj = data;
                for(loop = 0; loop < obj.data.length; loop++){
                    var a = obj.data[loop];
                    $('#kecamatan').append('<option value="'+a.id+'">'+a.nama+'</option>');
                }
            }
        });

        $('#desa').empty();
        $('#desa').append('<option value="00">- Pilih Desa -</option>');
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
    $('#kecamatan').on('change',function(e){
        var kecamatan_id = $(this).val();
        $.ajax({
            type: "GET",
            url: "{{ url('/') }}/api/informasi/desa/"+kecamatan_id,
            dataType: "json",
            success: function (data) {
                $('#desa').empty();
                $('#desa').append('<option value="00">- Pilih Desa -</option>');
                var obj = data;
                for(loop = 0; loop < obj.data.length; loop++){
                    var a = obj.data[loop];
                    $('#desa').append('<option value="'+a.id+'">'+a.nama+'</option>');
                }
            }
        });
    });
</script>

<script type="text/javascript">
    function validate()
    {
      if($('#kecamatan').val() != "00" && $('#desa').val() != "00")
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
"{{ url('backend/kategori-informasi/informasi/kosan/foto') }}/"+id+"/index"
@endsection

@section('storeurl')
"{{ url('#') }}"
@endsection

@section('updateurl')
"{{ url('backend/kategori-informasi/informasi/kosan/detail') }}/"+id
@endsection

@section('deleteurl')
"{{ url('#') }}"
@endsection

@section('dataurl')
{
   "url": "{{ url('backend/kategori-informasi/informasi/kosan/data') }}",
   "type": "GET",
   "data":{
         "_token": "{{ csrf_token() }}"
    },
}
@endsection

@section('serverside')
true
@endsection

@section('prepareediturl')
"{{ url('backend/kategori-informasi/informasi/kosan/detail') }}/"+id
@endsection

@section('leftcolumsfeeze')
1	
@endsection

@section('searchable')
{ searchable: false, targets: [] }
@endsection

@section('editvideo')
document.getElementById("buttonSubmit").disabled = false;
var idkecamatan = document.getElementById("kecamatan_id").value;
$.ajax({
    type: "GET",
    url: "{{ url('/') }}/api/informasi/kecamatan/all",
    dataType: "json",
    success: function (data) {
        $('#kecamatan').empty();
        $('#kecamatan').append('<option value="00">- Pilih Kecamatan -</option>');
        var obj = data;
        for(loop = 0; loop < obj.data.length; loop++){
            var a = obj.data[loop];
            if($('#kecamatan_id').val() == a.id){
                $('#kecamatan').append('<option value="'+a.id+'" selected="">'+a.nama+'</option>');
            }
            else{
                $('#kecamatan').append('<option value="'+a.id+'">'+a.nama+'</option>');
            }
        }
    }
});
$.ajax({
    type: "GET",
    url: "{{ url('/') }}/api/informasi/desa"+"/"+idkecamatan,
    dataType: "json",
    success: function (data) {
        $('#desa').empty();
        $('#desa').append('<option value="00">- Pilih Desa -</option>');
        var obj = data;
        for(loop = 0; loop < obj.data.length; loop++){
            var a = obj.data[loop];
            if($('#desa_id').val() == a.id){
                $('#desa').append('<option value="'+a.id+'" selected="">'+a.nama+'</option>');
            }
            else{
                $('#desa').append('<option value="'+a.id+'">'+a.nama+'</option>');
            }
        }
    }
});
@endsection

