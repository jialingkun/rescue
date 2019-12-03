<!DOCTYPE html>
<html lang="en">
    <head>        
        <title>Backend | PSiYH</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" href="{{URL::to('assets/image/pamekasan.png')}}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('assets/img/faviconnew.png') }}"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Bootstrap -->
        <link href="{{URL::to('assets/gentelella/vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
        <!-- Font Awesome -->
        <link href="{{URL::to('assets/gentelella/vendors/font-awesome/css/font-awesome.min.css')}}" rel="stylesheet">
        <!-- NProgress -->
        <link href="{{URL::to('assets/gentelella/vendors/nprogress/nprogress.css')}}" rel="stylesheet">
        <!-- iCheck -->
        <link href="{{URL::to('assets/gentelella/vendors/iCheck/skins/flat/green.css')}}" rel="stylesheet">
        <!-- Datatables -->
        <link href="{{URL::to('assets/gentelella/vendors/datatables.net-bs/css/dataTables.bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{URL::to('assets/gentelella/vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{URL::to('assets/gentelella/vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{URL::to('assets/gentelella/vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{URL::to('assets/gentelella/vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css')}}" rel="stylesheet">

        <!-- Alertigo-->
        <link href="{{URL::to('assets/gentelella/vendors/alertigo/jquery-alertigo.css')}}" rel="stylesheet">

        <!-- Custom Theme Style -->
        <link href="{{URL::to('assets/gentelella/build/css/custom.min.css')}}" rel="stylesheet">
    </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        @include('layouts.backendsidebar')
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
              <div class="page-title">
                  <div class="title_left">
                      <h3>@yield('pageTitle')</h3>
                  </div>
              </div>
              <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="x_panel">
                      <div id="scroll" style="overflow-y: auto; height:480px; ">
                          @yield('content')
                      </div>
                      <div >
                  </div>
                </div>
              </div>
            </div>
          </div>
              @yield('textarea')
        </div>
        <!-- /page content -->

      </div>
    </div>
    @if(Auth::user()->role_id=="superadmin")
        <div id="alertigo"></div>
    @endif

    <!-- jQuery -->
    <script src="{{URL::to('assets/gentelella/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Bootstrap -->
    <script src="{{URL::to('assets/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{URL::to('assets/gentelella/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{URL::to('assets/gentelella/vendors/nprogress/nprogress.js')}}"></script>
    <!-- iCheck -->
    <script src="{{URL::to('assets/gentelella/vendors/iCheck/icheck.min.js')}}"></script>


    <!-- Custom Theme Scripts -->
    <script src="{{URL::to('assets/gentelella/build/js/custom.min.js')}}"></script>

    @if(Auth::user()->role_id=="superadmin")
        <script src="{{URL::to('assets/gentelella/vendors/alertigo/jquery-alertigo.js')}}"></script>

        <script type="text/javascript">
            $(document).ready(function(){
                var lastId = 0;
                var audio = new Audio('{{URL::to('assets/mp3/emergency.mp3')}}');
                function loadlink(){
                    $.ajax({
                        type: 'GET',
                        async: true,
                        headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                        url: '{{url('backend/darurat/getNotif')}}'+"/"+lastId,
                        success: function (hasil) {
//                        console.log(hasil);
                            if(hasil['status']==="success"){
                                var pengaduanLast = hasil['pengaduanLast'];
                                var pengaduan = hasil['pengaduan'];
                                if(lastId==0){
                                    $('#notif').empty();
                                    $.each(pengaduan, function (index, list) {
                                        $('#notif').append('<li><a href="{{url('backend/darurat/detail/')}}/'+list['id']+'">'+'<b>['+list['kategoridarurat_id']+']</b> '+list['pengguna_id']+" : "+list['isi'].substring(0,30)+'...</a></li>');
                                    });
                                }else{
                                    audio.play();
                                    alertigo('<b>Darurat ' + pengaduanLast['kategoridarurat_id']+'</b></br>'
                                        + pengaduanLast['pengguna_id']+" : "+pengaduanLast['isi'],{
                                        life: '8000',
                                        color : "red",
                                    });
                                    $('#notif').empty();
                                    $.each(pengaduan, function (index, list) {
                                        $('#notif').append('<li><a href="{{url('backend/darurat/detail/')}}/'+list['id']+'">'+'<b>['+list['kategoridarurat_id']+']</b> '+list['pengguna_id']+" : "+list['isi'].substring(0,30)+'...</a></li>');
                                    });
                                }
                                lastId=pengaduanLast['id'];
                            }
                        },
                        error: function (data) {
                            console.log(data)
                        }
                    });
                }

                loadlink(); // This will run on page load
                setInterval(function(){
                    loadlink() // this will run after every 5 seconds
                }, 10000);

            });
        </script>
    @endif

        <script type="text/javascript">
            function appendHtml(el, str) {
              var div = document.createElement('div');
              div.innerHTML = str;
              while (div.children.length > 0) {
                el.append(div.children[0]);
              }
            }
        </script>
  </body>
</html>