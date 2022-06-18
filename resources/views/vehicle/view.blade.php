@extends('layouts.app')
@section('content')
<style>
.right_side .table_row, .member_right .table_row {
    border-bottom: 1px solid #dedede;
    float: left;
    width: 100%;
	padding: 1px 0px 4px 2px;
	
}
.member_right{border: 1px solid #dedede;
    margin-left: 9px;}
.table_row .table_td {
  padding: 8px 8px !important;
  
}
.report_title {
    float: left;
    font-size: 20px;
    margin-bottom: 10px;
    padding-top: 10px;
    width: 100%;
}
.b-detail__head-title {
    border-left: 4px solid #2A3F54;
    padding-left: 15px;
   text-transform: capitalize;
  
}

 .b-detail__head-price {
    width: 100%;
    float: right;
    text-align: center;
}
.b-detail__head-price-num {
   padding: 4px 34px;
    font: 700 23px 'PT Sans',sans-serif;
    
}

.thumb img{
  border-radius: 0px;
}


.item .thumb {
    width: 23%;
  cursor: pointer;
  float: left;
  border:1px solid;
 margin: 3px;
 
}
.item .thumb img {
  width: 100%;
  height: 80px;
}
.item img {
  width:435px;

}
.carousel-inner-1{
	margin-top: 16px;
}
.carousel-inner>.item>a>img, .carousel-inner>.item>img, .img-responsive, .thumbnail a>img, .thumbnail>img{height:300px; width:100%;}
.shiptitleright{
	float: right;
}
ul.bar_tabs>li.active { background:#fff !important;}

</style>
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Vehicles',$userid)=='yes')
	<div class="right_col" role="main">
		<div class="">
			<div class="page-title">
				<div class="nav_menu">
					<nav>
						<div class="nav toggle">
							<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Vehicle')}}	</span></a>
						</div>
						  @include('dashboard.profile')
					</nav>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12 col-sm-12 col-xs-12">
					<div class="x_content">
						<ul class="nav nav-tabs bar_tabs" role="tablist">
							<li role="presentation" class=""><a href="{!! url('/vehicle/list')!!}"><span class="visible-xs"></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Vehicle List')}}</a></li>
						
							<li role="presentation" class="active"><a href="{!! url('/vehicle/list/view/'.$view_id)!!}"><span class="visible-xs"></span><i class="fa fa-user">&nbsp; </i> <b>{{ trans('app.View Vehicle')}}</b></a></li>
						</ul>
					  <!--page conten -->
						<div class="row">
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="x_panel">
									<div id="carousel" class="carousel slide">
										<div class="carousel-inner">
										</div>
									</div>
									<div id="thumbcarousel" >
										<div class="carousel-inner-1">
										</div><!-- /carousel-inner -->
									</div> <!-- /thumbcarousel -->
								</div> 
							</div>
							<div class="col-md-6 col-sm-12 col-xs-12">
								<div class="x_panel">
									<span class="report_title">
										<span class="fa-stack cutomcircle">
											<i class="fa fa-align-left fa-stack-1x"></i>
										</span> 
										<span class="shiptitle" style="text-transform: capitalize;">{{ $vehical->modelname }}</span>		
												
										<span class="shiptitleright">(<?php echo getCurrencySymbols(); ?>) {{ $vehical->price }}</span>		
									</span>	
									<div class="col-md-12 col-sm-12 col-xs-12 member_right">					
										<div class="table_row">
											<div class="col-md-6 col-sm-6 col-xs-6 table_td">
												<b>{{ trans('app.Make :')}}</b>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-6 table_td">
												<span class="txt_color">{{ $vehical->modelname }}</span>
											</div>
										</div>					
										 <div class="table_row">
											<div class="col-md-6 col-sm-6 col-xs-6 table_td">
												<b>{{ trans('app.Vehicle Brand :')}}</b>
											</div>
											<div class="col-md-6 col-sm-6 col-xs-6 table_td">
												<span class="txt_color">{{ getVehicleBrands($vehical->vehiclebrand_id) }}</span>
											</div>
										</div>
										<div class="table_row">
											<div class="col-md-6 col-sm-6 col-xs-6 table_td">
												<b>{{ trans('app.Engine :')}}</b>				
											</div>
											<div class="col-md-6 col-sm-6 col-xs-6 table_td">
												<span class="txt_color"> {{ $vehical->engine }}</span>
											</div>
										</div>
										<div class="table_row">
											<div class="col-md-6 col-sm-6 col-xs-6 table_td">
												 <b>{{ trans('app.Model Year :')}}</b>			
											</div>
											<div class="col-md-6 col-sm-6 col-xs-6 table_td">
												<span class="txt_color">{{ $vehical->modelyear }}</span>
											</div>
										</div>
										<div class="table_row">
											<div class="col-md-6 col-sm-6 col-xs-6 table_td">
												<b> <b>{{ trans('app.Color :')}}</b></b>							
											</div>
											<div class="col-md-6 col-sm-6 col-xs-6 table_td">
											@if(!empty($col))
												@foreach($col as $colo)
												<div class="col-md-12 col-sm-6 col-xs-6 table_td">
													<style>
														.box_color
														{
														  width:40px;
														  height:20px;
														  float: left;
														  margin: 0px 0px 3px 0px;
														}
													</style>
													<span class="box_color txt_color" style=" background-color:<?php echo getColourCode($colo->color) ?>"></span>
												</div>
												@endforeach
											@endif
											</div>
										</div>
									</div>
								</div>
							</div> 
						</div>
			<!-- end  slider -->
						<div class="row">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="x_content">
									<ul class="nav nav-tabs bar_tabs" role="tablist" id="myTab">
										<li class="active"><a href="#tab_content1"  data-toggle="tab"></i> {{ trans('app.Basic Detail')}}</a></li>
										<li class=""><a href="#tab_content2"  data-toggle="tab" > {{ trans('app.Description')}}</a></li>
									</ul>
										<div class="row">
											<div class="col-md-12 col-sm-12 col-xs-12">
												<div class="x_panel">
													<div class="tab-content">
														@if(!empty($desription))
														   <div  class="tab-pane fade " id="tab_content2" style="min-height: 320px;" >
																<div class="row">
																   @foreach($desription as $desriptions)
																		<div class="col-md-12 col-sm-12 col-xs-12">
																			{{ $desriptions->vehicle_description }}
																		</div>
																   @endforeach
																</div>
															</div>
														@endif
														<div  class="tab-pane fade active in" id="tab_content1" >
															<div class="col-md-12 col-sm-12 col-xs-12">
																<span class="report_title">
																	<span class="fa-stack cutomcircle">
																		<i class="fa fa-align-left fa-stack-1x"></i>
																	</span> 
																	<span class="shiptitle">{{ trans('app.Basic Details')}}</span>
																</span>
																	<div class="col-md-5 col-sm-12 col-xs-12 member_right" style="border: 1px solid #dedede; margin-left:9px;">
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<b>{{ trans('app.Vehicle Name :')}}</b>
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color"> {{ $vehical->modelname }}</span>
																			</div>
																		</div>					
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<b>{{ trans('app.Vehicle Type')}} :</b>
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color"> {{ getVehicleType($vehical->vehicletype_id) }}</span>
																			</div>
																		</div>
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				  <b>{{ trans('app.Chasic No :')}}</b>				
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color"> {{ $vehical->chassisno}}</span>
																			</div>
																		</div>
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				 <b>{{ trans('app.Fuel type :')}}</b>			
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color">{{ getFuelType($vehical->fuel_id) }} </span>
																			</div>
																		</div>
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				 <b>{{ trans('app.No of Gears:')}}</b>							
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color"> {{ $vehical->nogears }}</span>
																			</div>
																		</div>
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				 <b>{{ trans('app.Odometer Reading  :')}}</b>			
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color"> {{$vehical->odometerreading }}</span>
																			</div>
																		</div>
																	</div> 
																	<div class="col-md-5 col-sm-12 col-xs-12 member_right" >
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				 <b>{{ trans('app.Date Of Manufacturing:')}}</b>
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color"> {{ date(getDateFormat(),strtotime($vehical->dom)) }}</span>
																			</div>
																		</div>					
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<b>{{ trans('app.Gear Box:')}}</b>
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color"> {{ $vehical->gearbox }}</span>
																			</div>
																		</div>
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				  <b>{{ trans('app.Gear Box No :')}}</b>			
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color">{{ $vehical->gearboxno }}</span>
																			</div>
																		</div>
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<b>{{ trans('Fuel Reading:')}}</b>			
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color">{{ $vehical->engineno }}</span>
																			</div>
																		</div>
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				 <b>{{ trans('app.Engine Size:')}}</b>							
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color"> {{ $vehical->enginesize }}</span>
																			</div>
																		</div>
																		<div class="table_row">
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				  <b>{{ trans('Number Plate :')}}</b>			
																			</div>
																			<div class="col-md-6 col-sm-6 col-xs-6 table_td">
																				<span class="txt_color"> {{ $vehical->keyno }}</span>
																			</div>
																		</div>
																	</div> 
															</div>
														</div>
													</div>
											   </div>
											</div>
										</div>
								</div> 
							</div>
						</div>
					</div>
				</div>
			</div> 
		</div>
	</div>
@else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
              <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
              </div>
        </div>
	</div>
@endif   
			
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
 <script>
$(document).ready(function(){  
 var m = <?php echo $available; ?>;
  
  for(var i=0 ; i< m.length ; i++) {
    $('<div class="item"><img src="'+m[i]+'"><div class="carousel-caption"></div>   </div>').appendTo('.carousel-inner');
	 $('<div class="item"> <div data-target="#carousel" data-slide-to="'+i+'" class="thumb"><img src="'+m[i]+'"></div></div>').appendTo('.carousel-inner-1');
    $('<li data-target="#carousel-example-generic" data-slide-to="'+i+'"></li>').appendTo('.carousel-indicators')

  }
  $('#thumbcarousel .item').first().addClass('active');
  $('.item').first().addClass('active');
  $('.carousel-indicators > li').first().addClass('active');
  $('#carousel-example-generic').carousel();
});
</script>
@endsection