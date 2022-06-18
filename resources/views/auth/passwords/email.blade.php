<html dir="" lang="en">
<head>
    <meta content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ URL::asset('fevicol.png') }}" type="image/gif" sizes="16x16">
    <title>{{ trans('app.Garrage Management System')}}</title>
<!-- Bootstrap -->
    <link href= "{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }} " rel="stylesheet">
	<!-- Own Theme Style -->
    <link href="{{ URL::asset('build/css/own.css') }} " rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('build/css/custom.min.css') }} " rel="stylesheet">
	<link href="{{ URL::asset('vendors/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
<style>
.login_form{background: #2A3F54;}
.row.massage {
    padding: 10px;
}	
</style>	
<body class="login">
    <div>
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
		
        <div class="animate form login_form">
			
			<div class="loginlogo" style="">
				 <a href="" >
			  <img src="{{ URL::asset('public/general_setting/'.getLogoSystem())}}"
			   width="230px" height="70px"></a>
			</div>
			
			<section class="login_content">
				<form class="form-horizontal" method="POST" action="{{ url('/password/forgot') }}">
					{{ csrf_field() }}
					<h1 class="logintextcolor">Forgot Password</h1>
					<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
						

						<div class="col-md-12 col-sm-12 col-xs-12 loginpading">
							<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter Valid E-mail" required >

							@if ($errors->has('email'))
								<span class="help-block">
									<strong>{{ $errors->first('email') }}</strong>
								</span>
							@endif
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-12 col-sm-12 col-xs-12">
							<button type="submit" class="btn btn-success">
								<i class="fa fa-btn fa-envelope"></i> Submit
							</button>
						</div>
					</div>
				</form>
			</section>
			@if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
							<label for="checkbox-10 colo_success">  {{session('message')}} </label>
						</div>
					</div>
				</div> 
				@endif
		</div>
	</div>
</div>

</head>
</html>