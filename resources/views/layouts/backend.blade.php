<!DOCTYPE html>
<html lang="en">
    <head>        
        <title>Rescue.id</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="icon" href="{{URL::to('assets/image/logo2.png')}}">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
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
                    <div class="x_title">
                        @yield('xtitle')
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">

                        <div id="app">
                            @yield('content')
                        </div>
                        <!-- <script src="http://code.jquery.com/jquery-1.9.1.js"></script> -->
                        <!-- <script src="{{ asset('js/app.js') }}"></script> -->

                    </div>
                    </div>
                </div>
                </div>
            </div>
            </div>
            <!-- /page content -->

            <!-- footer content -->
        <!--  <footer>
                <div class="pull-right">

            </div>
            <div class="clearfix"></div>
            </footer> -->
            <!-- /footer content -->
        </div>
        </div>

    <!-- jQuery -->
    <script src="{{URL::to('assets/gentelella/vendors/jquery/dist/jquery.min.js')}}"></script>
    <!-- Pusher -->
    <!-- <script src="http://js.pusher.com/3.0/pusher.min.js"></script> -->
    <script src="https://js.pusher.com/4.4/pusher.min.js"></script>
    <!-- Bootstrap -->
    <script src="{{URL::to('assets/gentelella/vendors/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <!-- FastClick -->
    <script src="{{URL::to('assets/gentelella/vendors/fastclick/lib/fastclick.js')}}"></script>
    <!-- NProgress -->
    <script src="{{URL::to('assets/gentelella/vendors/nprogress/nprogress.js')}}"></script>
    <!-- iCheck -->
    <script src="{{URL::to('assets/gentelella/vendors/iCheck/icheck.min.js')}}"></script>
    <!-- Datatables -->
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-buttons/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-buttons/js/buttons.flash.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-buttons/js/buttons.html5.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-buttons/js/buttons.print.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-keytable/js/dataTables.keyTable.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/datatables.net-scroller/js/dataTables.scroller.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/jszip/dist/jszip.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/pdfmake/build/pdfmake.min.js')}}"></script>
    <script src="{{URL::to('assets/gentelella/vendors/pdfmake/build/vfs_fonts.js')}}"></script>

    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase.js"></script>
    <script src="https://www.gstatic.com/firebasejs/4.12.1/firebase-firestore.js"></script>
    <!-- <script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&v=3&libraries=geometry"></script> -->


    <!-- Custom Theme Scripts -->
    <script src="{{URL::to('assets/gentelella/build/js/custom.min.js')}}"></script>

    <script type="text/javascript">
        //for edit and update data
            $('#form-data').on('submit',function(e){
                
                var id = document.getElementById(@yield('id')).value;
                if( id == '' ){
                    e.preventDefault(e);
                    var formData = new FormData($(this)[0]);
                        $.ajax({
                            type:"POST",
                            url: @yield('storeurl'),
                            data: formData,
                            processData: false,
                            contentType: false,
                            async:false,
                            cache:false,
                            dataType: 'json',
                            beforeSend: function(){
                                $('#data-table_processing').show();
                            },
                            success: function(data){
                                console.log(data);
                                $('#data-table').DataTable().ajax.reload();
                                $('#close').click();
                                $('#data-table_processing').show();
                            },
                            error: function(data){

                                @yield('messagefailed')
                                $('#data-table_processing').hide();
                                console.log(data);
                                var errors      = data.responseJSON;
                                var listErrors  = "<ul>";

                                $.each(errors, function(index, value) {
                                    
                                    listErrors += "<li>"+value+"</li>";                        

                                });
                                listErrors +="</ul>";
                                $('#alert-msg').html(listErrors);
                                $('#alert-msg').show(500);

                        }

                    })
                }else{
                    e.preventDefault(e);
                    var formData = new FormData($(this)[0]);
                        $.ajax({
                            type:"PUT",
                            url: @yield('updateurl'),
                            data: @yield('datatype', '$( this ).serialize()'),
                            dataType: 'json',
                            async:false,
                            cache:false,
                            beforeSend: function(){
                                //CKEDITOR.instances['editor'].updateElement();
                                // document.getElementById('data').value = CKEDITOR.instances.editor.getData();
                                $('#data-table_processing').show();
                            },
                            success: function(data){
                                console.log(data);
                                $('#data-table').DataTable().ajax.reload(null, false);
                                $('#close').click();
                                $('#data-table_processing').show();

                            },
                            error: function(data){

                                //$('body').append('<div id="note" class="errorMessage">Edit data error</div>');
                                $('#data-table_processing').hide();
                                var errors = data.responseJSON;
                                var listErrors = "<ul>";

                                $.each(errors, function(index, value) {
                                    
                                    listErrors += "<li>"+value+"</li>";

                                });

                                listErrors +="</ul>";
                                $('#alert-msg').html(listErrors);
                                $('#alert-msg').show(500);
                            }

                    })
                }
            });

            $('#form-data-2').on('submit',function(e){
                    e.preventDefault(e);
                    var formData = new FormData($(this)[0]);
                        $.ajax({
                            type:"PUT",
                            url: @yield('updateurl'),
                            data: @yield('datatype', '$( this ).serialize()'),
                            dataType: 'json',
                            async:false,
                            cache:false,
                            beforeSend: function(){
                                //CKEDITOR.instances['editor'].updateElement();
                                // document.getElementById('data').value = CKEDITOR.instances.editor.getData();
                                $('#data-table_processing').show();
                            },
                            success: function(data){
                                console.log(data);
                                $('#data-table').DataTable().ajax.reload(null, false);
                                $('#close').click();
                                $('#data-table_processing').show();

                            },
                            error: function(data){

                                //$('body').append('<div id="note" class="errorMessage">Edit data error</div>');
                                $('#data-table_processing').hide();
                                var errors = data.responseJSON;
                                var listErrors = "<ul>";

                                $.each(errors, function(index, value) {
                                    
                                    listErrors += "<li>"+value+"</li>";

                                });

                                listErrors +="</ul>";
                                $('#alert-msg').html(listErrors);
                                $('#alert-msg').show(500);
                            }

                    })
                    $('#modal-update_password').modal('hide');;    
            });

            function deleteData(id){
                var result = confirm("Delete Data ?");

                if( result ){
                    $.ajax({
                        type: "GET",
                        url: @yield('deleteurl'),
                        data: 'id='+id,
                        dataType : 'json',
                        async:false,
                        cache:false,
                        success: function(data){
                            $('#data-table').DataTable().ajax.reload(null, false);
                        },
                        error: function(data){
                            //$('body').append('<div id="note" class="errorMessage">Delete data error</div>');
                            console.log(data);
                        }
                    });
                }
            }
            function gotoDetail(id)
            {
                window.location.href = @yield('redirect');
            }

            function prepareEdit(id){ 

                 @yield('add_select_status')
                var check =  document.getElementById('articlecontent');
                if (typeof(check) != 'undefined' && check != null)
                {
                    window.location.href = '/backend/information';
                }

                $("#reset").click();
                $('#div-button').attr('class',"");
                $('#div-image').attr('class',"hidden");
                $('#alert-msg').hide(500);
                $.ajax({
                    type: "GET",
                    url: @yield('prepareediturl'),
                    data: 'id='+id,
                    dataType : 'json',
                    async:false,
                    cache:false,
                    success: function(data){                    
                        @yield('customimage');
                        jQuery.each(data, function(i, val) {
                            var element =  document.getElementById(i);
                            if (typeof(element) != 'undefined' && element != null)
                            {
                                document.getElementById(i).value = val;
                            }

                            if (typeof statusUserManagement == 'function') { 
                              statusUserManagement(val); 
                            }

                            @yield('customeditcondition')

                        });
                        
                        @yield('customerSelect')

                    }
                });
                var url = $("#foto").val();
                console.log(url);
                $("#foto_show").attr('src',url);
                @yield('editvideo')
            }

            function loadAllData(){
                console.log('loadData');
                if (window.matchMedia("(max-width: 767px)").matches) { // Device diatas 768px
                    var table = $('table.table').DataTable( {
                        ajax:           @yield('dataurl'),
                        processing: true,
                        serverSide: true,
                        sDom: 'Rfrtlip',
                        scrollX:        true,
                        responsive: true,
                        lengthMenu: [[25, 100, -1], [25, 100, "All"]],
                        columnDefs: [@yield('searchable')],
                        @yield('export')
                    } );
                }
                else{
                    var table = $('table.table').DataTable( {

                        ajax:           @yield('dataurl'),
                        columns : @yield('col'),
                        processing: true,
                        serverSide: @yield('serverside',true),
                        deferRender: false,
                        bSortClasses: false,
                        sDom: 'Rfrtlip',
                        language: {
                            processing: "<div></div><div></div><div></div><div></div><div></div>"
                        },
                        scrollX:        true,
                        @yield('orderbycustom')
                        @yield('createrow')
                        lengthMenu: [[25, 100, -1], [25, 100, "All"]],
                        @yield('fixedCol')
                        fixedColumns:   {
                            leftColumns: @yield('leftcolumsfeeze')
                        },
                         search: {
                           smart: false
                         },
                        orderCellsTop: true,
                        columnDefs: [@yield('searchable')],
                        initComplete: function(settings, json) {
                            @yield('oncomplete')
                            $(".table-responsive").show();
                            $("#loadingTable").hide();
                            
                        },
                        @yield('export')
                    } );

                    @yield('relactiveColumn')

                    var info = table.page.info();
                    console.log(info);
                    try{
                        console.log('Currently showing page '+(info.page+1)+' of '+info.pages+' pages.');
                    }
                    catch (err){
                        console.log('Not a table');
                    }

                    @yield('customaction')
                }
            }

            $(document).ready(function() {
                 
                 loadAllData();

            } );


        </script>
        <script type="text/javascript">
            function appendHtml(el, str) {
              var div = document.createElement('div');
              div.innerHTML = str;
              while (div.children.length > 0) {
                el.append(div.children[0]);
              }
            }
        </script>
        
        @yield('customjs')

  </body>
</html>