@extends('layouts.app')
@section('content')
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Reports',$userid)=='yes')

<script src="{{ URL::asset('js/jquery.min.js') }}"></script>

<?php include("vendors/chart/GoogleCharts.class.php"); ?>
<?php
$options = Array(
			'title' => $title_report,
			'titleTextStyle' => Array('color' => '#73879C','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'"Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif'),
			'legend' =>Array('position' => 'right',
					'textStyle'=> Array('color' => '#73879C','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'"Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif')),
				
			'hAxis' => Array(
					'title' => $date_report,
					'titleTextStyle' => Array('color' => '#73879C','fontSize' => 14,'bold'=>true,'italic'=>false,'fontName' =>'"Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif'),
					'textStyle' => Array('color' => '#73879C','fontSize' => 14),
					'maxAlternation' =>2,
					
			),
			'vAxis' => Array(
					'title' => $title,
				    'minValue' => 0,
					'maxValue' => 4,
					'width'=> 100,
				 'format' => '#',
					'titleTextStyle' => Array('color' => '#73879C','fontSize' => 16,'bold'=>true,'italic'=>false,'fontName' =>'"Helvetica Neue",Roboto,Arial,"Droid Sans",sans-serif'),
					'textStyle' => Array('color' => '#73879C','fontSize' => 12)
			),
			 'colors'=>array(
				'#26b99a'
				),
			'bar' =>array(
				'groupWidth'=>'100'
				),
	);
foreach($product as $data)
{
	$datas = $data->counts;
}
	
	
$GoogleCharts = new GoogleCharts;
$chart_array=array();
		$chart_array[] = array('date','counts');
		foreach($product as $products)
			{
				
				$chart_array[] = array($products->date,(int)$products->counts);
			}
			
$chart = $GoogleCharts->load('column','product_report')->get($chart_array,$options);
	
?>
	
<style>
body .top_nav .right_col.servi{
	min-height: 1150px!important;
}
</style>
<div class="right_col servi" role="main">
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
			
			<li class="active suppo_llng_li_add floattab"><a href="{!! url('/report/productreport') !!}" class="anchor_tag anchr"><i class="fa fa-product-hunt" aria-hidden="true"></i> <b>{{ trans('app.Product Stock')}}</b> </a></li>
			
			<li class="suppo_llng_li_add floattab"><a href="{!! url('/report/productuses') !!}" class="anchor_tag anchr"><i class="fa fa-product-hunt" aria-hidden="true"></i> {{ trans('app.Product Usage')}} </a></li>
			
			<li class="suppo_llng_li_add floattab"><a href="{!! url('/report/servicebyemployee') !!}" class="anchor_tag anchr"><i class="fa fa-slack image_icon"> </i> {{ trans('app.Emp. Services')}}</a></li>
		</ul>
	</div>
	
	<div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_content">
                    <form method="post" action="{!! url('/report/record_product') !!}" enctype="multipart/form-data"  class="form-horizontal upperform">
					<!--
						<div class="col-md-6 col-sm-6 col-xs-12 form-group {{ $errors->has('start_date') ? ' has-error' : '' }}">
							<label class="control-label col-md-3 col-sm-5 col-xs-12" for="Country">{{ trans('app.Strat Date')}} <label class="text-danger">*</label>
							</label>
							<div class="col-md-9 col-sm-7 col-xs-12 input-group date start_date" id="start_dates">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
							  
							 <input type="text" name="start_date" id="start_date" class="form-control" value="<?php if(!empty($s_date)) { echo date(getDateFormat(),strtotime($s_date));}else{ echo old('start_date'); }?>"  placeholder="<?php echo getDatepicker();?>" required/>
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
							  
							 <input type="text" name="end_date" id="end_date" class="form-control" value="<?php if(!empty($e_date)) { echo date(getDateFormat(),strtotime($e_date));}else{ echo old('end_date'); }?>"  placeholder="<?php echo getDatepicker();?>" required/>
							</div>
							@if ($errors->has('end_date'))
									<span class="help-block denger" style="margin-left: 27%;">
										<strong>{{ $errors->first('end_date') }}</strong>
									</span>
								@endif
						</div>   
                     -->     
						<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
						   <label class="control-label col-md-3 col-sm-5 col-xs-12"  for="option">{{ trans('app.Manufacturer Name')}} <label class="text-danger">*</label> </label>
							<div class="col-md-9 col-sm-7 col-xs-12">
								<select class="form-control select_producttype" name="s_product" m_url="{!! url('/report/producttype/name') !!}" required>
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
						   <label class="control-label col-md-3 col-sm-5 col-xs-12"  for="option">{{ trans('app.Product Name')}} <label class="text-danger">*</label> </label>
							<div class="col-md-9 col-sm-7 col-xs-12">
								<select class="form-control select_productname" name="product_name" required>
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
								<!-- <button type="button" onclick="myFunction()" class="btn btn-success" id="chartshow">{{ trans('app.View Chart')}}</button> -->
							</div>
						</div>

					</form>
                </div>
            </div>
        </div>
    </div>
	
	@if(!empty($datas))
	 <div class="row">
		<div id="chartdiv" style="visibility:hidden;height:0;float:left;width:100%;">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel tab_bottom">
					<div id="product_report"></div>
				</div>
			</div>
		</div>
	</div>
	
	@endif
		 <script type="text/javascript" src="https://www.google.com/jsapi"></script> 
					<script type="text/javascript">
						<?php if(!empty($chart)) {echo $chart; }?>
					</script>
	
	<div class="row" >
        <div class="col-md-12 col-sm-12 col-xs-12">
		
			 <div class="x_panel table_up_div">
                  <table id="datatable" class="table table-striped jambo_table" style="margin-top:20px; width:100%;">
                      <thead>
                        <tr>
							<th>#</th>
							<th>{{ trans('app.Purchase Number')}}</th>
							<th>{{ trans('app.Product Number')}}</th>
							<th>{{ trans('app.Manufacturer Name')}}</th>
							<th>{{ trans('app.Product Name')}}</th>
							<th>{{ trans('app.Purchase Date')}}</th>
							<th>{{ trans('app.Supplier Name')}}</th>
							<th>{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
							<th>{{ trans('app.Stock')}} </th>
                        </tr>
                      </thead>


                      <tbody>
					  <?php $i = 1; ?>   
						@if(!empty($productreport))
						@foreach($productreport as $productreports)
						
                        <tr>
							<td>{{ $i }}</td>
							<td>
								<a href="{!! url('/purchase/list/pview/'.$productreports->purchase_id)!!}">
									{{	getPurchaseCode($productreports->purchase_id) }}
								</a>
							</td>
							
							<td> 
								<a href="{!! url('/product/list/'.$productreports->id)!!}" >
								{{	$productreports->product_no }}
								</a>
							</td>
							<td>{{	getProductName($productreports->product_type_id) }}</td>
							<td>{{	$productreports->name }}</td>
							<td>{{	 date(getDateFormat(),strtotime(getPurchaseDate($productreports->purchase_id))) }}</td>
							<td>{{	getSupplierName(getPurchaseSupplier($productreports->purchase_id)) }}</td>
							<td>{{	$productreports->price }}</td>
							<td>{{ getTotalStock($productreports->id) }}</td>
							
							
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>

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
		}).on('changeDate', function (selected) {
			var startDate = new Date(selected.date.valueOf());
		
			$('.end_date').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
			
			}).datetimepicker('setStartDate', startDate); 
		})
		.on('clearDate', function (selected) {
			 $('.end_date').datetimepicker('setStartDate', null);
		})
		
			$('.end_date').click(function(){
				
			var date = $('#start_date').val(); 
			if(date == '')
			{
				swal('First Select Strat Date');
			}
			else{
				$('.end_date').datetimepicker({
				format: "<?php echo getDatepicker(); ?>",
				 minView: 2,
				autoclose: 1,
				})
				
			}
			});
	});	
	function myFunction() {
				var x = document.getElementById("chartdiv");
				if (x.style.visibility === "hidden") {
					x.style.visibility = "inherit";
					x.style.height = "auto";
					x.style.float = "left";
					x.style.width = "100%";
					
				} else {
					x.style.visibility = "hidden";
					x.style.height = "0";
					x.style.float = "left";
					x.style.width = "100%";
				}
			}
</script> 
@endsection