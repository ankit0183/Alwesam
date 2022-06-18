@extends('layouts.app')
@section('content')
		<!-- page content -->
	<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Job Card',$userid)=='yes')
	<div class="right_col" role="main">
		<div id="myModal-job" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<a href=""><button type="button" class="close">&times;</button></a>
							<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.JobCard')}}</h4>
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
					<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.JobCard')}}</span></a>
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
						<li role="presentation" class="active suppo_llng_li floattab"><a href="{!! url('/jobcard/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i><b>{{ trans('app.List Of Job Cards')}}</b></span></a></li>

						@if(getActiveCustomer($userid)=='yes')
						<li role="presentation" class="suppo_llng_li_add floattab"><a href="{!! url('/service/add') !!}"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg">&nbsp;</i>{{ trans('app.Add JobCard')}}</span></a></li>

						@endif
					</ul>
					</div>
					<div class="x_panel table_up_div">
						<table id="datatable" class="table table-striped jambo_table" style="margin-top:20px;">
							<thead>
								<tr>
									<th>{{ trans('app.#')}}</th>
									<th>{{ trans('app.Job Card No')}}</th>
									<th>{{ trans('app.Service Type')}}</th>
									<th>{{ trans('app.Customer Name')}}</th>
									<th>{{ trans('app.Service Date')}}</th>
									<th>{{ trans('app.Status')}}</th>
									<th>{{ trans('app.Action')}}</th>
								</tr>
							</thead>
							<tbody>
								@if(!empty($services))
								   <?php $i = 1; ?>
									@foreach ($services as $servicess)

										<tr>
											<td>{{ $i }}</td>
											<td>{{ $servicess->job_no }}</td>
											<td>{{ ucfirst($servicess->service_type) }}</td>
											<td>{{ getCustomerName($servicess->customer_id) }}</td>
											<?php $dateservice = date("Y-m-d", strtotime($servicess->service_date)); ?>
											@if (strpos($available, $dateservice) !== false)
												<td><span class="label  label-danger" style="font-size:13px;">{{ date(getDateFormat(),strtotime($dateservice))}}</span></td>
											@else
												<td>{{ date(getDateFormat(),strtotime($dateservice)) }}</td>
											@endif
											<td><?php if($servicess->done_status == 0)
												 { echo"Open";}
												 else if($servicess->done_status == 1)
												 { echo"Completed";}
												 elseif($servicess->done_status == 2){
													 echo"Progress";
												 } ?>
											</td>
											<td>
											<?php $userid=Auth::User()->id; ?>
											@if(getActiveCustomer($userid)=='yes')
												<?php
												$view_data = getInvoiceStatus($servicess->job_no);

											if($view_data == "No")
											{
												if($servicess->done_status == '1')
												{
												?>
													<a href="{{ url('jobcard/list/add_invoice/'.$servicess->id) }}"><button type="button" class="btn btn-round btn-info">{{ trans('app.Create Invoice')}} </button></a>

												<?php
												}
												elseif($servicess->done_status != '1'  )
												{

												?>
													<a href="{{ url('jobcard/list/add_invoice/'.$servicess->id) }}"><button type="button" class="btn btn-round btn-info" disabled>{{ trans('app.Create Invoice')}} </button></a>

												<?php
												}
											}
											else
											{
											?>
													<button type="button" data-toggle="modal" data-target="#myModal-job" serviceid="{{ $servicess->id }}" url="{!! url('/jobcard/modalview') !!}" class="btn btn-round btn-info save">{{ trans('app.View Invoice')}} </button>
											<?php
											}
											?>

												<?php  $jobcard = getJobcardStatus($servicess->job_no);
														$view_data = getInvoiceStatus($servicess->job_no);
													?>

												@if($jobcard == 1)
													<a href="{{ url('jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" disabled>{{ trans('app.Process Job')}}</button></a>
												@elseif($view_data == "Yes")
													<a href="{{ url('jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" disabled>{{ trans('app.Process Job')}}</button></a>
												@else
													<a href="{{ url('jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" >{{ trans('app.Process Job')}}</button></a>
												@endif

												{{-- @if(getAlreadypasss($servicess->job_no) == 0 && $view_data =='Yes')
													<a href="{!! url('/jobcard/gatepass/'.$servicess->id) !!}"><button type="button" class="btn btn-round btn-success" >{{ trans('app.Gate Pass')}}</button></a>

												@elseif($view_data =='No')
												<a href="{!! url('/jobcard/gatepass/'.$servicess->id) !!}"><button type="button" class="btn btn-round btn-success" disabled>{{ trans('app.Gate Pass')}}</button></a>

												@elseif(getAlreadypasss($servicess->job_no) == 1)
													<button type="button" data-toggle="modal" data-target="#myModal-gate"
													serviceid="" class="btn getgetpass btn-round btn-info" getid="{{ $servicess->job_no }}">{{ trans('app.Gate Receipt')}}</button>
												@endif --}}
											@elseif(getActiveEmployee($userid)=='yes')
												<?php
													$view_data = getInvoiceStatus($servicess->job_no);

													if($view_data == "Yes")
													{
													?>
															<button type="button" data-toggle="modal" data-target="#myModal-job" serviceid="{{ $servicess->id }}" url="{!! url('/jobcard/modalview') !!}" class="btn btn-round btn-info save">{{ trans('app.View Invoice')}} </button>
													<?php
													}
													else{
													?>
															<button type="button" data-toggle="modal" data-target="#myModal-job" serviceid="{{ $servicess->id }}" url="{!! url('/jobcard/modalview') !!}" class="btn btn-round btn-info save" disabled>{{ trans('app.View Invoice')}} </button>
													<?php
													}
													?>

													<?php  $jobcard = getJobcardStatus($servicess->job_no);
														$view_data = getInvoiceStatus($servicess->job_no);
													?>

												@if($jobcard == 1)
													<a href="{{ url('jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" disabled>{{ trans('app.Process Job')}}</button></a>
												@elseif($view_data == "Yes")
													<a href="{{ url('jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" disabled>{{ trans('app.Process Job')}}</button></a>
												@else
													<a href="{{ url('jobcard/list/'.$servicess->id)}}" ><button type="button" class="btn btn-round btn-success" >{{ trans('app.Process Job')}}</button></a>
												@endif
											@else
													<?php
												$view_data = getInvoiceStatus($servicess->job_no);

													if($view_data == "Yes")
													{
													?>
															<button type="button" data-toggle="modal" data-target="#myModal-job" serviceid="{{ $servicess->id }}" url="{!! url('/jobcard/modalview') !!}" class="btn btn-round btn-info save">{{ trans('app.View Invoice')}} </button>
													<?php
													}
													else{
													?>
															<button type="button" data-toggle="modal" data-target="#myModal-job" serviceid="{{ $servicess->id }}" url="{!! url('/jobcard/modalview') !!}" class="btn btn-round btn-info save" disabled>{{ trans('app.View Invoice')}} </button>
													<?php
													}
													?>
											@endif
											</td>
										</tr>
									<?php $i++; ?>
									@endforeach

								@endif
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

<script>
$(document).ready(function(){
	$('body').on('click', '.getgetpass', function() {
		var getid = $(this).attr('getid');
	 var url = "<?php echo url('/getpassdetail'); ?>";
		$.ajax({
			type:'GET',
			url:url,
			data:{getid:getid},
			success:function(response)
			{
				$('.modal-body').html(response.html);
			},
		});
	});
});
</script>

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

<!-- Gate Pass Script -->

<script  type="text/JavaScript">

		function PrintElem(elem)
			{
					Popup($(elem).html());
			}
			function Popup(data)
    {
        var mywindow = window.open('', 'Print Expense Invoice', 'height=600,width=1000');

        mywindow.document.write(data);


        mywindow.document.close();
        mywindow.focus();

        mywindow.print();
        mywindow.close();

        return true;
    }
</script>

<!-- End Of Gate Pass Script -->
<script type="text/JavaScript">

$( document ).ready(function(){
$('body').on('click', '.save', function() {

	  $('.modal-body').html("");

       var serviceid = $(this).attr("serviceid");

		var url = $(this).attr('url');


       $.ajax({
       type: 'GET',
       url: url,

       data : {serviceid:serviceid},
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
