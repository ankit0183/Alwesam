@extends('layouts.app')
@section('content')
<style>
.error_color{color:red; font-weight:bold;}
.delete_hours {
	color:red;
	text-align: center;
}
.listdata{
border-top: 1px solid #e5e5e5;
    color: #fff;
    background-color: #fff;
    height: 1px;
}
.delete_holiday {
	color:red;
	text-align: center;
}
.appendhours{text-align:center;}

</style>
<!-- page content -->
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
							<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.Business Hours')}}</span></a>
						</div>
						@include('dashboard.profile')
					</nav>
				</div>
            @if(session('message'))
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
							@if(session('message') == 'Successfully Submitted')
							<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
						   @elseif(session('message')=='Successfully Updated')
						   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
						   @elseif(session('message')=='Successfully Deleted')
						   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted')}}  </label>@elseif(session('message')=='Date is already inserted')
						  <label for="checkbox-10 colo_success"> {{ trans('app.Date is already inserted')}} </label>
						  @elseif(session('message')=='Please select time which is greater than start time')
						  <label for="checkbox-10 colo_success"> {{ trans('app.Please select time which is greater than start time')}} </label>
						   @endif
						</div>
					</div>
				</div>
			@endif
           
			 @if(session('message1'))
				<style>
					.checkbox-success{
						background-color: #cad0cc!important;
						 color:red;
					}
				</style>
				<div class="row massage">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="checkbox checkbox-success checkbox-circle">
							@if(session('message1')=='Date is already inserted')
								<label for="checkbox-10 colo_success"> {{ trans('app.Date is already inserted')}} </label>
							@elseif(session('message1')=='Please select time which is greater than start time')
								<label for="checkbox-10 colo_success"> {{ trans('app.Please select time which is greater than start time')}} </label>
						   @endif
			
						</div>
					</div>
				</div>
			@endif
            </div>
			
			
			<div class="x_content">
				<ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
					
					<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('setting/general_setting/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cogs">&nbsp;</i>{{ trans('app.General Settings')}}</a></li>
					
					<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/timezone/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cog">&nbsp;</i>{{ trans('app.Other Settings')}}</a></li>
					
					<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/accessrights/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-universal-access">&nbsp;</i> {{ trans('app.Access Rights')}}</a></li>
					
					<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('setting/hours/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-hourglass-end">&nbsp;</i><b>{{ trans('app.Business Hours')}}</b></a></li>
					
				</ul>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_panel">
						<div class="x_content">
							<div class="col-md-12 col-sm-12 col-xs-12 space">
								<h4><b>{{ trans('app.Business Hours') }}</b></h4>
								<p class="col-md-12 col-sm-12 col-xs-12 ln_solid"></p>
							</div>
					
							<div class="form-group col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-offset-2">
									<div class="col-md-12 col-sm-12 col-xs-12 hours_data" style="padding:5px;">
										<div class="col-md-2 col-sm-3 col-xs-3"><b>{{ trans('app.Day')}}</b></div>
										<div class="col-md-2 col-sm-3 col-xs-3 hours_title"><b>{{ trans('app.Open')}}</b> </div>
										<div class="col-md-2 col-sm-3 col-xs-3 hours_title"><b>{{ trans('app.Close')}}</b></div>
										<div class="col-md-1 col-sm-3 col-xs-3 hours_title"><b>{{ trans('app.Action')}}</b></div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12">
									<p class="col-md-7 col-sm-12 col-xs-12 listdata"></p>
									</div>
									@if(!empty($tbl_hours))
									@foreach($tbl_hours as $tbl_hourss)
										<div class="col-md-12 col-sm-12 col-xs-12 hours_data" style="padding:5px;" id="hours_data">
											<input type="hidden" value="{{$tbl_hourss->day}}">
											<input type="hidden" value="{{$tbl_hourss->from}}">
											<input type="hidden" value="{{$tbl_hourss->to}}">
											<div class="col-md-2 col-sm-3 col-xs-3 day_margin">{{getDayName($tbl_hourss->day)}}</div>
										@if($tbl_hourss->from == $tbl_hourss->to)
											<div class="col-md-4 col-sm-6 col-xs-6 day_off">------ {{ trans('app.Day off')}} ------</div>
										@else
											<div class="col-md-2 col-sm-3 col-xs-3 tbl_hourss">{{ getOpenHours($tbl_hourss->from)}} </div>
											<div class="col-md-2 col-sm-3 col-xs-3 tbl_hourss">{{ getCloseHours($tbl_hourss->to)}}</div>
										@endif
											<div class="col-md-1 col-sm-3 col-xs-2 delete_hours remv_padding" deletehours="{{$tbl_hourss->id}}" url="{!! url('/setting/deletehours/'.$tbl_hourss->id) !!}"><i class="fa fa-trash fa-2x"></i></div>
										</div>
									@endforeach
									@endif
									<div class="col-md-12 col-sm-12 col-xs-12">
										<p class="col-md-7 col-sm-12 col-xs-12 listdata"></p>
									</div>
								</div>
							</div>
								<form method="post" action="{{ url('setting/hours/store') }}" enctype="multipart/form-data" class="form-horizontal upperform">
									<div class="form-group col-md-12 col-sm-12 col-xs-12 ">
										<label class="control-label col-md-2 col-sm-2 col-xs-12">{{ trans('app.Business Hours')}} <label class="text-danger">*</label></label>
										<div class="col-md-2 col-sm-3 col-xs-6">
											<select class="form-control day" name="day">
												<option value="1">Monday</option>
												<option value="2">Tuesday</option>
												<option value="3">Wednesday</option>
												<option value="4">Thursday</option>
												<option value="5">Friday</option>
												<option value="6">Saturday</option>
												<option value="7">Sunday</option>
											</select>
										</div>
										<div class="col-md-2 col-md-2 col-sm-2 col-xs-6 form-group">
											<select class="form-control" name="start" >
												<option value="0">12:00 AM</option>
												<option value="1">1:00 AM</option>
												<option value="2">2:00 AM</option>
												<option value="3">3:00 AM</option>
												<option value="4">4:00 AM</option>
												<option value="5">5:00 AM</option>
												<option value="6">6:00 AM</option>
												<option value="7">7:00 AM</option>
												<option value="8">8:00 AM</option>
												<option value="9">9:00 AM</option>
												<option value="10">10:00 AM</option>
												<option value="11">11:00 AM</option>
												<option value="12">12:00 PM</option>
												<option value="13">1:00 PM</option>
												<option value="14">2:00 PM</option>
												<option value="15">3:00 PM</option>
												<option value="16">4:00 PM</option>
												<option value="17">5:00 PM</option>
												<option value="18">6:00 PM</option>
												<option value="19">7:00 PM</option>
												<option value="20">8:00 PM</option>
												<option value="21">9:00 PM</option>
												<option value="22">10:00 PM</option>
												<option value="23">11:00 PM</option>
											</select>
										</div>
										<div class="col-md-2 col-md-2 col-sm-2 col-xs-6 form-group">
											<select class="form-control to" name="to">
												<option value="0">12:00 AM</option>
												<option value="1">1:00 AM</option>
												<option value="2">2:00 AM</option>
												<option value="3">3:00 AM</option>
												<option value="4">4:00 AM</option>
												<option value="5">5:00 AM</option>
												<option value="6">6:00 AM</option>
												<option value="7">7:00 AM</option>
												<option value="8">8:00 AM</option>
												<option value="9">9:00 AM</option>
												<option value="10">10:00 AM</option>
												<option value="11">11:00 AM</option>
												<option value="12">12:00 PM</option>
												<option value="13">1:00 PM</option>
												<option value="14">2:00 PM</option>
												<option value="15">3:00 PM</option>
												<option value="16">4:00 PM</option>
												<option value="17">5:00 PM</option>
												<option value="18">6:00 PM</option>
												<option value="19">7:00 PM</option>
												<option value="20">8:00 PM</option>
												<option value="21">9:00 PM</option>
												<option value="22">10:00 PM</option>
												<option value="23">11:00 PM</option>
												
											</select>
										</div>
											<input type="hidden" name="_token" value="{{ csrf_token() }}">
											<div class="col-md-2 col-sm-2">
												 <input type="submit" class="btn btn-success"  value="{{ trans('app.Submit')}}"/>
											</div>
									</div>
								</form>
							<div class="col-md-12 col-sm-12 col-xs-12 space">
									<h4><b>{{ trans('app.Business Holiday') }}</b></h4>
									<p class="col-md-12 col-sm-12 col-xs-12 ln_solid"></p>
							</div>
							<div class="form-group col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-offset-2 col-sm-10">
									<div class="col-md-12 col-sm-12 hours_data" style="padding:5px;">
										<div class="col-md-2 col-sm-3"><b>{{ trans('app.Date')}}</b></div>
										<div class="col-md-2 col-sm-3"><b>{{ trans('app.Title')}}</b> </div>
										<div class="col-md-2 col-sm-3"><b>{{ trans('app.Description')}}</b></div>
										<div class="col-md-2 col-sm-3"><b>{{ trans('app.Action')}}</b></div>
									</div>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<p class="col-md-7 col-sm-12 col-xs-12 listdata" ></p>
									</div>
									@if(!empty($tbl_holidays))
										@foreach($tbl_holidays as $tbl_holidayss)
										<div class="col-md-12 col-sm-12 data_holiday" style="padding:5px;" id="hours_data">
											<input type="hidden" value="{{$tbl_holidayss->title}}">
											<input type="hidden" value="{{$tbl_holidayss->date}}">
											<input type="hidden" value="{{$tbl_holidayss->description}}">
											<div class="col-md-2 col-sm-3">{{date(getDateFormat(),strtotime($tbl_holidayss->date))}}</div>
											<div class="col-md-2 col-sm-3">{{$tbl_holidayss->title}}</div>
											<div class="col-md-2 col-sm-3">{{$tbl_holidayss->description}}</div>
											<div class="col-md-1 col-sm-3 col-xs-12 delete_holiday" holidayurl="{!! url('/setting/deleteholiday/'.$tbl_holidayss->id) !!}"><i class="fa fa-trash fa-2x"></i></div>
										</div>
										@endforeach
									@endif
									<div class="col-md-12 col-sm-12 col-xs-12">
										<p class="col-md-7 col-sm-12 col-xs-12 listdata"></p>
									</div>
								</div>
							</div>
								<form method="post" action="{{ url('setting/holiday/store') }}" enctype="multipart/form-data" class="form-horizontal upperform">	
								
									<div class="form-group col-md-12 col-sm-12 col-xs-12 {{ $errors->has('adddate') ? ' has-error' : 'Date inst' }}" >
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Date')}} <label class="text-danger">*</label></label>
										<div class="col-md-5 col-sm-5 col-xs-12 input-group date datepicker">
													<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
											<input type="text" name="adddate" class="form-control adddate" placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required>
											@if ($errors->has('adddate'))
											   <span class="help-block">
												   <strong>{{ $errors->first('adddate') }}</strong>
											   </span>
											@endif
										</div>
									</div>
									<div class="form-group col-md-12 col-sm-12 col-xs-12">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Title')}} <label class="text-danger">*</label></label>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<input type="text" name="addtitle" class="form-control" placeholder="{{ trans('app.Enter Title') }}" maxlength="30" required />
										</div>
									</div>
									<div class="form-group col-md-12 col-sm-12 col-xs-12">
										<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Country">{{ trans('app.Description')}}</label>
										<div class="col-md-5 col-sm-5 col-xs-12">
											<textarea name="adddescription" class="form-control adddescription" rows="2" maxlength="100" placeholder="{{ trans('app.Enter Holiday Description') }} "></textarea>
										</div>
									</div>
									<input type="hidden" name="_token" value="{{ csrf_token() }}">
									<div class="form-group col-md-12 col-sm-12 col-xs-12">
										<div class="col-md-9 col-sm-9 col-xs-12 text-center">
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


<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- datetimepicker -->
<script>
    
    $('.datepicker').datetimepicker({
        format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });
</script>
<!-- Delete hours-->
<script>
$('body').on('click', '.delete_hours', function() {

	var url =$(this).attr('url');
	  
        swal({   
            title: "Are You Sure?",
			text: "You will not be able to recover this data afterwards!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#297FCA",   
            confirmButtonText: "Yes, delete!",   
            closeOnConfirm: false 
        }, function(){
			window.location.href = url;
             
        });
});
</script>  	
<!-- DELETE holiday -->
<script>
$('body').on('click', '.delete_holiday', function() {
  
	var url =$(this).attr('holidayurl');
	
        swal({   
            title: "Are You Sure?",
			text: "You will not be able to recover this data afterwards!",   
            type: "warning",   
            showCancelButton: true,   
            confirmButtonColor: "#297FCA",   
            confirmButtonText: "Yes, delete!",   
            closeOnConfirm: false 
        }, function(){
			window.location.href = url;
             
        });
});
</script>
@endsection