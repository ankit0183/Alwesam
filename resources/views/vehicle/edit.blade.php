@extends('layouts.app')

@section('content')
<style>
.removeimage{float:left;    padding: 5px; height: 70px;}
.removeimage .text {
position:relative;
bottom: 45px;
display:block;
left: 20px;
font-size:18px;
color:red;
visibility:hidden;
}
.removeimage:hover .text {
visibility:visible;
}
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Vehicles',$userid)=='yes')
	 @if(getActiveCustomer($userid)=='yes' || getActiveEmployee($userid)=='yes')
	
	<div class="right_col" role="main">
		<div class="page-title">
			 <div class="nav_menu">
				<nav>
				  <div class="nav toggle">
					<a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Vehicle')}}</span></a>
				  </div>
					  @include('dashboard.profile')
				</nav>
			</div>
		</div>
		<div class="x_content">
			<ul class="nav nav-tabs bar_tabs" role="tablist">
				<li role="presentation" class=""><a href="{!! url('/vehicle/list')!!}"><span class="visible-xs"></span> <i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.Vehicle List')}}</span></a></li>
				
				<li role="presentation" class="active"><a href="{!! url('/vehicle/list/edit/'.$editid)!!}"><span class="visible-xs"></span> <i class="fa fa-pencil-square-o" aria-hidden="true">&nbsp;</i><b>{{ trans('app.Edit Vehicle')}}</b></a></li>
			</ul>
		</div>
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">
				<div class="x_panel">
					<div class="x_content">
						<form  action="update/{{$vehicaledit->id }}" method="post" enctype="multipart/form-data"  class="form-horizontal upperform">
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Vehicle Type')}} <label class="text-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<select class="form-control select_vehicaltype" name="vehical_id"
										 vehicalurl="{!! url('/vehicle/vehicaltypefrombrand') !!}">
											<option value="">{{ trans('app.Select Vehicle Type')}}</option>
												@if(!empty($vehical_type))
													@foreach($vehical_type as $vehical_types)
														<option value="{{ $vehical_types->id }}" <?php if($vehical_types->id == $vehicaledit->vehicletype_id) {echo 'selected'; }?>>{{ $vehical_types->vehicle_type }}</option>	
													@endforeach
												@endif
										</select> 
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Chasic No')}} <label class="text-danger">*</label> </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="chasicno"  value="{{ $vehicaledit->chassisno }}" placeholder="{{ trans('app.Enter ChasicNo')}}" maxlength="30"  class="form-control" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Vehicle Brand')}} <label class="text-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<select class="form-control   select_vehicalbrand" name="vehicabrand" >

														<option value="">{{ trans('app.Select Vehicle Brand')}}</option>
												  @if(!empty($vehical_brand))
													@foreach($vehical_brand as $vehical_brands)
														<option value="{{ $vehical_brands->id }}" <?php if($vehical_brands->id==$vehicaledit->vehiclebrand_id) { echo "selected"; }?>>{{ $vehical_brands->vehicle_brand }}</option>
													@endforeach
												@endif 
												  </select> 
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-brand" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('Year Of Manufacture(YOM)')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12 input-group date" id="myDatepicker2" >
										<span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
										<input type="text"  name="modelyear" value="{{ $vehicaledit->modelyear }}"  class="form-control" readonly   />
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Fuel Type')}} <label class="text-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
										<select class="form-control select_fueltype " name="fueltype" >
											<option value="">{{ trans('app.Select fuel type')}}</option>
										@if(!empty($fueltype))
											@foreach($fueltype as $fueltypes)
												<option value="{{ $fueltypes->id }}"<?php if($fueltypes->id == $vehicaledit->fuel_id){ echo"selected"; } ?>> {{ $fueltypes->fuel_type }}</option>
											@endforeach
										@endif 
										</select> 
									</div>
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-fuel" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.No of Grear')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearno"  value="{{ $vehicaledit->nogears }}" placeholder="{{ trans('app.Enter No of Gear')}}" maxlength="30" class="form-control" >
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Model Name')}} <label class="text-danger">*</label></label>
									<div class="col-md-2 col-sm-2 col-xs-12">
									
										<select class="form-control model_addname" name="modelname" required>
											<option value="{{ $vehicaledit->modelname }}">{{ $vehicaledit->modelname }}</option>
										@if(!empty($model_name))
											@foreach ($model_name as $model_names)
											<option value="{{ $model_names->model_name }}">{{ $model_names->model_name }}</option>
											@endforeach
										@endif
										</select>
									</div>
									
									<div class="col-md-2 col-sm-2 col-xs-12 addremove">
										<button type="button" class="btn btn-default" data-target="#responsive-modal-vehi-model" data-toggle="modal">{{ trans('app.Add Or Remove')}}</button>
									</div>
								</div>
								<div class="{{ $errors->has('price') ? ' has-error' : '' }}">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>) </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="price"  value="{{ $vehicaledit->price }}" placeholder="{{ trans('app.Enter Price')}}" maxlength="10"  class="form-control" >
										@if ($errors->has('price'))
										   <span class="help-block">
											   <strong>{{ $errors->first('price') }}</strong>
										   </span>
										@endif
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="{{ $errors->has('odometerreading') ? ' has-error' : '' }}">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Odometer Reading')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="odometerreading"  
										value="{{ $vehicaledit->odometerreading }}" placeholder="{{ trans('app.Enter OdometerReading')}}"  class="form-control" maxlength="30" >
										@if ($errors->has('odometerreading'))
										   <span class="help-block">
											   <strong>{{ $errors->first('odometerreading') }}</strong>
										   </span>
									   @endif
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Gear Box')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearbox"  value="{{ $vehicaledit->gearbox }}" placeholder="{{ trans('app.Enter Grear Box')}}" maxlength="20" class="form-control" >
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Gear Box No')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="gearboxno"  value="{{  $vehicaledit->gearboxno }}" placeholder="{{ trans('app.Enter Gearbox No')}}" maxlength="20" class="form-control" >
									</div>
								</div>
							</div>
							
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('Fuel Reading')}}  <label class="text-danger">*</label></label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="engineno"  value="{{ $vehicaledit->engineno }}" placeholder="{{ trans('app.Enter Fuel Reading')}}" maxlength="30"  class="form-control" required>
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="last-name">{{ trans('app.Engine Size')}} 	</label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="enginesize"  value="{{ $vehicaledit->enginesize }}" placeholder="{{ trans('app.Enter Engine Size')}}" maxlength="30" class="form-control" >
									</div>
								</div>
							</div>
							<div class="form-group">
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('Plate Code')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="keyno"  value="{{ $vehicaledit->keyno }}" placeholder="{{ trans('Enter Plate Code')}}" maxlength="30" class="form-control" >
									</div>
								</div>
								<div class="">
									<label class="control-label col-md-2 col-sm-2 col-xs-12" for="first-name">{{ trans('app.Engine')}} </label>
									<div class="col-md-4 col-sm-4 col-xs-12">
										<input type="text"  name="engine"  value="{{ $vehicaledit->engine }}" placeholder="{{ trans('app.Enter Engine')}}" maxlength="30" class="form-control" >
									</div>
								</div>
							</div>
							<div class=" col-md-12 col-sm-12 col-xs-12 form-group" style="padding:5px 0px 5px 0px">
							</div>
						<div class="form-group">
			<!-- Vehical images  -->
							<div class="col-md-6 col-sm-12 col-xs-12 form-group">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<h2>{{ trans('app.Vehicle Images')}}</h2>
									<span> <h5 style="margin-left: 10px;"> {{ trans('app.Select Multiple Images')}} </h5> </span>
								</div>
								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<input type="file"   name="image[]"   class="form-control imageclass" data-max-file-size="5M" id="images" onchange="preview_images();" multiple >
										
										<div class="row" id="image_preview">
											@if(!empty($images1))
												@foreach($images1 as $images2)
														<div class="col-md-4 col-sm-4 col-xs-12 removeimage delete_image" id="image_remove_<?php echo $images2->id; ?>"  imgaeid="{{$images2->id}}" delete_image="{!! url('vehicle/delete/getImages')!!}">
															<a href=""><img src="{{ url('public/vehicle/'.$images2->image) }}"  width="100px" height="60px"> 
															<p class="text">{{ trans('app.Remove')}}</p> </a>
														</div>
												@endforeach
											@endif
										</div>
								</div>
							</div>
						
				<!--vehical color-->
							<div class="col-md-6 col-sm-12 col-xs-12 form-group" style="padding-right:0px;">
								<div class="col-md-6 col-sm-6 col-xs-6" style="padding-left:0px;">
									<h2>{{ trans('app.Vehicle Color')}} </h2></span>
								</div>
								<div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom: 33px;">
									<button type="button" id="add_new_color" class="btn btn-default newadd" url="{!! url('vehicle/add/getcolor')!!}">{{ trans('app.Add New')}}
									</button>
								</div>
								<div class="form-group col-md-12 col-sm-12 col-xs-12" style="padding-bottom:5px">
									<table class="table table-bordered addtaxtype"  id="tab_color" align="center">
										<thead>
											<tr>
												<th class="all">{{ trans('app.Colors')}}</th>
												<th>{{ trans('app.Action')}}</th>
											</tr>
										</thead>			
										<tbody>
										@if(!empty($colors1))
											@foreach ($colors1 as $item)
												<tr id="color_id_{{ $item->id }}">
													<td>
														<select name="color[]" class="form-control color" id="tax_{{ $item->id }}" data-id="1" >
															<option value="0">{{ trans('app.Select Color')}}</option>
															@if(!empty($color))
																@foreach($color as $colors)
																	<option value="{{ $colors->id }}"
																	<?php if($colors->id == ($item->color)){ echo"selected"; } ?>>{{ $colors->color }}</option>
																@endforeach
															@endif
														</select>
													</td>
													<td>
														<span class="remove_color" data-id="{{ $item->id }}" colordelete="{!! url('vehicle/delete/getcolor')!!}"><i class="fa fa-trash"></i> {{ trans('app.Delete')}}</span>
													</td>
												</tr>
											@endforeach
										@endif
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="form-group">	
		 <!-- Vehical Description  -->
							<div class="col-md-6 col-sm-12 col-xs-12 form-group">
								<div class="col-md-6 col-sm-6 col-xs-6">
									<h2>{{ trans('app.Vehicle Description')}} </h2>
								</div> 
								<div class="col-md-6 col-sm-6 col-xs-6" style="padding-bottom: 33px;">
									<button type="button" id="add_new_description" class="btn btn-default newadd" url="{!! url('vehicle/add/getDescription')!!}">{{ trans('app.Add New')}} </button>
								</div>
								<div class="form-group col-md-12 col-sm-12 col-xs-12">
									<table class="table table-bordered addtaxtype"  id="tab_decription_detail" align="center">
										<thead>
											<tr>
												<th class="all">{{ trans('app.Description')}}</th>
												<th>{{ trans('app.Action')}}</th>
											</tr>
										</thead>			
										<tbody>
											 @if(!empty($vehicaldes))
												@foreach ($vehicaldes as $vehicaldess)
													<tr id="row_id_{{ $vehicaldess->id }}">
														<td>
															<textarea name="description[]" class="form-control"  id="tax_{{ $vehicaldess->id }}" maxlength="100">{{ $vehicaldess->vehicle_description }}</textarea>
														</td>
														<td>
															<span class="delete_description" data-id="{{ $vehicaldess->id }}" delete_description="{!! url('vehicle/delete/getDescription')!!}"><i class="fa fa-trash"></i> {{ trans('app.Delete')}}</span>
														</td>
													</tr>
												@endforeach
											@endif
										</tbody>
									</table>
								</div>					
							</div>
						</div>
							<input type="hidden" name="_token" value="{{csrf_token()}}">
							<div class="form-group col-md-12 col-sm-12 col-xs-12">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<a class="btn btn-primary" href="{{ URL::previous() }}">{{ trans('app.Cancel')}}</a>
									<button type="submit" class="btn btn-success">{{ trans('app.Update')}}</button>
								</div>
							</div>
						</form>
					</div>
					
		   <!-- Vehical Type  -->
					<div class="col-md-6">
						<div id="responsive-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title"> {{ trans('app.Add Vehicle Type')}}</h4>
									</div>
									<div class="modal-body">
										<form class="form-horizontal formaction" action="" method="">
											<table class="table vehical_type_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Vehicle Type')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
													@if(!empty($vehical_type))
													@foreach ($vehical_type as $vehical_types)
													<tr class="del-{{ $vehical_types->id }} data_of_type" >
													<td class="text-center ">{{ $vehical_types->vehicle_type }}</td>
													<td class="text-center">
													
													<button type="button" vehicletypeid="{{ $vehical_types->id }}" 
													deletevehical="{!! url('/vehicle/vehicaltypedelete') !!}" class="btn btn-danger btn-xs deletevehicletype">X</button>
													</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Vehicle Type:')}} <span class="text-danger">*</span></label>
												<input type="text" class="form-control vehical_type" name="vehical_type" id="vehical_type" placeholder="Enter Vehical Type" maxlength="20" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												
												<button type="button" class="btn btn-success vehicaltypeadd" 
												url="{!! url('/vehicle/vehicle_type_add') !!}" >{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
			 <!-- End  Vehical Type  -->
			
			<!-- Vehical Brand -->	
					<div class="col-md-6">
						<div id="responsive-modal-brand" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Add Vehicle Brand')}}</h4>
									</div>
									<div class="modal-body">
									    <form class="form-horizontal" action="" method="">
											<table class="table vehical_brand_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Vehicle Brand')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
													@if(!empty($vehical_brand))
													@foreach ($vehical_brand as $vehical_brands)
													<tr class="del-{{ $vehical_brands->id }} data_of_type" >
													<td class="text-center ">{{ $vehical_brands->vehicle_brand }}</td>
													<td class="text-center">
													
													<button type="button" brandid="{{ $vehical_brands->id }}" 
													deletevehicalbrand="{!! url('/vehicle/vehicalbranddelete') !!}" class="btn btn-danger btn-xs deletevehiclebrands">X</button>
													</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
												<div class="col-md-8 form-group data_popup">
													<label>{{ trans('app.Vehicle Type:')}} <span class="text-danger">*</span></label>
														<select class="form-control  vehical_id" name="vehical_id" vehicalurl="{!! url('/vehicle/vehicalformtype') !!}">
															<option value="">{{ trans('app.Select Vehicle Type')}}</option>
															@if(!empty($vehical_type))
																@foreach($vehical_type as $vehical_types)
																	<option value="{{ $vehical_types->id }}">{{ $vehical_types->vehicle_type }}</option>
																@endforeach
															@endif
														</select> 
												</div>
												<div class="col-md-8 form-group data_popup">
													<label>{{ trans('app.Vehicle Brand:')}} <span class="text-danger">*</span></label>
													<input type="text" class="form-control vehical_brand" name="vehical_brand" id="vehical_brand" placeholder="Enter Vehical brand" maxlength="30" required />
												</div>
												<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
													
													<button type="button" class="btn btn-success vehicalbrandadd" 
													   vehiclebrandurl="{!! url('/vehicle/vehicle_brand_add') !!}">{{ trans('app.Submit')}}</button>
												</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>
				<!-- End Vehical Brand --->	
		
				<!-- Fuel Type -->	
					<div class="col-md-6">
						<div id="responsive-modal-fuel" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Add Fuel Type')}}</h4>
									</div>
									<div class="modal-body">
									    <form class="form-horizontal" action="" method="post">
											<table class="table fuel_type_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Fuel Type')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
													@if(!empty($fueltype))
													@foreach ($fueltype as $fueltypes)
													<tr class="del-{{ $fueltypes->id }} data_of_type" >
													<td class="text-center ">{{ $fueltypes->fuel_type }}</td>
													<td class="text-center">
													
													<button type="button" fuelid="{{ $fueltypes->id }}" 
													deletefuel="{!! url('/vehicle/fueltypedelete') !!}" class="btn btn-danger btn-xs fueldeletes">X</button>
													</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Fuel Type:')}} <span class="text-danger">*</span></label>
												<input type="text" class="form-control fuel_type" name="fuel_type" id="fuel_type" placeholder="{{ trans('app.Enter Fuel Type')}}" maxlength="30" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												
												<button type="button" class="btn btn-success fueltypeadd"  
												fuelurl="{!! url('/vehicle/vehicle_fuel_add') !!}">{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>	
						</div>
					</div>
				<!-- end Fuel Type -->	

				<!-- Model Name -->
					<div class="col-md-6">
						<div id="responsive-modal-vehi-model" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
										<h4 class="modal-title">{{ trans('app.Add Model Name')}}</h4>
									</div>
									<div class="modal-body">
										<form class="form-horizontal" action="" method="post">
											<table class="table vehi_model_class"  align="center" style="width:40em">
												<thead>
													<tr>
														<td class="text-center"><strong>{{ trans('app.Model Name')}}</strong></td>
														<td class="text-center"><strong>{{ trans('app.Action')}}</strong></td>
													</tr>
												</thead>
												<tbody>
													@if(!empty($model_name))
													@foreach ($model_name as $model_names)
													<tr class="mod-{{ $model_names->id }} data_of_type" >
														<td class="text-center ">{{ $model_names->model_name }}</td>
														<td class="text-center">
															<button type="button" modelid="{{ $model_names->id }}" 
															deletemodel="{!! url('/vehicle/vehicle_model_delete') !!}" class="btn btn-danger btn-xs modeldeletes">X</button>
														</td>
													</tr>
													@endforeach
													@endif
												</tbody>
											</table>
											<div class="col-md-8 form-group data_popup">
												<label>{{ trans('app.Model Name :')}} <span class="text-danger">*</span> </label>
												<input type="text" class="form-control vehi_modal_name" name="model_name" id="model_name" placeholder="{{ trans('app.Enter Model Name')}}" maxlength="30" required />
											</div>
											<div class="col-md-4 form-group data_popup" style="margin-top:24px;">
												<button type="button" class="btn btn-success vehi_model_add"  
													modelurl="{!! url('/vehicle/vehicle_model_add') !!}">{{ trans('app.Submit')}}</button>
											</div>
										</form>
									</div>
								</div>
							</div>	
						</div>
					</div>
				<!-- End Model Name -->
				</div>
			</div>
		</div>
	</div>
	@else
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
	@endif
@else
	<div class="right_col" role="main">
		<div class="nav_menu main_title" style="margin-top:4px;margin-bottom:15px;">
              <div class="nav toggle" style="padding-bottom:16px;">
               <span class="titleup">&nbsp {{ trans('app.You Are Not Authorize This page.')}}</span>
              </div>
          </div>
	</div>
@endif   

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
	<script>
    $('#myDatepicker').datetimepicker();
    
    $('#myDatepicker2').datetimepicker({
       format: "yyyy",
		autoclose: 2,
		minView: 4,
		startView: 4,
    });
</script>
<script type="text/javascript">
    $(".datepicker").datetimepicker({
		format: "<?php echo getDatepicker(); ?>",
		autoclose: 1,
		minView: 2,
	});
 </script>
<!-- vehical type -->
<script>
    $(document).ready(function(){
		
		 $('.vehicaltypeadd').click(function(){
			
		 var vehical_type= $('.vehical_type').val();

		 var url = $(this).attr('url');
         if(vehical_type == ""){
            swal('Please Enter Vehicle Type!');
			}else{  
					$.ajax({
						type:'GET',
						url:url,
							data :{vehical_type:vehical_type},

							success:function(data)
						{
						   var newd = $.trim(data);
						   var classname = 'del-'+newd;
						  
						   if (data == '01')
						   {
							   
							   swal('Duplicate Data !!! Please try Another...');
						   }
						   else
						   {
						   $('.vehical_type_class').append('<tr class="'+classname+' data_of_type"><td class="text-center">'+vehical_type+'</td><td class="text-center"><button type="button" vehicletypeid='+data+' deletevehical="{!! url('/vehicle/vehicaltypedelete') !!}" class="btn btn-danger btn-xs deletevehicletype">X</button></a></td><tr>');
							$('.select_vehicaltype').append('<option value='+data+'>'+vehical_type+'</option>');
							$('.vehical_type').val('');
						   }
					   },
			   
			});
		}
		});
	});
</script>

<!-- vehical Type delete-->
<script>
$(document).ready(function(){
	
	$('body').on('click','.deletevehicletype',function(){

	var vtypeid = $(this).attr('vehicletypeid');
	var url = $(this).attr('deletevehical');
	
	swal({
		    title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {
					$.ajax({
							type:'GET',
							url:url,
							data:{vtypeid:vtypeid},
							success:function(data){
		
								$('.del-'+vtypeid).remove();
								$(".select_vehicaltype option[value="+vtypeid+"]").remove();
								swal("Done!","It was succesfully deleted!","success");
							}
						});
					}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
						} 
				})
			});
		});
</script>


<!-- vehical brand -->
<script>
    $(document).ready(function(){
		
		$('.vehicalbrandadd').click(function(){
        var vehical_id = $('.vehical_id').val();
		var vehical_brand= $('.vehical_brand').val();
		var url = $(this).attr('vehiclebrandurl');
		if(vehical_id == ''){
            swal('Please Enter Vehicle Type!');
        }
		else if(vehical_brand =='')
		{
			swal('Please Enter Vehicle Brand!');
		}
		else{
			$.ajax({
			   type:'GET',
			   url:url,
             
			   data :{vehical_id:vehical_id,
			         vehical_brand:vehical_brand
			   },

			   success:function(data)
               
               {
				   var newd = $.trim(data);
				   var classname = 'del-'+newd;
               
			    if (data == '01')
			       {
			 	      swal('Duplicate Data !!! Please try Another...');
				   }
				   else
				   {
					   $('.vehical_brand_class').append('<tr class="'+classname+' data_of_type"><td class="text-center">'+vehical_brand+'</td><td class="text-center"><button type="button" brandid='+data+' deletevehicalbrand="{!! url('/vehicle/vehicalbranddelete') !!}" class="btn btn-danger btn-xs deletevehiclebrands">X</button></a></td><tr>');
						$('.select_vehicalbrand').append('<option value='+data+'>'+vehical_brand+'</option>');
						$('.vehical_brand').val('');
					}
			   },
		 });
		}
		});
	});
</script>

<!-- vehical brand delete-->

	<script>
	$(document).ready(function(){
		
		$('body').on('click','.deletevehiclebrands',function(){

		var vbrandid = $(this).attr('brandid');
		var url = $(this).attr('deletevehicalbrand');
	swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
				if (isConfirm) {  	
					$.ajax({
					type:'GET',
					url:url,
					data:{vbrandid:vbrandid},
					success:function(data){
						$('.del-'+vbrandid).remove();
						 $(".select_vehicalbrand option[value="+vbrandid+"]").remove();
					swal("Done!","It was succesfully deleted!","success");
						}
					});
				}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
					} 
				})
		});
	});
	</script>

