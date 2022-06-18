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
    <div class="right_col" role="main">
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
				<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('/accountant/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Accountant List') }}</a></li>
			 
				<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('/accountant/list/edit/'.$editid)!!}"><span class="visible-xs"></span><i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i> <b>{{ trans('app.Edit Accountant')}}</b></a></li>
            </ul>
		</div>
        <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
				<div class="x_content">
					<form id="demo-form2" action="update/{{ $accountant->id }}" method="post" 
					          enctype="multipart/form-data" 
					             class="form-horizontal form-label-left input_mask">
								 
                      <div class="col-md-12 col-xs-12 col-sm-12 space">
					  <h4><b>{{ trans('app.Personal Information')}}</b></h4>
					  <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
					  </div>
						
					<div class="col-md-12 col-sm-6 col-xs-12">  
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12"  for="first-name">{{ trans('app.First Name')}} <label class="text-danger">*</label> 
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" id="firstname" name="firstname" placeholder="{{ trans('app.Enter First Name')}}" value="{{$accountant->name}}" class="form-control" maxlength="25" required >
						   @if ($errors->has('firstname'))
							   <span class="help-block">
								   <strong>{{ $errors->first('firstname') }}</strong>
							   </span>
						   @endif
                        </div>
                      </div>
                      
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">{{ trans('app.Last Name')}} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" id="lastname"  name="lastname" placeholder="{{ trans('app.Enter Last Name')}}" value="{{$accountant->lastname}}"
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="display-name">{{ trans('app.Display Name') }} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text"  name="displayname" placeholder="{{ trans('app.Enter Display Name')}}" value="{{$accountant->display_name}}" maxlength="25" class="form-control ">
						   @if ($errors->has('displayname'))
						   <span class="help-block">
							   <strong>{{ $errors->first('displayname') }}</strong>
						   </span>
					   @endif
                        </div>
                      </div>
					  
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Gender') }} <label class="text-danger">*</label></label>
                        <div class="col-md-8 col-sm-8 col-xs-12 gender">
                              <input type="radio"  name="gender" value="0"  <?php if($accountant->gender ==0) { echo "checked"; }?> checked>  {{ trans('app.Male')}} 
                      
                              <input type="radio" name="gender" value="1" <?php if($accountant->gender ==1) { echo "checked"; }?>> {{ trans('app.Female')}}
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12 col-sm-6 col-xs-12">  
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('dob') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Date Of Birth') }} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                          <input type="text" id="datepicker" class="form-control" placeholder="<?php echo getDateFormat();?>" value="{{date(getDateFormat(),strtotime($accountant->birth_date))}}" name="dob" onkeypress="return false;" required />
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
                          <input type="text"  name="email" placeholder="{{ trans('app.Enter Email')}}" value="{{$accountant->email}}" maxlength="50" class="form-control " required>
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Password">{{ trans('app.Password') }} 
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="password"  name="password" placeholder="{{ trans('app.Enter Password')}}" maxlength="20" class="form-control col-md-7 col-xs-12" >
						@if ($errors->has('password'))
						   <span class="help-block">
							   <strong>{{ $errors->first('password') }}</strong>
						   </span>
					   @endif
                        </div>
                      </div>
					  
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
								<label class="control-label col-md-4 col-sm-4 col-xs-12 currency" style="padding-right: 0px;"for="Password">{{ trans('app.Confirm Password') }}</label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="password"  name="password_confirmation" placeholder="{{ trans('app.Enter Confirm Password')}}" class="form-control col-md-7 col-xs-12" maxlength="20">
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobile">{{ trans('app.Mobile No')}} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text"  name="mobile" placeholder="{{ trans('app.Enter Mobile No')}}" value="{{$accountant->mobile_no}}"  class="form-control" maxlength="15" required>
						   @if ($errors->has('mobile'))
						   <span class="help-block">
							   <strong>{{ $errors->first('mobile') }}</strong>
						   </span>
					   @endif
                        </div>
                      </div>
					  
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('landlineno') ? ' has-error' : '' }}">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="landline-no">{{ trans('app.Landline No')}} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" id="landlineno" name="landlineno" placeholder="{{ trans('app.Enter LandLine No')}}" value="{{$accountant->landline_no}}"  class="form-control" maxlength="15">
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">{{ trans('app.Image') }}</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="file" id="image" name="image"  class="form-control " >
						   <img src="{{ url('public/accountant/'.$accountant->image) }}"  width="50px" height="50px" class="img-circle" >
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
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Country" >{{ trans('app.Country') }} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <select class="form-control  select_country" name="country_id" countryurl="{!! url('/getstatefromcountry') !!}" required>
                            <option value="">Select Country</option>
                								@foreach ($country as $countrys)
                								<option value="{{ $countrys->id }}" <?php if($accountant->country_id==$countrys->id){ echo "selected"; }?>>{{$countrys->name }}</option>
                								@endforeach
                          </select>
                        </div>
                      </div>
					  
					   <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="State ">{{ trans('app.State') }}       </label>
                         <div class="col-md-8 col-sm-8 col-xs-12">
                          <select class="form-control  state_of_country" name="state_id" stateurl="{!! url('/getcityfromstate') !!}">
                           @foreach ($state as $states)
								<option value="{!! $states->id !!}" <?php if($accountant->state_id==$states->id){ echo "selected"; }?>>{!! $states->name !!}</option>
							@endforeach
                          </select>
                        </div>
                      </div>
					  
					   <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Town/City">{{ trans('app.Town/City') }}      </label>
                         <div class="col-md-8 col-sm-8 col-xs-12">
                          <select class="form-control  city_of_state" name="city">
                            <option value=""></option>
                            @foreach ($city as $citys)
									<option value="{!! $citys->id !!}" <?php if($accountant->city_id==$citys->id){ echo "selected"; }?>>{!! $citys->name !!}</option>
							@endforeach
                          </select>
                        </div>
                      </div>
					
		              <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Address">{{ trans('app.Address') }} <label class="text-danger">*</label>
                        </label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <textarea id="address" name="address" class="form-control" maxlength="100" required>{{ $accountant->address }}</textarea>
                        </div>
                      </div>
					  <input type="hidden" name="_token" value="{{csrf_token()}}">
                      
                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                          <button type="submit" class="btn btn-success">{{ trans('app.Update') }}</button>
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