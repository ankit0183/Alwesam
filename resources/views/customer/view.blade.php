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
@if (getAccessStatusUser('Customers',$userid)=='yes')
    <div class="right_col" role="main" >
		<!-- free service  model-->
		<div id="myModal-free-open" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<a href="{!! url('/customer/list/'.$viewid)!!}"><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title"> {{ trans('app.Free Service Details')}}</h4>
					</div>
					<div class="modal-body">

					</div>
				</div>
			</div>
		</div>
	<!-- Paid Service view -->
		<div id="myModal-paid-service" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<a href="{!! url('/customer/list/'.$viewid)!!}"><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Paid Service Details')}}</h4>
					</div>
					<div class="modal-body">

					</div>
				</div>
			</div>
		</div>
	<!--  Repeat job service view -->
		<div id="myModal-repeatjob" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">

			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<a href="{!! url('/customer/list/'.$viewid)!!}"><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Repeat Job Service Details')}}</h4>
					</div>
					<div class="modal-body">

					</div>
				</div>
			</div>
		</div>
		<!--  Free service customer view -->
		<div id="myModal-customer-modal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">
				<!-- Modal content-->
				<div class="modal-content">

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
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Customer')}}</span></a>
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
        <div class="row" >
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_content">
					<ul class="nav nav-tabs bar_tabs" role="tablist">
						<li role="presentation" class=""><a href="{!! url('/customer/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp; </i> {{ trans('app.Customer List') }}</a></li>
						<li role="presentation" class="active"><a href="{!! url('/customer/list/'.$viewid)!!}"><span class="visible-xs"></span><i class="fa fa-user">&nbsp; </i><b>{{ trans('app.View Customer') }}</b></a></li>
					</ul>
				</div>
				<div class="row">
					<div class="col-md-8 col-sm-12 col-xs-12 main_left">
						<div class="x_panel">
							<section class="content invoice">
								  <!-- title row -->
								<div class="col-md-6 col-sm-12 col-xs-12 left_side">
									<img src="{{ URL::asset('public/customer/'.$customer->image) }}" class="cimg" >

								</div>
								<div class="col-md-6 col-sm-12 col-xs-12 right_side">
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td">
											<i class="fa fa-user"></i>
											<b>{{ trans('app.Name')}}</b>
										</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">
											{{ $customer->name.' '.$customer->lastname }}
											</span>
										</div>
									</div>
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td">
											<i class="fa fa-envelope"></i>
											<b>{{ trans('app.Email')}}</b>
										</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">{{ $customer->email }}</span>
										</div>
									</div>
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td"><i class="fa fa-phone"></i> <b>{{ trans('app.Mobile No')}}</b> </div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">
												<span class="txt_color">{{ $customer->mobile_no }} </span>
											</span>
										</div>
									</div>
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td">
											<i class="fa fa-calendar"></i><b> {{ trans('app.Date Of Birth')}}</b>
										</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">
											@if($customer->birth_date)
												{{ date(getDateFormat(),strtotime($customer->birth_date)) }}
											@endif
											</span>
										</div>
									</div>
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td">
											<i class="fa fa-mars"></i> <b>{{ trans('app.Gender')}} </b>
										</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">
											@if($customer->gender =='0')
											  <?php echo"male ";?>
											  @else
												<?php echo"female";?>
											@endif
														 </span>
										</div>
									</div>
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td">
											<i class="fa fa-map-marker"></i> <b>{{ trans('app.Emirates')}}</b>		</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">
											  {{ $customer->address }},<br/>{{ getCityName($customer->city_id) }},<br/>{{ getStateName($customer->state_id)}},{{ getCountryName($customer->country_id)}}.
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
									$userid=$customer->id;

									$datavalue=getCustomData($tbl_custom,$userid);
									?>
									<div class="table_row">
										<div class="col-md-6 col-sm-12 table_td">
											<b>{{$tbl_custom_field->label}}</b>
										</div>
										<div class="col-md-6 col-sm-12 table_td">
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

                    <h2>{{ trans('app.Free Service Details')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">

                      <li>
					   <form method="get" action="/garage/jobcard/list">

						 <input type="hidden" name="free"  value="<?php  echo'free';?>"/>
					  <button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
					  </form>
                      </li>

                    </ul>
                    <div class="clearfix"></div>
                  </div>
				   @if(!empty($freeservice))
				   @foreach($freeservice as $saless)
                  <div class="x_content">

				    <?php
                        $date=$saless->service_date;
						$month=date("M", strtotime($date));
						$day=date("d", strtotime($date));

					?>

                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month"><?php echo $month; ?></p>
                        <p class="day"><?php echo $day; ?></p>
                      </a>
					  <?php $view_data = getInvoiceStatus($saless->job_no); ?>
							@if($view_data == "Yes")
								<a href="" data-toggle="modal" f_serviceid="{{$saless->id }}"  url="{!! url('/customer/free-open') !!}"  data-target="#myModal-free-open" print="20" class="freeserviceopen">
							@else
								@if(!empty(getCustomersactive($userid)=='yes'))
									<a href="" data-toggle="modal" open_customer_id="{{$saless->id }}"  url="{!! url('/service/list/view') !!}"  data-target="#myModal-customer-modal" print="20" class="customeropenmodel">
								@else
									<a href="{!! url('/jobcard/list/'.$saless->id) !!}">
								@endif
							@endif
                      <div class="media-body">
						<?php $dateservicefree = date("Y-m-d", strtotime($saless->service_date)); ?>
                        <span class="jobdetails">{{ $saless->job_no }} | {{ date(getDateFormat(),strtotime($dateservicefree)) }}</span></br>
                        <span> {{ getCustomerName($saless->customer_id)}} | {{ getRegistrationNo($saless->vehicle_id) }} |
						{{ getVehicleName($saless->vehicle_id) }}</span>
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

                    <h2>{{ trans('app.Paid Service Details')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">

                      <li>
					  <form method="get" action="/garage/jobcard/list">

						 <input type="hidden" name="paid"  value="<?php  echo'paid';?>"/>

					  <button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
					  </form>
                      </li>

                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  @if(!empty($paidservice))
				   @foreach($paidservice as $saless)
                  <div class="x_content">

				    <?php
                        $date=$saless->service_date;
						$month=date("M", strtotime($date));
						$day=date("d", strtotime($date));

					?>

                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month"><?php echo $month; ?></p>
                        <p class="day"><?php echo $day; ?></p>
                      </a>
					  <?php   $view_data = getInvoiceStatus($saless->job_no); ?>
					   @if($view_data == "Yes")
						<a href="" data-toggle="modal" p_serviceid="{{$saless->id }}"  url="{!! url('/customer/paid-open') !!}"  data-target="#myModal-paid-service" print="20" class="paidservice">
						@else
							@if(!empty(getCustomersactive($userid)=='yes'))
								<a href="" data-toggle="modal" open_customer_id="{{$saless->id }}"  url="{!! url('/service/list/view') !!}"  data-target="#myModal-customer-modal" print="20" class="customeropenmodel">
							@else
								<a href="{!! url('/jobcard/list/'.$saless->id) !!}">
							@endif
						@endif
                      <div class="media-body">
						<?php $dateservicepaid = date("Y-m-d", strtotime($saless->service_date)); ?>
                        <span class="jobdetails">{{ $saless->job_no }} | {{ date(getDateFormat(),strtotime($dateservicepaid)) }} </span></br>
                        <span> {{ getCustomerName($saless->customer_id)}} | {{ getRegistrationNo($saless->vehicle_id) }} |
						{{ getVehicleName($saless->vehicle_id) }}</span>
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

                    <h2>{{ trans('app.Repeat Job Service Details')}}</h2>
                    <ul class="nav navbar-right panel_toolbox">

                      <li>
					  <form method="get" action="/garage/jobcard/list">

						 <input type="hidden" name="repeatjob"  value="<?php  echo'repeat job';?>"/>
					  <button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
					  </form>
                      </li>

                    </ul>
                    <div class="clearfix"></div>
                  </div>
				  @if(!empty($repeatjob))
				   @foreach($repeatjob as $saless)
                  <div class="x_content">

				    <?php
                        $date=$saless->service_date;
						$month=date("M", strtotime($date));
						$day=date("d", strtotime($date));

					?>

                    <article class="media event">
                      <a class="pull-left date">
                        <p class="month"><?php echo $month; ?></p>
                        <p class="day"><?php echo $day; ?></p>
                      </a>
					  <?php $view_data = getInvoiceStatus($saless->job_no); ?>
							@if($view_data == "Yes")
								 <a href="" data-toggle="modal" r_service="{{$saless->id }}"  url="{!! url('/customer/Repeatjob-modal') !!}"  data-target="#myModal-repeatjob" print="20" class="repeatjobservice">
							@else
								@if(!empty(getCustomersactive($userid)=='yes'))
									<a href="" data-toggle="modal" open_customer_id="{{$saless->id }}"  url="{!! url('/service/list/view') !!}"  data-target="#myModal-customer-modal" print="20" class="customeropenmodel">
								@else
									<a href="{!! url('/jobcard/list/'.$saless->id) !!}">
								@endif
							@endif
                      <div class="media-body">
						<?php $dateservicerepeat = date("Y-m-d", strtotime($saless->service_date)); ?>
                        <span class="jobdetails">{{ $saless->job_no }} | {{ date(getDateFormat(),strtotime($dateservicerepeat)) }} </span></br>
                        <span> {{ getCustomerName($saless->customer_id)}} | {{ getRegistrationNo($saless->vehicle_id) }} |
						{{ getVehicleName($saless->vehicle_id) }}</span>
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
  <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
 <!-- Free Service only -->
  <script type="text/javascript">

$(document).ready(function(){

    $(".freeserviceopen").click(function(){

	  $('.modal-body').html("");

       var f_serviceid = $(this).attr("f_serviceid");

		var url = $(this).attr('url');

       $.ajax({
       type: 'GET',
       url: url,

       data : {f_serviceid:f_serviceid},
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

    $(".paidservice").click(function(){

	  $('.modal-body').html("");

       var p_serviceid = $(this).attr("p_serviceid");

		var url = $(this).attr('url');

       $.ajax({
       type: 'GET',
       url: url,

       data : {p_serviceid:p_serviceid},
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

<!-- Repeat job  Service only -->
  <script type="text/javascript">

$(document).ready(function(){

    $(".repeatjobservice").click(function(){

	  $('.modal-body').html("");

       var r_service = $(this).attr("r_service");

		var url = $(this).attr('url');

       $.ajax({
       type: 'GET',
       url: url,

       data : {r_service:r_service},
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
<!--  Free cusomer model service -->

  <script type="text/javascript">

$(document).ready(function(){

    $(".customeropenmodel").click(function(){

	  $('.modal-body').html("");
	    var open_customer_id= $(this).attr("open_customer_id");
		var url = $(this).attr('url');

       $.ajax({
       type: 'GET',
       url: url,
	   data : {servicesid:open_customer_id},
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
