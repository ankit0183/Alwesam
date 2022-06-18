@extends('layouts.app')
@section('content')
<Style>
.cld{
	 border-top: 3px solid #F25656;
}
.rjc{
	border-top: 3px solid #3a87ad;
}
.tmm{
	border-top: 3px solid #f39c12;
}
.mss{
    border-top: 3px solid  #12AFCB;
}
.freebuttom{
	    border-top: 3px solid #996600;
}
.paidbuttom{
	    border-top: 3px solid #f39c12 ;
}
.repeatbuttom{
	    border-top: 3px solid #00a65a ;
}
</style>
<script src="{{ URL::asset('build/js/jscharts.js') }}" defer="defer"></script>
<!-- <script src="{{ URL::asset('build/js/Chart.min.js') }}" defer="defer"></script> -->
	<div class="right_col" role="main">
	<!--  Free service view -->
		<div id="myModal-open-modal" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<a href=""><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Free Service Details')}}</h4>
					</div>
					<div class="modal-body">
					
					</div>
				</div>
			</div>
		</div>
		
	<!--  Paid service view -->
		<div id="myModal-com-service" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">
			<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<a href=""><button type="button" class="close">&times;</button></a>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Paid Service Details')}}</h4>
					</div>
					<div class="modal-body">
	                   
					</div>
				</div>
			</div>
		</div>
	<!--  Repeat Job Service view -->
		<div id="myModal-serviceup" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg modal-xs">
		<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<a href=""><button type="button" class="close">&times;</button></a>
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
        <div class="page-title">
			
			<div class="nav_menu hidden-lg hidden-md" style="background-color: #2a3f54;">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars" style="color:#fff;"></i></a>
							<span class="titleup"> <a href="{!! url('/')!!}"> <img src="{{ URL::asset('public/general_setting/'.getLogoSystem())}}" width="140px" height="45px" style="background-color: #2a3f54;" ></a>
							<!-- ( {{ trans('app.Dashboard')}} ) -->
							</span>
						
					</div>
					
					<ul class="nav navbar-nav navbar-right ulprofile">
						<li class="">
							<a href="javascript:;" class=" dropdown-toggle mobilefocus" data-toggle="dropdown" aria-expanded="false">
							@if(!empty(Auth::user()->id))
								@if(Auth::user()->role=='admin')
									<img src="{{ URL::asset('public/admin/'.Auth::user()->image)}}" alt="admin"  width="40px" height="40px" class="img-circle">
								@endif
								@if(Auth::user()->role=='Customer')
									<img src="{{ URL::asset('public/customer/'.Auth::user()->image)}}" alt="customer" width="40px" height="40px" class="img-circle">
								@endif
							
								@if(Auth::user()->role=='Supplier')
									<img src="{{ URL::asset('public/supplier/'.Auth::user()->image)}}" alt="supplier" width="40px" height="40px" class="img-circle">
								@endif
							
								@if(Auth::user()->role=='employee')
									<img src="{{ URL::asset('public/employee/'.Auth::user()->image)}}" alt="employee" width="40px" height="40px" class="img-circle">
								@endif
								
								@if(Auth::user()->role=='accountant')
									<img src="{{ URL::asset('public/accountant/'.Auth::user()->image)}}" alt="accountant" width="40px" height="40px" class="img-circle">
								@endif
							
								@if(Auth::user()->role=='supportstaff')
									<img src="{{ URL::asset('public/supportstaff/'.Auth::user()->image)}}" alt="supportstaff" width="40px" height="40px" class="img-circle">
								@endif
								
								@if(Auth::user()->role=='')
									<img src="{{ URL::asset('public/customer/'.Auth::user()->image)}}" alt="customer" width="40px" height="40px" class="img-circle">
								@endif
							@endif
							@if(!empty(Auth::user()->id))
								<span style="color:#fff;">{{ Auth::user()->name }}</span>
							@endif
								<span class="fa fa-angle-down" style="color:#fff;"></span>
							</a>
								<ul class="dropdown-menu dropdown-usermenu pull-right">
									<li><a href="{!!url('setting/profile')!!}"> {{ trans('app.Profile')}}</a></li>
								<?php $userid=Auth::User()->id;?>
										 @if (getAccessStatusUser('Settings',$userid)=='yes')
											@if(getActiveAdmin($userid)=='yes')
												<li> <a href="{!! url('setting/general_setting/list') !!}"><span>{{ trans('app.Settings')}}</span></a></li>
											@else
												<li> <a href="{!! url('setting/timezone/list') !!}"><span>{{ trans('app.Settings')}}</span></a></li>
											@endif
										@endif
									<li><a href="#" onclick="event.preventDefault();document.getElementById('logout-dash').submit();"><i class="fa fa-sign-out pull-right"></i> {{ trans('app.Log Out')}}</a></li>
									<form id="logout-dash" action="{{ route('logout') }}" method="POST" style="display: none;">
											@csrf
									</form>
								</ul>
						</li>
					</ul>
				</nav>
			</div>
			<div class="nav_menu hidden-xs hidden-sm">
				<nav>
					<div class="nav toggle">
						<a id="menu_toggle"><i class="fa fa-bars"></i></a>
						<span class="titleup">{{ getNameSystem() }} </span>

					</div>
					
					<ul class="nav navbar-nav navbar-right ulprofile">
						<li class="">
							<a href="javascript:;" class=" dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
							@if(!empty(Auth::user()->id))
								@if(Auth::user()->role=='admin')
									<img src="{{ URL::asset('public/admin/'.Auth::user()->image)}}" alt="admin" width="40px" height="40px" class="img-circle">
								@endif
								@if(Auth::user()->role=='Customer')
									<img src="{{ URL::asset('public/customer/'.Auth::user()->image)}}" alt="customer" width="40px" height="40px" class="img-circle">
								@endif
							
								@if(Auth::user()->role=='Supplier')
									<img src="{{ URL::asset('public/supplier/'.Auth::user()->image)}}" alt="supplier" width="40px" height="40px" class="img-circle">
								@endif
							
								@if(Auth::user()->role=='employee')
									<img src="{{ URL::asset('public/employee/'.Auth::user()->image)}}" alt="employee" width="40px" height="40px" class="img-circle">
								@endif
								
								@if(Auth::user()->role=='accountant')
									<img src="{{ URL::asset('public/accountant/'.Auth::user()->image)}}" alt="accountant" width="40px" height="40px" class="img-circle">
								@endif
							
								@if(Auth::user()->role=='supportstaff')
									<img src="{{ URL::asset('public/supportstaff/'.Auth::user()->image)}}" alt="supportstaff" width="40px" height="40px" class="img-circle">
								@endif
								
								@if(Auth::user()->role=='')
									<img src="{{ URL::asset('public/customer/'.Auth::user()->image)}}" alt="customer" width="40px" height="40px" class="img-circle">
								@endif
							@endif
							@if(!empty(Auth::user()->id))
								{{ Auth::user()->name }}
							@endif
								<span class=" fa fa-angle-down"></span>
							</a>
								<ul class="dropdown-menu dropdown-usermenu pull-right">
									<li><a href="{!!url('setting/profile')!!}"> {{ trans('app.Profile')}}</a></li>
								<?php $userid=Auth::User()->id;?>
										 @if (getAccessStatusUser('Settings',$userid)=='yes')
											@if(getActiveAdmin($userid)=='yes')
												<li> <a href="{!! url('setting/general_setting/list') !!}"><span>{{ trans('app.Settings')}}</span></a></li>
											@else
												<li> <a href="{!! url('setting/timezone/list') !!}"><span>{{ trans('app.Settings')}}</span></a></li>
											@endif
										@endif
									<li><a href="#" onclick="event.preventDefault();document.getElementById('logout-dash1').submit();"><i class="fa fa-sign-out pull-right"></i> {{ trans('app.Log Out')}}</a></li>
									<form id="logout-dash1" action="{{ route('logout') }}" method="POST" style="display: none;">
											@csrf
									</form>
								</ul>
						</li>
					</ul>
				</nav>
			</div>
        </div>
	
	<!-- Active(login) in show admin , supportstaff,accountant -->
	
	<?php $userid=Auth::User()->id;?>
	@if(!empty(getActiveCustomer($userid)=='yes'))		
		<div class="row">	
			
			
			<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
				<a href="customer/list" target="blank">
					<div class="panel info-box panel-white">
						<div class="panel-body staff-member">
						<img src="{{ URL::asset('public/img/dashboard/client.png')}}" class="dashboard_background" alt="">	
							<div class="info-box-stats">
								<p class="counter">
									
								@if(isset($Customer))
									<?php echo $Customer; ?>
								@else
									<?php  echo "0"; ?>
								@endif
														  </p>
									<span class="info-box-title">{{ trans('app.Customers')}}</span>
							</div>
							
							
						</div>
					</div>
					</a>
			</div>
			
			
			
			
			<div class="col-lg-2 col-md-2 col-xs-6 col-sm-3">
				<a  href="service/list" target="blank">
					<div class="panel info-box panel-white">
						<div class="panel-body staff-member">
						<img src="{{ URL::asset('public/img/dashboard/tasks.png')}}" class="dashboard_background" alt="">						<div class="info-box-stats">
								<p class="counter">
								@if($service)
									<?php echo $service; ?>
								@else
									<?php  echo "0"; ?>
								@endif
								</p>
								
								<span class="info-box-title">{{ trans('app.Services')}}</span>
							</div>
							
							
						</div>
					</div>
				</a>
			</div>
		</div>
	@endif
	<!-- end Active(login) in show admin , supportstaff,accountant -->

	
	<!-- Active(login) in show customer , employee -->
	@if(!empty(getActiveCustomer($userid)=='no'))
		<!-- free service -->
		<div class="row">
			<div class="col-md-4 col-xs-12 col-sm-12">
				<div class="x_panel freebuttom">
					<div class="x_title">
						<h2>{{ trans('app.Free Service Details')}}</h2>
						<ul class="nav navbar-right panel_toolbox">
							<li>
								<form method="get" action="jobcard/list">
									<input type="hidden" name="free"  value="<?php  echo'free';?>"/>
										<button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
								</form>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
				  <?php $userid=Auth::User()->id; ?>
				@if(!empty($sale))
				   @foreach($sale as $saless)
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
							  <a href="" data-toggle="modal" open_id="{{$saless->id }}"  url="{!! url('/dashboard/open-modal') !!}"  data-target="#myModal-open-modal" print="20" class="openmodel">
							@else
								@if(!empty(getActiveEmployee($userid)=='yes'))
									<a href="{!! url('/jobcard/list/'.$saless->id) !!}">
								@else
									<a href="" data-toggle="modal" open_customer_id="{{$saless->id }}"  url="{!! url('/service/list/view') !!}"  data-target="#myModal-customer-modal" print="20" class="customeropenmodel">
								@endif
								
							@endif
							  <div class="media-body">
								<?php $dateservicefree = date("Y-m-d", strtotime($saless->service_date)); ?>
								<span class="jobdetails">{{ $saless->job_no }} | {{ date(getDateFormat(),strtotime($dateservicefree)) }} </span></br> 
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
		 <!-- paid service --> 
			<div class="col-md-4 col-xs-12 col-sm-12">
				<div class="x_panel paidbuttom">
					<div class="x_title">
						<h2> {{ trans('app.Paid Service Details')}}</h2>
						<ul class="nav navbar-right panel_toolbox">
					
							<form method="get" action="jobcard/list">
								<input type="hidden" name="paid"  value="<?php  echo'paid';?>"/>
									<button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}	</button>
							</form>
						</ul>
						<div class="clearfix"></div>
					</div>
				   @if(!empty($sale1))
					   @foreach($sale1 as $sale1s)
							<div class="x_content">
							<?php
								$date=$sale1s->service_date;
								$month=date("M", strtotime($date));
								$day=date("d", strtotime($date));
								
							?>
								<article class="media event">
								  <a class="pull-left date">
									<p class="month"><?php echo $month ?></p>
									<p class="day"><?php echo $day; ?></p>
								  </a>
								<?php $view_data = getInvoiceStatus($sale1s->job_no); ?>
								@if($view_data == "Yes")
									<a href="" data-toggle="modal" c_service="{{ $sale1s->id }}"  url="{!! url('/dashboard/view/com-modal') !!}"  data-target="#myModal-com-service" print="20" class="completedservice">
							    @else
									@if(!empty(getActiveEmployee($userid)=='yes'))
										<a href="{!! url('/jobcard/list/'.$sale1s->id) !!}">
									@else
									<a href="" data-toggle="modal" open_customer_id="{{$sale1s->id }}"  url="{!! url('/service/list/view') !!}"  data-target="#myModal-customer-modal" print="20" class="customeropenmodel">
									@endif
								@endif
								  <div class="media-body">
									<?php $dateservicepaid = date("Y-m-d", strtotime($sale1s->service_date)); ?>
									<span class="jobdetails">{{ $sale1s->job_no }} | {{date(getDateFormat(),strtotime($dateservicepaid)) }} </span></br> 
									<span> {{ getCustomerName($sale1s->customer_id)}} | {{ getRegistrationNo($sale1s->vehicle_id) }} |
									{{ getVehicleName($sale1s->vehicle_id) }}</span>
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
		<!-- Repeat job service -->
			<div class="col-md-4 col-xs-12 col-sm-12">
				<div class="x_panel repeatbuttom">
					<div class="x_title">
						<h2>{{ trans('app.Repeat Job Service Details')}}</h2>
						<ul class="nav navbar-right panel_toolbox">
							<form method="get" action="jobcard/list">
								<input type="hidden" name="repeatjob"  value="<?php  echo'repeat job';?>"/>
								<button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
							</form>
						</ul>
						<div class="clearfix"></div>
					</div>
					@if(!empty($sale2))
						@foreach($sale2 as $sale2s)
							<div class="x_content">
							<?php
								$date=$sale2s->service_date;
								$month=date("M", strtotime($date));
								$day=date("d", strtotime($date));
								
							?>
								<article class="media event">
									<a class="pull-left date">
										<p class="month"><?php echo $month ?></p>
										<p class="day"><?php echo $day; ?></p>
									</a>
								<?php $view_data = getInvoiceStatus($sale2s->job_no); ?>
								@if($view_data == "Yes")
									<a href="" data-toggle="modal" u_service="{{ $sale2s->id }}"  url="{!! url('/dashboard/view/up-modal') !!}"  data-target="#myModal-serviceup" print="20" class="service-up">
								@else
									@if(!empty(getActiveEmployee($userid)=='yes'))
										<a href="{!! url('/jobcard/list/'.$sale2s->id) !!}">
									@else
									<a href="" data-toggle="modal" open_customer_id="{{$sale2s->id }}"  url="{!! url('/service/list/view') !!}"  data-target="#myModal-customer-modal" print="20" class="customeropenmodel">
									@endif
								@endif
									<div class="media-body">
										<?php $dateservicerepeat = date("Y-m-d", strtotime($sale2s->service_date)); ?>
										<span class="jobdetails">{{ $sale2s->job_no }} | {{date(getDateFormat(),strtotime($dateservicerepeat)) }} </span></br> 
										
										<span> {{ getCustomerName($sale2s->customer_id)}} | {{ getRegistrationNo($sale2s->vehicle_id) }} |
										{{ getVehicleName($sale2s->vehicle_id) }}</span>
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
		
		<!-- Upcoming service  service -->
		<div class="row">
			<div class="col-md-4 col-xs-12 col-sm-12">
				<div class="x_panel freebuttom">
					<div class="x_title">
						<h2>{{ trans('app.Upcoming Service Details')}}</h2>
						<!-- <ul class="nav navbar-right panel_toolbox">
							<li>
								<form method="get" action="jobcard/list">
									<input type="hidden" name="free"  value="<?php  echo'free';?>"/>
										<button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
								</form>
							</li>
						</ul> -->
						<div class="clearfix"></div>
					</div>
				  <?php $userid=Auth::User()->id; ?>
				@if(!empty($upcomingservice))
				   @foreach($upcomingservice as $upcomingservices)
						<div class="x_content">
							<?php
								$date=$upcomingservices->service_date;
								$month=date("M", strtotime($date));
								$day=date("d", strtotime($date));
								
							?>
							<article class="media event">
							  <a class="pull-left date">
								<p class="month"><?php echo $month; ?></p>
								<p class="day"><?php echo $day; ?></p>
							  </a>
							  <div class="media-body">
								<?php $upcomingservicesdate = date("Y-m-d", strtotime($upcomingservices->service_date)); ?>
								<span class="jobdetails">{{ $upcomingservices->job_no }} | {{ date(getDateFormat(),strtotime($upcomingservicesdate)) }} </span></br> 
								<span> {{ getCustomerName($upcomingservices->customer_id)}} | 
								{{ getVehicleName($upcomingservices->vehicle_id) }}</span>
							  </div>
							 
							</article>
						</div>
				   @endforeach
				@endif
				</div>
			</div>
			<div class="col-md-4 col-xs-12 col-sm-12">
				<div class="x_panel tmm"> 
					<div class="x_title">
						<h2>{{ trans('app.Opening Hours')}}</h2>
						<div class="clearfix"></div>
					</div>
						@if(!empty($openinghours))
						@foreach($openinghours as $openinghourss)
							<div class="bessuhours">	
								<div class="col-md-4 col-sm-12 bessuhoursday">
									<b>{{getDayName($openinghourss->day)}}</b>
								</div>
								<div class="col-md-8 col-sm-12 bessuhoursday">
								@if($openinghourss->from == $openinghourss->to)
									<span class="dayhours">- - - - - - Day off - - - - - - </span>
								@else
									<span>
										<span class="dayhours">{{getOpenHours($openinghourss->from)}}</span>
										<span class="dayhours">To</span>
										<span class="dayhours">{{getCloseHours($openinghourss->to)}}</span>
									</span>
								@endif
								</div>
							</div>
						@endforeach
						@endif
				</div>
			</div>
			<div class="col-md-4 col-xs-12 col-sm-12">
				<div class="x_panel repeatbuttom"> 
						<div class="x_title">
							<h2>{{ trans('app.Holiday List')}}</h2>
							<div class="clearfix"></div>
						</div>
							@if(!empty($holiday))
								@foreach($holiday as $holidays)
									<div class="bessuhours">	
										<div class="col-md-4 col-sm-12 bessuhoursday">
											<b>{{ date(getDateFormat(),strtotime($holidays->date))}}</b>
										</div>
										<div class="col-md-8 col-sm-12 bessuhoursday">
											<span class="dayhours">{{$holidays->title}}</span>
										</div>
									</div>
								@endforeach
							@endif
				</div>	
			</div>
		</div>
		
		<div class="row">
            <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                <div class="x_panel cld">
                  <div class="x_title">
                    <h2>{{ trans('app.Calendar Events')}}</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="calendarevent"></div>

                  </div>
                </div>
			</div>
		</div>
	@endif
