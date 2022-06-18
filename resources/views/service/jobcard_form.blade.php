@extends('layouts.app')
@section('content')
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<style>
.jobcardmargintop{margin-top:9px;}
.table>tbody>tr>td{padding:10px;vertical-align: unset!important;}
.jobcard_heading{margin-left: 19px;margin-bottom: 15px}
label{margin-bottom:0px;}
.checkbox_padding{margin:10px 0px;}
.first_observation{margin-left:23px;}
.height{height:28px;}
.all{width:226px;}
.step{color:#5A738E !important;}

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
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.JobCard')}}</span></a>
					</div>
					@include('dashboard.profile')
				</nav>
			</div>
        </div>
		@if(session('message'))
		<div class="row massage">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="checkbox checkbox-success checkbox-circle">

                  <label for="checkbox-10 colo_success">  {{session('message')}} </label>
                </div>
			</div>
		</div>
		@endif
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_content">
                    <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
						<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('/jobcard/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.List Of Job Cards')}}</span></a></li>

						<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add JobCard')}}</b></span></a></li>
					</ul>
				</div>
				<div class="row">
					<div class="col-md-12 col-sm-12 col-xs-12">
						<div class="x_panel">
							<div class="well well-sm titleup">{{ trans('app.Step - 2 : Add Jobcard Details...')}}</div><hr>
							<form method="post" action="{{ url('/service/add_jobcard') }}">
								<input type="hidden" class="service_id" name="service_id" value="{{ $service_data->id }}"/>

								<div class="col-md-12 col-xs-12 col-xs-12">
									<div class="col-md-7 col-xs-12 col-sm-12">
										<div class="col-md-12 col-sm-12 col-xs-12" colspan="2" valign="top">
											<h3><?php echo $logo->system_name; ?></h3></td>
										</div>
										<div class="col-md-12 col-xs-12 col-sm-12 ">
											<div class="col-md-5 col-xs-12 col-sm-12 printimg">
												<img src="{{ url('/public/general_setting/'.$logo->logo_image) }}" width="200" height="70px" style="max-height: 80px;">
											</div>
											<div class="col-md-7 col-sm-12 col-xs-12 garrageadd" valign="top">
												<?php
												echo $logo->address;
												echo ", ".getStateName($logo->state_id);
												echo ", ".getCountryName($logo->country_id);
												echo "<br>".$logo->email;
												echo "<br>".$logo->phone_number;
												?>
											</div>
										</div>
									</div>
									<div class="col-md-5 col-xs-12 col-sm-12">
										<div class="col-md-12 col-xs-12 col-sm-12">
											<label class="control-label jobcardmargintop col-md-4 col-sm-12 col-xs-12">{{ trans('app.Job Card No')}} : <label class="text-danger">*</label></label>
											<div class="col-md-8 col-sm-12 col-xs-12">
												<input type="text" id="job_no" name="job_no" value="{{ $service_data->job_no }}" class="form-control">
											</div>
										</div>
										<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
											<label class="control-label jobcardmargintop col-md-4 col-sm-12 col-xs-12">{{ trans('app.In Date/Time')}} : <label class="text-danger">*</label></label>
											<div class="col-md-8 col-sm-12 col-xs-12 input-group date">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
												<input  type="text" id="in_date" name="in_date" value="<?php  echo date(getDateFormat().' H:i:s',strtotime($service_data->service_date));?>" class="form-control" placeholder="<?php echo getDateFormat();  echo " hh:mm:ss"?>" readonly>
											</div>
										</div>
										<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
											<label class="control-label jobcardmargintop col-md-4 col-sm-4 col-xs-12">{{ trans('app.Expected Out Date/Time')}} : <label class="text-danger">*</label> </label>
											<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker">
												<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
												<input type="text" id="out_date" name="out_date" class="form-control" placeholder="<?php echo getDatepicker();  echo " hh:mm:ss"?>" onkeypress="return false;" required/>

											</div>
										</div>
									</div>
								</div>
								<div class="col-md-12 col-xs-12 col-sm-12 space1">
									<p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
								</div>
								<div class="col-md-12 col-xs-12 col-xs-12">
									<div class="col-md-4 col-xs-12 col-sm-12">
										<h2 class="text-left jobcard_heading">{{ trans('app.Customer Details')}}</h2>
										<p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
										<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
											<label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12">{{ trans('app.Name')}}:</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="hidden" name="cust_id" value="{{ $service_data->customer_id }}" >
												<input type="text" id="name" name="name" value="{{ getCustomerName($service_data->customer_id) }}" class="form-control">
											</div>
										</div>
										<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
											<label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12">{{ trans('app.Address')}}: </label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" id="address" value="{{ getCustomerAddress($service_data->customer_id) }}" name="address" class="form-control">
											</div>
										</div>
										<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
											<label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Contact No')}}:</label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" id="con_no" name="con_no" value="{{ getCustomerMobile($service_data->customer_id) }}" class="form-control">
											</div>
										</div>
										<div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
											<label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12"> {{ trans('app.Email')}}: </label>
											<div class="col-md-8 col-sm-8 col-xs-12">
												<input type="text" id="email" name="email" value="{{ getCustomerEmail($service_data->customer_id) }}" class="form-control">
											</div>
										</div>
									</div>

									<div class="col-md-8 col-sm-12 col-xs-12 vehicle_space">
										<h2 class="text-left jobcard_heading">{{ trans('app.Vehicle Details')}}</h2>
										<p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
										<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
											<label class="jobcardmargintop col-md-2 col-sm-2 col-xs-12">{{ trans('app.Model Name')}}:</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="hidden" name="vehi_id" value="{{ $vehical->id }}">
												<input type="text" id="model" name="model" class="form-control" value="{{ $vehical->modelname }}">
											</div>

											<label class="jobcardmargintop col-md-2 col-sm-2 col-xs-12">{{ trans('app.Chasis No')}}:</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" id="chassis" name="chassis" class="form-control" value="{{ $vehical->chassisno }}">
											</div>
										</div>

										<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
											<label class="jobcardmargintop control-label col-md-2 col-sm-2 col-xs-12">{{ trans('app.Engine No')}}:</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" id="engine_no" name="engine_no" class="form-control" value="{{ $vehical->engineno }}" />
											</div>

											<label class="jobcardmargintop control-label col-md-2 col-sm-2 col-xs-12">{{ trans('app.KMS Run')}}:<label class="text-danger">*</label></label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="number" min='0' id="kms" name="kms" value="<?php if(!empty($job)){
												echo"$job->kms_run"; } ?>" maxlength="10" class="form-control" required>
											</div>
										</div>

   <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:10px;">
                        <label class="jobcardmargintop control-label col-md-2 col-sm-2 col-xs-12">{{ trans('Repair Suggestion')}}:<label class="text-danger">*</label></label> </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                              <textarea class="form-control" name="customer_sug" id="customer_sug" maxlength="99999" required value="<?php if(!empty($job)){
												echo"$job->customer_sug"; } ?>"></textarea></textarea>
                        </div>
                        <label class="jobcardmargintop col-md-2 col-sm-2 col-xs-12">{{ trans('Customer Complaint')}}:
                        <label class="text-danger">*</label></label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                           <textarea class="form-control" name="customer_comp" id="customer_comp" maxlength="99999" value="<?php if(!empty($job)){
												echo"$job->customer_comp"; } ?>"></textarea></textarea>
											</div>
                        </div>
                     </div>


										@if(!empty($sale_date))
										<div class="col-md-12 col-sm-12 col-xs-12 divId" id="divId" style="margin-top:5px;" >
											<label class="jobcardmargintop col-md-2 col-sm-2 col-xs-12">{{ trans('app.Date Of Sale')}} :</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
													<input type="text" id="sales_date" name="sales_date" class="form-control" value="{{ date(getDateFormat(),strtotime($sale_date->date)) }}">
											</div>
											<label class="jobcardmargintop col-md-2 col-sm-2 col-xs-12">{{ trans('app.Color')}} :</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<input type="text" id="color" name="color" class="form-control" value="{{ $color->color }}" >
											</div>
										</div>
										@endif
										@if($service_data->service_type == 'free')
										<div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
											<label class="col-md-2 col-sm-2 col-xs-12">{{ trans('app.Free Service Coupan No')}}<label class="text-danger">*</label> :</label>
											<div class="col-md-4 col-sm-4 col-xs-12">
												<select id="coupan_no" name="coupan_no" class="form-control" required>
													<option value=""> {{ trans('app.Select Free Coupan') }} </option>
												@foreach($free_coupan as $coupan)
													<option value="{{ $coupan->job_no }}"> {{ $coupan->job_no }} </option>
												@endforeach
												</select>
											</div>
										</div>
										@endif
									</div>
								</div>


								<div class=" col-md-12 col-xs-12 col-sm-12 ">

								</div>
								<input type="hidden" name="_token" value="{{csrf_token()}}">
								<div class="form-group">
									<div class="col-md-12 col-sm-12 col-xs-12 text-center">
										<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
										<button type="submit" class="btn btn-success ">{{ trans('app.Submit')}}</button>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!---- model in observation Point -->
		<div class="col-md-12">
			<div id="responsive-modal-observation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
								<h4 class="modal-title">{{ trans('app.Observation Point')}}</h4>
						</div>
						<div class="modal-body">
							@foreach($tbl_checkout_categories as $checkoout)
								<div class="panel-group">
									<div class="panel panel-default">
									  <div class="panel-heading">
										<h4 class="panel-title">
										  <a data-toggle="collapse" href="#collapse1-{{ $checkoout->id }}" class="ob_plus{{$checkoout->id }}"><i class="glyphicon glyphicon-plus"></i>{{ $checkoout->checkout_point }}</a>
										</h4>
									  </div>
									  <div id="collapse1-{{ $checkoout->id }}" class="panel-collapse collapse">
										<div class="panel-body">

										<table class="table table-striped">

																	<thead>
																	  <tr>
																		<td><b>#</b></td>
																		<td><b>{{ trans('app.Checkpoints')}}</b></td>
																		<td><b>{{ trans('app.Choose')}}</b></td>
																	  </tr>
																	</thead>
																	<tbody>
																	 <?php

																	$i = 1;
																	$subcategory =getCheckPointSubCategory($checkoout->checkout_point,$checkoout->vehicle_id);
																	  if(!empty($subcategory))
																	  {
																		foreach($subcategory as $subcategorys)
																	  { ?>

																	<tr class="id{{ $subcategorys->checkout_point }}">

																	<td class="col-md-1"><?php echo $i++; ?></td>

																	<td class="row{{ $subcategorys->checkout_point}} col-md-4">

																		<?php echo $subcategorys->checkout_point;
																				//echo $subcategorys->id;
																			 ?>
																			<?php $data = getCheckedStatus($subcategorys->id,getServiceId($service_data->id))?>

																	</td>
																	<td>
																	<input type="checkbox" <?php echo $data;?> name="chek_sub_points" name="check_sub_points[]" check_id="{{ $subcategorys->id }}" class="check_pt" url="{!! url('service/select_checkpt')!!}"  s_id = "{{ getServiceId($service_data->id) }}"
																	>
																	</td>
															  </tr>

															 <?php   }
																	  }
																	?>
																	</tbody>
										</table>

										</div>
									  </div>
									</div>
								</div>
								<script>
									$(document).ready(function(){
										var i = 0;
										$('.ob_plus{{$checkoout->id }}').click(function(){
											i = i+1;
											if(i%2!=0){
												$(this).parent().find(".glyphicon-plus:first").removeClass("glyphicon-plus").addClass("glyphicon-minus");
											}else{
												$(this).parent().find(".glyphicon-minus:first").removeClass("glyphicon-minus").addClass("glyphicon-plus");
											}
										});
									});
									</script>
								@endforeach
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-success col-md-offset-10 check_submit" style="margin-bottom:5px;">{{ trans('app.Submit')}}</button>
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

        <!-- /page content -->
