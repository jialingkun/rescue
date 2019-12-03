@extends('layouts.backend')

@section('pageTitle')
Maps
@endsection

@section('content')

<!-- <div style="height: 500px; width: 100%;">{!! Mapper::render() !!}</div> -->
<div style="height: 500px; width: 100%;" id="map"></div>

@endsection

@section('customjs')

<script>
    var map, marker;
    var markers = {};

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
                    var htmlEl = "";

                    htmlEl += locations[i].nama ? "<b>" + locations[i].nama + "</b>" : "<b>" + locations[i].username + "</b>";
                    htmlEl += locations[i].alamat ? "<p>" + locations[i].alamat + "</p>" : "<p>" + locations[i].no_pol_ambulan + "</p>";
                    htmlEl += locations[i].telp ? "<p>" + locations[i].telp + "</p>" : "";

                    infowindow.setContent(htmlEl);
                    infowindow.open(map, marker);
                }
            })(marker, i));

        }

      }

      function initMap() {

        var dataAed = @json($dataAed);
        var dataHospital = @json($dataHospital);
        var dataAmbulance = @json($dataAmbulance);

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

        db.collection("trackLocation").onSnapshot((doc) => {

            var infowindow = new google.maps.InfoWindow;
            var i;
            // var userIcon = 'http://localhost:8000/assets/icon/Volunteer%20Pin%20Icon.png';
            var userIcon = {
                url:  "{{env('BASE_HOST')}}/assets/icon/Volunteer%20Pin%20Icon.png", // url
                scaledSize: new google.maps.Size(30, 35), // scaled size
                origin: new google.maps.Point(0,0), // origin
                anchor: new google.maps.Point(0, 0) // anchor
            };

            doc.forEach((docs) => {

                var findId = markers[docs.id]; 
                console.log('Data User:', docs.data());
                if(findId == undefined){
                    var infowindow = new google.maps.InfoWindow;
                    marker = new google.maps.Marker({
                        id: docs.id,
                        position: new google.maps.LatLng(
                            docs.data().latitude,
                            docs.data().longitude
                        ),
                        map: map,
                        icon: userIcon,
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
        
</script>
<script type="text/javascript"
    src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&key={{ env('GOOGLE_API_KEY') }}&callback=initMap">
</script>
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

@section('prepareediturl')
"{{ url('#') }}"
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

@section('col')
[
    { "data": "id" }
]
@endsection

@section('leftcolumsfeeze')
1	
@endsection
