@extends('layouts.app')
@section('content')
<style>
.bootstrap-datetimepicker-widget table td span {
    width: 0px!important;
}
.table-condensed>tbody>tr>td {
    padding: 3px;
}
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Services',$userid)=='yes')
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
		<div class="page-title">
			<div class="nav_menu">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Service')}}</span></a>
					</div>
					@include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class=""><a href="{!! url('/service/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Services List')}}</a></li>
				<li role="presentation" class="active"><a href="{!! url('/service/list/edit/'.$service->id )!!}"><span class="visible-xs"></span><i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit Services')}}</b></a></li>
			</ul>
		</div>
            
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form method="post" action="update/{{ $service->id }}" enctype="multipart/form-data"  class="form-horizontal upperform">

							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Jobcard Number')}} <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
									
										<input type="text"  name="jobno"  class="form-control" value="{{ $service->job_no }}" placeholder="{{ trans('app.Enter Job No')}}" readonly>
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Customer Name')}} <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select   name="Customername"  class="form-control" required>
											<option value="">{{ trans('app.Select Select Customer')}}</option>

											@if(!empty($customer))
												@foreach($customer as $customers)
												 <option value="{{ $customers->id}}" <?php if($customers->id==$service->customer_id){echo"selected"; }?>>{{ $customers->name }}</option>
												@endforeach
											@endif
										</select>
									</div>
								</div>
							</div>
						  
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Vehicle Name')}} <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										  <select  name="vehicalname" class="form-control" >
											 <option value="">{{ trans('app.Select vehicle Name')}}</option>
											  @if(!empty($vehical))
													@foreach($vehical as $vehicals)
														<option value="{{ $vehicals->id}}" <?php if($vehicals->id==$service->vehicle_id){ echo"selected"; }?>>{{ $vehicals->modelname }}</option>
													@endforeach
												@endif	
										  </select>
									 </div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Date')}} <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text" id="name" name="date"
										value="<?php  echo date( getDateFormat().' H:i:s',strtotime($service->service_date)); ?>" class="form-control" placeholder="<?php echo getDatepicker();  echo " hh:mm:ss"?>" onkeypress="return false;" required>
									</div>
								</div>
							</div>
						  
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Title')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" name="title" placeholder="{{ trans('app.Enter Title')}}" maxlength="30" value="{{ $service->title }}" class="form-control">
									</div>
								</div>
								
							</div>
						  
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Repair Category')}} <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<select name="repair_cat"  class="form-control" required>
											<option value="">{{ trans('app.-- Select Repair Category--')}}</option>
											<option value="breakdown" <?php if($service->service_category=='breakdown') { echo 'selected'; } ?> >{{ trans('app.Breakdown') }}</option>
											<option value="booked vehicle" <?php if($service->service_category=='booked vehicle') { echo 'selected'; } ?>>{{ trans('app.Booked Vehicle') }}</option>	
											<option value="repeat job" <?php if($service->service_category=='repeat job') { echo 'selected'; } ?>>{{ trans('app.Repeat Job') }}</option>	
											<option value="customer waiting" <?php if($service->service_category=='customer waiting') { echo 'selected'; } ?>>{{ trans('app.Customer Waiting') }}</option>	
										</select>
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12">{{ trans('app.Service Type')}} <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<label class="radio-inline">
											<input type="radio" name="service_type" id="free"  value="free" required <?php if($service->service_type=='free') { echo 'checked'; } ?>>{{ trans('app.Free')}}</label>
										<label class="radio-inline">
											<input type="radio" name="service_type" id="paid"  value="paid" required <?php if($service->service_type=='paid') { echo 'checked'; } ?>> {{ trans('app.Paid')}}</label>
									</div>
								</div>
							</div>
						  
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Details')}} <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<textarea name="details"  class="form-control" maxlength="100" required>{{ $service->detail }}</textarea> 
									</div>
								</div>
								<div id="dvCharge" style="display: none" class="has-feedback {{ $errors->has('charge') ? ' has-error' : '' }}">
									<label class="control-label col-md-2 col-sm-2 col-xs-12 currency" for="last-name">{{ trans('app.Fix Service Charge')}} (<?php echo getCurrencySymbols(); ?>) <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  id="charge_required" name="charge" class="form-control" placeholder="{{ trans('app.Enter Fix Service Charge')}}" maxlength="10" value="{{ $service->charge }}">
										@if ($errors->has('charge'))
										   <span class="help-block">
											   <strong>{{ $errors->first('charge') }}</strong>
										   </span>
										 @endif
									</div>
								</div> 	
							</div>
							
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="reg_no">{{ trans('app.Registration No.')}}</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text" name="reg_no" id="reg_no" placeholder="{{ trans('app.Enter Registration Number') }}" class="form-control" maxlength="15" value="{{ $regi->registration_no }}">
									</div>
								</div>
							</div>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
						 
							<div class="form-group">
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	
<!--Datetime picker -->
	<script>
    $('.datepicker').datetimepicker({
        format: "<?php echo getDatetimepicker(); ?>",
		autoclose:1,
    });
	</script>
<!--Service type free and paid -->	
	<script>
    $(function() {
        $("input[name='service_type']").html(function () {
            if ($("#paid").is(":checked")) {
                $("#dvCharge").show();
                $("#charge_required").attr('required', true);
            } else {
                $("#dvCharge").hide();
				$("#charge_required").removeAttr('required', false);
            }
        });
		
		$("input[name='service_type']").click(function () {
            if ($("#paid").is(":checked")) {
                $("#dvCharge").show();
                $("#charge_required").attr('required', true);
            } else {
                $("#dvCharge").hide();
				$("#charge_required").removeAttr('required', false);
            }
        });
    });
</script>

@endsection