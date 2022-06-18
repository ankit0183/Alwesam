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
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Job Card',$userid)=='yes')
	@if(getActiveCustomer($userid)=='no')
    <div class="right_col" role="main">
        <div class="">
            <div class="nav_menu">
				<nav>
					<div class="nav toggle titleup">
						<span class="">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
					</div>
				</nav>
			</div>
        </div>
	</div>
    @else	
<?php 
$job_no= (isset($suggestions)) ? $suggestions->job_no : '' ;
$f_name= (isset($user)) ? $user->name : '' ;
$l_name= (isset($user)) ? $user->lastname : '' ;
$email= (isset($user)) ? $user->email : '' ;
$mobile= (isset($user)) ? $user->mobile_no : '' ;
$model_name= (isset($vehicle)) ? $vehicle->modelname : '' ;
$v_type= (isset($vehicle)) ? $vehicle->vehicletype_id : '' ;
$chassis= (isset($vehicle)) ? $vehicle->chassisno : '' ;


?>
	<div class="right_col" role="main">
		<div class="page-title">
			  <div class="nav_menu">
				<nav>
				  <div class="nav toggle">
					<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.JobCard')}}</span></a>
				  </div>
					  @include('dashboard.profile')
				</nav>
			  </div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				
				<li role="presentation" class=""><a href="{!! url('/jobcard/list')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.List Of Job Cards')}}</a></li>
				
				<li role="presentation" class="active"><a href="{!! url('/gatepass/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Gate Pass')}}</b></a></li>
			</ul>
		</div>
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_content">
						<form id="demo-form2" action="{!! url('/jobcard/insert_gatedata')!!}" method="post" 
						enctype="multipart/form-data" data-parsley-validate 
									 class="form-horizontal form-label-left input_mask">
									 
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							
						 <div class="col-md-12 col-sm-12 col-xs-12 space">
						  <h4><b>{{ trans('app.Customer Information')}}</b></h4>
						  <p class="col-md-12 ln_solid"></p>
						  </div>
						  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('jobcard') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="jobcard">{{ trans('app.JobCard No. ') }} <label class="text-danger">*</label> 
							
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" id="jobcard" name="jobcard" value="<?php echo $job_no; ?>" class="form-control"  
							  placeholder="{{ trans('app.Enter Job Card Number')}}"  required  job_url="{!! url('jobcard/gatepass/autofill_data')!!}" readonly />
										  
							</div>
						  </div>


						  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('gatepass_no') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="gatepass_no">{{ trans('app.Gate_no') }} <label class="text-danger">*</label> 
				
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" id="gatepass_no" name="gatepass_no"  class="form-control"  
							  value="{{ $code }}" placeholder="{{ trans('app.Auto Generated Gate Pass Number')}}"  readonly />
				 
							</div>
						  </div>

						   <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('firstname') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="firstname">{{ trans('app.First Name') }} <label class="text-danger">*</label> 
							
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" id="firstname" name="firstname" value="{{$f_name}}" class="form-control"  
							   placeholder="{{ trans('app.Enter First Name')}}"  readonly  />
							  
							</div>
						  </div>
						   
						  
						   <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('lastname') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="lastname">{{ trans('app.Last Name') }} <label class="text-danger">*</label>
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" id="lastname" name="lastname" value="{{$l_name}}" placeholder="{{ trans('app.Enter Last Name')}}" 
										   class="form-control" readonly>
							</div>
						  </div>
						  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('email') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="email">{{ trans('app.Email') }} <label class="text-danger">*</label>
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text"  id="email" name="email" value="{{$email}}" placeholder="{{ trans('app.Enter Email')}}" class="form-control " readonly>
							   
							</div>
						  </div>
						  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('mobile') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="mobile">{{ trans('app.Mobile No') }} <label class="text-danger" >*</label>
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="number"  id="mobile" name="mobile" value="{{$mobile}}" placeholder="{{ trans('app.Enter Mobile No')}}"  class="form-control" readonly >
							  
							</div>
						  </div>
						 
						  <div class="col-md-12 col-sm-12 col-xs-12 space">
						  <h4><b>{{ trans('app.Vehicle Information')}}</b></h4>
						  <p class="col-md-12 ln_solid"></p>
						  </div>

						  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('model_name') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="model_name">{{ trans('app.Model Name') }} <label class="text-danger" >*</label>
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text"  id="model_name" name="model_name" value="{{$model_name}}" placeholder="{{ trans('app.Enter Model Name')}}" class="form-control" readonly >
							  
							</div>
						  </div>

						  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('veh_type') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="veh_type">{{ trans('app.Vehicle Type') }} <label class="text-danger" >*</label>
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text"  id="veh_type" name="veh_type" value="{{getVehicleType($v_type)}}"placeholder="{{ trans('app.Enter Vehicle Type')}}" class="form-control" readonly >
										  
							</div>
						  </div>
						  
						  <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('chassis') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="chassis">{{ trans('app.Chassis') }} <label class="text-danger" >*</label>
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" id="chassis" name="chassis" value="{{$chassis}}" placeholder="{{ trans('app.Enter Chassis No.')}}"  class="form-control" readonly >
							  
							</div>
						  </div>

							<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback {{ $errors->has('kms') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12" for="kms">{{ trans('app.KMs.Run') }} <label class="text-danger" >*</label>
							</label>
							<div class="col-md-9 col-sm-9 col-xs-12">
							  <input type="text" id="kms" name="kms" placeholder="{{ trans('app.Enter Kms. Run')}}" maxlength="20" class="form-control" required >
							 
							</div>
						  </div>

						  <div class="col-md-12 col-sm-12 col-xs-12 space">
						  <h4><b>{{ trans('app.Other Information')}}</b></h4>
						  <p class="col-md-12 ln_solid"></p>
						  </div>

						 
						  <div class="col-md-6 col-sm-6 col-xs-12 form-group  {{ $errors->has('servie_out_date') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-3 col-xs-12 currency" for="servie_out_date">{{ trans('app.Service Out Date') }} <label class="text-danger" >*</label>
							</label>
							<!-- today date in hidden type -->
								<?php  $currendate= date('Y-m-d H:i:s'); ?>
									<input type="hidden"  id="" name="today" placeholder="<?php echo getDateFormat(); echo " hh:mm:ss"; ?>"  class="form-control"  value="{{$currendate}}" >
									
							<div class="col-md-9 col-sm-9 col-xs-12 input-group date datepicker">
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							  <input type="text"  id="servie_out_date" name="servie_out_date" placeholder="<?php echo getDatepicker(); echo " hh:mm:ss";?>" class="form-control" onkeypress="return false;" required >
							 
							</div>
							@if ($errors->has('servie_out_date'))
								   <span class="help-block">
									   <strong style="margin-left: 27%;">{{ $errors->first('servie_out_date') }}</strong>
								   </span>
								 @endif
						  </div>

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
<script src="{{ URL::asset('build/js/jquery.min.js') }}"></script>

<script>
$(function(){
     $('body').on('click','.ui-corner-all',function(){
        
        var job_id = $(this).text();
	
        var url = "{!! url('jobcard/gatepass/autofill_data')!!}";

          $.ajax({
            type: 'GET',
            url: url,
            data : {job_id:job_id},
            success: function (response)
               {  
                var res_job = jQuery.parseJSON(response);
                var d = res_job.service_date;
				 var date = new Date(d);
			     var final_date = date.toString('dd-MM-yyyy');
				
                $('#firstname').attr('value',res_job.name);
                $('#lastname').attr('value',res_job.lastname);
                $('#email').attr('value',res_job.email);
                $('#mobile').attr('value',res_job.mobile_no);
                
                $('#model_name').attr('value',res_job.modelname);
                $('#veh_type').attr('value',res_job.vehical_type);
                $('#chassis').attr('value',res_job.chasicno);
                $('#kms').attr('value',res_job.kms_run);
                $('#ser_date').attr('value',final_date);

              },

              error: function(e) 
              {
               alert("An error occurred: " + e.responseText);
                console.log(e);
              }
            });
      });
  });
  
  $(function() {

    var $sug = <?php if(!empty($search_data)){ echo $search_data;} ?>

    $("#jobcard").autocomplete({

    source:$sug,

    select:function(event, ui)
    {        
    }

    });
  });
</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- datetimepicker -->
	<script>
    
    $('.datepicker').datetimepicker({
         format: "<?php echo getDatetimepicker(); ?>",
		 autoclose:1,
    });
</script>
@endsection