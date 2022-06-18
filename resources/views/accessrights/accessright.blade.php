@extends('layouts.app')
@section('content')
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
						<a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.Access Rights')}}</span></a>
					  </div>
						  @include('dashboard.profile')
					</nav>
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
            </div>
			<div class="x_content">
                <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
					
					<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('setting/general_setting/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cogs">&nbsp;</i>{{ trans('app.General Settings')}}</a></li>
					
					<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/timezone/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-cog">&nbsp;</i>{{ trans('app.Other Settings')}}</a></li>
					
					<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('setting/accessrights/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-universal-access">&nbsp;</i><b> {{ trans('app.Access Rights')}}</b></a></li>
					
					<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('setting/hours/list')!!}" class="anchor_tag anchr"><span class="visible-xs"></span><i class="fa fa-hourglass-end">&nbsp;</i>{{ trans('app.Business Hours')}}</a></li>
					
				</ul>
			</div>
			<div class="clearfix"></div>
            <div class="row" >
				<div class="col-md-12 col-sm-12 col-xs-12" >
					<div class="x_panel">
						<table id="datatable" class="table table-striped table-top jambo_table">
							<thead>
								<tr>
									<th>#</th>
									<th>{{ trans('app.Module Name')}}</th>
									<th>{{ trans('app.Customers')}}</th>
									<th>{{ trans('app.Employee')}}</th>
									<th>{{ trans('app.Supportstaff')}}</th>
									<th>{{ trans('app.Accountant')}}</th>
								</tr>
							</thead>
							<tbody>
								   <?php $i = 1; ?>   
								@foreach ($accessright as $accessrights)
								    <tr>
										<td>{!! $i !!}</td>
										<td>{!! $accessrights->menu_name !!}</td>
										
										<!-- customer in accessright -->
											@if($accessrights->menu_name == 'Inventory' || $accessrights->menu_name == 'Accounts & Tax Rates' || $accessrights->menu_name == 'Compliance' ||  $accessrights->menu_name == 'Reports' || $accessrights->menu_name == 'Email Templates' || $accessrights->menu_name == 'Observation library' || $accessrights->menu_name == 'Custom Fields')
													<td><input type="checkbox" class="Customers" Customers_id="{{ $accessrights->id }}" url="{!! url('/setting/accessrights/store')!!}" <?php echo $accessrights->customers?"checked":"";?> disabled /></td>
											@else
													<td><input type="checkbox" class="Customers" Customers_id="{{ $accessrights->id }}" url="{!! url('/setting/accessrights/store')!!}" <?php echo $accessrights->customers?"checked":"";?> /></td>
											@endif
											
										<!-- employee in accessright -->	
											@if($accessrights->menu_name == 'Accounts & Tax Rates' || $accessrights->menu_name == 'Compliance' || $accessrights->menu_name == 'Reports' || $accessrights->menu_name == 'Email Templates' || $accessrights->menu_name == 'Observation library' || $accessrights->menu_name == 'Custom Fields')
												<td><input type="checkbox" class="Employee" Employee_id ="{{ $accessrights->id }}" url="{!! url('/setting/accessrights/Employeestore')!!}" <?php echo $accessrights->employee?"checked":"";?> disabled /></td>
											@else
												<td><input type="checkbox" class="Employee" Employee_id ="{{ $accessrights->id }}" url="{!! url('/setting/accessrights/Employeestore')!!}" <?php echo $accessrights->employee?"checked":"";?>/></td>
											@endif
										
										<td><input type="checkbox" class="Support_staff" Support_staff_id ="{{ $accessrights->id }}" url="{!! url('/setting/accessrights/staffstore')!!}" <?php echo $accessrights->support_staff?"checked":"";?> /></td>
										<td><input type="checkbox" class="Accountant" Accountant_id ="{{ $accessrights->id }}" url="{!! url('/setting/accessrights/Accountantstore')!!}" <?php echo $accessrights->accountant?"checked":"";?> /></td>							
									</tr>
									 <?php $i++; ?>
								@endforeach
							</tbody>
						</table>
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

<!-- language change in user selected -->	
<script>
$(document).ready(function() {
    $('#datatable').DataTable( {
		responsive: true,
        "language": {
			
				"url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/<?php echo getLanguageChange(); 
			?>.json"
        }
    } );
} );
</script> 
<script type="text/javascript">
    $(document).ready(function(){
        $('input.Customers[type="checkbox"]').click(function(){

            if($(this).prop("checked") == true){
				var Customers_id = $(this).attr('Customers_id');
				var value = 1;
                var url = $(this).attr('url');
				$.ajax({
						type: 'GET',
						url: url,
						data : {Customers_id:Customers_id,value:value},
						success: function (response)
							 {	
								
							},

						});
            }
            else if($(this).prop("checked") == false){
                var Customers_id = $(this).attr('Customers_id');
				var value = 0;
                var url = $(this).attr('url');
				$.ajax({
						type: 'GET',
						url: url,
						data : {Customers_id:Customers_id,value:value},
						success: function (response)
							 {	
								
							},
						});
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('input.Employee[type="checkbox"]').click(function(){

            if($(this).prop("checked") == true){
				var Employee_id = $(this).attr('Employee_id');
				var value = 1;
                var url = $(this).attr('url');
				$.ajax({
						type: 'GET',
						url: url,
						data : {Employee_id:Employee_id,value:value},
						success: function (response)
							 {	
								
							},

						});
            }
            else if($(this).prop("checked") == false){
                var Employee_id = $(this).attr('Employee_id');
				var value = 0;
                var url = $(this).attr('url');
				$.ajax({
						type: 'GET',
						url: url,
						data : {Employee_id:Employee_id,value:value},
						success: function (response)
							 {	
								
							},
						});
            }
        });
    });
</script>


<script type="text/javascript">
    $(document).ready(function(){
        $('input.Support_staff[type="checkbox"]').click(function(){

            if($(this).prop("checked") == true){
				var Support_staff_id = $(this).attr('Support_staff_id');
				var value = 1;
                var url = $(this).attr('url');
				$.ajax({
						type: 'GET',
						url: url,
						data : {Support_staff_id:Support_staff_id,value:value},
						success: function (response)
							 {	
								
							},

						});
            }
            else if($(this).prop("checked") == false){
                var Support_staff_id = $(this).attr('Support_staff_id');
				var value = 0;
                var url = $(this).attr('url');
				$.ajax({
						type: 'GET',
						url: url,
						data : {Support_staff_id:Support_staff_id,value:value},
						success: function (response)
							 {	
								
							},
						});
            }
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('input.Accountant[type="checkbox"]').click(function(){

            if($(this).prop("checked") == true){
				var Accountant_id = $(this).attr('Accountant_id');
				var value = 1;
                var url = $(this).attr('url');
				$.ajax({
						type: 'GET',
						url: url,
						data : {Accountant_id:Accountant_id,value:value},
						success: function (response)
							 {	
								
							},

						});
            }
            else if($(this).prop("checked") == false){
                var Accountant_id = $(this).attr('Accountant_id');
				var value = 0;
                var url = $(this).attr('url');
				$.ajax({
						type: 'GET',
						url: url,
						data : {Accountant_id:Accountant_id,value:value},
						success: function (response)
							 {	
								
							},
						});
            }
        });
    });
</script>
@endsection