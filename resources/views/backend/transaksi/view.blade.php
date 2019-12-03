@extends('layouts.backend')

@section('pageTitle')
Kejadian Aktif
@endsection

@section('xtitle')
<!-- <a data-toggle="modal" href="#modal-edit" onclick="prepareAdd()"><button type="button" class="btn btn-primary"><i class="fa fa-plus"></i> Add Data</button></a> -->
<div id="loadingTable" class="text-center">
    <img src="{{ asset('assets/image/loading.gif') }}">
</div>
@endsection

@section('content')

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
                    <th>Nearby Hospital</th>
                    <th>Tanggal</th>
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
                    <th>Nearby Hospital</th>
                    <th>Tanggal</th>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div style="height: 500px; width: 100%;" id="map"></div>
        </div>
        <div class="col-md-4">
            <h3>Keterangan</h3>
            <div>Volunteer</div>
            <div id="volunteerList"></div>
        </div>
    </div>

@endsection

@section('customjs')
<script>

    var map, marker;
    var markers = {};
    var idTransaction = /[^/]*$/.exec(window.location.href)[0];

    var dataAed = @json($dataAed);
    var dataHospital = @json($dataHospital);
    var dataAmbulance = @json($dataAmbulance);

    var dataPenolong = [];
    var dataDetail;

    var callListenTrx = true;

    var base_url = window.location.origin;

    function generateVolunteer() {
        console.log('Generate Volunteer', dataPenolong);
        var elVol = $('#volunteerList');
        elVol.children().remove();

        dataPenolong.forEach(item => {

            var col = $("<div>", {"class": "col-md-12"});
            var h4 = $("<h4>");
            var stringName = $("<p>");
            var stringPhone = $("<p>");

            var name = "Nama : " + item.name;
            var phone = "No. Telp : " + item.no_hp;

            var line = $("<hr />");


            col.append(h4);

            stringName.append(name);
            stringPhone.append(phone);

            col.append(stringName);
            col.append(stringPhone);
            col.append(line);

            elVol.append(col);

        });

    }

    function getVolunteer() {
        $.ajax({
            url: base_url + "/backend/transaksi/detailv2/" + idTransaction,
            type: 'GET',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: (data) => {
                dataDetail = data.data[0];
                dataPenolong = data.data[0].dataPenolong;
                if(callListenTrx){
                    listenTransaction();
                    callListenTrx = false;
                }
                generateVolunteer();
                realTimeData(dataDetail.id_korban);
                dataPenolong.forEach(item => {
                    realTimeData(item.id_user);
                });
            }
        });
    }
    getVolunteer();

    function addMarker(locations, type) {

        for (i = 0; i < locations.length; i++) {

            // var hospitalIcon = 'https://cdn2.iconfinder.com/data/icons/fatcow/32x32/hospital.png';
            // var ambulanceIcon = 'http://www.freenew.net/upload/picon/1/ambulance-rush-10.png';
            // var aedIcon = 'https://cdn4.iconfinder.com/data/icons/cologne/32x32/heart.png';

            var hospitalIcon = {
                url: "{{env('BASE_HOST')}}/assets/icon/Hospital%20Pin%20Icon.png", // url
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };

            var ambulanceIcon = {
                url: "{{env('BASE_HOST')}}/assets/icon/Ambulance%20Pin%20Icon.png", // url
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };            

            var aedIcon = {
                url: "{{env('BASE_HOST')}}/assets/icon/AED%20Pin%20Icon.png", // url
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };

            var infowindow = new google.maps.InfoWindow;
            var i;

            marker = new google.maps.Marker({
                id: 0,
                position: new google.maps.LatLng(
                    locations[i].lat,
                    locations[i].lang
                ),
                map: map,
                icon: type == 1 ? hospitalIcon : type == 2 ? ambulanceIcon : aedIcon,
                zoom: 12
            });
            markers[0] = marker;
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i].nama);
                    infowindow.open(map, marker);
                }
            })(marker, i));

        }

    }

    function initMap() {

        map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: -7.2990122, lng: 112.7703221},
            zoom: 12
        });

        addMarker(dataAed, 3);
        addMarker(dataAmbulance, 2);
        addMarker(dataHospital, 1);
    }

    firebase.initializeApp({
        apiKey: 'AIzaSyA_1QuglcwQaiSxqKfMVBWFR60BVEXGe-4',
        projectId: 'tanggapsdev'
    });
    var db = firebase.firestore();

    function realTimeData(user_id){
        
        console.log('Real Location User id', user_id);
        db.collection("trackLocation").where(firebase.firestore.FieldPath.documentId(), '==', user_id.toString()).onSnapshot((doc) => {

            var infowindow = new google.maps.InfoWindow;
            var i;
            var volunteer = 'https://www.shareicon.net/data/32x32/2016/07/26/801993_man_512x512.png';
            // var victim = 'https://www.shareicon.net/download/2015/05/13/37767_bruce.ico';

            // var volunteer = {
            //     url: "http://localhost:8000/assets/icon/Volunteer%20Pin%20Icon.png", // url
            //     scaledSize: new google.maps.Size(30, 35), // scaled size
            //     origin: new google.maps.Point(0,0), // origin
            //     anchor: new google.maps.Point(0, 0) // anchor
            // };

            var victim = {
                url: "{{env('BASE_HOST')}}/assets/icon/Volunteer%20Pin%20Icon.png", // url
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };

            doc.forEach((docs) => {

                var findId = markers[docs.id]; 
                if(findId == undefined){
                    var infowindow = new google.maps.InfoWindow;
                    marker = new google.maps.Marker({
                        id: docs.id,
                        position: new google.maps.LatLng(
                            docs.data().latitude,
                            docs.data().longitude
                        ),
                        map: map,
                        icon: victim,
                        zoom: 12
                    });

                    markers[docs.id] = marker;
                    google.maps.event.addListener(marker, 'click', (function(marker, i) {
                        return function() {
                            var html = "<b>" + docs.data().nama + "</b><br />" + docs.data().nohp;
                            infowindow.setContent(html);
                            infowindow.open(map, marker);
                        }
                    })(marker, i));
                }else{
                    var updateMarker = markers[docs.id];
                    var newLatLng = new google.maps.LatLng(
                        docs.data().latitude,
                        docs.data().longitude
                    );
                    updateMarker.setPosition(newLatLng); 
                }

            });

        });

    }

    function listenTransaction(){

        db.collection("transaction").where(firebase.firestore.FieldPath.documentId(), '==', dataDetail.id_korban.toString()).onSnapshot((doc) => {
            console.log('Data Changes', doc);
            doc.forEach((docs) => {
                console.log('Transaction type', docs.exists);
                console.log(docs.data());
                getVolunteer();
            });
        });

    }