<!-- end Active(login) in show customer , employee -->
	
	
<!--- Active(login) in show admin,supportstaff,accountant -->
	<?php $userid=Auth::User()->id;?>
	@if(!empty(getActiveCustomer($userid)=='yes'))
		<div class="row">
            <div class="col-lg-8 col-md-8 col-xs-12 col-sm-12">
                <div class="x_panel cld">
                  <div class="x_title">
                    <h2>{{ trans('app.Calendar Events')}}</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <div id="calendarevent"></div>

                  </div>
                </div>
			</div>
           
            <div class="col-md-4 col-sm-12 col-xs-12">
					<div class="x_panel rjc"> 
						<div class="x_title">
							
		
								<h2>{{ trans('app.Recently Joined customer')}}</h2>
								<ul class="nav navbar-right panel_toolbox">
									<li><a href="{!! url('/customer/list')!!}"><button type="button" class="btn  btn-default">{{ trans('app.View All')}}</button></a>
									</li>
								</ul>
							<div class="clearfix"></div>
						</div>
						
						<ul class="list-unstyled top_profiles scroll-view">
						@foreach($Customere as $user)
						  <li class="media event">
							<a class="userpic">
							 <img src="{{ URL::asset('public/customer/'.$user->image) }}" style="width: 40px; height: 40px;margin-right: 18px;" class="img-circle" > 
							</a>
							<div class="media-body">
							  <a class="title" href="customer/list/{{$user->id}}"><strong>{{ $user->name}}&nbsp;{{ $user->lastname }}</a> </strong>
							  <p> {{ $user->email }} </p>
							  </p>
							</div>
						  </li>
						 @endforeach
						</ul>
					</div>
					<div class="x_panel tmm">
						<div class="col-md-12 col-xs-12 col-sm-12">
						<div class="x_title">
							<h2 style="margin:0">{{ trans('app.Top Mechanics This Month')}}</h2>
							
							<div class="clearfix"></div>
						 </div>
							
							<div id="donutchartperformance" style="margin-top:15px;" dir="<?php if(getValue() =='rtl') {echo 'rtl';} else{echo'ltr';}?>"></div>
						</div> 
					</div>
            </div> 
        </div>
	@endif
		<?php $userid=Auth::User()->id;?>
		@if(!empty(getActiveCustomer($userid)=='yes'))
		<div class="row">
			<div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
				<div class="x_panel mss">
					<div class="x_title">
						<h2 style="width:100%;">{{ trans('app.Monthly Service Summary')}} - {{$nowmonth}}</h2>
						<div class="clearfix"></div>
					</div>
					<div class="x_content">
						<div class="row">
							<div class="col-md-8 col-xs-12 col-sm-12">
								<div id="barchart" dir="<?php if(getValue() =='rtl') {echo 'rtl';} else{echo'ltr';}?>" style="width:100%;padding:0px;margin:0">
								</div>
							</div>
							<div class="col-md-4 col-xs-12 col-sm-12">
								<div class="row" align="center" >
									<div class="col-md-6 col-xs-12 col-sm-12">
										<h4 class="onservicess">{{ trans('app.Ontime Service')}}</h4>
										<div id="donutchartontime"  dir="<?php if(getValue() =='rtl') {echo 'rtl';} else{echo'ltr';}?>" style="padding-bottom:15px;"></div>
									</div>
									<div class="col-md-6 col-xs-12 col-sm-12">
									
										<h4 style="margin:0">{{ trans('app.Top Five Serviced Vehicles')}}</h4>
										<div id="donutchart" dir="<?php if(getValue() =='rtl') {echo 'rtl';} else{echo'ltr';}?>"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	@endif	
	@if(!empty(getActiveCustomer($userid)=='yes'))
	<!-- free service -->
		<div class="row">
			<div class="col-md-4 col-xs-12 col-sm-12">
				<div class="x_panel freebuttom">
					<div class="x_title">
						<h2>{{ trans('app.Free Service Details')}}</h2>
						<ul class="nav navbar-right panel_toolbox">
							<li>
								<form method="get" action="jobcard/list">
									<input type="hidden" name="free"  value="<?php  echo'free';?>"/>
										<button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
								</form>
							</li>
						</ul>
						<div class="clearfix"></div>
					</div>
				  <?php $userid=Auth::User()->id; ?>
				@if(!empty($sale))
				   @foreach($sale as $saless)
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
							  <a href="" data-toggle="modal" open_id="{{$saless->id }}"  url="{!! url('/dashboard/open-modal') !!}"  data-target="#myModal-open-modal" print="20" class="openmodel" >
							@else
								<a href="{!! url('/jobcard/list/'.$saless->id) !!}"   >
							@endif
							  <div class="media-body">
								<?php $dateservicefree = date("Y-m-d", strtotime($saless->service_date)); ?>
								<span class="jobdetails">{{ $saless->job_no }} | {{ date(getDateFormat(),strtotime($dateservicefree)) }} </span></br> 
								<span> {{ getCustomerName($saless->customer_id)}} | {{ getRegistrationNo($saless->vehicle_id )}} |
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
		 <!-- paid service --> 
			<div class="col-md-4 col-xs-12 col-sm-12">
				<div class="x_panel paidbuttom">
					<div class="x_title">
						<h2> {{ trans('app.Paid Service Details')}}</h2>
						<ul class="nav navbar-right panel_toolbox">
					
							<form method="get" action="jobcard/list">
								<input type="hidden" name="paid"  value="<?php  echo'paid';?>"/>
									<button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}	</button>
							</form>
						</ul>
						<div class="clearfix"></div>
					</div>
				   @if(!empty($sale1))
					   @foreach($sale1 as $sale1s)
							<div class="x_content">
							<?php
								$date=$sale1s->service_date;
								$month=date("M", strtotime($date));
								$day=date("d", strtotime($date));
								
							?>
								<article class="media event">
								  <a class="pull-left date">
									<p class="month"><?php echo $month ?></p>
									<p class="day"><?php echo $day; ?></p>
								  </a>
								<?php $view_data = getInvoiceStatus($sale1s->job_no); ?>
								@if($view_data == "Yes")
									<a href="" data-toggle="modal" c_service="{{ $sale1s->id }}"  url="{!! url('/dashboard/view/com-modal') !!}"  data-target="#myModal-com-service" print="20" class="completedservice">
								@else
									<a href="{!! url('/jobcard/list/'.$sale1s->id) !!}">
								@endif
								  <div class="media-body">
									<?php $dateservicepaid = date("Y-m-d", strtotime($sale1s->service_date)); ?>
									
									<span class="jobdetails">{{ $sale1s->job_no }} | {{date(getDateFormat(),strtotime($dateservicepaid)) }} </span></br> 
									<span> {{ getCustomerName($sale1s->customer_id)}} | {{ getRegistrationNo($sale1s->vehicle_id) }} |
									{{ getVehicleName($sale1s->vehicle_id) }}</span>
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
		<!-- Repeat job service -->
			<div class="col-md-4 col-xs-12 col-sm-12">
				<div class="x_panel repeatbuttom">
					<div class="x_title">
						<h2>{{ trans('app.Repeat Job Service Details')}}</h2>
						<ul class="nav navbar-right panel_toolbox">
							<form method="get" action="jobcard/list">
								<input type="hidden" name="repeatjob"  value="<?php  echo'repeat job';?>"/>
								<button type="submit"  class="btn  btn-default1 freeservice">{{ trans('app.View All')}}</button>
							</form>
						</ul>
						<div class="clearfix"></div>
					</div>
					@if(!empty($sale2))
						@foreach($sale2 as $sale2s)
							<div class="x_content">
							<?php
								$date=$sale2s->service_date;
								$month=date("M", strtotime($date));
								$day=date("d", strtotime($date));
								
							?>
								<article class="media event">
									<a class="pull-left date">
										<p class="month"><?php echo $month ?></p>
										<p class="day"><?php echo $day; ?></p>
									</a>
									<?php $view_data = getInvoiceStatus($sale2s->job_no); ?>
									@if($view_data == "Yes")
										<a href="" data-toggle="modal" u_service="{{ $sale2s->id }}"  url="{!! 		url('/dashboard/view/up-modal') !!}"  data-target="#myModal-serviceup" print="20" class="service-up">
									@else
										<a href="{!! url('/jobcard/list/'.$sale2s->id) !!}">
									@endif
									<div class="media-body">
										<?php $dateservicerepeat = date("Y-m-d", strtotime($sale2s->service_date)); ?>
										<span class="jobdetails">{{ $sale2s->job_no }} | {{date(getDateFormat(),strtotime($dateservicerepeat)) }} </span></br> 
										
										<span> {{ getCustomerName($sale2s->customer_id)}} |  {{ getRegistrationNo($sale2s->vehicle_id) }} |
										{{ getVehicleName($sale2s->vehicle_id) }}</span>
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
		@endif
		
	<!---end Active(login) in show admin,supportstaff,accountant-->	
    </div>
	<div id="myModal-job" class="modal fade" role="dialog">
		<div class="modal-dialog modal-lg">
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header"> 
					<a href=""><button type="button" class="close">&times;</button></a>
					<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Invoice')}}</h4>
				</div>
				<div class="modal-body">
				</div>
			</div>
		</div>
	</div>
	

 <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script> 
 <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
 <script type="text/javascript" src="https://www.google.com/jsapi"></script>
 
 <!-- service event in calendarevent -->
 <?php if(!empty($serviceevent))
	{
		foreach($serviceevent as $serviceevents)
		{	
			
			$i=1;
			$n_start_date=date("Y-m-d", strtotime($serviceevents->service_date));
			$n_end_date=date("Y-m-d", strtotime($serviceevents->service_date));
			$sid=$serviceevents->job_no; 
			$userid=Auth::User()->id;
			if(!empty(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes'))
			{
				$view_data = getInvoiceStatus($serviceevents->job_no);
												
				if($view_data == "No")
				{
					$service_data_array[]=array('title'=>$serviceevents->job_no,
					'title1'=>$serviceevents->job_no,
					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),
					'customer'=>getCustomerName($serviceevents->customer_id),
					'vehicle'=>getVehicleName($serviceevents->vehicle_id),
					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),
					'url'=> 'jobcard/list/'.$serviceevents->id,
					'start'=>$n_start_date,
					'end'=>$n_end_date,
					'color'=>'#f0ad4e',
					);
				}
				else
				{
					$service_data_array[]=array('title'=>$serviceevents->job_no,
					'title1'=>$serviceevents->job_no,
					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),
					'customer'=>getCustomerName($serviceevents->customer_id),
					'vehicle'=>getVehicleName($serviceevents->vehicle_id),
					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),
					's_id'=>$serviceevents->id,
					'url1'=> 'dashboard/open-modal',
					'start'=>$n_start_date,
					'end'=>$n_end_date,
					'color'=>'#5FCE9B',
					);
				}
					
			}
			else
			{
				$view_data = getInvoiceStatus($serviceevents->job_no);
				
				if($view_data == "No")
				{
					$service_data_array[]=array('title'=>$serviceevents->job_no,
					'title1'=>$serviceevents->job_no,
					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),
					'customer'=>getCustomerName($serviceevents->customer_id),
					'vehicle'=>getVehicleName($serviceevents->vehicle_id),
					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),
					's_id'=>$serviceevents->id,
					'url11'=>'service/list/view',
					'start'=>$n_start_date,
					
					'end'=>$n_end_date,
					'color'=>'#f0ad4e',
					);
				}
				else
				{
					$service_data_array[]=array('title'=>$serviceevents->job_no,
					'title1'=>$serviceevents->job_no,
					'dates'=>date(getDateFormat(),strtotime($serviceevents->service_date)),
					'customer'=>getCustomerName($serviceevents->customer_id),
					'vehicle'=>getVehicleName($serviceevents->vehicle_id),
					'plateno'=>getRegistrationNo($serviceevents->vehicle_id),
					's_id'=>$serviceevents->id,
					'url1'=> 'dashboard/open-modal',
					'start'=>$n_start_date,
					'end'=>$n_end_date,
					'color'=>'#5FCE9B',
					);
				}
			}
			
		}
	
	} 
	
	//Holiday Event
	if(!empty($holiday))
	{
		foreach($holiday as $holidays)
		{	
			$i=1;
			$n_start_date=date("Y-m-d", strtotime($holidays->date));
			$n_end_date=date("Y-m-d", strtotime($holidays->date));
			$service_data_array[]=array('title'=>substr($holidays->title,0,10),
			'title1'=>$holidays->title,
			'dates'=>date(getDateFormat(),strtotime($holidays->date)),
			'description'=>$holidays->description,
			'customer'=>'Holiday',
			'vehicle'=>"",
			'plateno'=>"",
			'start'=>$n_start_date,
			'end'=>$n_end_date,
			'color'=>'#3a87ad',
			);
		}
	} 
	if(!empty($service_data_array)) {
		$data1 = json_encode($service_data_array);
	}
	else{
		$data1=json_encode('0');
	}
