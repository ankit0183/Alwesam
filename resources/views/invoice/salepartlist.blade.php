@extends('layouts.app')
@section('content')
<style>
.table>thead>tr>th {
    padding: 12px 2px 12px 4px;
}
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Invoices',$userid)=='yes')
        <div class="right_col" role="main">
			<!--invoice modal-->
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
			<!--Payment modal-->
			<div id="myModal-payment" class="modal fade" role="dialog">
				<div class="modal-dialog modal-lg">
					<!-- Modal content-->
					<div class="modal-content modal-data">
						
					</div>
				</div>
			</div>
          <div class="">
           <div class="page-title">
              <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Invoice')}}</span></a>
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
				   @elseif(session('message')=='Successfully Sent')
				   <label for="checkbox-10 colo_success"> {{ trans('app.Successfully Sent')}}  </label>
				   @elseif(session('message')=='Error! Something went wrong.')
				   <label for="checkbox-10 colo_success"> {{ trans('app.Error! Something went wrong.')}}  </label>
				   @endif
                </div>
			</div>
			</div>
			@endif
            <div class="row" >
              <div class="col-md-12 col-sm-12 col-xs-12" >
            <div class="x_content">
            <ul class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class="active"><a href="{!! url('/invoice/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.Invoice List')}}</b></a></li>
			@if(getActiveCustomer($userid)=='yes')
			<li role="presentation" class=""><a href="{!! url('/invoice/add')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Invoice')}}</a></li>
			<li role="presentation" class=""><a href="{!! url('/invoice/sale_part')!!}"><span class="visible-xs"></span> <i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add Sale Part Invoice')}}</a></li>
			@endif
            </ul>
			</div>
			 <div class="x_panel">
                  <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
                      <thead>
                        <tr>
						<th>#</th>
						 <th>{{ trans('app.Invoice Number')}}</th>
						 <th>{{ trans('app.Customer Name')}}</th>
						 <th>{{ trans('app.Invoice For')}}</th>
                         <th>{{ trans('app.Status')}}</th>
						 <th>{{ trans('app.Total Amount')}} ({{getCurrencySymbols()}})</th>
						 <th>{{ trans('app.Paid Amount')}} ({{getCurrencySymbols()}})</th>
                         <th>{{ trans('app.Date')}}</th>
                         <th>{{ trans('app.Action')}}</th>
                        </tr>
                      </thead>
                      <tbody>
						<?php $i = 1; ?>   
					  	@foreach($invoice as $invoices)
						<tr class="texr-left">
							<td>{{ $i }}</td>
							<td>{{ $invoices->invoice_number }}</td>
							<td>{{ getCustomerName($invoices->customer_id) }}</td>
							@if($invoices->type == 2)
								<td>{{ trans('app.Part')}}</td>
							@else
								<td>@if(getVehicleName($invoices->job_card) == null){{ $invoices->job_card }}
								@else{{ getVehicleName($invoices->job_card) }}
								@endif
								</td>
							@endif
							<td><?php if($invoices->payment_status == 0)
									{ echo"Unpaid"; }
								elseif($invoices->payment_status == 1)
									{ echo"Partially Paid"; }
								elseif($invoices->payment_status == 2)
									{ echo"Paid";}
								else
									{echo"Unpaid";}
								?>
							</td>
							<td>{{ number_format($invoices->grand_total, 2) }}</td>
							<td>{{ number_format($invoices->paid_amount, 2) }}</td>
							
							<td>{{ date(getDateFormat(),strtotime($invoices->date)) }}</td>
							<td>
							<?php $userid=Auth::User()->id; ?>
							@if(getActiveCustomer($userid)=='yes')
								@if($invoices->type != 2)
								<button type="button" data-toggle="modal" data-target="#myModal-job" type_id ="{{ $invoices->type }}" serviceid="{{ $invoices->sales_service_id }}" auto_id = "{{ $invoices->id }}" url="{!! url('/jobcard/modalview') !!}" sale_url="{!! url('/sales/list/modal') !!}" class="btn btn-round btn-info save">{{ trans('app.View Invoice')}}</button>					
								@else
									<button type="button" data-toggle="modal" data-target="#myModal-job" type_id ="{{ $invoices->type }}" serviceid="{{ $invoices->sales_service_id }}" auto_id = "{{ $invoices->id }}" url="{!! url('/jobcard/modalview') !!}" sale_url="{!! url('/sales_part/list/modal') !!}" class="btn btn-round btn-info save">{{ trans('app.View Invoice')}}</button>	
								@endif
								<a href="{!! url('/invoice/list/edit/'.$invoices->id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Edit')}}</button></a>	
								
								{{--<a url="{!! url('/invoice/list/delete/'.$invoices->id) !!}" class="sa-warning"><button type="button" class="btn btn-round btn-danger">{{ trans('app.Delete')}}</button></a>--}}
								
								<button type="button" data-toggle="modal" data-target="#myModal-payment" invoice_id ="{{ $invoices->id }}" url="{!! url('/invoice/payment/paymentview') !!}"  class="btn btn-round btn-info Payment"> {{ trans('app.Payment History')}}</button>
								
								@if($invoices->grand_total == $invoices->paid_amount)
									<a href="{!! url('/invoice/pay/'.$invoices->id) !!}" ><button type="button" class="btn btn-round btn-success" disabled >{{ trans('app.Pay')}}</button></a>
								@else
									<a href="{!! url('/invoice/pay/'.$invoices->id) !!}" ><button type="button" class="btn btn-round btn-success">{{ trans('app.Pay')}}</button></a>
								@endif
							@else
								<button type="button" data-toggle="modal" data-target="#myModal-job" type_id ="{{ $invoices->type }}" serviceid="{{ $invoices->sales_service_id }}" auto_id = "{{ $invoices->id }}" url="{!! url('/jobcard/modalview') !!}" sale_url="{!! url('/sales/list/modal') !!}" class="btn btn-round btn-info save">{{ trans('app.View Invoice')}} </button>
								
								<?php  
									$grand_total = $invoices->grand_total; 
									$paid_amount =$invoices->paid_amount;
									$amountdue = $grand_total - $paid_amount; 
								?>
								@if(Auth::user()->role !='employee')
									<button type="button" data-toggle="modal" data-target="#myModal-payment" invoice_id ="{{ $invoices->id }}" url="{!! url('/invoice/payment/paymentview') !!}"  class="btn btn-round btn-info Payment"> {{ trans('app.Payment History')}}</button>
								
									@if($amountdue != 0)
										<script src="https://js.stripe.com/v3/"></script>
										<form method="post" action="{{ url('invoice/stripe')}}" class="medium" id="medium">
										  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
										  <input type='hidden' name="invoice_amount" value="{{$amountdue}}">
										  <input type='hidden' name="invoice_id" value="{{$invoices->id}}">
										  <input type='hidden' name="invoice_no" value="{{$invoices->invoice_number}}">
										  
										  <input type="submit" class="submit2  btn btn-round btn-success" value="{{ trans('app.Pay')}}" data-key="{{$updatekey->publish_key}}" data-email="{{getCustomerEmail($invoices->customer_id)}}" 
											 data-name="{{$logo->system_name}}"data-description="Invoice Number - {{$invoices->invoice_number}}" data-amount="{{$amountdue *100}}"  />
											 
										  <script src="https://checkout.stripe.com/v2/checkout.js"></script>
										  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
										  <script>
											 $(document).ready(function() {
												$('.submit2').on('click', function(event) {
													event.preventDefault();
													
														var $button = $(this),
															$form = $button.parents('form');
														var opts = $.extend({}, $button.data(), {
															token: function(result) {
																$form.append($('<input>').attr({
																	type: 'hidden',
																	name: 'stripeToken',
																	value: result.id
																})).submit();
															}
														});
														StripeCheckout.open(opts);
												});
											 });
										  </script>
										</form>
									@else
										<input type="submit" class="btn btn-round btn-success" value="{{ trans('app.Pay')}}" disabled/>	
									@endif
								@endif
							@endif
							</td>
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
    });
});
</script>
<!-- Delete invoice -->
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
<script type="text/JavaScript">

$(document).ready(function(){
	//view invoice 
	$('body').on('click', '.save', function() {	  
		$('.modal-body').html("");
		var type_id = $(this).attr("type_id");
		var serviceid = $(this).attr("serviceid");
		var auto_id = $(this).attr("auto_id");

		if(type_id == 0 )
		{
			var url = $(this).attr('url');
		}
		else
		{
			var url = $(this).attr('sale_url');
		}
		
		$.ajax({
			type: 'GET',
			url: url,
		   data : {serviceid:serviceid,auto_id:auto_id},
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
	//view Payment 
	$('body').on('click', '.Payment', function() {	  
		$('.modal-data').html("");
		var invoice_id = $(this).attr("invoice_id");
		var url = $(this).attr('url');
		$.ajax({
			type: 'GET',
			url: url,
			
			data : {invoice_id:invoice_id},
			success: function (data)
			{            
			 
				$('.modal-data').html(data.html);	
			},
			beforeSend:function(){
				$(".modal-data").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
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