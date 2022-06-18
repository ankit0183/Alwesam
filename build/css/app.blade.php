<!DOCTYPE html>
<html dir="" lang="en" >
<head>
    <meta content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" href="{{ URL::asset('fevicol.png') }}" type="image/gif" sizes="16x16">
    <title>{{ getNameSystem() }}</title>
	
    <!-- Bootstrap -->
    <link href= "{{ URL::asset('vendors/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ URL::asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
    <!-- NProgress -->
    <link href="{{ URL::asset('vendors/nprogress/nprogress.css') }}" rel="stylesheet">
	 <!-- iCheck -->
    <link href="{{ URL::asset('vendors/iCheck/skins/flat/green.css') }}" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <!-- <link href="{{ URL::asset('vendors/google-code-prettify/bin/prettify.min.css') }}" rel="stylesheet"> -->
    <!-- Select2 -->
    <link href="{{ URL::asset('vendors/select2/dist/css/select2.min.css') }}" rel="stylesheet">
   
    
	<!-- FullCalendar -->
    <link href="{{ URL::asset('vendors/fullcalendar/dist/fullcalendar.min.css')}}" rel="stylesheet">
    <link href="{{ URL::asset('vendors/fullcalendar/dist/fullcalendar.print.css')}}" rel="stylesheet" media="print">
	<!-- bootstrap-daterangepicker -->
    <link href="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.css') }} " rel="stylesheet">
    <link href="{{ URL::asset('vendors/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}" rel="stylesheet">
	<!-- dropify CSS -->
	<link rel="stylesheet" href="{{ URL::asset('vendors/dropify/dist/css/dropify.min.css') }}">
	
    <!-- Custom Theme Style -->
    <link href="{{ URL::asset('build/css/custom.min.css') }} " rel="stylesheet">
	
	 <!-- Own Theme Style -->
    <link href="{{ URL::asset('build/css/own.css') }} " rel="stylesheet">
	
   <!-- Datatables -->
    
    <link href="{{ URL::asset('vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ URL::asset('vendors/datatables.net-bs/css/dataTables.bootstrap.min.css') }}" rel="stylesheet">
	 <link href="{{ URL::asset('build/css/dataTables.responsive.css') }} " rel="stylesheet">
	 <link href="{{ URL::asset('build/css/dataTables.tableTools.css') }} " rel="stylesheet">
    <!-- <link href="{{ URL::asset('vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css') }}" rel="stylesheet"> -->
    
    <link href="{{ URL::asset('vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css') }}" rel="stylesheet">
	
	 <!-- AutoComplete CSS -->
	<link href="{{ URL::asset('build/css/themessmoothness.css') }}" rel="stylesheet">
	 <!-- Multiselect CSS -->
	<link href="{{ URL::asset('build/css/multiselect.css') }}" rel="stylesheet">
	 <!-- Slider Style -->
	<link href="https://fonts.googleapis.com/css?family=Helvetica" rel="stylesheet">
	@if(getValue()=='rtl')
	<link href="{!! URL::asset('build/css/bootstrap-rtl.min.css'); !!}" rel="stylesheet" id="rtl"/>
	@else
		
	@endif
	
	<!-- sweetalert -->
	<link href="{{ URL::asset('vendors/sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css">
	
	<style>
	@media print
   {
     
      .noprint
      {
        display:none
      }
   }
	</style>
  </head>