<!-- Fuel type -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
		
		 $('.fueltypeadd').click(function(){
			 
		var fuel_type= $('.fuel_type').val();

		 var url = $(this).attr('fuelurl');
		 if(fuel_type == ""){
				swal('Please Enter Fuel Type!');
			}else{ 
				$.ajax({
				   type:'GET',
				   url:url,

				   data :{fuel_type:fuel_type},
				   success:function(data)
				   {
					   var newd = $.trim(data);
					   var classname = 'del-'+newd;
					if (data == '01')
					   {
						   swal('Duplicate Data !!! Please try Another...');
					   }
					   else
					   {
						$('.fuel_type_class').append('<tr class="'+classname+' data_of_type"><td class="text-center">'+fuel_type+'</td><td class="text-center"><button type="button" fuelid='+data+' deletefuel="{!! url('/vehicle/fueltypedelete') !!}" class="btn btn-danger btn-xs fueldeletes">X</button></a></td><tr>');
						$('.select_fueltype').append('<option value='+data+'>'+fuel_type+'</option>');
						$('.fuel_type').val('');
						}
					 
				   },
			   
				});
			}
			});
	});
</script>
<!-- Fuel  Type delete-->

<script>
$(document).ready(function(){
	
	$('body').on('click','.fueldeletes',function(){
   
	
	var fueltypeid = $(this).attr('fuelid');
	
	var url = $(this).attr('deletefuel');
	swal({
            title: "Are you sure?",
            text: "You will not be able to recover this imaginary file!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: "Yes, delete it!",
            closeOnConfirm: false
        },
         function(isConfirm){
			if (isConfirm) {
					$.ajax({
							type:'GET',
							url:url,
							data:{fueltypeid:fueltypeid},
							success:function(data){
									$('.del-'+fueltypeid).remove();
									$(".select_fueltype option[value="+fueltypeid+"]").remove();
									swal("Done!","It was succesfully deleted!","success");
								}
						});
					}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
					} 
				})
	
			});
		});
