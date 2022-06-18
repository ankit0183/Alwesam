@extends('layouts.app')
@section('content')
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Reports',$userid)=='yes')


<style>
body .top_nav .right_col.servi{
	min-height: 1150px!important;
}
</style>
<div class="right_col servi" role="main">

	<div id="stockview" class="modal fade" role="dialog">
			<div class="modal-dialog modal-lg">
		<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header"> 
						<button type="button" data-dismiss="modal" class="close" >&times;</button>
						<h4 id="myLargeModalLabel" class="modal-title">{{ trans('app.Stock History')}}</h4>
						
					</div>
					<div class="modal-body">
					
					</div>
				</div>
			</div>
	</div>
	<div class="page-title">
        <div class="nav_menu">
		<nav>
			<div class="nav toggle">
				<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Report')}}</span></a>
			</div>
			@include('dashboard.profile')
        </nav>
        </div>
    </div>
	
	<div class="x_content">
        <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
			<li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('/report/salesreport')!!}" class="anchor_tag "><span class="visible-xs"></span><i class="fa fa-tty image_icon"> </i> {{ trans('app.Vehicle Sales')}} </a></li>
			
            <li class="suppo_llng_li_add floattab"><a href="{!! url('/report/servicereport') !!}" class="anchor_tag anchr"><i class="fa fa-slack image_icon"> </i> {{ trans('app.Services')}} </a></li>
			
			<li class="suppo_llng_li_add floattab"><a href="{!! url('/report/productreport') !!}" class="anchor_tag anchr"><i class="fa fa-product-hunt" aria-hidden="true"></i> {{ trans('app.Product Stock')}} </a></li>
			
			<li class="active suppo_llng_li_add floattab"><a href="{!! url('/report/productuses') !!}" class="anchor_tag anchr"><i class="fa fa-product-hunt" aria-hidden="true"></i> <b>{{ trans('app.Product Usage')}}</b> </a></li>
			
			<li class="suppo_llng_li_add floattab"><a href="{!! url('/report/servicebyemployee') !!}" class="anchor_tag anchr"><i class="fa fa-slack image_icon"> </i> {{ trans('app.Emp. Services')}}</a></li>
		</ul>
	</div>
	
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <form method="post" action="{!! url('/report/uses_product') !!}" enctype="multipart/form-data"  class="form-horizontal upperform">
						<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-5 col-xs-12" for="Country">{{ trans('app.Start Date')}} <label class="text-danger">*</label>
							</label>
							<div class="col-md-9 col-sm-7 col-xs-12 input-group date start_date" id="start_dates">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							  
							 <input type="text" name="start_date" id="start_date" class="form-control" value="<?php if(!empty($s_date)) { echo date(getDateFormat(),strtotime($s_date));}else{ echo old('start_date'); }?>"  placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required />
							</div>
							@if ($errors->has('start_date'))
									<span class="help-block denger" style="margin-left: 27%;">
										<strong>{{ $errors->first('start_date') }}</strong>
									</span>
								@endif
						</div>
					  
						<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('end_date') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-5 col-xs-12" for="Country">{{ trans('app.End Date')}} <label class="text-danger">*</label>
							</label>
							<div class="col-md-9 col-sm-7 col-xs-12 input-group date end_date">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							  
							 <input type="text" name="end_date" id="end_date" class="form-control" value="<?php if(!empty($e_date)) { echo date(getDateFormat(),strtotime($e_date));}else{ echo old('end_date'); }?>"  placeholder="<?php echo getDatepicker();?>" onkeypress="return false;" required/>
							</div>
							@if ($errors->has('end_date'))
									<span class="help-block denger" style="margin-left: 27%;">
										<strong>{{ $errors->first('end_date') }}</strong>
									</span>
								@endif
						</div>   
                          
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						   <label class="control-label col-md-3 col-sm-5 col-xs-12"  for="option">{{ trans('app.Manufacturer Name')}} </label>
							<div class="col-md-9 col-sm-7 col-xs-12">
								<select class="form-control select_producttype" name="m_product" m_url="{!! url('/report/producttype/name') !!}">
									<option value="all"<?php if($all_product=='all'){ echo 'selected'; } ?>>{{ trans('app.All')}}</option>
									@if(!empty($Select_product))
									@foreach ($Select_product as $Select_products)
									 <option value="{{ $Select_products->id }}" <?php if($Select_products->id == $all_product) { echo  'selected'; } ?>>{{ $Select_products->type }}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div> 
						
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						   <label class="control-label col-md-3 col-sm-5 col-xs-12"  for="option">{{ trans('app.Product Name')}} </label>
							<div class="col-md-9 col-sm-7 col-xs-12">
								<select class="form-control select_productname" name="product_name">
									<option value="item"<?php if($all_item=='item'){ echo 'selected'; } ?>>{{ trans('app.Items')}}</option>
									@if(!empty($productname))
									@foreach ($productname as $productreports)
									 <option value="{{ $productreports->id }}" <?php if($productreports->id == $all_item) { echo  'selected'; } ?>>{{ $productreports->name }}</option>
									@endforeach
									@endif
								</select>
							</div>
						</div> 
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<div class="form-group">
							<div class="col-md-10 col-sm-6 col-xs-12 col-md-offset-2 text-right">
								<button type="submit" class="btn btn-success">{{ trans('app.Go')}}</button>
								
							</div>
						</div>
					</form>
                </div>
            </div>
        </div>
    </div>
	<div class="row" >
        <div class="col-md-12 col-sm-12 col-xs-12">
		
			<div class="x_panel table_up_div">
                <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px; width:100%;">
                    <thead>
                        <tr>
							<th>#</th>
							<th>{{ trans('app.Product Number')}}</th>
							<th>{{ trans('app.Manufacturer Name')}}</th>
							<th>{{ trans('app.Product Name')}}</th>
						   <!-- <th>{{ trans('app.Date')}}</th> -->
							<th>{{ trans('app.Total Stock')}}</th>
							<th>{{ trans('app.Product Sales')}}</th>
						    <!--<th>{{ trans('app.Current Stock')}} </th> -->
							<th>{{ trans('app.Action')}} </th>
                        </tr>
                    </thead>
                    <tbody>
					  <?php $i = 1; ?>   
						@if(!empty($productreport))
						@foreach($productreport as $productreports)
						
                        <tr>
							<td>{{ $i }}</td>
							<td>{{	$productreports->product_no }}</td>
							<td>{{	getProductName($productreports->product_type_id) }}</td>
							<td>{{	$productreports->name }}</td>
							<!--<td>{{	 date(getDateFormat(),strtotime(getPurchaseDate($productreports->purchase_id))) }}</td> -->
							<td>{{	getTotalProduct($productreports->id,$s_date,$e_date) }}</td>
							@if($productreports->category == 0)
								<td>{{	getCellProduct($productreports->id,$s_date,$e_date) }}</td>
							@else
								<td>{{	getCellProductSale($productreports->id,$s_date,$e_date) }}</td>
							@endif
							<!--<td>{{	getStockProduct($productreports->id,$s_date,$e_date) }}</td> -->
							@if($productreports->category == 0)
								<td><button type="button" data-toggle="modal" data-target="#stockview" productid="{{$productreports->product_id}}" s_date="{{$s_date}}" e_date="{{$e_date}}" url="{!! url('/report/stock/modalview') !!}" class="btn btn-round btn-info stocksave">{{ trans('app.View')}}</button></td>
							@else
								<td><button type="button" data-toggle="modal" data-target="#stockview" productid="{{$productreports->product_id}}" s_date="{{$s_date}}" e_date="{{$e_date}}" url="{!! url('/report/stock/modalviewPart') !!}" class="btn btn-round btn-info stocksave">{{ trans('app.View')}}</button></td>
							@endif
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

	$('.select_producttype').change(function(){
		var m_id = $(this).val();
		
		var url = $(this).attr('m_url');

		$.ajax({
			type:'GET',
			url: url,
			data:{ m_id:m_id },
			success:function(response){
				$('.select_productname').html(response);
			}
		});
	});
});

