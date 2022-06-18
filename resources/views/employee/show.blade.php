@extends('layouts.app')
@section('content')
<style>
.right_side .table_row, .member_right .table_row {
    border-bottom: 1px solid #dedede;
    float: left;
    width: 100%;
	padding: 1px 0px 4px 2px;
}
.table_row .table_td {
  padding: 8px 8px !important;
}
.report_title {
    float: left;
    font-size: 20px;
    width: 100%;
}
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Employees',$userid)=='yes')
	
	

    <div class="right_col" role="main">
	<!-- free service  model-->
		<div id="myModal_free_service" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<a href="{!! url('/employee/view/'.$viewid) !!}"><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Free Service Details')}}</h4>
					</div>
					<div class="modal-body">
					</div>
				</div>
			</div>
		</div>
	<!-- Paid service  model-->
		<div id="myModal_paid_service" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<a href="{!! url('/employee/view/'.$viewid) !!}"><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Paid Service Details')}}</h4>
					</div>
					<div class="modal-body">
					</div>
				</div>
			</div>
		</div>
	<!-- Repeat job service  model-->
		<div id="myModal_repeat_service" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<a href="{!! url('/employee/view/'.$viewid) !!}"><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Repeat Job Service Details')}}</h4>
					</div>
					<div class="modal-body">
					</div>
				</div>
			</div>
		</div>
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
		@if(session('message'))
		<div class="row massage">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="checkbox checkbox-success checkbox-circle">
					<input id="checkbox-10" type="checkbox" checked="">
					<label for="checkbox-10 colo_success">  {{session('message')}} </label>
				</div>
			</div>
		</div>
		@endif
		<div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_content">
					<ul class="nav nav-tabs bar_tabs" role="tablist">
						<li role="presentation" class=""><a href="{!! url('/employee/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Employee List')}}</a></li>
						<li role="presentation" class="active"><a href="{!! url('/employee/view/'.$viewid)!!}"><span class="visible-xs"></span> <i class="fa fa-user">&nbsp; </i><b>{{ trans('app.View Employee')}}</b></a></li>
					</ul>
				</div>
				<div class="row">
					<div class="col-md-8 col-sm-12 col-xs-12 main_left">
						<div class="x_panel">
							<div class="col-md-6 col-sm-12 col-xs-12 left_side">
								<img src="{{ URL::asset('public/employee/'.$user->image) }}" class="cimg">
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12 right_side">
								<div class="table_row">
									<div class="col-md-5 col-sm-12 col-xs-12 table_td">
										<i class="fa fa-user"></i> 
											<b>{{ trans('app.Name')}}</b>	
									</div>
									<div class="col-md-7 col-sm-12 col-xs-12 table_td">
										<span class="txt_color">
										{{ $user->name.' '.$user->lastname }}
										</span>
									</div>
								</div>
								<div class="table_row">
									<div class="col-md-5 col-sm-12 col-xs-12 table_td">
										<i class="fa fa-envelope"></i> 
										<b>{{ trans('app.Email')}}</b> 	
									</div>
									<div class="col-md-7 col-sm-12 col-xs-12 table_td">
										<span class="txt_color">{{ $user->email }}</span>
									</div>
								</div>
								<div class="table_row">
									<div class="col-md-5 col-sm-12 col-xs-12 table_td"><i class="fa fa-phone"></i> <b>{{ trans('app.Mobile No')}}</b>
									</div>
									<div class="col-md-7 col-sm-12 col-xs-12 table_td">
										<span class="txt_color">
											<span class="txt_color">{{ $user->mobile_no }} </span>
										</span>
									</div>
								</div>
								<div class="table_row">
									<div class="col-md-5 col-sm-12 col-xs-12 table_td">
										<i class="fa fa-calendar"></i><b> {{ trans('app.Date Of Birth')}}</b>	
									</div>
									<div class="col-md-7 col-sm-12 col-xs-12 table_td">
										<span class="txt_color">{{ date(getDateFormat(),strtotime($user->birth_date)) }}</span>
									</div>
								</div>
								<div class="table_row">
									<div class="col-md-5 col-sm-12 col-xs-12 table_td">
										<i class="fa fa-mars"></i> <b>{{ trans('app.Gender')}} </b>
									</div>
									<div class="col-md-7 col-sm-12 col-xs-12 table_td">
										<span class="txt_color">
										@if($user->gender =='1')
										  <?php echo"male ";?>
										  @else
											<?php echo"female";?>
										@endif
										 </span>
									</div>
								</div>
								<div class="table_row">
									<div class="col-md-5 col-sm-12 col-xs-12 table_td">
										<i class="fa fa-map-marker"></i> <b>{{ trans('app.Address')}}</b>		</div>
									<div class="col-md-7 col-sm-12 col-xs-12 table_td">
										<span class="txt_color">
										  {{ $user->address }},<br/>{{ getCityName($user->city_id) }},<br/>{{ getStateName($user->state_id)}},{{ getCountryName($user->country_id)}}.
										</span>
									</div>
								</div>
							</div>
                        </div>
					</div>
					<div class="col-md-4 col-sm-12 col-xs-12 morinfo">
                        <div class="x_panel">
                            <div class="col-md-12 col-sm-12 col-xs-12 right_side">
								<span class="report_title">
									<span class="fa-stack cutomcircle">
										<i class="fa fa-align-left fa-stack-1x"></i>
									</span> 
									<span class="shiptitle">{{ trans('app.More Info')}}</span>		
								</span>
						 
							@if(!empty($tbl_custom_fields))		
								@foreach($tbl_custom_fields as $tbl_custom_field)	
									<?php 
									$tbl_custom=$tbl_custom_field->id;
									$userid=$user->id;
								
									$datavalue=getCustomData($tbl_custom,$userid);
									?>
									<div class="table_row">
										<div class="col-md-6 col-sm-12 col-xs-12 table_td">
											<b>{{$tbl_custom_field->label}}</b>
										</div>
										<div class="col-md-6 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">{{$datavalue}}</span>
										</div>
									</div>					
								@endforeach
							@endif
							</div>
						</div>
					</div>
				</div>
            </div>
        </div>
		<div class="row">
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>{{ trans('app.Free Service Details')}} </h2>
                    <ul class="nav navbar-right panel_toolbox">
						<li class="dropdown">
							<form method="get" action="/garage/jobcard/list">
						
								<input type="hidden" name="free"  value="<?php  echo'free';?>"/>
								<button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
							</form>
						</li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  
				  @if(!empty($emp_free_service))
				  @foreach($emp_free_service as $services)
					<div class="x_content">
				 
				    <?php
                        $date=$services->service_date;
						$month=date("M", strtotime($date));
						$day=date("d", strtotime($date));
						
					?>

                    <article class="media event">
						<a class="pull-left date">
							<p class="month"><?php echo $month; ?></p>
							<p class="day"><?php echo $day; ?></p>
						</a>
						<?php $view_data = getInvoiceStatus($services->job_no); ?>
							@if($view_data == "Yes")
								<a href="" data-toggle="modal" emp_free="{{$services->id }}"  url="{!! url('/employee/free_service') !!}"  data-target="#myModal_free_service" print="20" class="emp_freeservice">
							@else
									<a href="{!! url('/jobcard/list/'.$services->id) !!}">
							@endif
						<div class="media-body">
							<?php $dateservicefree = date("Y-m-d", strtotime($services->service_date)); ?>
							<span class="jobdetails">{{ $services->job_no }} | {{ date(getDateFormat(),strtotime($dateservicefree)) }}</span></br> 
							<span> {{ getCustomerName($services->customer_id)}} | {{ getRegistrationNo($services->vehicle_id) }} | {{ getVehicleName($services->vehicle_id) }}</span>
						</div>
						@if($view_data == "Yes")
							 <i class="fa fa-eye eye" style="color:#5FCE9B;" aria-hidden="true"></i></a>		  
						@else
							 <i class="fa fa-eye eye" style="color:#f0ad4e;" aria-hidden="true"></i></a>
						@endif
                    </article>
					</div>
				  @endforeach
				  @endif
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
						<h2>{{ trans('app.Paid Service Details')}} </h2>
						<ul class="nav navbar-right panel_toolbox">
							<li class="dropdown">
								<form method="get" action="/garage/jobcard/list">
									<input type="hidden" name="paid"  value="<?php  echo'paid';?>"/>
									<button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
								</form>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
					@if(!empty($emp_paid_service))
					@foreach($emp_paid_service as $emp_paid)
						<div class="x_content">
						<?php
							$date=$emp_paid->service_date;
							$month=date("M", strtotime($date));
							$day=date("d", strtotime($date));
						?>
						<article class="media event">
							<a class="pull-left date">
								<p class="month"><?php echo $month; ?></p>
								<p class="day"><?php echo $day; ?></p>
							</a>
							 <?php   $view_data = getInvoiceStatus($emp_paid->job_no); ?>
								@if($view_data == "Yes")
									<a href="" data-toggle="modal" emp_paid="{{$emp_paid->id }}"  url="{!! url('/employee/paid_service') !!}"  data-target="#myModal_paid_service" print="20" class="emp_paidservice">
								@else
									<a href="{!! url('/jobcard/list/'.$emp_paid->id) !!}">
								@endif
						
							<div class="media-body">
								<?php $dateservicepaid = date("Y-m-d", strtotime($emp_paid->service_date)); ?>
								<span class="jobdetails">{{ $emp_paid->job_no }} | {{  date(getDateFormat(),strtotime($dateservicepaid)) }} </span></br> 
								<span> {{ getCustomerName($emp_paid->customer_id)}} | {{ getRegistrationNo($emp_paid->vehicle_id) }} | {{ getVehicleName($emp_paid->vehicle_id) }}</span>
							</div>
							@if($view_data == "Yes")
								<i class="fa fa-eye eye" style="color:#5FCE9B;" aria-hidden="true"></i></a>		  
							@else
								<i class="fa fa-eye eye" style="color:#f0ad4e;" aria-hidden="true"></i></a>
							@endif
						</article>
						</div>
					@endforeach
					@endif
                </div>
            </div>
            <div class="col-md-4 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_title">
						<h2>{{ trans('app.Repeat Job Service Details')}} </h2>
						<ul class="nav navbar-right panel_toolbox">
							<li class="dropdown">
								<form method="get" action="/garage/jobcard/list">
							
									<input type="hidden" name="repeatjob"  value="<?php  echo'repeat job';?>"/>
									<button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
								</form>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
				@if(!empty($emp_repeatjob))
				@foreach($emp_repeatjob as $repeatjobs)
					<div class="x_content">
						<?php
							$date=$repeatjobs->service_date;
							$month=date("M", strtotime($date));
							$day=date("d", strtotime($date));
							
						?>
						<article class="media event">
							<a class="pull-left date">
								<p class="month"><?php echo $month; ?></p>
								<p class="day"><?php echo $day; ?></p>
							</a>
							<?php $view_data = getInvoiceStatus($repeatjobs->job_no); ?>
							@if($view_data == "Yes")
								<a href="" data-toggle="modal" emp_repeat="{{$repeatjobs->id }}"  url="{!! url('/employee/repeat_service') !!}"  data-target="#myModal_repeat_service" print="20" class="emp_repeatjob">
							@else
								<a href="{!! url('/jobcard/list/'.$repeatjobs->id) !!}">
							@endif
							<div class="media-body">
							    <?php $dateservicerepeat = date("Y-m-d", strtotime($repeatjobs->service_date)); ?>
								<span class="jobdetails">{{ $repeatjobs->job_no }} | {{  date(getDateFormat(),strtotime($dateservicerepeat)) }} </span></br> 
								<span> {{ getCustomerName($repeatjobs->customer_id)}} | {{ getRegistrationNo($repeatjobs->vehicle_id) }} | {{ getVehicleName($repeatjobs->vehicle_id) }}</span>
							</div>
							@if($view_data == "Yes")
								<i class="fa fa-eye eye" style="color:#5FCE9B;" aria-hidden="true"></i></a>		  
							@else
								<i class="fa fa-eye eye" style="color:#f0ad4e;" aria-hidden="true"></i></a>
							@endif
						</article>
					</div>
				@endforeach
				@endif
                </div>
			</div>
        </div>
    </div>
	
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
 <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
 <!-- Free Service only -->
  <script type="text/javascript">
  
