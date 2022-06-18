@extends('layouts.app')
@section('content')

<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Accounts & Tax Rates',$userid)=='yes')
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
               <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Expense')}}</span></a>
              </div>
                    @include('dashboard.profile')
            </nav>
          </div>
        </div>
		
		@if(session('message'))
			<div class="row massage">
			 <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="checkbox checkbox-success checkbox-circle">
                
                  <label for="checkbox-10 colo_success"> {{session('message')}} </label>
                </div>
			</div>
			</div>
		@endif
              
            </div>
			 <div class="x_content">
             <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
			<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('/expense/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Expense List')}}</a></li>
			
			<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/expense/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg i">&nbsp;</i>{{ trans('app.Add Expense')}}</a></li>
			
			<li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('/expense/month_expense')!!}"><span class="visible-xs"></span> <i class="fa fa-area-chart fa-lg">&nbsp;</i><b>{{ trans('app.Monthly Expense Reports')}}</b></a></li>
			
            </ul>
			</div>
			
            
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                   <div class="x_content">
                    <form method="post" action="{{ url('/expense/expense_report') }}" enctype="multipart/form-data"  class="form-horizontal upperform">
					<div class="col-md-12 col-xs-12 col-sm-12">
					  <h4><b>{{ trans('app.Expenses Details')}}</b></h4><hr style="margin-top:0px;">
					  <p class="col-md-12 col-xs-12 col-sm-12"></p>
					  </div>
                       
					   
					<div class="col-md-12">
						<div class="col-md-2">
							<b>{{ trans('app.Start Date')}} :</b> {{  date(getDateFormat(),strtotime($start_date)) }}
						</div>
						<div class="col-md-2">
							<b>{{ trans('app.End Date')}} :</b> {{  date(getDateFormat(),strtotime($end_date)) }}
						</div>
					</div>
					  
					  
					  
				<div class="x_panel table_up_div">
                   <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                      <thead>
                        <tr>
						<th>#</th>
						 <th>{{ trans('app.Main Label')}}</th>
						 <th>{{ trans('app.Expense Label')}}</th>
						 <th>{{ trans('app.Expense Amount')}} ( <?php echo getCurrencySymbols(); ?> )</th>
						 <th>{{ trans('app.Status')}}</th>
						 <th>{{ trans('app.Date')}}</th>
                        
                        </tr>
                      </thead>


                      <tbody>
					  <?php $i = 1; ?>   
						@if(!empty($month_expense))
						@foreach ($month_expense as $month_expenses)
                        <tr>
							<td>{{ $i }}</td>
							<td>{{ $month_expenses->main_label }}</td>
							<td>{{ $month_expenses->label_expense }}</td>
							<td>{{ $month_expenses->expense_amount }}</td>
							@if($month_expenses->status==1)<td>Paid</td>
							
							@elseif($month_expenses->status==2)<td>Unpaid</td>
							
							@else($month_expenses->status==0)<td>Partially Paid</td>
							@endif
							<td>{{  date(getDateFormat(),strtotime($month_expenses->date)) }}</td>
							
                        </tr>
                         <?php $i++; ?>
							@endforeach	
						@endif
						
                      </tbody>
                    </table>
                  </div>
					  
				 <input type="hidden" name="_token" value="{{csrf_token()}}">
                     
                    </form>
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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
    $('.datepicker').datetimepicker({
      format: "yyyy-mm-dd",
		autoclose: 1,
		minView: 2,
    });
</script>
@endsection