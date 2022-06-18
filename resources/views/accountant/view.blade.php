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
    margin-bottom: 10px;
    padding-top: 10px;
    width: 100%;
}
</style>
		<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Accountants',$userid)=='yes')
	
	
    <div class="right_col" role="main" >
		<!-- vehicle model-->
		<div id="myModal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
    <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="myLargeModalLabel" class="modal-title"><?php echo ('Sales'); ?></h4>
					</div>
					<div class="modal-body">
	
					</div>
				</div>
			</div>
		</div>
	<!-- All sales view -->
		<div id="myModal-sales" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
 
    <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="myLargeModalLabel" class="modal-title"><?php echo ('Sales Datails'); ?></h4>
					</div>
					<div class="modal-body">
	                   
					</div>
				</div>
			</div>
		</div>
		<!--  Completed service view -->
		<div id="myModal-service" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
 
    <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="myLargeModalLabel" class="modal-title"><?php echo ('Service'); ?></h4>
					</div>
					<div class="modal-body">
	                   
					</div>
				</div>
			</div>
		</div>
		<!-- All Completed service view -->
		<div id="myModal-completed" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
 
    <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="myLargeModalLabel" class="modal-title"><?php echo ('Completed Service'); ?></h4>
					</div>
					<div class="modal-body">
	                   
					</div>
				</div>
			</div>
		</div>
		 <!-- All upcoming service view -->
		<div id="myModal-upcoming" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
    <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="myLargeModalLabel" class="modal-title"><?php echo ('Upcoming Service'); ?></h4>
					</div>
					<div class="modal-body">
	                   
					</div>
				</div>
			</div>
		</div>
		<!--  upcoming service view -->
		<div id="myModal-up-service" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
 
    <!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 id="myLargeModalLabel" class="modal-title"><?php echo ('Upcoming Service'); ?></h4>
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
						<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Accountant')}}</span></a>
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
					<ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
						<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('/accountant/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp; </i> {{ trans('app.Accountant List') }}</a></li>
					
						<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('/accountant/list/'.$viewid)!!}"><span class="visible-xs"></span><i class="fa fa-user">&nbsp; </i> <b> {{ trans('app.View Accountant') }}</b></a></li>
					</ul>
			    </div>
				<div class="row">
					<div class="col-md-8 col-sm-12 col-xs-12 main_left">
						<div class="x_panel" >
							<section class="content invoice">
							<!-- title row -->
								<div class="col-md-6 col-sm-12 col-xs-12 left_side">
									<img src="{{ URL::asset('public/accountant/'.$accountant->image) }}" class="cimg" >
								</div>
								<div class="col-md-6 col-sm-12 col-xs-12 right_side">
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td">
											<i class="fa fa-user"></i> 
											<b>{{ trans('app.Name')}}</b>	
										</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">
											{{ $accountant->name.' '.$accountant->lastname }}
											</span>
										</div>
									</div>
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td">
											<i class="fa fa-envelope"></i> 
											<b>{{ trans('app.Email')}}</b> 	
										</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">{{ $accountant->email }}</span>
										</div>
									</div>
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td"><i class="fa fa-phone"></i> <b>{{ trans('app.Mobile No')}}</b>
										</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">
												<span class="txt_color">{{ $accountant->mobile_no }} </span>
											</span>
										</div>
									</div>
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td">
											<i class="fa fa-calendar"></i><b> {{ trans('app.Date Of Birth')}}</b>	
										</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">{{ date(getDateFormat(),strtotime($accountant->birth_date)) }}</span>
										</div>
									</div>
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td">
											<i class="fa fa-mars"></i> <b>{{ trans('app.Gender')}} </b>
										</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">
											@if($accountant->gender =='0')
											  <?php echo"male ";?>
											  @else
												<?php echo"female";?>
											@endif
														 </span>
										</div>
									</div>
									<div class="table_row">
										<div class="col-md-5 col-sm-12 col-xs-12 table_td">
											<i class="fa fa-map-marker"></i> <b>{{ trans('app.Address')}}</b>
										</div>
										<div class="col-md-7 col-sm-12 col-xs-12 table_td">
											<span class="txt_color">
											  {{ $accountant->address }},<br/>{{ getCityName($accountant->city_id) }},<br/>{{ getStateName($accountant->state_id)}},{{ getCountryName($accountant->country_id)}}.
											</span>
										</div>
									</div>
								</div>
                        </div>
					</div>
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
 <!-- sales in only person -->
    
@endsection