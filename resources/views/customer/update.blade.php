@extends('layouts.app')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Customers',$userid)=='yes')
	@if(getActiveCustomer($userid)=='no' && $customer->id != Auth::user()->id )
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
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Customer')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
			</div>
        </div>
		<div class="x_content">
            <ul class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class=""><a href="{!! url('/customer/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Customer List') }}</a></li>
				<li role="presentation" class="active"><a href="{!! url('/customer/list/edit/'.$editid)!!}"><span class="visible-xs"></span><i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i> <b>{{ trans('app.Edit Customer')}}</b></a></li>
            </ul>
		</div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_content">
						<form id="demo-form2" action="update/{{ $customer->id }}" method="post"
					          enctype="multipart/form-data" class="form-horizontal form-label-left input_mask">
							<div class="col-md-12 col-xs-12 col-sm-12 space">
								<h4><b>{{ trans('app.Personal Information')}}</b></h4>
								<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
							</div>
						<div class="col-md-12 col-sm-6 col-xs-12">
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }}">
								<label class="control-label col-md-4 col-sm-4 col-xs-12"  for="first-name">{{ trans('app.First Name')}} <label class="text-danger">*</label> </label>
								<div class="col-md-8 col-sm-8 col-xs-12">
								  <input type="text" id="firstname" name="firstname" placeholder="{{ trans('app.Enter First Name')}}" value="{{$customer->name}}" class="form-control" maxlength="25" required >
												   @if ($errors->has('firstname'))
												   <span class="help-block">
													   <strong>{{ $errors->first('firstname') }}</strong>
												   </span>
											   @endif
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }}">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="last-name">{{ trans('app.Last Name')}} <label class="text-danger">*</label></label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="text" id="lastname"  name="lastname" placeholder="{{ trans('app.Enter Last Name')}}" value="{{$customer->lastname}}"class="form-control" maxlength="25" required>
									@if ($errors->has('lastname'))
								    <span class="help-block">
									    <strong>{{ $errors->first('lastname') }}</strong>
								    </span>
									@endif
								</div>
							</div>

						<div class="col-md-12 col-sm-6 col-xs-12">
							<div class="col-md-6 col-sm-6 col-xs-12 form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Date Of Birth') }}</label>
								<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									@if($customer->birth_date)
										<input type="text" id="datepicker" class="form-control" placeholder="<?php echo getDateFormat();?>" value="{{ date(getDateFormat(),strtotime($customer->birth_date))}}" name="dob" onkeypress="return false;"  />
									@else
										<input type="text" id="datepicker" class="form-control" placeholder="<?php echo getDateFormat();?>" value="" name="dob" onkeypress="return false;"  />
									@endif
								</div>
								@if ($errors->has('dob'))
											<span class="help-block">
												<strong style="margin-left:27%;">{{ $errors->first('dob') }}</strong>
											</span>
										@endif
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 form-group">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Email">{{ trans('app.Email') }} </label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="text"  name="email" placeholder="{{ trans('app.Enter Email')}}" value="{{$customer->email}}" class="form-control" maxlength="50" >
									@if ($errors->has('email'))
										<span class="help-block">
											<strong>{{ $errors->first('email') }}</strong>
										</span>
								    @endif
								</div>
							</div>
						</div>

						<div class="col-md-12 col-sm-6 col-xs-12">
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobile">{{ trans('app.Mobile No')}} <label class="text-danger">*</label> </label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="text"  name="mobile" placeholder="{{ trans('app.Enter Mobile No')}}" value="{{$customer->mobile_no}}" maxlength="15" class="form-control" required>
									@if ($errors->has('mobile'))
									<span class="help-block">
										<strong>{{ $errors->first('mobile') }}</strong>
									</span>
									@endif
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('landlineno') ? ' has-error' : '' }}">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="landline-no">{{ trans('app.Landline No')}} </label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="text" id="landlineno" name="landlineno" placeholder="{{ trans('app.Enter LandLine No')}}" value="{{$customer->landline_no}}" maxlength="15"  class="form-control">
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
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">{{ trans('app.Image') }} </label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<input type="file" id="image" name="image"  class="form-control " >
										<img src="{{ url('public/customer/'.$customer->image) }}"  width="50px" height="50px" class="img-circle" >
									@if ($errors->has('image'))
									<span class="help-block">
										<strong>{{ $errors->first('image') }}</strong>
									</span>
									@endif
								</div>
							</div>
						</div>
							<div class="col-md-12 col-xs-12 col-sm-12 space">
								<h4><b>{{ trans('app.Emirates')}}</b></h4>
								<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Country" >{{ trans('app.Country') }} <label class="text-danger">*</label></label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<select class="form-control  select_country" name="country_id" countryurl="{!! url('/getstatefromcountry') !!}" required>
										<option value="">Select Country</option>
											@foreach ($country as $countrys)
											<option value="{{ $countrys->id }}" <?php if($customer->country_id==$countrys->id){ echo "selected"; }?>>{{$countrys->name }}</option>
											@endforeach
									</select>
								</div>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="State ">{{ trans('app.State') }} </label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<select class="form-control  state_of_country" name="state_id" stateurl="{!! url('/getcityfromstate') !!}">
										@foreach ($state as $states)
											<option value="{!! $states->id !!}" <?php if($customer->state_id==$states->id){ echo "selected"; }?>>{!! $states->name !!}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Town/City">{{ trans('app.Town/City') }}</label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<select class="form-control  city_of_state" name="city">
											<option value=""></option>
										@foreach ($city as $citys)
											<option value="{!! $citys->id !!}" <?php if($customer->city_id==$citys->id){ echo "selected"; }?>>{!! $citys->name !!}</option>
										@endforeach
									</select>
								</div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
								<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Address">{{ trans('Emirates') }} <label class="text-danger">*</label></label>
								<div class="col-md-8 col-sm-8 col-xs-12">
									<textarea class="form-control" id="address" name="address" maxlength="100" required>{{ $customer->address }}</textarea>
								</div>
							</div>
							@if(!empty($tbl_custom_fields))
							<div class="col-md-12 col-xs-12 col-sm-12 space">
								<h4><b>{{ trans('app.Custom Fields')}}</b></h4>
								<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
							</div>
								@foreach($tbl_custom_fields as $tbl_custom_field)
							       <?php
										if($tbl_custom_field->required == 'yes')
										{
											$required="required";
											$red="*";
										}else{
											$required="";
											$red="";
										}

											$tbl_custom=$tbl_custom_field->id;
											$userid=$customer->id;
											$datavalue=getCustomData($tbl_custom,$userid);
									?>
										<div class="form-group col-md-6  col-sm-6 col-xs-12">
											<label class="control-label col-md-4 col-sm-4 col-xs-12" for="account-no">{{$tbl_custom_field->label}} <label class="text-danger">{{$red}}</label></label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												@if($tbl_custom_field->type == 'textarea')
													<textarea  name="custom[{{$tbl_custom_field->id}}]" class="form-control" placeholder="Enter {{$tbl_custom_field->label}}" maxlength="100" {{$required}}>{{$datavalue}}</textarea>
												@else
													<input type="{{$tbl_custom_field->type}}" name="custom[{{$tbl_custom_field->id}}]"  class="form-control" placeholder="Enter {{$tbl_custom_field->label}}" value="{{$datavalue}}" maxlength="30" {{$required}}>
												@endif
											</div>
										</div>
								@endforeach
							@endif
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
