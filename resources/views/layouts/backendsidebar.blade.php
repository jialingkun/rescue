<style type="text/css">
  .counter {
    display: inline-block;
    width: auto;
    height: 20px;
    position: absolute;
    z-index: 100;
    top: 0;
    left: calc(50% + 5px);
    background-color: rgb(238, 43, 32);
    text-align: center;
    border-radius: 10px;
    border: 2px solid #fff;
    line-height: 14px;
    padding: 0 5px;
    font-size: 12px;
    display: none;
    font-weight: bold;
    color: #fff;
  }
</style>


<div class="col-md-3 left_col">
  <div class="left_col scroll-view">
    <div class="navbar nav_title" style="border: 0;">
      <a href="index.html#" class="site_title" style="font-family: 'MyriadPro'"></i> <span>TANGGAPPS</span></a>
    </div>

    <div class="clearfix"></div>

    <!-- menu profile quick info -->
    <div class="profile clearfix">
      <div class="profile_pic">
        <img src="{{URL::to('assets/image/logo2.png')}}" alt="..." class="img-circle profile_img">
      </div>
      <div class="profile_info">
        <span>Welcome,</span>
        <h2>{{Auth::user()->name}}</h2>
      </div>
    </div>
    <!-- /menu profile quick info -->

    <br />
    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
      <div class="menu_section">
        <h3>Menu</h3>
        <ul class="nav side-menu">
          <li><a href="{{url('backend/transaksi/index')}}"><i class="fa fa-exchange"></i> Transaksi</span></a></li>
          <li><a href="{{url('backend/transaksi/live')}}"><i class="fa fa-exclamation-triangle"></i> Kejadian Aktif</span></a></li>
          <li><a href="{{url('backend/pengaduan/index')}}"><i class="fa fa-bullhorn"></i> Pengaduan</span></a></li>
          <li><a href="{{url('backend/pengguna/index')}}"><i class="fa fa-users"></i> Pengguna</span></a></li>
          <li><a href="{{url('backend/maps/index')}}"><i class="fa fa-map"></i> Maps</span></a></li>
          <li><a href="{{url('backend/admin/index')}}"><i class="fa fa-user"></i> Admin</span></a></li>
          <li><a href="{{url('backend/ambulance/index')}}"><i class="fa fa-ambulance"></i> Master Ambulance</span></a></li>
          <li><a href="{{url('backend/master/hospital')}}"><i class="fa fa-hospital-o"></i> Master Hospital</span></a></li>
          <li><a href="{{url('backend/master/aed')}}"><i class="fa fa-heart"></i> Master AED</span></a></li>

        </ul>
      </div>
  
      <div class="menu_section">
      
      </div>

    </div>
    <!-- /sidebar menu -->

    <!-- /menu footer buttons -->
    <div class="sidebar-footer hidden-small">
     <!--  <a data-toggle="tooltip" data-placement="top" title="Settings">
        <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="FullScreen">
        <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Lock">
        <span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span>
      </a>
      <a data-toggle="tooltip" data-placement="top" title="Logout" href="login.html">
        <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
      </a> -->
    </div>
    <!-- /menu footer buttons -->
  </div>
</div>

<!-- top navigation -->
<div class="top_nav">
  <div class="nav_menu">
    <nav>
      <div class="nav toggle">
        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
      </div>

      <ul class="nav navbar-nav navbar-right">
        <li class="">
          <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <img src="{{URL::to('assets/image/logo2.png')}}" alt="">{{Auth::user()->name}}
            <span class=" fa fa-angle-down"></span>
          </a>
          <ul style="z-index: 1000" class="dropdown-menu dropdown-usermenu pull-right">
            <li><a href="{{url('backend/logout')}}"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
          </ul>
        </li>

      </ul>
    </nav>
  </div>
</div>


<!-- /top navigation -->