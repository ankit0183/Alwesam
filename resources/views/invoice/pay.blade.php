@extends('layouts.app')

@section('content')
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Invoices',$userid)=='yes')	
@if(getActiveCustomer($userid)=='no')
	<div class="right_col" role="main">
        <div class="page-title">
          <div class="nav_menu">
            <nav>
				<div class="nav toggle titleup" style="padding-bottom:16px;">
					<span class="">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
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
					<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Invoice')}}</span></a>
				  </div>
						@include('dashboard.profile')
				</nav>
			  </div>
			</div>
            </div>
			 <div class="x_content">
             <ul class="nav nav-tabs bar_tabs" role="tablist">
			<li role="presentation" class=""><a href="{!! url('/invoice/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i> {{ trans('app.Invoice List')}}</a></li>
			
			<li role="presentation" class="active"><a href="{!! url('/invoice/pay/'.$tbl_invoices->id) !!}"><span class="visible-xs"></span><b>{{ trans('app.Pay Payment')}}</b></a></li>
			
            </ul>
			</div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
					<div class="x_content">
                    <form method="post"  action="update/{{$tbl_invoices->id}}" enctype="multipart/form-data"  name="Form" class="form-horizontal upperform" onsubmit="return enableSample()">
					<div class="col-md-12 col-xs-12 col-sm-12">
					  <h4><b>{{ trans('app.Payment Information')}}</b></h4><hr style="margin-top:0px;">
					  <p class="col-md-12"></p>
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">
						  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12">{{ trans('app.Invoice Number') }} <label class="text-danger">*</label>
							</label>						
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" name="" class="form-control" value="{{ $tbl_invoices->invoice_number }}" readonly>
							</div>
						  </div>
						  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Payment Number') }} <label class="text-danger">*</label> 
							</label>						
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" name="paymentno" class="form-control" value="{{ $code }}" readonly>
							</div>
						</div>
					</div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">  
						<div class="col-md-6 col-sm-6 col-xs-12 form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="Date">{{ trans('app.Payment Date')}} <label class="text-danger">*</label></label>
								
							<div class="col-md-8 col-sm-8 col-xs-12 input-group date datepicker" >
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
								<input type="text"  name="Date"  class="form-control" 
								placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required >
							</div>
					    </div>
						<div class="col-md-6 col-sm-6 col-xs-12 form-group text-danger">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Amount Due') }} (<?php echo getCurrencySymbols();?>) </label>						
							<div class="col-md-8 col-sm-8 col-xs-12">
								<input type="text" name="Invoice_Number" id="dueamount" class="form-control" value="{{ $dueamount }}" readonly>
							</div>
						</div>
						
					</div>
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">  
						<div class="col-md-6 col-sm-6 col-xs-12 form-group">
							<label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Payment Type') }} <label class="text-danger">*</label> 
							</label>						
							<div class="col-md-8 col-sm-8 col-xs-12">
								<select name="Payment_type" class="form-control" required>
									<option value="">{{ trans('app.Select Payment Type') }}</option>
									@if(!empty($tbl_payments))
										@foreach($tbl_payments as $tbl_paymentss)
										<option value="{{$tbl_paymentss->id}}">{{ $tbl_paymentss->payment }}</option>
										@endforeach
									@endif	
								</select>
							</div>
						</div>
					  
					  <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" style="    padding: 8px;" for="cus_name">{{ trans('app.Amount Received') }} (<?php echo getCurrencySymbols(); ?>) <label class="text-danger">*</label> 
                        </label>						
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<input type="text" name="receiveamount" class="form-control paidamount" id="amountreceived"  required>
                        </div>
                      </div>
                    </div>
					<div class="col-md-12 col-sm-12 col-xs-12 form-group">  
						<div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label class="control-label col-md-4 col-sm-4 col-xs-12" for="cus_name">{{ trans('app.Note') }}</label>						
                        <div class="col-md-8 col-sm-8 col-xs-12">
							<textarea name="note" class="form-control" maxlength="100" ></textarea>
                        </div>
                      </div>
					</div>
					  <input type="hidden" name="_token" value="{{csrf_token()}}">
                     
                      <div class="form-group col-md-12 col-sm-12 col-xs-12">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                         <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                          <button type="submit" class="btn btn-success submit" >{{ trans('app.Submit')}}</button>
                        </div>
                      </div>

                    </form>
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
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- Datetimepicker -->
	<script>
    $('.datepicker').datetimepicker({
       format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
    });
	</script>

	
	<script>
	$(document).ready(function(){
		$('body').on('keyup','#amountreceived',function(){
			
			var dueamount = $('#dueamount').val();
			var amount = $('#amountreceived').val();
			if(parseInt(amount) <= parseInt(dueamount))
			{
			}
			else{
				swal({   
					title: "Pay Amount",
					text: 'please enter an amount less than Amount Due'  

					});
				var amount = $('#amountreceived').val('');
					return false;
			}
		});
		
		
	});
	</script>
	

@endsection