<!-- Display observation points in list -->
<script>
$(document).ready(function(){

	$('.tbl_points, .check_submit').click(function(){

		var url = "<?php echo url('service/get_obs') ?>"
		var service_id = $('.service_id').val();

		$.ajax({
						type: 'GET',
						url: url,
						data : {service_id:service_id},
						success: function (response)
							{

								$('.main_data').html(response.html);
								$('.modal').modal('hide');
							},

					    error: function(e)
							{

								console.log(e);
							}
						});
	});

});

</script>

<!-- Checkpoints in modal -->
<script type="text/javascript">
    $(document).ready(function(){
        $('input.check_pt[type="checkbox"]').click(function(){

            if($(this).prop("checked") == true){
				var value = 1;
                var url = $(this).attr('url');
				var id = $(this).attr('check_id');
				var s_id = $(this).attr('s_id');

				$.ajax({
						type: 'GET',
						url: url,
						data : {value:value,id:id,service_id:s_id},
						success: function (response)
							{

							},

					    error: function(e)
							{
							 alert("An error occurred: " + e.responseText);
								console.log(e);
							}
						});
            }
            else if($(this).prop("checked") == false){
				var value = 0;
                var url = $(this).attr('url');
				var id = $(this).attr('check_id');
				var s_id = $(this).attr('s_id');
				$.ajax({
						type: 'GET',
						url: url,
						data : {value:value,id:id,service_id:s_id},
						success: function (response)
							 {

							},

					    error: function(e)
							{
							 alert("An error occurred: " + e.responseText);
								console.log(e);
							}
						});
            }
        });
    });
</script>

<!--delete in script -->
<script>
 $('.sa-warning').click(function(){

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

	<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
	$(document).ready(function(){
		var i = 0;
		$('.observation_Plus').click(function(){
			i = i+1;
			if(i%2!=0){
				$(this).parent().find(".glyphicon-minus:first").removeClass("glyphicon-minus").addClass("glyphicon-plus");

			}else{
				$(this).parent().find(".glyphicon-plus:first").removeClass("glyphicon-plus").addClass("glyphicon-minus");
			}
		});
	});
</script>
<!-- datetime picker-->
	<script>
		// $('.datepicker').datetimepicker({
			 // format: "<?php echo getDatetimepicker(); ?>",
			 // autoclose:1,
		// });

	$(document).ready(function(){



			var startDate = $('#in_date').val();

			$('.datepicker').datetimepicker({
				format: "<?php echo getDatetimepicker(); ?>",
				autoclose: 1,

			}).datetimepicker('setStartDate', startDate);
		})



	</script>
@endsection
