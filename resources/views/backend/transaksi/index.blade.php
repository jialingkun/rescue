@extends('layouts.backend')

@section('pageTitle')
Transaksi

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
                <th>ID Transaksi</th>
                <th>Tipe Transaksi</th>
                <th>Status</th>
                <th>Ambulance</th>
                <th>Penolong</th>
                <th>Korban</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID Transaksi</th>
                <th>Tipe Transaksi</th>
                <th>Status</th>
                <th>Ambulance</th>
                <th>Penolong</th>
                <th>Korban</th>
                <th>Lokasi</th>
                <th>Tanggal</th>
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
                            ID Transaksi
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="ID Transaksi" class="form-control" name="id_transaksi" id="id_transaksi" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Tipe Transaksi
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Tipe Transaksi" class="form-control" name="tipe_transaksi" id="tipe_transaksi" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Status
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Status" class="form-control" name="id_status" id="id_status" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Ambulan
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Ambulan" class="form-control" name="id_ambulan" id="id_ambulan" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Penolong
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Penolong" class="form-control" name="id_penolong" id="id_penolong" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Korban
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Korban" class="form-control" name="id_korban" id="id_korban" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Lokasi
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Lokasi" class="form-control" name="lokasi" id="lokasi" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Latitude
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Latitude" class="form-control" name="latitude" id="latitude" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Longitude
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Longitude" class="form-control" name="longitude" id="longitude" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Tanggal Kejadian
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Longitude" class="form-control" name="created_at" id="created_at" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Foto
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">   
                            <div id="div-button" class="">
                                <button type="button" class="btn btn-sm btn-warning" id="tampil-foto" onclick="showFoto()">Tampilkan Foto</button>
                            </div>
                            <input type="hidden" name="foto" id="foto" value="">
                            <div id="div-image" class="hidden">
                                <img src="" id="foto_show" name="foto_show" style="width: 100%;">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Follow Up
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Follow Up" class="form-control" name="followup" id="followup" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
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
<script>

    var pusher = new Pusher('b6fcaf2cb2e82bebd1a4', {
        encrypted: true,
        cluster: 'ap1',
        forceTLS: true
    });

    // pusher.connection.bind('connected', function() {
    //     console.log('Pusher Ready!!!');
    // });
    // pusher.connection.bind('connecting_in', function(delay) {
    //     console.log('I have not been able to establish a connection for this feature. I will try again in ' + delay + ' seconds.');
    // });
    // pusher.connection.bind('state_change', function(states) {
    //     console.log('Channels current state is ' + states.current);
    // });

    var channel = pusher.subscribe('new-transaction');

    channel.bind('App\\Events\\TransactionAdded', (data) => {
        var table = $('table.table').DataTable();
        var newData = JSON.parse(data.data);
        console.log('New Data', newData);
        newData.action = '<center><a data-toggle="modal" href="#modal-edit" onClick="prepareEdit('+newData.id_transaksi+');loaddata('+newData.id_transaksi+');" class="btn btn-xs btn-info	"><i class="fa fa-edit"></i></a></center>';
        table.row.add(newData);
        table.draw();
    });
    
</script>
<script type="text/javascript" src="{{ URL::to('js/select2.min.js') }}"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::to('css/select2.min.css') }}">
<script type="text/javascript">
	function prepareAdd(){
		$('#reset').click();
    }

    function showFoto(){
        $('#div-button').attr('class',"hidden");
        $('#div-image').attr('class',"");
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
'id_transaksi'
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
"{{ url('#') }}"
@endsection

@section('deleteurl')
"{{ url('#') }}"
@endsection

@section('dataurl')
{
   "url": "{{ url('backend/transaksi/data') }}",
   "type": "POST",
   "data":{
         "_token": "{{ csrf_token() }}"
    },
}
@endsection

@section('serverside')
false
@endsection

@section('prepareediturl')
"{{ url('backend/transaksi/detail') }}/"+id
@endsection

@section('leftcolumsfeeze')
1	
@endsection

@section('searchable')
{ 
    searchable: true, 
    targets: [1],
    render : function (data, type, row) {
         return data == '1' ? 'Panic Button' : 'Code Blue'
    }
},
{ 
    searchable: true, 
    targets: [3],
    render : function (data, type, row) {
         return data ? data.kode : ''
    }
},
{ 
    searchable: true, 
    targets: [5],
    render : function (data, type, row) {
         return data ? data.name : ''
    }
},
{ 
    searchable: true, 
    targets: [4],
    render : function (data, type, row) {
        var dataPenolong = '';  
        if(data)
        {
            //for (let i=0; i<data.length; i++) {
            //    dataPenolong = dataPenolong + (i+1) + ". " + data[i].name + "<br />";
            //}
            
            for (let i=0; i<data.length; i++) {
                if(i+1 == data.length)
                {
                    dataPenolong = dataPenolong + data[i].name;
                }else{
                    dataPenolong = dataPenolong + data[i].name + ", ";
                }
            }
        }    
        return dataPenolong;
    }
}
@endsection

@section('col')
[
    { "data": "id_transaksi" },
    { "data": "tipe_transaksi" },
    { "data": "status_trx.keterangan" },
    { "data": "ambulan_trx" },
    { "data": "dataPenolong" },
    { "data": "korban" },
    { "data": "lokasi" },
    { "data": "created_at" },
    { "data": "action" },
]
@endsection
