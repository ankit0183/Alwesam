@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Accountants',$userid)=='yes')
	@if(!empty(getActiveCustomer($userid)=='no'))
	<div class="right_col" role="main" style="background-color: #e6e6e6;">
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle titleup">
						<span>&nbsp {{ trans('app.You are not authorize this page.')}}</span>
					</div>
				</nav>
			</div>
		</div>
	</div>
	@else
        <div class="right_col" role="main" style="background-color: #e6e6e6;">
          <div class="">
            <div class="page-title">
              <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Accountant')}}</span></a>
              </div>
               @include('dashboard.profile')
            </nav>
          </div>
        </div>
            </div>
			 <div class="x_content">
                   <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
			<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('/accountant/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg ">&nbsp;</i> {{ trans('app.Accountant List') }}</a></li>
			
			<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('/accountant/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i> <b>{{ trans('app.Add Accountant') }}</b></a></li>
            </ul>
			</div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   <div class="x_content">
                    <form id="demo-form2" action="{!! url('/accountant/store')!!}" method="post" 
					enctype="multipart/form-data" data-parsley-validate 
					             class="form-horizontal form-label-left input_mask">
					 <div class="col-md-12 col-xs-12 col-sm-12 space">
					  <h4><b>{{ trans('app.Personal Information')}}</b></h4>
					  <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
					  </div>
                    <div class="col-md-12 col-sm-6 col-xs-12">     
					   <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">{{ trans('app.First Name') }} <label class="text-danger">*</label> 
						
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" id="firstname" name="firstname"  class="form-control"  
                          value="{{ old('firstname') }}" placeholder="{{ trans('app.Enter First Name')}}" maxlength="25"  required  />
						  @if ($errors->has('firstname'))
						   <span class="help-block">
							   <strong>{{ $errors->first('firstname') }}</strong>
						   </span>
					   @endif
                        </div>
                      </div>
                       <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">{{ trans('app.Last Name') }} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" id="lastname" name="lastname" placeholder="{{ trans('app.Enter Last Name')}}" value="{{ old('lastname') }}"
						  class="form-control" maxlength="25" required>
						  @if ($errors->has('lastname'))
						   <span class="help-block">
							   <strong>{{ $errors->first('lastname') }}</strong>
						   </span>
					     @endif
                        </div>
                      </div>
                    </div>
					<div class="col-md-12 col-sm-6 col-xs-12">  
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('displayname') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="display-name">{{ trans('app.Display Name')}} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text"  name="displayname" placeholder="{{ trans('app.Enter Display Name')}}" maxlength="25" value="{{ old('displayname') }}" class="form-control ">
						  @if ($errors->has('displayname'))
						   <span class="help-block">
							   <strong>{{ $errors->first('displayname') }}</strong>
						   </span>
					     @endif
                        </div>
                      </div>
                       <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12"> {{ trans('app.Gender')}} <label class="text-danger">*</label></label>
                        <div class="col-md-8 col-sm-8 col-xs-12 gender">
                              <input type="radio"  name="gender" value="0" checked>{{ trans('app.Male')}} 
                      
                              <input type="radio" name="gender" value="1" > {{ trans('app.Female')}}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-12">  
						<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Date Of Birth')}} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                          <input type="text" id="datepicker" class="form-control" placeholder="<?php echo getDatepicker();?>" name="dob" value="{{ old('dob') }}"  onkeypress="return false;" required />
                        </div>
						@if ($errors->has('dob'))
							<span class="help-block">
								<strong style="margin-left:27%;">{{ $errors->first('dob') }}</strong>
							</span>
						@endif
                      </div>
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Email">{{ trans('app.Email') }} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="email"  name="email" placeholder="{{ trans('app.Enter Email')}}" value="{{ old('email') }}" maxlength="50" class="form-control " required>
						   @if ($errors->has('email'))
						   <span class="help-block">
							   <strong>{{ $errors->first('email') }}</strong>
						   </span>
					   @endif
                        </div>
                      </div>
                    </div>
					<div class="col-md-12 col-sm-6 col-xs-12">  
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('password') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Password">{{ trans('app.Password') }} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="password"  name="password" placeholder="{{ trans('app.Enter Password')}}" maxlength="20" class="form-control col-md-7 col-xs-12" required>
						   @if ($errors->has('password'))
						   <span class="help-block">
							   <strong>{{ $errors->first('password') }}</strong>
						   </span>
					   @endif
                        </div>
                      </div>
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
								<label class="control-label col-md-4 col-sm-4 col-xs-12 currency" style="padding-right: 0px;"for="Password">{{ trans('app.Confirm Password') }} <label class="text-danger">*</label></label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="password"  name="password_confirmation" placeholder="{{ trans('app.Enter Confirm Password')}}" class="form-control col-md-7 col-xs-12" maxlength="20" required>
									@if ($errors->has('password_confirmation'))
									<span class="help-block">
										<strong>{{ $errors->first('password_confirmation') }}</strong>
									</span>
									@endif
								</div>
							</div>
						</div>
						<div class="col-md-12 col-sm-6 col-xs-12">  	
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobile">{{ trans('app.Mobile No') }} <label class="text-danger" >*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text"  name="mobile" placeholder="{{ trans('app.Enter Mobile No')}}" value="{{ old('mobile') }}" maxlength="15" class="form-control" required >
						  @if ($errors->has('mobile'))
						   <span class="help-block">
							   <strong>{{ $errors->first('mobile') }}</strong>
						   </span>
					   @endif
                        </div>
                      </div>
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('landlineno') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="landline-no">{{ trans('app.Landline No') }} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" id="landlineno" name="landlineno" placeholder="{{ trans('app.Enter LandLine No')}}" maxlength="15" value="{{ old('landlineno') }}" class="form-control">
						  @if ($errors->has('landlineno'))
						   <span class="help-block">
							   <strong>{{ $errors->first('landlineno') }}</strong>
						   </span>
					   @endif
                        </div>
                      </div>
                    </div>
					<div class="col-md-12 col-sm-6 col-xs-12">  
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('image') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">
                        {{ trans('app.Image')}}</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="file" id="image" name="image"  class="form-control ">
						  @if ($errors->has('image'))
						   <span class="help-block">
							   <strong>{{ $errors->first('image') }}</strong>
						   </span>
					   @endif
                        </div>
                      </div>
					</div> 
					  <div class="col-md-12 col-xs-12 col-sm-12 space">
					  <h4><b>{{ trans('app.Address')}}</b></h4>
					  <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
					  </div>
					   <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Country">{{ trans('app.Country')}} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <select class="form-control  select_country" name="country_id" countryurl="{!! url('/getstatefromcountry') !!}" required>
                            <option value="">{{ trans('app.Select Country')}}</option>
								@foreach ($country as $countrys)
								<option value="{{ $countrys->id }}">{{$countrys->name }}</option>
								@endforeach
                          </select>
                        </div>
                      </div>
					  
					   <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="State ">{{ trans('app.State') }}        </label>
                         <div class="col-md-8 col-sm-8 col-xs-12">
                          <select class="form-control  state_of_country" name="state_id" stateurl="{!! url('/getcityfromstate') !!}">
                            
                          </select>
                        </div>
                      </div>
					   <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Town/City">{{ trans('app.Town/City')}} 
                        </label>
                         <div class="col-md-8 col-sm-8 col-xs-12">
                          <select class="form-control  city_of_state" name="city"  >
                          </select>
                        </div>
                      </div>
		               <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Address">{{ trans('app.Address') }} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
						  <textarea id="address" name="address" class="form-control" maxlength="100" required>{{ old('address') }}</textarea>
                        </div>
                      </div>
					   <input type="hidden" name="_token" value="{{csrf_token()}}">
                      
                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                          <button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
           </div>
		  @endif
		  @else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
              <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
              </div>
        </div>
	</div>
@endif   
<script>
$(document).ready(function(){
	
	$('.select_country').change(function(){
		countryid = $(this).val();
		var url = $(this).attr('countryurl');
		$.ajax({
			type:'GET',
			url: url,
			data:{ countryid:countryid },
			success:function(response){
				$('.state_of_country').html(response);
			}
		});
	});
	
	$('body').on('change','.state_of_country',function(){
		stateid = $(this).val();
		
		var url = $(this).attr('stateurl');
		$.ajax({
			type:'GET',
			url: url,
			data:{ stateid:stateid },
			success:function(response){
				$('.city_of_state').html(response);
			}
		});
	});
});
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
    
    
    $('.datepicker').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
		endDate: new Date(),
    });
</script>

@endsection