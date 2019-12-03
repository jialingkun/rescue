@extends('layouts.backend')

@section('pageTitle')
Hospital
@endsection

@section('xtitle')
<a data-toggle="modal" href="#modal-edit" onclick="prepareAdd()"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add Data</button></a>
<div id="loadingTable" class="text-center">
    <img src="{{ asset('assets/image/loading.gif') }}">
</div>
@endsection

@section('content')

<div class="table-responsive displayNone">       
    <table class="table table-striped table-bordered" id="data-table" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telp</th>
                <th>Desc</th>
                <th>Action</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Alamat</th>
                <th>Telp</th>
                <th>Desc</th>
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
                            <input type="hidden" class="form-control" name="id" id="id" value="" required="" onchange="validate()" readonly="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Nama
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Nama" class="form-control" name="nama" id="nama" value="" required="" onchange="validate()" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Alamat
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Alamat" class="form-control" name="alamat" id="alamat" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Telp
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Telp" class="form-control" name="telp" id="telp" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Desc
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input type="text" placeholder="Description" class="form-control" name="desc" id="desc" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Lat
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input readonly type="text" placeholder="Latitude" class="form-control" name="lat" id="lat" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                            Long
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <input readonly type="text" placeholder="Longitude" class="form-control" name="lang" id="lang" value="" required="" onchange="validate()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                            <div style="height: 200px; width: 100%;" id='map_canvas'></div>
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
<script>

    function initMap()
    {
        
        var map = 
        new google.maps.Map(document.getElementById('map_canvas'), {
                center: {lat: -7.2990122, lng: 112.7703221},
                zoom: 12
        });

        var latitude = document.getElementById("lat").value;
        var longitude = document.getElementById("lang").value;
        console.log('lat', latitude);
        if(latitude != '' || longitude != ''){
            var myMarker = new google.maps.Marker({
                position: new google.maps.LatLng(latitude, longitude),
                draggable: true
            });
        }else{
            var myMarker = new google.maps.Marker({
                position: new google.maps.LatLng(-7.2990122, 112.7703221),
                draggable: true
            });
        }

        google.maps.event.addListener(myMarker, 'dragend', function (evt) {
            console.log('latlang', evt.latLng.lat() + " -- " + evt.latLng.lng());
            document.getElementById("lat").value = evt.latLng.lat();
            document.getElementById("lang").value = evt.latLng.lng();
        });

        myMarker.setMap(map);
        
    }
</script>
<script type="text/javascript">
    function loaddata(arg) {
        
    }
	function prepareAdd(){
		$('#id').val('');
		$('#reset').click();
    }
</script>
<script type="text/javascript">
    $.fn.modal.Constructor.prototype.enforceFocus = function () {};
</script>
<script type="text/javascript">
    function validate()
    {
      
    }
</script>
<script type="text/javascript"
    src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&key={{ env('GOOGLE_API_KEY') }}&callback=initMap">
</script>
@endsection

@section('id')
'id'
@endsection

@section('dataurl')
{
   "url": "{{ url('backend/master/hospital/list') }}",
   "type": "GET",
   "data":{
         "_token": "{{ csrf_token() }}"
    },
}
@endsection

@section('prepareediturl')
    "{{ url('backend/master/hospital') }}/"+id
@endsection

@section('redirect')
    "{{ url('#') }}"
@endsection

@section('storeurl')
    "{{ url('#') }}"
@endsection

@section('updateurl')
    "{{ url('backend/master/hospital') }}/"+id
@endsection

@section('deleteurl')
    "{{ url('backend/master/hospital/delete') }}/"+id
@endsection

@section('col')
[
    { "data": "id" },
    { "data": "nama" },
    { "data": "alamat" },
    { "data": "telp" },
    { "data": "desc" },
    { "data": "action" },
]
@endsection

@section('leftcolumsfeeze')
1	
@endsection
