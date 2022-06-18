@extends('layouts.app')
@section('content')
<!-- page content -->
<style>
.error_color{color:red; font-weight:bold;}
</style>
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Settings',$userid)=='yes')
	@if(!empty(getActiveAdmin($userid)=='no'))
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
							<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.General Settings')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
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
            </div>
			<div class="x_content">
				<ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
					
					
					<li role="presentation" class="active suppo_llng_li floattab"><a href="{!! url('setting/general_setting/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cogs">&nbsp;</i><b>{{ trans('app.General Settings')}}</b></a></li>
					
					<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/timezone/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cog">&nbsp;</i>{{ trans('app.Other Settings')}}</a></li>
					
					{{-- <li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/accessrights/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-universal-access">&nbsp;</i> {{ trans('app.Access Rights')}}</a></li>
					
					<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/hours/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-hourglass-end">&nbsp;</i>{{ trans('app.Business Hours')}}</a></li> --}}
					
					
				</ul>
			</div>
            <div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<form method="post" action="{{ url('setting/general_setting/store') }}" enctype="multipart/form-data" class="form-horizontal upperform">
					
								<div class="col-md-12 col-sm-12 col-xs-12">
								  <h4><b>{{ trans('app.Business Information')}} </b></h4>
								  <p class="col-md-12 col-sm-12 col-xs-12 ln_solid"></p>
								</div>
								<div class="form-group col-md-12 col-sm-12 col-xs-12  has-feedback">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Country">{{ trans('app.System Name')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="System_Name" class="form-control" placeholder="{{ trans('app.Enter System Name/Title') }}" required maxlength="50" value="{{ $settings_data->system_name }}">
										@if ($errors->has('System_Name'))
										   <span class="help-block">
											   <span class="error_color">{{ $errors->first('System_Name') }}</span>
										   </span>
										@endif
									</div>
								</div>
					
								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Country">{{ trans('app.Starting Year')}} </label>
								   <div class="col-md-6 col-sm-6 col-xs-12 input-group date" id="datepicker1">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" name="start_year" class="form-control" id="Country" value="{{ $settings_data->starting_year }}">
									</div>
								</div>
													
								<div class="form-group col-md-12 col-sm-12 col-xs-12  has-feedback">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Phone_Number">{{ trans('app.Phone Number')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="Phone_Number" class="form-control" placeholder="{{ trans('app.Enter Phone Number') }}" required maxlength="15" value="{{ $settings_data->phone_number }}">
										@if ($errors->has('Phone_Number'))
										   <span class="help-block">
											   <span class="error_color">{{ $errors->first('Phone_Number') }}</span>
										   </span>
										@endif
									</div>
								</div>
					
								<div class="form-group col-md-12 col-sm-12 col-xs-12  has-feedback">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Country">{{ trans('app.Email')}} <label class="text-danger">*</label> 
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="Email" class="form-control" placeholder="{{ trans('app.Enter Email Address') }}" required value="{{ $settings_data->email }}" maxlength="50">
										@if ($errors->has('Email'))
										   <span class="help-block">
											   <span class="error_color">{{ $errors->first('Email') }}</span>
										   </span>
										@endif
									</div>
								</div>
					
								<div class="form-group col-md-12 col-sm-12 col-xs-12  has-feedback">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Country">{{ trans('app.Address')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<textarea name="address" class="form-control" rows="4" placeholder="{{ trans('app.Enter Address') }}" maxlength="100" required >{{ $settings_data->address }}</textarea>
									</div>
								</div>
				
								<div class="form-group col-md-12 col-sm-12 col-xs-12  has-feedback">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Country">{{ trans('app.Country')}} <label class="text-danger">*</label>
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<select class="form-control  select_country" name="country_id" countryurl="{!! url('/getstatefromcountry') !!}" required>
											<option value="">Select Country</option>
											@foreach ($country as $countrys)
											<option value="{{ $countrys->id }}" <?php if($settings_data->country_id==$countrys->id){ echo "selected"; }?>>{{$countrys->name }}</option>
											@endforeach
										</select>
									</div>
								</div>
					
								<div class="form-group col-md-12 col-sm-12 col-xs-12  has-feedback">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="state">{{ trans('app.State')}}</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<select class="form-control  state_of_country" name="state_id" stateurl="{!! url('/getcityfromstate') !!}">
										   @foreach ($state as $states)
												<option value="{!! $states->id !!}" <?php if($settings_data->state_id==$states->id){ echo "selected"; }?>>{!! $states->name !!}</option>
											@endforeach
									    </select>
									</div>
								</div>
					
								<div class="form-group col-md-12 col-sm-12 col-xs-12  has-feedback">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="city">{{ trans('app.City')}} 			</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<select class="form-control  city_of_state" name="city">
										<option value=""></option>
										@foreach ($city as $citys)
												<option value="{!! $citys->id !!}" <?php if($settings_data->city_id==$citys->id){ echo "selected"; }?>>{!! $citys->name !!}</option>
										@endforeach
									  </select>
									</div>
								</div>
					
								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="image">{{ trans('app.Logo Image')}}</label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<input type="file" id="input-file-max-fs" name="Logo_Image" class="form-control dropify" data-max-file-size="5M">
											@if ($errors->has('Logo_Image'))
											   <span class="help-block">
												   <span class="error_color">{{ $errors->first('Logo_Image') }}</span>
											   </span>
											@endif
											<div class="col-md-12 col-sm-12 col-xs-12 printimg">
											<img src="{{ url('public/general_setting/'.$settings_data->logo_image) }}" class="logo_img">
											</div>
												<div class="dropify-preview">
													<span class="dropify-render"></span>
													<div class="dropify-infos">
														<div class="dropify-infos-inner">
															<p class="dropify-filename">
																<span class="file-icon"></span> 
																<span class="dropify-filename-inner"></span>
															</p>
														</div>
													</div>
												</div>
										</div>
								</div> 
					  
								<div class="form-group col-md-12 col-sm-12 col-xs-12 ">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="image">{{ trans('app.Cover Image')}}</label>
										<div class="col-md-4 col-sm-4 col-xs-12">
											<input type="file" id="input-file-max-fs"  name="Cover_Image"  class="form-control dropify" data-max-file-size="5M">
											@if ($errors->has('Cover_Image'))
											   <span class="help-block">
												   <span class="error_color">{{ $errors->first('Cover_Image') }}</span>
											   </span>
											@endif
											
											<img src="{{ url('public/general_setting/'.$settings_data->cover_image) }}" class="cov_img" height="250px" width="100%">
											
												<div class="dropify-preview ">
													<span class="dropify-render"></span>
													<div class="dropify-infos">
														<div class="dropify-infos-inner">
															<p class="dropify-filename">
																<span class="file-icon"></span> 
																<span class="dropify-filename-inner"></span>
															</p>
														</div>
													</div>
												</div>
										</div>
								</div>
					
								{{-- <div class="form-group col-md-12 col-sm-12 col-xs-12  has-feedback">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="Country">{{ trans('app.Paypal Email Id')}}
									</label>
									<div class="col-md-6 col-sm-6 col-xs-12">
										<input type="text" name="Paypal_Id" class="form-control" placeholder="{{ trans('app.Enter Paypal Email Address') }}" maxlength="50" value="{{ $settings_data->paypal_id }}">
										@if ($errors->has('Paypal_Id'))
										   <span class="help-block">
											   <span class="error_color">{{ $errors->first('Paypal_Id') }}</span>
										   </span>
										@endif
									</div>
								</div> --}}
								<input type="hidden" name="_token" value="{{ csrf_token() }}">
								<div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">  
									<div class="col-md-9 col-sm-9 col-xs-12 text-center" >
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
										<input type="submit" class="btn btn-success"  value="{{ trans('app.Update')}}"/>
									</div>
								</div>
							</form>
						</div>
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
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script> 
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

	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- datetimepicker in starting_year  -->
	<script>
    $('#datepicker1').datetimepicker({
        format: "yyyy",
		autoclose: 2,
		minView: 4,
		startView: 4,
    });
</script>

<script>
            $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();

                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();
                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        
</script>
@endsection