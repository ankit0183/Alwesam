<!DOCTYPE html>

<html lang="en">

<head>
    <!-- <meta content="text/html; charset=UTF-8"> -->
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ URL::asset('fevicol.png') }}" type="image/gif" sizes="16x16">
    <title>Garage Management System</title>

    <!-- Bootstrap -->
    <link href= "{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }} " rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('build/css/custom.min.css') }} " rel="stylesheet">
	 <!-- Own Theme Style -->
    <link href="{{ URL::asset('build/css/own.css') }} " rel="stylesheet">
	<!-- sweetalert -->
	<link href="{{ URL::asset('vendors/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
	 <!-- Custom Theme Scripts -->
	<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ URL::asset('build/js/custom.min.js') }}" defer="defer"></script>
	<script src="{{ URL::asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
<style>
.login_form{background: #2A3F54;}	
.login_content a:hover {
    text-decoration: none;
    color: #fff;
}
.login_content{text-shadow: none;}
.help-block{text-align: left;}
</style>
  </head>
  
<body class="login">
<div class="lgn_padding">
    
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
		
        <div class="animate form login_form">
			
			<div class="loginlogo" style="">
				 <a href="" >
			  <img src="{{ URL::asset('public/general_setting/'.getLogoSystem())}}"
			   width="230" height="70" alt="Garage Management System" style="margin-top:20px;"></a>
			</div>
			
			<section class="login_content">
            <form class="form-horizontal" method="POST" action="{{ url('/login') }}">
                 {{ csrf_field() }}
				 
              <h1 class="logintextcolor">Login Form</h1>
              <div class="loginpading {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="text" class="form-control" name="email" placeholder="Email"  value="{{ old('email') }}"/>
				@if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
              </div>

              <div class="loginpading {{ $errors->has('password') ? ' has-error' : '' }}">
                <input type="password" class="form-control" name="password" placeholder="Password"  />
				 @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
              </div>
              <div>
                <button type="submit" class="btn btn-default submit">Log in</button>
              
              </div>
             

              <div class="separator">
               
				<p class="change_link ">
                  <a href="{{url('/password/reset')}}" class="to_register logintextcolor"> Forgot Password </a>
                </p>
                <div class="clearfix"></div>
                <br />

               
              </div>
            </form>
          </section>
        </div>

        <div id="register" class="animate form registration_form">
          <section class="login_content">
            <form>
              <h1>Create Account</h1>
              <div>
                <input type="text" class="form-control" placeholder="Username"  />

              </div>
              <div class="">
                <input type="email" class="form-control" placeholder="Email"  />
				
              </div>
              <div class="">
                <input type="password" class="form-control" placeholder="Password" />
				
              </div>
              <div>
                <a class="btn btn-default submit" href="index.html">Submit</a>
              </div>

              <div class="clearfix"></div>

              <div class="separator">
                <p class="change_link">Already a member ?
                  <a href="#signin" class="to_register"> Log in </a>
                </p>

                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class="fa fa-paw"></i> Gentelella Alela!</h1>
                  <p>©2016 All Rights Reserved. Gentelella Alela! is a Bootstrap 3 template. Privacy and Terms</p>
                </div>
              </div>
            </form>
          </section>
        </div>
      </div>
    </div>
	
	@if(!empty(session('firsttime')))
		
		<Script>
			$(document).ready(function(){
				swal({   
					title: "Your Installation is Successful",   
					 
				}, function(){
					
						window.location.reload()
				});	
				});	
		
		</script>
		<?php Session::flush(); ?>
	@endif
  </body>

</html>



                   
                       

                      