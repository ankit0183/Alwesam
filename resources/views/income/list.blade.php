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
                <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Income')}}</span></a>
              </div>
                  @include('dashboard.profile')
            </nav>
          </div>
            </div>
			@if(session('message'))
			<div class="row massage">
			 <div class="col-md-12 col-sm-12 col-xs-12">
				<div class="checkbox checkbox-success checkbox-circle">
					@if(session('message') == 'Successfully Submitted')
						<label for="checkbox-10 colo_success"> {{trans('app.Successfully Submitted')}}  </label>
					@elseif(session('message')=='Successfully Updated')
						<label for="checkbox-10 colo_success"> {{ trans('app.Successfully Updated')}}  </label>
					@elseif(session('message')=='Successfully Deleted')
						<label for="checkbox-10 colo_success"> {{ trans('app.Successfully Deleted')}}  </label>
					@endif
                </div>
			</div>
			</div>
			@endif
		
            <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12" >
               
                  
                  <div class="x_content">
                   <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
						<li role="presentation" class="active suppo_llng_li floattab"><a href="{!! url('/income/list')!!}" class="anchr"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Income List')}}</b></a></li>
						
						<li role="presentation" class=" suppo_llng_li_add floattab"><a href="{!! url('/income/add')!!}" class="anchr"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Income')}}</a></li>
						
						<li role="presentation" class=" suppo_llng_li_add floattab"><a href="{!! url('/income/month_income')!!}" class="anchr"><span class="visible-xs"></span> <i class="fa fa-area-chart fa-lg">&nbsp;</i>{{ trans('app.Monthly Income Reports')}}</a></li>
			
					</ul>
			</div>
			 <div class="x_panel table_up_div">
                   <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                      <thead>
                        <tr>
						<th>#</th>
						 <th>{{ trans('app.Customer Name')}}</th>
						 <th>{{ trans('app.Invoice Number')}}</th>
						 <th>{{ trans('app.Amount')}} (<?php echo getCurrencySymbols(); ?>)</th>
                         <th>{{ trans('app.Payment Type')}}</th>
						 <th>{{ trans('app.Date')}}</th>
                         <th>{{ trans('app.Main Label')}}</th>
                         <th>{{ trans('app.Action')}}</th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php $i = 1; ?>   
								
						@foreach ($income as $incomes)
						@if(getSumOfIncome($incomes->tbl_income_id) != 0)
                        <tr>
							<td>{{ $i }}</td>
							
							<td>{{ getCustomerName($incomes->customer_id) }}</td>
							
							<td>{{ $incomes->invoice_number }}</td>
							
							<td>{{ number_format(getSumOfIncome($incomes->tbl_income_id),2) }}</td>
							
							<td>{{ GetPaymentMethod($incomes->payment_type) }}</td>
							
							
							
							<td>{{  date(getDateFormat(),strtotime($incomes->date)) }}</td>
							
							<td>{{ $incomes->main_label }}</td>
                          <td>
						
						  <a href="{!! url('/income/edit/'.$incomes->tbl_income_id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>
						  <a url="{!! url('/income/delete/'.$incomes->tbl_income_id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger dgr">{{ trans('app.Delete')}}</button></a>
						  </td>
                        </tr>
                         <?php $i++; ?>
						 @endif
							@endforeach	
                      </tbody>
                    </table>
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
<!-- delete income -->
<script>
 $('body').on('click', '.sa-warning', function() {
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
@endsection