?>
 <!-- Calendar Event in Dashboard---->
 <script>
	$(document).ready(function() {
		$('#calendarevent').fullCalendar({
		height: 620,
		 header: {
		left: 'prev,next today',
		center: 'title',
		right: 'month,agendaWeek,agendaDay'
		},
		defaultDate: new Date(),
			navLinks: true, // can click day/week names to navigate views
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			editable: true,
			toolkip:true,
			events: <?php  if(!empty($data1)){ echo $data1;} ?>,
			eventMouseover: function (data, event, view) {
			   tooltip = '<div class="col-md-12 col-sm-12 col-xs-12 tooltiptopicevent" style="width:auto;height:auto;background:black;color:#fff;position:absolute;z-index:10001;padding:10px 10px 10px 10px ;border-radius:5px;  line-height: 200%;">';
			   // alert(data.vehicle);
				if(data.title1 != '')
					tooltip = tooltip + data.title1 ; 
				if(data.dates != '')
					tooltip = tooltip + ' | ' + data.dates + '</br>' + ' ';  
				if(data.customer != '')
					tooltip = tooltip  + data.customer;
				if(data.plateno != '')
					tooltip = tooltip + ' | ' + data.plateno;
				if(data.vehicle != '')
					tooltip = tooltip + ' | ' + data.vehicle;
			
				tooltip = tooltip + '</div>';
			
            $("body").append(tooltip);
            $(this).mouseover(function (e) {
                $(this).css('z-index', 10000);
                $('.tooltiptopicevent').fadeIn('500');
                $('.tooltiptopicevent').fadeTo('10', 1.9);
            }).mousemove(function (e) {
                $('.tooltiptopicevent').css('top', e.pageY + 10);
                $('.tooltiptopicevent').css('left', e.pageX + 20);
            });
			},
			eventMouseout: function (data, event, view) {
				$(this).css('z-index', 8);
				$('.tooltiptopicevent').remove();
			},
			dayClick: function () {
				tooltip.hide()
			},
			eventResizeStart: function () {
				tooltip.hide()
			},
			eventDragStart: function () {
				tooltip.hide()
			},
			viewDisplay: function () {
				tooltip.hide()
			},
			
			eventClick: function(event) {
				if (event.url) {
					window.location(event.url);
				}
				if (event.url1)
				{
					$('#myModal-job').modal();

					$('.modal-body').html("");
					
					var serviceid = (event.s_id);					
									
											
					var url = (event.url1);
				
					   $.ajax({
					   type: 'GET',
					   url: url,
					
					   data : {open_id:serviceid},
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
				}
				if (event.url11)
				{
					$('#myModal-customer-modal').modal();
					$('.modal-body').html("");
					var servicesid = (event.s_id);
					var url = (event.url11);
					
				   $.ajax({
				   type: 'GET',
				   url: url,
				   data : {servicesid:servicesid},
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
				}
			}
      
		});
	});	
	
	</script>
	
 <!-- Monthly service in barchart---->
 <script type="text/javascript">
 google.load("visualization", "1", {packages:["corechart"]});
 google.setOnLoadCallback(drawChart);
 function drawChart() {
 var data = google.visualization.arrayToDataTable([
          ['Date', 'Service',{ role: 'style' },{ role: 'annotation' }],
		  <?php
		     for($i=1;$i<=sizeof($dates);$i++)
			 {
				$count =  getNumberOfService($i);
				
			 ?>
			 ['<?php echo $i;?>',<?php echo $count;?>,'',''],
			<?php 
			
			 }
		   ?>
 ]);
 var options = {
	legend:'none',
	heigth:150,
	chartArea:{left:40,'width':'90%',top:20,bottom:50,},
	fontSize :10,
	color:'#73879C',
	hAxis: {
			title: 'Dates',
			titleTextStyle: {fontSize:12,color:'#4E5E6A',fontName: 'Roboto'},
						
			},
    vAxis: {
			title: ' Number Of Service',
			titleTextStyle: {fontSize:12,color:'#4E5E6A',fontName: 'Roboto'},
			
			format:'decimal',
			},
 };
 var chart = new google.visualization.ColumnChart(document.getElementById("barchart"));
 chart.draw(data, options);
 }
 </script>
 
 <!-- Ontime   donutchart-->
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Hours', 'No of service'],
          ['24-Hours',<?php if(!empty($one_day)){echo $one_day;}else{echo"0";}?> ],
		
          ['48-Hours',<?php if(!empty($two_day)){echo $two_day;}else{echo"0";}?> ],
          ['48-Hours After',<?php if(!empty($more)){echo $more;}else{echo"0";}?> ],
       
        ]);
        var options = {
			
			fontSize:10,
			fontName:'sans-serif',
			height:150,
		 chartArea:{left:1,right:2,bottom:30,top:30},
		legend: { position: 'right', maxLines: 5,textStyle: {fontSize: 10,color:'#73879C',bold:true}},
		isStacked: 'relative',
		 vAxis: {
            minValue: 0,
            ticks: [0, .3, .6, .9, 1]
          }	
        };
        var chart = new google.visualization.PieChart(document.getElementById('donutchartontime'));
        chart.draw(data, options);
      }
    </script>
<!-- Vehicle  donutchart-->
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Vehicle', 'Number of service'],
		  @foreach ($vehical as $vehicals)
			<?php $v_name = getVehicleName($vehicals->vid);?>
          ['<?php echo $v_name;?>',    <?php echo $vehicals->count;?> ],
         @endforeach
        ]);

        var options = {
			is3D: true, 
			fontSize:10,
			fontName:'sans-serif',
			height:150,
			chartArea:{left:3,right:3,bottom:30,top:10},
			legend: { position: 'right', maxLines: 5,textStyle: {fontSize: 10,color:'#73879C',bold:true}},
			isStacked: 'relative',
			vAxis: {
					minValue: 0,
					ticks: [0, .3, .6, .9, 1]
					}	
			};

        var chart = new google.visualization.PieChart(document.getElementById('donutchart'));
        chart.draw(data, options);
      }
    </script>

