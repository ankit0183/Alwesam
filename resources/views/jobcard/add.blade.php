@extends('layouts.app')
@section('content')
<style>
.step{color:#5A738E !important;}
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Job Card',$userid)=='yes')
	@if(getActiveCustomer($userid)=='no')
        <div class="right_col" role="main">
			<div class="">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle titleup">
							<span class="">&nbsp {{ trans('app.You are not authorize this page.')}}</span>
						</div>
					</nav>
				</div>
			</div>
		</div>
    @else	
	<div class="right_col" role="main">
    <div class="page-title">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"> </i><span class="titleup">&nbsp {{ trans('app.JobCard')}}</span></a>
              </div>
                  @include('dashboard.profile')
            </nav>
          </div>
    </div>
	<div class="x_content">
        <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
			<li role="presentation" class="floattab suppo_llng_li"><a href="{!! url('/jobcard/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.List Of Job Cards')}}</a></li>
		
			<li role="presentation" class="active floattab suppo_llng_li_add"><a href="{!! url('/jobcard/add')!!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i><b>{{ trans('app.Add Jobcard')}}</b></a></li>
		</ul>
	</div>
    {{-- <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
				<div class="panel panel-default">
				<div class="panel-heading step titleup">{{ trans('app.Step - 1 : Add Service Details...')}}</div>
                   <form method="post" action="{{ url('/service/store') }}" enctype="multipart/form-data"  class="form-horizontal upperform">

                       <div class="form-group">
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Jobcard Number')}} <label class="text-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
								
									<input type="text" id="jobno" name="jobno" class="form-control" value="{{ $code }}" readonly>
								</div>
							</div>
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Customer Name')}} <label class="text-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<select name="Customername"  class="form-control select_vhi" cus_url = "{!! url('service/get_vehi_name') !!}" required >
									<option value="">{{ trans('app.Select Customer')}}</option>
									@if(!empty($customer))
										@foreach($customer as $customers)
										<option value="{{$customers->customer_id}}">{{ getCustomerName($customers->customer_id) }}
										@endforeach
										@endif
									</select>
								</div>
							</div>
                      </div>
                       <div class="form-group">
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Vehicle Name')}} <label class="text-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
								      <select  name="vehicalname" class="form-control" id="vhi" required>
								        <option value="">{{ trans('app.Select vehicle Name')}}</option>
											<!-- Option comes from Controller -->
								      </select>
								 </div>
							</div>
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Date')}} <label class="text-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12 input-group date datepicker">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
									<input type="text" id="name" name="date" class="form-control" placeholder="<?php echo getDatepicker(); echo " hh:mm:ss"; ?>"  required>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Title')}}</label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" name="title" placeholder="{{ trans('app.Enter Title')}}" class="form-control">
								</div>
							</div>
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Assign To')}} <label class="text-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<select id="AssigneTo" name="AssigneTo"  class="form-control" required>
										<option value="">-- {{ trans('app.Select Assign To')}} --</option>
										@if(!empty($employee))
										@foreach($employee as $employees)
										<option value="{{$employees->id}}">{{ $employees->name }}</option>	
										@endforeach
										@endif
									</select>
								</div>
							</div>
						</div>
						<div class="form-group">
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Repair Category')}} <label class="text-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
								      <select name="repair_cat"  class="form-control" required>
									    <option value="">{{ trans('app.-- Select Repair Category--')}}</option>
										<option value="breakdown">{{ trans('app.Breakdown') }}</option>
										<option value="booked vehicle">{{ trans('Booked Vehicle') }}</option>	
										<option value="repeat job">{{ trans('Repeat Job') }}</option>	
										<option value="customer waiting">{{ trans('Customer Waiting') }}</option>	
									</select>
								</div>
							</div>
							<label class="control-label col-md-2 col-sm-2 col-xs-12" for="service_type">{{ trans('app.Service Type')}} <label class="text-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<label class="radio-inline"><input type="radio" name="service_type" id="free"  value="free" required>{{ trans('app.Free')}}</label>
									
									<label class="radio-inline"><input type="radio" name="service_type" id="paid"  value="paid" required>{{ trans('app.Paid')}}</label>
								</div>
						</div>				
						<div class="form-group">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="details">{{ trans('app.Details')}} <label class="text-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<textarea class="form-control" name="details" id="details"  required></textarea> 
								</div>
								<div id="dvCharge" style="display: none">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Fix Service Charge')}} (<?php echo getCurrencySymbols(); ?>) <label class="text-danger">*</label></label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" id="charge_required" name="charge" class="form-control" placeholder="{{ trans('app.Enter Fix Service Charge')}}" required>
								</div>
								</div> 	
						</div>
						<div class="form-group">
							<div class="">
								<label class="control-label col-md-2 col-sm-2 col-xs-12" for="reg_no">{{ trans('app.Registration No.')}}</label>
								<div class="col-md-4 col-sm-4 col-xs-12">
									<input type="text" name="reg_no" id="reg_no" placeholder="{{ trans('app.Enter Registration Number') }}" class="form-control" readonly>
								</div>
							</div>
						</div>
					  <input type="hidden" name="_token" value="{{csrf_token()}}">
                     
                      <div class="form-group">
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                          <a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
                          <button type="submit" class="btn btn-success">{{ trans('app.Submit')}}</button>
                        </div>
                      </div>
						</form>
					</div>
				</div>
            </div>
        </div>
    </div> --}}
@endif
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
	<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<!--datetimepicker-->
	<script type="text/javascript">
    $(".datepicker").datetimepicker({
        format: "<?php echo getDatetimepicker(); ?>",
		autoclose:1,

    });
 </script> 
<!--  service type  free and paid --> 
<script>
    $(function() {
        $("input[name='service_type']").click(function () {
            if ($("#paid").is(":checked")) {
                $("#dvCharge").show();
                $("#charge_required").attr('required', true);
            } else {
                $("#dvCharge").hide();
				$("#charge_required").removeAttr('required', false);
            }
        });
    });
</script>

<script>

$(document).ready(function(){
	
	$('body').on('change','.select_vhi',function(){
	
		var url = $(this).attr('cus_url');
		var cus_id = $(this).val();
		
		$.ajax({
			
			type:'GET',
			url:url,
			data:{cus_id:cus_id},
			success:function(response)
			{	
				$('.modelnms').remove();
				$('#vhi').append(response);
				
			}
			
		});
	});	
	
	
	$('body').on('click','#vhi',function(){
	
		var cus_id = $('.select_vhi').val();
		
		if(cus_id =="")
		{
			swal({   
				title: "Customer",
				text: "Please select Customer!"   

				});
				return false;
		}
	});	
	
	$('body').on('change','#vhi',function(){
	
		var vehi_id = $('.modelnms:selected').val();
		
		var url = '{{ url('service/getregistrationno')}}';
		$.ajax({
			
			type:'GET',
			url:url,
			data:{vehi_id:vehi_id},
			success:function(response)
			{	
				var res = $.trim(response);
				if(res == "")
				{
					$('#reg_no').val(res);
					$('#reg_no').removeAttr('readonly');
				}
				else
				{	
					$('#reg_no').val(res);
					$('#reg_no').attr('readonly',true);
				}
			}
		});
		
	});	
});
</script>
@endsection