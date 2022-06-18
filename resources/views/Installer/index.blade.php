 
 <!-- Bootstrap -->
 
	<link href="{{ URL::asset('build/css/jq-steps/normalize.css') }} " rel="stylesheet">
	<link href="{{ URL::asset('build/css/jq-steps/main.css') }} " rel="stylesheet">
	  <link href="{{ URL::asset('build/css/jq-steps/jquery.steps.css') }} " rel="stylesheet">
	  <link href="{{ URL::asset('build/css/bootstrapss.min.css') }} " rel="stylesheet">
   
	<link href="{{ URL::asset('build/css/jq-steps/custom_style.css') }} " rel="stylesheet">
  <!-- Custom Theme Style -->
    <link href="{{ URL::asset('build/css/custom.min.css') }} " rel="stylesheet">
    
  <style>
  body {
    color: #73879C;
		background: #fff;
  }
  </style>
    
  

	<div class="pg-header">
		<h4 class="install_title">Garage Management System Wizard</h4>
	</div>
	<div class="step-content">
		<form id="install-form" method="post" action="{!! url('/installation') !!}" enctype="multipart/form-data" class="form-horizontal"> 

			<div>
				<h3>Database Setup</h3>
				<section>
					<h4>Database Setup</h4>
					<hr/>
					<div class="form-group">
						<label class="control-label col-md-3">Database Name<span class="text-danger"> *</span></label>
						<div class="col-md-5">
						<div class="input text">
							<input type="text" name="db_name" value="{{ old('db_name') }}" class="form-control required">
							(Database Name Must Be Unique.)
						</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Database User Name<span class="text-danger"> *</span></label>
						<div class="col-md-5">
						<div class="input text">
						<input type="text" name="db_username" value="{{ old('db_username') }}" class="form-control required">
						</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Database Password</label>
						<div class="col-md-5">
						<div class="input text">
						<input type="password" name="db_pass" class="form-control">
						</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Host<span class="text-danger"> *</span></label>
						<div class="col-md-5">
						<div class="input text">
						<input type="text" name="db_host" value="{{ old('db_host') }}" class="form-control required">
						</div>
						</div>
					</div>
					<div class="col-md-offset-3">
						<p> (*) Fields are required.</p>
					</div>
				</section>
				<h3>System Setting</h3>
				<section> 
				  <h4>System Setting</h4>
				  <hr/>
				  <div class="form-group">
					  <label class="control-label col-md-3">System Name<span class="text-danger"> *</span></label>
					  <div class="col-md-8">
					  <div class="input text">
						<input type="text" name="name" value="{{ old('name') }}" class="form-control required" >
					  </div>
					  </div>
				  </div>		  		  
					<div class="form-group">
						<label class="control-label col-md-3">Email</label>
						<div class="col-md-8">
						<div class="input text">
						<input type="text" name="email" value="{{ old('email') }}" class="form-control" value="">
						</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Address </label>
						<div class="col-md-8">
						<div class="input text">
						<input type="text" name="address" value="{{ old('address') }}" class="form-control" value="">
						</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">First Name<span class="text-danger">*</span></label>
						<div class="col-md-8">
						<div class="input text">
						<input type="text" name="firstname"  value="{{ old('firstname') }}" class="form-control required " value="">
						</div>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-md-3">Last Name <span class="text-danger">*</span></label>
						<div class="col-md-8">
						<div class="input text">
						<input type="text" name="lastname" value="{{ old('lastname') }}" class="form-control required " value="">
						</div>
						</div>
					</div>
					
					<div class="col-md-offset-3">
							<p> (*) Fields are required</p>
					</div>
				</section>  
				 <h3>Login Details</h3>
				<section>
				<h4>Login Details</h4>
						<hr/>
						<div class="form-group">
							<label class="control-label col-md-3">Email<span class="text-danger"> *</span></label>
							<div class="col-md-5">
							<div class="input text">
							<input type="email" name="loginemail" value="{{ old('loginemail') }}" class="form-control required">
							</div>
							</div>
						</div>
						<div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
							<label class="control-label col-md-3">Password<span class="text-danger"> *</span></label>
							<div class="col-md-5">
							<div class="input text">
							<input type="password" id="password" name="password" class="form-control required password">
							 @if ($errors->has('password'))
							   <span class="help-block">
								   <strong>{{ $errors->first('password') }}</strong>
							   </span>
						    @endif
							</div>
							</div>
						</div>
						
						<div class="form-group {{ $errors->has('confirm') ? ' has-error' : '' }}">
							<label class="control-label col-md-3">Confirm Password<span class="text-danger"> *</span></label>
							<div class="col-md-5">
							<div class="input text">
							<input type="password" name="confirm" id="confirm" class="form-control required">
							 @if ($errors->has('confirm'))
							   <span class="help-block">
								   <strong>{{ $errors->first('confirm') }}</strong>
							   </span>
						    @endif
							</div>
							</div>
						</div> 		
							<input type="hidden" name="_token" value="{{csrf_token()}}">
				</section>
				<h3>Finish</h3>
				<section id="final">
					<h4>Please Note :</h4>
					<hr/>					
					<p>
						1. It may take couple of minutes to set-up database.
					</p>			
					<p>
						2. Do not refresh this page once you click on install button..
					</p>
					<p>
						3. Installation wizard will acknowledge you once the installation is successful.
					</p>
					<p>
						4. Click on install to complete the installation.
					</p>
					<input type="hidden" name="_token" value="{{csrf_token()}}">
					<div id="loader" style="display:none;">
						<p>			
							<hr/>
							<h4>Please Wait, installation in progress...</h4>
						</p>
						<span>
							
						</span>
					</div>
				</section>
			</div>	
		<input type="hidden" name="_token" value="{{csrf_token()}}">
		</form>
	</div>

