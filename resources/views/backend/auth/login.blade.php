<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Rescue.id</title>
    @include('layouts.header')
  </head>

  <body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form  class="form-horizontal" role="form" method="POST" action="{{ url('/login') }}">
              {{ csrf_field() }}
              @if ($errors->has('errors'))
                  <div class="alert alert-danger alert-dismissable alert-important">
                       {{ $errors->first('errors') }}
                  </div>
              @endif
              <h1>Login</h1>
              <div>
                <input type="text" class="form-control" placeholder="Email" required="" name="email" />
              </div>
              <div>
                <input type="password" class="form-control" placeholder="Kode" required="" name="kode" />
              </div>
              <div>
                <button class="btn btn-default submit" >Log in</button>
                <!-- <a class="reset_pass" href="#">Lost your password?</a> -->
              </div>
              <div class="clearfix"></div>
              <div class="separator">
                <div class="clearfix"></div>
                <br />
                <div>
                  <h1><!-- <i class="fa fa-paw"></i> -->RESCUE.ID</h1>
                  <!-- <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p> -->
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
  </body>
</html>
