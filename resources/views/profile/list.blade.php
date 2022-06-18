@extends('layouts.app')
 
@section('content')
<div class="right_col" role="main">
	<div class="">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Profile Setting')}}</span></a>
					</div>
						@include('dashboard.profile')
				</nav>
			</div>
		</div>
    </div>
	@if(session('message'))
		<div class="row massage">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="checkbox checkbox-success checkbox-circle">
                   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
                </div>
			</div>
		</div>
	@endif
	<div class="x_content">
		<ul class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="{!!url('setting/profile')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> <b> {{ trans('app.Profile Setting') }}</b></a></li>
		</ul>
	</div>
	<div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_content">
						<form  action="profile/update/{{ $profile->id }}" method="post" enctype="multipart/form-data" 
					            class="form-horizontal upperform">
							<div class="form-group col-md-12 col-sm-12 col-xs-12 has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }}">
								<label class="control-label col-md-3 col-sm-3 col-xs-12"  for="first-name">{{ trans('app.First Name')}} <label class="text-danger">*</label></label>
								<div class="col-md-5 col-sm-5 col-xs-12">
									<input type="text"  name="firstname" placeholder="{{ trans('app.Enter First Name')}}" maxlength="25" value="{{$profile->name}}" class="form-control" required >
											   @if ($errors->has('firstname'))
											   <span class="help-block">
												   <strong>{{ $errors->first('firstname') }}</strong>
											   </span>
										   @endif
								</div>
							</div>
						  
							<div class="form-group col-md-12 col-sm-12 col-xs-12 has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }}">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">{{ trans('app.Last Name')}} <label class="text-danger">*</label>
								</label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								  <input type="text" id="lastname"  name="lastname" placeholder="{{ trans('app.Enter Last Name')}}" maxlength="25" value="{{$profile->lastname}}"
								  class="form-control" >
								  @if ($errors->has('lastname'))
								   <span class="help-block">
									   <strong>{{ $errors->first('lastname') }}</strong>
								   </span>
							   @endif
								</div>
							</div>
						  
							<div class="form-group col-md-12 col-sm-12 col-xs-12 has-feedback">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Gender') }} <label class="text-danger">*</label></label>
								<div class="col-md-5 col-sm-5 col-xs-12 gender">
								  
								   
									  <input type="radio"  name="gender" value="0"  <?php if($profile->gender ==0) { echo "checked"; }?> checked>  {{ trans('app.Male')}} 
							  
									  <input type="radio" name="gender" value="1" <?php if($profile->gender ==1) { echo "checked"; }?>> {{ trans('app.Female')}}
								   
								</div>
							</div>
							<div class="form-group col-md-12 col-sm-12 col-xs-12 {{ $errors->has('dob') ? ' has-error' : '' }}">
								<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Date Of Birth') }}</label>
								<div class="col-md-5 col-sm-5 col-xs-12 input-group date datepicker">
								<?php
								 if($profile->birth_date != '0000-00-00')
								 {
									 $dob =  date(getDateFormat(),strtotime($profile->birth_date)); 
								 }
								 else
								 {
									$dob=''; 
								 }								 
								 ?>
								  
								  <span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
								  <input type="text" id="datepicker" class="form-control" placeholder="<?php echo getDatepicker();?>" value="{{ $dob }}" name="dob" onkeypress="return false;" >
								</div>
								 @if ($errors->has('dob'))
								   <span class="help-block">
									   <strong style="margin-left:27%;">{{ $errors->first('dob') }}</strong>
								   </span>
								@endif
							</div>
							<div class="form-group col-md-12 col-sm-12 col-xs-12 has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Email">{{ trans('app.Email') }} <label class="text-danger">*</label>
								</label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								  <input type="text"  name="email" placeholder="{{ trans('app.Enter Email')}}" value="{{$profile->email}}" class="form-control " maxlength="50" required>
												  @if ($errors->has('email'))
												   <span class="help-block">
													   <strong>{{ $errors->first('email') }}</strong>
												   </span>
											   @endif
								</div>
							</div>
						  
							<div class="form-group col-md-12 col-sm-12 col-xs-12 has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Password">{{ trans('app.New Password') }} </label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								  <input type="password"  name="password" placeholder="{{ trans('app.Enter Password')}}" maxlength="20" class="form-control col-md-7 col-xs-12" >
											   @if ($errors->has('password'))
											   <span class="help-block">
												   <strong>{{ $errors->first('password') }}</strong>
											   </span>
										   @endif
								</div>
							</div>
							
							<div class="form-group has-feedback col-md-12 col-sm-12 col-xs-12 {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Password">
								{{ trans('app.Confirm Password') }}</label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								  <input type="password"  name="password_confirmation" placeholder="{{ trans('app.Enter Confirm Password')}}" maxlength="20" class="form-control col-md-7 col-xs-12" >
											   @if ($errors->has('password_confirmation'))
											   <span class="help-block">
												   <strong>{{ $errors->first('password_confirmation') }}</strong>
											   </span>
										   @endif
								</div>
							</div>
						  
							<div class="form-group col-md-12 col-sm-12 col-xs-12 has-feedback {{ $errors->has('mobile') ? 'has-error' : '' }}">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobile">{{ trans('app.Mobile No')}}</label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								  <input type="text"  name="mobile" placeholder="{{ trans('app.Enter Mobile No')}}" value="{{$profile->mobile_no}}" maxlength="15"  class="form-control">
								   @if ($errors->has('mobile'))
								   <span class="help-block">
									   <strong>{{ $errors->first('mobile') }}</strong>
								   </span>
							   @endif
								</div>
							</div>
						
							<div class="form-group col-md-12 col-sm-12 col-xs-12 has-feedback {{ $errors->has('image') ? 'has-error' : '' }}">
								<label class="control-label col-md-3 col-sm-3 col-xs-12" for="image">{{ trans('app.Image') }} 
								</label>
								<div class="col-md-5 col-sm-5 col-xs-12">
								  <input type="file" id="image" name="image"  class="form-control " >
								@if($profile->role == "admin")
									<img src="{{ url('public/admin/'.$profile->image) }}"  width="50px" height="50px" class="img-circle" >
								@elseif($profile->role == "Customer")
									<img src="{{ url('public/customer/'.$profile->image) }}"  width="50px" height="50px" class="img-circle" >
								@elseif($profile->role == "employee")
									<img src="{{ url('public/employee/'.$profile->image) }}"  width="50px" height="50px" class="img-circle" >
								@elseif($profile->role == "supportstaff")
									<img src="{{ url('public/supportstaff/'.$profile->image) }}"  width="50px" height="50px" class="img-circle" >
								@elseif($profile->role == "accountant")
									<img src="{{ url('public/accountant/'.$profile->image) }}"  width="50px" height="50px" class="img-circle" >
								@endif
								    @if ($errors->has('image'))
								   <span class="help-block">
									   <strong>{{ $errors->first('image') }}</strong>
								   </span>
							   @endif
								</div>
							</div>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-9 col-sm-9 col-xs-12 text-center">
								 <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
								  <button type="submit" class="btn btn-success">{{ trans('app.Update')}}</button>
								</div>
							</div> 
						</form>
					</div>
				</div>
			</div>
		</div>           
	</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
    
    
    $('.datepicker').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 2,
		minView: 2,
		endDate: new Date(),
		
    });
</script>
@endsection