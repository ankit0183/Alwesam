@extends('layouts.app')
@section('content')
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Employees',$userid)=='yes')

	@if(getActiveCustomer($userid)=='no' && $user->id != Auth::user()->id )
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
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Employee')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
			</div>
		</div>
		<div class="x_content">
            <ul class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class=""><a href="{!! url('employee/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Employee List')}}</a></li>
				<li role="presentation" class="active"><a href="{!! url('employee/edit/'.$editid)!!}"><span class="visible-xs"></span> <i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit Employee')}}</b></a></li>
            </ul>
		</div>
        <div class="clearfix"></div>
            <div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<form method="post" action="update/{{ $user->id }}" enctype="multipart/form-data" class="form-horizontal upperform">
							{!! method_field('patch') !!}
								<div class="col-md-12 col-xs-12 col-sm-12 space">
									<h4><b>{{ trans('app.Personal Information')}}</b></h4>
									<p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
								</div>
							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="first-name">{{ trans('app.First Name')}} <label class="text-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" id="firstname" name="firstname" placeholder="{{ trans('app.Enter First Name')}}" class="form-control" value="{{ $user->name }}" maxlength="25" required>
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
									  <input type="text" id="lastname" name="lastname" placeholder="{{ trans('app.Enter Last Name')}}" class="form-control" value="{{ $user->lastname }}" maxlength="25">
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
									<label for="middle-name" class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Display Name')}} <label class="text-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" id="displayname" class="form-control" placeholder="Enter Display Name" name="displayname" value="{{ $user->display_name }}" maxlength="25">
										@if ($errors->has('displayname'))
										<span class="help-block">
											<strong>{{ $errors->first('displayname') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Gender')}} <label class="text-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12 gender">
										<input type="radio"  name="gender" value="1" <?php if($user->gender ==1) { echo "checked"; }?> required>{{ trans('app.Male')}}
										<input type="radio" name="gender" value="2" <?php if($user->gender ==2) { echo "checked"; }?> required> {{ trans('app.Female')}}
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group  {{ $errors->has('dob') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Date Of Birth')}} <label class="text-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker1">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" id="datepicker" class="form-control" placeholder="<?php echo getDateFormat();?>" name="dob" value="{{ date(getDateFormat(),strtotime($user->birth_date)) }}"  onkeypress="return false;" required />
									</div>
									@if ($errors->has('dob'))
											<span class="help-block">
												<strong style="margin-left:27%;">{{ $errors->first('dob') }}</strong>
											</span>
										@endif
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }} ">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Email">{{ trans('app.Email')}} <label class="text-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
									  <input type="text" id="email" name="email" class="form-control" placeholder="Enter Email" value="{{ $user->email }}" maxlength="50" required>
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
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="mobile">{{ trans('app.Mobile No')}} <label class="text-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" id="mobile" name="mobile" placeholder="Enter Mobile No" class="form-control" value="{{ $user->mobile_no }}" maxlength="15" required>
										@if ($errors->has('mobile'))
										<span class="help-block">
											<strong>{{ $errors->first('mobile') }}</strong>
										</span>
										@endif
									</div>
								</div>

							</div>
							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('join_date') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Town/City">{{ trans('app.Join Date')}} <label class="text-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" id="join_date" class="form-control" placeholder="<?php echo getDateFormat();?>"  value="{{date(getDateFormat(),strtotime($user->join_date))}}"  name="join_date" required readonly />
										@if ($errors->has('join_date'))
										<span class="help-block">
											<strong>{{ $errors->first('join_date') }}</strong>
										</span>
										@endif
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback ">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">{{ trans('app.Designation')}}</label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<input type="text" id="" class="form-control" value="{{ $user->designation }}"  name="designation" placeholder="{{ trans('app.Designation')}}" maxlength="30">
										@if ($errors->has('designation'))
										<span class="help-block" style="color:red;">
											<strong>{{ $errors->first('designation') }}</strong>
										</span>
										@endif
									</div>
								</div>
							</div>
							<div class="col-md-12 col-sm-6 col-xs-12">
								<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('left_date') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">{{ trans('app.Left Date')}}
									</label>
								    <div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker2">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<?php
											if($user->left_date =='0000-00-00')
											{
												$leftdate=getDatepicker();
											}
											else
											{
												$leftdate=date(getDateFormat(),strtotime($user->left_date));
											}
										?>
									   <input type="text" id="left_date" class="form-control" placeholder="<?php echo getDateFormat();?>"
									   value="{{ $leftdate }}"  name="left_date" readonly />

									</div>
									@if ($errors->has('left_date'))
										<span class="help-block" style="margin-left: 27%;">
											<strong>{{ $errors->first('left_date') }}</strong>
										</span>
									@endif
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('image') ? ' has-error' : '' }}">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="image">{{ trans('app.Image')}}</label>
									<div class="col-md-8 col-sm-8 col-xs-12">
									  <input type="file" id="image" name="image" value="{{$user->image}}"  class="form-control">
									 <img src="{{ URL::asset('public/employee/'.$user->image) }}"  width="40px" height="40px" class="img-circle" style="margin-top:10px;">
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
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Country">{{ trans('app.Country')}} <label class="text-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
									  <select class="form-control col-md-7 col-xs-12 select_country" name="country_id" countryurl="{!! url('/getstatefromcountry') !!}" required>
										<option value="">{{ trans('app.Select Country')}}</option>
											@foreach ($country as $countrys)
											<option value="{{ $countrys->id }}" <?php if($user->country_id==$countrys->id){ echo "selected"; }?>>{{$countrys->name }}</option>
											@endforeach
									  </select>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="State ">{{ trans('app.State')}} </label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<select class="form-control col-md-7 col-xs-12 state_of_country" name="state" stateurl="{!! url('/getcityfromstate') !!}">
											@foreach ($state as $states)
												<option value="{!! $states->id !!}" <?php if($user->state_id==$states->id){ echo "selected"; }?>>{!! $states->name !!}</option>
											@endforeach

										</select>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Town/City">{{ trans('app.Town/City')}}</label>
									<div class="col-md-8 col-sm-8 col-xs-12">
										<select class="form-control col-md-7 col-xs-12 city_of_state" name="city">
											<option value=""></option>
										@foreach ($city as $citys)
												<option value="{!! $citys->id !!}" <?php if($user->city_id==$citys->id){ echo "selected"; }?>>{!! $citys->name !!}</option>
										@endforeach
										</select>
									</div>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
									 <label class="control-label col-md-4 col-sm-4 col-xs-12" for="Address">{{ trans('app.Address')}} <label class="text-danger">*</label></label>
									<div class="col-md-8 col-sm-8 col-xs-12">
									  <textarea  id="address" name="address" class="form-control" maxlength="100" required>{{ $user->address }}</textarea>
									</div>
								</div>
							  @if(!empty($tbl_custom_fields))
								<div class="col-md-12 col-sm-12 col-xs-12 space">
									<h4><b>{{ trans('app.Custom Field')}}</b></h4>
									<p class="col-md-12 col-sm-12 col-xs-12 ln_solid"></p>
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
												$userid=$user->id;

												$datavalue=getCustomData($tbl_custom,$userid);
												?>
													<div class="form-group col-md-6 col-sm-6 col-xs-12">
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
										<button type="submit" class="btn btn-success">{{ trans('app.Update')}}</button>
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
		 <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.4.min.js"></script>

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


  $('.datepicker1').datetimepicker({
        format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
		endDate: new Date(),
    });

	  $(".datepicker,.input-group-addon").click(function(){

		var dateend = $('#left_date').val('');

		});

		$(".datepicker").datetimepicker({
			format: "<?php echo getDatepicker(); ?>",
			 minView: 2,
			autoclose: 1,
		}).on('changeDate', function (selected) {
			var startDate = new Date(selected.date.valueOf());

			$('.datepicker2').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,

			}).datetimepicker('setStartDate', startDate);
		})
		.on('clearDate', function (selected) {
			 $('.datepicker2').datetimepicker('setStartDate', null);
		})

			$('.datepicker2').click(function(){

			var date = $('#join_date').val();
			if(date == '')
			{
				swal('First Select Join Date');
			}
			else{
				$('.datepicker2').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
				})

			}
			});
</script>

@endsection