<!-- Performance  donutchart-->
    <script type="text/javascript">
      google.charts.load("current", {packages:["corechart"]});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Employee', 'No of service'],
           @foreach ($performance as $performances)
			<?php $assigne=getAssignedName($performances->a_id); ?>
          ['<?php echo $assigne;?>',    <?php echo $performances->count;?> ],
         @endforeach
        ]);

        var options = {
			is3D: true, 
			fontSize:10,
			fontName:'sans-serif',
			height:180,
		 chartArea:{left:5,right:5,bottom:5,top:15},
		legend: { position: 'right', maxLines: 15,textStyle: {fontSize: 12,padding:'5px',color:'#73879C',bold:true}},
		isStacked: 'relative',
		 vAxis: {
            minValue: 0,
            ticks: [0, .3, .6, .9, 1]
          }	
		};
        var chart = new google.visualization.PieChart(document.getElementById('donutchartperformance'));
        chart.draw(data, options);
      }
    </script>
<!--  Free service -->

  <script type="text/javascript">
  
$(document).ready(function(){
   
    $(".openmodel").click(function(){ 
	  
	  $('.modal-body').html("");
	    var open_id= $(this).attr("open_id");
		
		var url = $(this).attr('url');
       $.ajax({
       type: 'GET',
       url: url,
	   data : {open_id:open_id},
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

<!-- Paid service -->
  <script type="text/javascript">
  
$(document).ready(function(){
   
    $(".completedservice").click(function(){ 
	  
	  $('.modal-body').html("");
	   
       var c_service = $(this).attr("c_service");
	    
		var url = $(this).attr('url');
	     
       $.ajax({
       type: 'GET',
       url: url,
	
       data : {open_id:c_service},
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

<!-- Repeat Job service  -->
  <script type="text/javascript">
  
$(document).ready(function(){
   
    $(".service-up").click(function(){ 
	  
	  $('.modal-body').html("");
	   
       var u_service = $(this).attr("u_service");
	   
		var url = $(this).attr('url');
	     
       $.ajax({
       type: 'GET',
       url: url,
	
       data : {open_id:u_service},
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