<body id="app-layout" class="nav-md">
   <div class="container body">
    <div class="main_container">
       <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title hidden-xs" style="border: 0; ">
              <a href="{!! url('/')!!}" class="site_title">
			  <img src="{{ URL::asset('public/general_setting/'.getLogoSystem())}}"
			   class="profilepic" ></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
				 @if(!empty(Auth::user()->id))
					 @if(Auth::user()->role=='admin')
						  <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/customer/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
					 @if(Auth::user()->role=='Customer')
						 <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/customer/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
					
					@if(Auth::user()->role=='Supplier')
						 <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/supplier/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
					
					@if(Auth::user()->role=='employee')
						 <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/employee/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
					
					 @if(Auth::user()->role=='accountant')
						 <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/accountant/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
					
					@if(Auth::user()->role=='supportstaff')
						 <a href="{!! url('/setting/profile')!!}"><img src="{{ URL::asset('public/supportstaff/'.Auth::user()->image)}}" alt="..." class="img-circle profile_img"></a>
					@endif
				@endif
              </div>
              <div class="profile_info">
                <span>{{ trans('app.Welcome')}}</span>
				 @if(!empty(Auth::user()->id))
                <h2>{{ Auth::user()->name }}</h2>
				@endif
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                
                <ul class="nav side-menu">
				<?php $userid=Auth::User()->id;?>
				
                  <li><a href="{!! url('/') !!}"><i class="fa fa-home"></i> {{ trans('app.Dashboard')}} </a> </li>
				  
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Inventory',$userid)=='yes')
				   <li><a><i class="fa fa-user image_icon"></i> {{ trans('app.Inventory')}} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
						<li><a href="{!! url('/supplier/list')!!}">{{ trans('app.Supplier')}}</a></li>
						<li><a href="{!! url('/product/list') !!}">{{ trans('app.Product')}}</a></li>
						<li><a href="{!! url('/purchase/list')!!}">{{ trans('app.Purchase')}}</a></li>
						<li><a href="{!! url('/stoke/list')!!}">{{ trans('app.Stock')}}</a></li>
                    </ul>
				  </li>
				 @endif
				 
                  <li><a><i class="fa fa-edit"></i> {{ trans('app.Users')}} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
					<?php $userid=Auth::User()->id;?>
				     @if (getAccessStatusUser('Customers',$userid)=='yes')
                      <li><a href="{!! url('/customer/list')!!}">{{ trans('app.Customers')}}</a></li>
				     @endif
					 
					 <?php $userid=Auth::User()->id;?>
				     @if (getAccessStatusUser('Employee',$userid)=='yes')
                      <li><a href="{!! url('/employee/list')!!}">{{ trans('app.Employee')}}</a></li>
				     @endif
					 <?php $userid=Auth::User()->id;?>
				     @if (getAccessStatusUser('Support Staff',$userid)=='yes')
					  <li><a href="{!! url('/supportstaff/list')!!}">{{ trans('app.Support Staff')}}</a></li>
				     @endif
					 
					 <?php $userid=Auth::User()->id;?>
				     @if (getAccessStatusUser('Accountant',$userid)=='yes')
                      <li><a href="{!! url('/accountant/list')!!}">{{ trans('app.Accountant')}}</a></li>
				     @endif
					  
                    </ul>
                  </li>
				
				 <?php $userid=Auth::User()->id;?>
				@if(getActiveCustomer($userid)=='yes')
				@if (getAccessStatusUser('Vehicle',$userid)=='yes')
                  <li><a><i class="fa fa-motorcycle"></i> {{ trans('app.Vehicle')}} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{!! url('/vehicle/list') !!}">{{ trans('app.List Vehicle')}}</a></li>
                      <li><a href="{!! url('/vehicletype/list') !!}">{{ trans('app.List Vehicle Type')}}</a></li>
                      <li><a href="{!! url('/vehiclebrand/list') !!}">{{ trans('app.List Vehicle Brand')}}</a></li>
                    </ul>
                  </li>
                 @endif 
                 @endif 
				 @if(getActiveCustomer($userid)=='no')
					@if (getAccessStatusUser('Vehicle',$userid)=='yes')
						<li><a href="{!! url('/vehicle/list') !!}"><i class="fa fa-motorcycle"></i> {{ trans('app.Vehicle')}} </a></li>
					@endif 
                 @endif 
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Services',$userid)=='yes')
                  <li><a href="{!! url('/service/list') !!}"><i class="fa fa-slack image_icon"></i> {{ trans('app.Services')}} </a> </li>
				@endif

				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Invoice',$userid)=='yes')
                  <li><a href="{!! url('/invoice/list') !!}" ><i class="fa fa-file-text-o"></i> {{ trans('app.Invoice')}} </a>  </li>
				@endif

				
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Job Card',$userid)=='yes')
                  <li><a><i class="fa fa-table"></i> {{ trans('app.Job Card')}} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{!! url('/jobcard/list')!!}">{{ trans('app.Job Card')}}</a></li>
                      <li><a href="{!! url('/gatepass/list')!!}">{{ trans('app.Gate Pass')}}</a></li>
                     
                    </ul>
                  </li>
				@endif
				
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Colors',$userid)=='yes')
				 <li><a href="{!! url('/color/list') !!}"><i class="fa fa-bar-chart-o"></i> {{ trans('app.Colors')}}</a></li>
				 @endif 
				  
				  
				 <?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Account & Tax Rates',$userid)=='yes')
				  <li><a><i class="fa fa-tasks image_icon"></i>{{ trans('app.Account & Tax Rates')}} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{!! url('/taxrates/list') !!}">{{ trans('app.List Tax Rates')}}</a></li>
                      <li><a href="{!! url('/payment/list') !!}">{{ trans('app.List Payment')}} </a></li>
                    </ul>
                  </li>
				@endif
				
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Sales',$userid)=='yes')
					@if(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes')
						<li><a href="{!! url('/sales/list') !!}"><i class="fa fa-tty image_icon"></i>{{ trans('app.Sales')}} </a> </li>
					@else
						<li><a href="{!! url('/sales/list') !!}"><i class="fa fa-tty image_icon"></i>{{ trans('app.Purchase')}} </a> </li>
					@endif
				@endif
				
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Government Management',$userid)=='yes')
				  <li><a href="{!! url('/rto/list') !!}"><i class="fa fa-clone"></i>{{ trans('app.Compliance')}}</br> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{ trans('app.Management')}}</a>
                  </li>
				@endif
				
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Account',$userid)=='yes')
				  <li><a><i class="fa fa-calculator"></i> {{ trans('app.Account')}} <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
                      <li><a href="{!! url('/income/list')!!}">{{ trans('app.Income')}}</a></li>
                      <li><a href="{!! url('/expense/list')!!}">{{ trans('app.Expenses')}}</a></li>
                    </ul>
                  </li>
				@endif
				
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Report',$userid)=='yes')
				  <li><a href="{!! url('/report/salesreport') !!}"><i class="fa fa-bar-chart-o"></i>{{ trans('app.Report')}} </a></li>
				 @endif
				 
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Mail Formates',$userid)=='yes')
				  <li><a href="{!! url('/mail/mail') !!}"><i class="fa fa-envelope"></i>{{ trans('app.Email Template')}}</a></li>
				@endif
				 
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Custom Field',$userid)=='yes')
				  <li><a href="{!! url('/setting/custom/list') !!}"><i class="fa fa-user"></i>{{ trans('app.Custom Field')}}</a> </li>
				@endif
				
				<?php $userid=Auth::User()->id;?>
				@if (getAccessStatusUser('Observation library',$userid)=='yes')
				 <li><a href="{!! url('/observation/list') !!}" ><i class="fa fa-universal-access"></i>{{ trans('app.Observation library')}}</a></li> 
				@endif
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
            <div class="sidebar-footer hidden-small">
			 <?php $userid=Auth::User()->id;?>
			 @if (getAccessStatusUser('Settings',$userid)=='yes')
				 @if(getActiveAdmin($userid)=='yes')
					<a data-toggle="tooltip" data-placement="top" href="{!! url('/setting/general_setting/list') !!}" title="Settings"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
				@else
					<a data-toggle="tooltip" data-placement="top" href="{!! url('/setting/timezone/list') !!}" title="Settings"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></a>
				@endif
			 @endif
             
              <a data-toggle="tooltip" data-placement="top" title="Logout" href="{!! url('/logout') !!}">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>
        <!-- top navigation -->
        <div class="top_nav">
         
        <!-- /top navigation -->
		@yield('content')
		 
	   <footer>
          <div>
             <span class="footerbottom">{{ trans('app.All rights reserved by Garage System.')}}</span>
          </div>
         
        </footer>
   </div>
	
  </div>
 <!-- jQuery -->
    
    <script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
	<script src="{{ URL::asset('build/js/jquery-ui.js') }}"></script>
    <!-- Bootstrap -->
    <script src="{{ URL::asset('vendors/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ URL::asset('vendors/fastclick/lib/fastclick.js') }}"></script>
    <!-- NProgress -->
    <script src="{{ URL::asset('vendors/nprogress/nprogress.js') }}"></script>
    <!-- Chart.js -->
    <script src="{{ URL::asset('vendors/Chart.js/dist/Chart.min.js') }}" defer="defer"></script>
    <!-- jQuery Sparklines -->
    <script src="{{ URL::asset('vendors/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
    <!-- Flot -->
    <script src="{{ URL::asset('vendors/Flot/jquery.flot.js') }}"></script>
    <script src="{{ URL::asset('vendors/Flot/jquery.flot.pie.js') }}"></script>
    <script src="{{ URL::asset('vendors/Flot/jquery.flot.time.js') }}"></script>
    <script src="{{ URL::asset('vendors/Flot/jquery.flot.stack.js') }}"></script>
    <script src="{{ URL::asset('vendors/Flot/jquery.flot.resize.js') }}"></script>
    <!-- Flot plugins -->
    <script src="{{ URL::asset('vendors/flot.orderbars/js/jquery.flot.orderBars.js') }}"></script>
    <script src="{{ URL::asset('vendors/flot-spline/js/jquery.flot.spline.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/flot.curvedlines/curvedLines.js') }}"></script>
    <!-- DateJS -->
    <script src="{{ URL::asset('vendors/DateJS/build/date.js') }}"></script>
    <!-- FullCalendar -->
    <script src="{{ URL::asset('vendors/moment/min/moment.min.js')}}"></script>
    <script src="{{ URL::asset('vendors/fullcalendar/dist/fullcalendar.min.js')}}" defer="defer"></script>
    
    <!-- Custom Theme Scripts -->
    <script src="{{ URL::asset('build/js/custom.min.js') }}" defer="defer"></script>
	<script src="{{ URL::asset('vendors/sweetalert/sweetalert.min.js')}}"></script>
	<!-- datatable scripts
	 <script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.js') }}"></script>-->
	
	<script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
	
    <script src="{{ URL::asset('vendors/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/buttons.flash.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-keytable/js/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js') }}"></script>
    <script src="{{ URL::asset('vendors/datatables.net-scroller/js/dataTables.scroller.min.js') }}"></script>
	<!-- dropify scripts-->
	<script src="{{ URL::asset('vendors/dropify/dist/js/dropify.min.js')}}"></script>
	<script src="{{ URL::asset('vendors/iCheck/icheck.min.js')}}"></script>
	<!-- slider scripts-->
	
	<script src="{{ URL::asset('vendors/slider/jssor.slider.mini.js')}}"></script>
	<!-- bootstrap-daterangepicker -->
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
	<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    
	
	 <!-- Filter  -->
	
    <script src="{{ URL::asset('build/js/jszip.min.js') }}"></script>
    
	 <!-- Autocomplete Js  -->
	<script src="{{ URL::asset('build/js/jquery.circliful.min.js') }}"></script>
	
	<!-- Multiselect Js  -->
	<script src="{{ URL::asset('build/js/bootstrap-multiselect.js') }}"></script>


</body>
</html>