</script>



<!-- Add Vehicle Model -->
<script>
	$(document).ready(function(){
	
		$('.vehi_model_add').click(function(){
			
			var model_name = $('.vehi_modal_name').val();
			var model_url = $(this).attr('modelurl');
			
			if(model_name == ""){
            swal('Please Enter Model Name!');
			}
			else
			{	
				$.ajax({
						type:'GET',
						url:model_url,
						data:{model_name:model_name},
						success:function(data)
						{
							var newd = $.trim(data);
							var classname = 'mod-'+newd;
				
					if(data == '01')
					{
						swal("Duplicate Data !!! Please try Another... ");
					}
					else
					{
						$('.vehi_model_class').append('<tr class="'+classname+'"><td class="text-center">'+model_name+'</td><td class="text-center"><button type="button" modelid='+data+' deletemodel="{!! url('/vehicle/vehicle_model_delete') !!}" class="btn btn-danger btn-xs modeldeletes">X</button></a></td><tr>');
						$('.model_addname').append('<option value='+data+'>'+model_name+'</option>');
						$('.vehi_modal_name').val('');
					}
					},
				});
			}
			});
		
	$('body').on('click','.modeldeletes',function(){
			
			var mod_del_id = $(this).attr('modelid');
			var del_url = $(this).attr('deletemodel');
			
			swal({
				title: "Are you sure?",
				text: "You will not be able to recover this imaginary file!",
				type: "warning",
				showCancelButton: true,
				confirmButtonColor: "#DD6B55",
				confirmButtonText: "Yes, delete it!",
				closeOnConfirm: false
			},
			function(isConfirm){
				if (isConfirm) {
					$.ajax({
							type:'GET',
							url:del_url,
							data:{mod_del_id:mod_del_id},
							
							success:function(data)
							{
								$('.mod-'+mod_del_id).remove();
								$(".model_addname option[value="+mod_del_id+"]").remove();
							swal("Done!","It was succesfully deleted!","success");
								}
							});
					}else{
						swal("Cancelled", "Your imaginary file is safe :)", "error");
						} 
				})
		});	
	});