</script>
<script type="text/javascript"
    src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&key={{ env('GOOGLE_API_KEY') }}&callback=initMap">
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
   "url": "{{ url('backend/transaksi/detailv2') }}/" + idTransaction,
   "type": "GET",
   "data":{
         "_token": "{{ csrf_token() }}"
    },
}
@endsection

@section('serverside')
false
@endsection

@section('prepareediturl')
    "{{ url('backend/transaksi/detailv2') }}/"+id
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
            for (let i=0; i<data.length; i++) {
                if(i+1 == data.length)
                {
                    dataPenolong = dataPenolong + data[i].name;
                }else{
                    dataPenolong = dataPenolong + data[i].name + ", ";
                }
            }
        }    
        return data ? dataPenolong : '';
    }
},
{ 
    searchable: true, 
    targets: [7],
    render : function (data, type, row) {

        if(data)
        {
            var listDistance = [];
            dataHospital.forEach((item) => {
                var distance = google.maps.geometry.spherical.computeDistanceBetween (
                        new google.maps.LatLng(data.latitude, data.longitude),
                        new google.maps.LatLng(item.lat, item.lang)
                );
                listDistance.push(distance);
            });
            var lowestDistance = Math.min.apply(null, listDistance);
            var iDist = listDistance.indexOf(lowestDistance);
            var response = "<b>"+dataHospital[iDist].nama+"</b><br />"+dataHospital[iDist].alamat+"<br />"+dataHospital[iDist].telp+"<br /> Distance: "+(lowestDistance/1000).toFixed(2)+"km";
            return response;
        }else
        {
            return 'Cant find user location';
        }

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
    { "data": "korban" },
    { "data": "created_at" }
]
@endsection