$(document).ready(function(){
   
    $(".emp_freeservice").click(function(){ 
	  
	  $('.modal-body').html("");
	   
       var emp_free = $(this).attr("emp_free");
	  
		var url = $(this).attr('url');
	      
       $.ajax({
       type: 'GET',
       url: url,
	
       data : {emp_free:emp_free},
       success: function (data)
       {            

			  $('.modal-body').html(data.html);
				
   },
   beforeSend:function(){
						$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
					},
error: function(e) {
       alert("An error occurred: " + e.responseText);
       console.log(e);	
}
   });
       });
   });
</script>     
	

<!-- Paid Service only -->
  <script type="text/javascript">
  
$(document).ready(function(){
   
    $(".emp_paidservice").click(function(){ 
	  
	  $('.modal-body').html("");
	   
       var emp_paid = $(this).attr("emp_paid");
	  
		var url = $(this).attr('url');
	      
       $.ajax({
       type: 'GET',
       url: url,
	
       data : {emp_paid:emp_paid},
       success: function (data)
       {            

			  $('.modal-body').html(data.html);
				
   },
   beforeSend:function(){
						$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
					},
error: function(e) {
       alert("An error occurred: " + e.responseText);
       console.log(e);	
}
   });
       });
   });
</script>
  
<!-- Repeat job Service only -->
  <script type="text/javascript">
  
$(document).ready(function(){
   
    $(".emp_repeatjob").click(function(){ 
	  
	  $('.modal-body').html("");
	   
       var emp_repeat = $(this).attr("emp_repeat");
	  
		var url = $(this).attr('url');
	      
       $.ajax({
       type: 'GET',
       url: url,
	
       data : {emp_repeat:emp_repeat},
       success: function (data)
       {            

			  $('.modal-body').html(data.html);
				
   },
   beforeSend:function(){
						$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
					},
error: function(e) {
       alert("An error occurred: " + e.responseText);
       console.log(e);	
}
   });
       });
   });
</script>   	
@endsection