</script>

<!-- End Add Vehicle Model -->

<!-- vehical Type from brand -->
<script>
$(document).ready(function(){
	
	$('.select_vehicaltype').change(function(){
		vehical_id = $(this).val();
		var url = $(this).attr('vehicalurl');

		$.ajax({
			type:'GET',
			url: url,
			data:{ vehical_id:vehical_id },
			success:function(response){
				$('.select_vehicalbrand').html(response);
			}
		});
	});
	
});

</script>




<!-- Vehical Description-->
<script>
$("#add_new_description").click(function(){
		//jQuery(this).attr("disabled", "disabled");
		var row_id = $("#tab_decription_detail > tbody > tr").length;
		
		var url = $(this).attr('url');
		
		$.ajax({
                       type: 'GET',
                      url: url,
                     data : {row_id:row_id},
                     success: function (response)
                        {	
						
                            $("#tab_decription_detail > tbody").append(response.html);
							return false;
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
	});
$('body').on('click','.delete_description',function(){
	
		var description = $(this).attr('data-id');
	    var url = $(this).attr('delete_description');
		
		$.ajax({
                       type: 'GET',
                      url: url,
                     data : {description:description},
                     success: function (response)
                        {	
						
                           $('table#tab_decription_detail tr#row_id_'+description).remove();
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
		
	});
</script>

<!-- vehical color -->
<script>
$("#add_new_color").click(function(){
		
		var color_id = $("#tab_color > tbody > tr").length;
		
		var url = $(this).attr('url');
        
		$.ajax({
                       type: 'GET',
                      url: url,
                     data : {color_id:color_id},
                     success: function (response)
                        {	
						   
                            $("#tab_color > tbody").append(response.html);
							return false;
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
	});
$('body').on('click','.remove_color',function(){
	
		var color_id = $(this).attr('data-id');
		
		var url = $(this).attr('colordelete');
        
		$.ajax({
                       type: 'GET',
                      url: url,
                     data : {color_id:color_id},
                     success: function (response)
                        {	
						   $('table#tab_color tr#color_id_'+color_id).remove();	
							
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
		
	});
</script>

<!-- Vehical image-->

<script>

            $(document).ready(function(){
                // Basic
                $('.dropify').dropify();

                // Translated
                $('.dropify-fr').dropify({
                    messages: {
                        default: 'Glissez-déposez un fichier ici ou cliquez',
                        replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
                        remove:  'Supprimer',
                        error:   'Désolé, le fichier trop volumineux'
                    }
                });

                // Used events
                var drEvent = $('#input-file-events').dropify();


                drEvent.on('dropify.beforeClear', function(event, element){
                    return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
                });

                drEvent.on('dropify.afterClear', function(event, element){
                    alert('File deleted');
                });

                drEvent.on('dropify.errors', function(event, element){
                    console.log('Has Errors');
                });

                var drDestroy = $('#input-file-to-destroy').dropify();

                drDestroy = drDestroy.data('dropify')
                $('#toggleDropify').on('click', function(e){
                    e.preventDefault();
                    if (drDestroy.isDropified()) {
                        drDestroy.destroy();
                    } else {
                        drDestroy.init();
                    }
                })
            });
        
</script>
<!--  show  images in multiple selected -->
<script>
$(document).ready(function(){
    $(".imageclass").click(function(){
        $(".classimage").empty();
    });
});
</script>
<script>

		function preview_images() 
		{
		 var total_file=document.getElementById("images").files.length;
		 for(var i=0;i<total_file;i++)
		 {
		  $('#image_preview').append("<div class='col-md-3 col-sm-3 col-xs-12 removeimage delete_image classimage'><img src='"+URL.createObjectURL(event.target.files[i])+"' width='100px' height='60px'> </div>");
		 }
		}
	</script>

<!--  new image append -->
<script>
$("#add_new_images").click(function(){
		//jQuery(this).attr("disabled", "disabled");
		var image_id = $("#tab_images > tbody > tr").length;
		 
		var url = $(this).attr('url');
          
		$.ajax({
                       type: 'GET',
                       url: url,
                     data : {image_id:image_id},
                     success: function (response)
                        {	
						   
                            $("#tab_images > tbody").append(response);
							return false;
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
	});
$('body').on('click','.delete_image',function(){
	
		var delete_image = $(this).attr('imgaeid');
		var url = $(this).attr('delete_image');
          
		$.ajax({
                       type: 'GET',
                       url: url,
                     data : {delete_image:delete_image},
                     success: function (response)
                        {	
						   //$('table#tab_color tr#color_id_'+color_id).remove();	
                            $('div#image_preview div#image_remove_'+delete_image).remove();
						},
                    error: function(e) {
                 alert("An error occurred: " + e.responseText);
                    console.log(e);
                }
       });
		return false;
	});
</script>
@endsection