<script src="{{ URL::asset('build/js/jq-steps/modernizr-2.6.2.min.js') }}"></script>
<script src="{{ URL::asset('build/js/jq-steps/jquery-1.11.1.min.js') }}"></script>
<script src="{{ URL::asset('build/js/jq-steps/jquery.cookie-1.3.1.js') }}"></script>
<script src="{{ URL::asset('build/js/jq-steps/jquery.steps.js') }}"></script>
<script src="{{ URL::asset('build/js/jq-steps/jquery.validate.min.js') }}"></script>
<script src="{{ URL::asset('build/js/bootstrap.min.js') }}"></script>
<script src="{{ URL::asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
    <!-- Bootstrap -->
	
	
<!-- sweetalert -->
	<link href="{{ URL::asset('vendors/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">	 
	
<link rel="stylesheet prefetch" href="http://fonts.googleapis.com/css?family=Roboto:400,100,300,500,700,900">	
	
<script>
$(function ()
 {
	 
var form = $("#install-form");

form.children("div").steps({
	 labels: {
        cancel: "Cancel",
        current: "current step:",
        pagination: "Pagination",
        finish: "Install Now",
        next: "Next Step",
        previous: "Previous Step",
        loading: "Loading ..."
    },	
    headerTag: "h3",
    bodyTag: "section",	
    transitionEffect: "slideLeft",
    onStepChanging: function (event, currentIndex, newIndex)
    {
        form.validate().settings.ignore = ":disabled,:hidden";
        return form.valid();
    },
    onFinishing: function (event, currentIndex)
    {
		$("#loader").css("display","block");
        form.validate().settings.ignore = ":disabled";
        return form.valid();
    },
    onFinished: function (event, currentIndex)
    {	
		
        form.submit();
    }
});
});
</script>

@if(!empty(session('databasecreated')))
	<Script>
		$(document).ready(function(){
			swal({   
				title: "Garage System is already installed on Same Database",   
				 
			}, function(){
				
					window.location.reload()
			});	
			});	
				
	</script>
	<?php Session::flush(); ?>
@endif