</script>   
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

<!-- datetimepicker-->
<script>
$(document).ready(function(){

	$(".start_date,.input-group-addon").click(function(){	
		var dateend = $('#end_date').val('');
	});
	
	$(".start_date").datetimepicker({
		format: "<?php echo getDatepicker(); ?>",
		minView: 2,
		autoclose: 1,
	}).on('changeDate', function (selected){
		var startDate = new Date(selected.date.valueOf());
		$('.end_date').datetimepicker({
			format: "<?php echo getDatepicker(); ?>",
			minView: 2,
			autoclose: 1,
		}).datetimepicker('setStartDate', startDate); 
	})
	.on('clearDate', function (selected){
		$('.end_date').datetimepicker('setStartDate', null);
	})
	
	$('.end_date').click(function(){
		var date = $('#start_date').val(); 
		if(date == '')
		{
			swal('First Select Start Date');
		}
		else
		{
			$('.end_date').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				minView: 2,
				autoclose: 1,
			})
		}
	});
});	

$( document ).ready(function(){
	$('body').on('click', '.stocksave', function() {	  
		$('.modal-body').html("");
		var productid = $(this).attr("productid");
		var s_date = $(this).attr("s_date");
		var e_date = $(this).attr("e_date");
		var url = $(this).attr('url');
		$.ajax({
			type: 'GET',
			url: url,
			data : {productid:productid,s_date:s_date,e_date:e_date},
			success: function (data)
			{            
				$('.modal-body').html(data.html);
			},
			beforeSend:function()
			{
				$(".modal-body").html("<center><h2 class=text-muted><b>Loading...</b></h2></center>");
			},
			error: function(e) 
			{
				alert("An error occurred: " + e.responseText);
				console.log(e);	
			}
		});
    });
});
</script> 	      
@endsection