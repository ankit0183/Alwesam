@extends('layouts.app')
@section('content')
<script src="{{ URL::asset('vendors/jquery/dist/jquery.min.js') }}"></script>
<style>
   .jobcardmargintop{margin-top:9px;}
   .table>tbody>tr>td{padding:10px;
   <!-- vertical-align: unset!important; -->
   }
   .jobcard_heading{margin-left: 19px;margin-bottom: 15px}
   label{margin-bottom:0px;}
   .checkbox_padding{margin:10px 0px;}
   .first_observation{margin-left:23px;}
   .height{height:28px;}
   .all{width:226px;}
</style>
<!-- page content -->
<?php $userid = Auth::user()->id; ?>
@if (getAccessStatusUser('Job Card',$userid)=='yes')
@if(getActiveCustomer($userid)=='no' && $services->assign_to != Auth::user()->id)
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
   <div class="">
      <div class="nav_menu">
         <nav>
            <div class="nav toggle">
               <a id="menu_toggle"><i class="fa fa-bars"></i><span class="titleup">&nbsp {{ trans('app.Process JobCard')}}</span></a>
            </div>
            @include('dashboard.profile')
         </nav>
      </div>
   </div>
   @if(session('message'))
   <div class="row massage">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="checkbox checkbox-success checkbox-circle">
            <label for="checkbox-10 colo_success">  {{session('message')}} </label>
         </div>
      </div>
   </div>
   @endif
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_content">
            <ul class="nav nav-tabs bar_tabs tabconatent" role="tablist">
               <li role="presentation" class="suppo_llng_li floattab"><a href="{!! url('/jobcard/list')!!}"><span class="visible-xs"	></span><i class="fa fa-list fa-lg">&nbsp;</i>{{ trans('app.List Of Job Cards')}}</span></a></li>
               <li role="presentation" class="active suppo_llng_li_add floattab"><a href="{!! url('/jobcard/list/'.$services->id)!!}" class="process"><span class="visible-xs"></span><i class="fa fa-plus-circle fa-lg i">&nbsp;</i><b>{{ trans('app.Process JobCard')}}</b></span></a></li>
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12 col-sm-12 col-xs-12">
         <div class="x_panel">
            <div class="well well-sm titleup">
               {{ trans('app.Processing Job for...').$services->job_no}}
            </div>
            <form method="post" action="{!! url('/jobcard/store') !!}">
               <input type="hidden" class="service_id" name="service_id" value="{{ $services->id }}"/>
               <hr/>
               <div class="col-md-12 col-xs-12 col-xs-12">
                  <div class="col-md-7 col-xs-12 col-sm-12">
                     <div class="col-md-12 col-sm-12 col-xs-12" colspan="2" valign="top">
                        <h3><?php echo $logo->system_name; ?></h3>
                     </div>
                     <div class="col-md-12 col-xs-12 col-sm-12">
                        <div class="col-md-5 col-xs-12 col-sm-12 printimg">
                           <img src="{{ url('/public/general_setting/'.$logo->logo_image) }}" width="200" height="70px" style="max-height: 80px;">
                        </div>
                        <div class="col-md-7 col-sm-12 col-xs-12 garrageadd" valign="top">
                           <?php 
                              echo $logo->address;
                              echo ", ".getStateName($logo->state_id);
                              echo ", ".getCountryName($logo->country_id);
                              echo "<br>".$logo->email;
                              echo "<br>".$logo->phone_number;
                              ?>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-5 col-xs-12 col-sm-12">
                     <div class="col-md-12 col-xs-12 col-sm-12">
                        <label class="control-label jobcardmargintop col-md-4 col-sm-12 col-xs-12">{{ trans('app.Job Card No')}} <label class="text-danger">*</label></label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                           <input type="text" id="job_no" name="job_no" value="{{ $services->job_no }}" class="form-control" readonly>
                        </div>
                     </div>
                     <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                        <label class="control-label jobcardmargintop col-md-4 col-sm-12 col-xs-12">{{ trans('app.In Date/Time')}} <label class="text-danger">*</label></label>
                        <div class="col-md-8 col-sm-12 col-xs-12 input-group date">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input  type="text" id="in_date" name="in_date" 
                              value="<?php  echo date( getDateFormat().' H:i:s',strtotime($services->service_date));?> " class="form-control" readonly>
                        </div>
                     </div>
                     <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                        <label class="control-label jobcardmargintop col-md-4 col-sm-12 col-xs-12 ">{{ trans('app.Out Date/Time')}} </label>
                        <div class="col-md-8 col-sm-12 col-xs-12 input-group date datepicker">
                           <span class="input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                           <input type="text" id="out_date" name="out_date" 
                              value="<?php if(!empty($job->out_date)){ echo date( getDateFormat().' H:i:s',strtotime($job->out_date));} ?>" class="form-control" placeholder="<?php echo getDatepicker(); echo " hh:mm:ss"; ?>" readonly >
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12 col-xs-12 col-sm-12 space1">
                  <p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
               </div>
               <div class="col-md-12 col-xs-12 col-xs-12">
                  <div class="col-md-4 col-xs-12 col-sm-12">
                     <h2 class="text-left jobcard_heading">{{ trans('app.Customer Details')}}</h2>
                     <p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
                     <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                        <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12">{{ trans('app.Name')}}:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                           <input type="text" id="name" name="name" class="form-control" value="{{ getCustomerName($services->customer_id) }}" readonly>
                        </div>
                     </div>
                     <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:5px;">
                        <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12">{{ trans('app.Address')}}:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                           <input type="text" id="address" name="address" class="form-control" value="{{ getCustomerAddress($services->customer_id) }}" readonly>
                        </div>
                     </div>
                     <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:8px;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">{{ trans('app.Contact No')}}:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                           <input type="text" id="con_no" name="con_no" class="form-control" value="{{ getCustomerMobile($services->customer_id) }}" readonly>
                        </div>
                     </div>
                     <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:8px;">
                        <label class="control-label jobcardmargintop col-md-3 col-sm-3 col-xs-12"> {{ trans('app.Email')}}:</label>
                        <div class="col-md-8 col-sm-12 col-xs-12">
                           <input type="text" id="email" name="email" class="form-control" value="{{ getCustomerEmail($services->customer_id) }}" readonly>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-8 col-sm-12 col-xs-12 vehicle_space">
                     <h2 class="text-left jobcard_heading">{{ trans('app.Vehicle Details')}}</h2>
                     <p class="col-md-12 col-xs-12 col-sm-12 space1_solid"></p>
                     <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
                        <label class="control-label col-md-2 col-sm-2 col-xs-12" style="padding-top: 7px;">{{ trans('app.Model Name')}}:</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                           <input type="text" id="model" name="model" class="form-control" value="{{ $vehicale->modelname }}" readonly>
                        </div>
                        <label class="jobcardmargintop col-md-2 col-sm-2 col-xs-12">{{ trans('app.Chasis No')}}: </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                           <input type="text" id="coupan_no" name="coupan_no" class="form-control" value="{{ $vehicale->chassisno }}" readonly>
                        </div>
                     </div>
                     <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
                        <label class="jobcardmargintop control-label col-md-2 col-sm-2 col-xs-12">{{ trans('app.Engine No')}}: </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                           <input type="text" id="engine_no" name="engine_no" class="form-control" value="{{ $vehicale->engineno }}" readonly>
                        </div>
                        <label class="jobcardmargintop col-md-2 col-sm-2 col-xs-12">{{ trans('app.KMS Run')}}:
                        <label class="text-danger">*</label></label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                           <input type="number" min='0' id="kms" name="kms" value="<?php if(!empty($job)){ 
                              echo"$job->kms_run"; } ?>" maxlength="15" class="form-control" required>
                        </div>
                     </div>
					 @if(!empty($s_date))
                     <div class="col-md-12 col-sm-12 col-xs-12 divId" id="divId" style="margin-top:5px;" >
                        <label class="control-label col-md-2 col-sm-2 col-xs-12">{{ trans('app.Date Of Sale')}}: </label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                           <input type="text" id="sales_date" name="sales_date" class="form-control" value="{{ date(getDateFormat(), strtotime($s_date->date))}}" readonly>
                        </div>
                        <label class="jobcardmargintop col-md-2 col-sm-2 col-xs-12">{{ trans('app.Color')}}:</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                           <input type="text" id="color" name="color" class="form-control" value="@if(!empty($color)) {{ $color->color }} @endif" readonly >
                        </div>
                     </div>
					 @endif
                     @if(!empty($job->coupan_no))
                     <div class="col-md-12 col-sm-12 col-xs-12" style="margin-top:5px;">
                        <label class="col-md-2 col-sm-2 col-xs-12">{{ trans('app.Free Service Coupan No')}}:</label>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                           <input type="text" id="coupan_no" name="coupan_no" value="<?php if(!empty($job)){ 
                              echo"$job->coupan_no"; } ?>" class="form-control">
                        </div>
                     </div>
                     @endif
                  </div>
               </div>
               <div class="col-md-12 col-xs-12 col-sm-12 space1">
                  <p class="col-md-12 col-xs-12 col-sm-12 ln_solid"></p>
               </div>
               {{-- <div class="col-md-12 col-sm-12 col-xs-12">
                  <div class="col-md-10 col-sm-8 col-xs-8">
                     <h3>{{ trans('app.Observation List')}}</h3>
                  </div>
                  <div class="col-md-2 col-sm-4 col-xs-4" style="padding-top:8px;">
                     <button type="button" data-target="#responsive-modal-observation" data-toggle="modal" class= "btn btn-default">{{ 	trans('app.Add New')}}</button>
                  </div>
               </div> --}}
               <div class="col-md-12 col-xs-12 col-sm-12 panel-group">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <h4 class="panel-title tbl_points">
                           <a data-toggle="collapse" href="#collapse1" class="observation_Plus" style="color:#5A738E"><i class="plus-minus glyphicon glyphicon-minus "></i>  {{ trans('app.Observation Points')}}</a>
                        </h4>
                     </div>
                     <div id="collapse1" class="panel-collapse collapse in">
                        <div class="panel-body main_data">
                           <!-- Observation Checked Points -->
						   <table class="table table-bordered  adddatatable main_data_points" id="main_data_points" align="center">
								<thead>
									<tr>
										<th>{{ trans('app.Category')}}</th>
										<th>{{ trans('app.Observation Point')}}</th>
										<th>{{ trans('app.Select Product')}}</th>
										<th style="width:9%;">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
										<th style="width:10%;">{{ trans('app.Quantity')}}</th>
										<th style="width:10%;">{{ trans('app.Total Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
										<th style="width:10%;">{{ trans('app.Chargeable')}}</th>
										<th>{{ trans('app.Comments')}}</th>
										<th>{{ trans('app.Action')}}</th>
									</tr>
								</thead>
								
								<tbody id="tbd">
									<?php $i=1;?>
									<?php foreach ($data as $datas) { ?>
									<tr class="obs_point_data" id="<?php echo "row_id_delete_".$i; ?>">
										<td>
											<input type="text"  name="product2[category][]" class="form-control" value="<?php echo $datas->checkout_subpoints;?>">
											<input type="hidden" name="pro_id_delete" class="del_pro_<?php echo $i;?>" id="del_pro_<?php echo $i;?>" value="<?php echo $datas->id;?>">
										</td>
											
										<td>
											<input type="text" name="product2[sub_points][]" class="form-control" value="<?php echo $datas->checkout_point;?>">
										</td>
											
										<td>
											<select name="product2[product_id][]" class="form-control product_ids product1s_{{$i}}"  url="{{ url('/jobcard/getprice') }}" row_did="{{$i}}" id="product1s_{{$i}}" qtyappend="" required >
												<option value="">{{ trans('app.Select Product')}}</option>
													<?php  foreach($product as $products)
													{ 
														if($products->id == $datas->product_id)
														{
															$is_select = "selected";
														}
														else
														{
															$is_select = "";
														}
													?>	
														<option value="<?php echo $products->id;?>"  <?php echo $is_select; ?> ><?php echo $products->name;?></option> 
												<?php } ?> 										
											</select>
										</td>
										
										<td>
											<input type="text" name="product2[price][]" value="<?php if(!empty($data)){ echo $datas->price; } ?>" value="<?php echo $products->price; ?>" class="form-control rate product1_<?php echo $i; ?> product1_<?php echo $i; ?>" id="product1_<?php echo $i; ?>" readonly="true">		
										</td>
										
										<td> 
											<input type="text" name="product2[qty][]" class="form-control qtyt qnt_<?php echo $i; ?> <?php echo "qty_".$i; ?>" row_id1="<?php echo $i; ?>" value="<?php if(!empty($data)){ echo $datas->quantity; } ?>"  url="<?php echo url('/jobcard/gettotalprice') ?>" id="<?php echo "qty_".$i; ?>" style="width:60%;float:left;" required >
											<span class="unit_<?php echo $i; ?>"></span>
										</td>
										
										<td>
											<input type="text" name="product2[total][]" value="<?php if(!empty($data)){ echo $datas->total_price; } ?>" value="0" class="form-control total1 total1_<?php echo $i; ?>" id="total1_<?php echo $i; ?>"  readonly="true"/>
										</td>
											
										<td>
											{{ trans('app.Yes:')}} <input type="radio" name="yesno_[]<?php echo $i;?>" class="yes_no" value="1" <?php if($datas->chargeable == 1) { echo "checked"; } ?> style=" height:13px; width:20px; margin-right:5px;" >
												
											{{ trans('app.No:')}} <input type="radio" name="yesno_[]<?php echo $i;?>" class="yes_no" value="0" <?php if($datas->chargeable == 0) { echo "checked"; } ?> style="height:13px; width:20px;">
										</td>
										<td><textarea name="product2[comment][]" class="form-control" >{{$datas->category_comments }}</textarea> </td>
										<td class="text-center">
											<i class="fa fa-trash fa-2x delete" data_id_trash = "<?php echo $i; ?>" delete_data_url=" <?php echo url('/jobcard/delete_on_reprocess') ?>" service_id="<?php echo $viewid; ?>"></i>
											<input type="hidden" name="obs_id[]" class="form-control" value="<?php echo $datas->id;?>">
										</td>
									</tr>
									<?php $i++; ?>
									<?php } ?>
								</tbody>	
							</table>
                        </div>
                     </div>
                  </div>
               </div>
			   <div class="col-md-12 col-xs-12 col-sm-12 panel-group">
					<div class="col-md-10 col-sm-8 col-xs-8">
						{{-- <h2>{{ trans('app.Other Service Charges')}}</h2> --}}
                  <h2>{{ trans('Service Charges')}}</h2>
					</div>
					<div class="col-md-2 col-sm-4 col-xs-4">
						<button type="button" id="add_new_product" class="btn btn-default" url="{!! url('/jobcard/addproducts')!!}" style="margin:5px 0px;">{{ trans('app.Add New')}} </button>
					</div>
			   </div>
			    <div class="col-md-12 col-xs-12 col-sm-12">
				   <div class="col-md-12 col-xs-12 col-sm-12" style="margin-top:20px;">
					  <table class="table table-bordered addtaxtype" id="tab_products_detail" align="center">
						 <thead>
							<tr>
							   <th class="all">{{ trans('app.Product')}}</th>
							   <th class="all">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
							   <th>Action</th>
							</tr>
						 </thead>
						 <tbody>
							@if(!empty($pros))
							<?php $id = 1; ?>
							@foreach($pros as $product)
							<tr id="<?php echo'row_id_'.$id; ?>">
							   <td>
								  <input type="text" name="other_product[]" class="form-control" value="<?php echo $product->comment;?>" id="othr_prod_<?php echo $id; ?>" othr_prod="<?php echo $product->id;?>" >
							   </td>
							   <td>
								  <input type="text" name="other_price[]" class="form-control" id="oth_price" value="<?php echo $product->total_price; ?>" >
							   </td>
							   <td>
								  <span class="trash_product" data-id="<?php echo $id; ?>" oth_url="<?php echo url('jobcard/oth_pro_delete') ?>"><i class="fa fa-trash fa-2x"style="vertical-align: middle !important;" ></i></span>
							   </td>
							</tr>
							<?php $id++; ?>
							@endforeach
							@endif
						 </tbody>
					  </table>
				   </div>
					
			  </div>
               <!---- model in observation Point -->
               <div class="col-md-12">
                  <div id="responsive-modal-observation" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                     <div class="modal-dialog">
                        <div class="modal-content">
                           <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                              <h4 class="modal-title">{{ trans('app.Observation Point')}}</h4>
                           </div>
                           <div class="modal-body">
                              @foreach($tbl_checkout_categories as $checkoout)
                              <div class="panel-group">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <h4 class="panel-title">
                                          <a data-toggle="collapse" href="#collapse1-{{ $checkoout->id }}" class="ob_plus{{$checkoout->id }}"><i class="glyphicon glyphicon-plus"></i> {{ $checkoout->checkout_point }}</a>
                                       </h4>
                                    </div>
                                    <div id="collapse1-{{ $checkoout->id }}" class="panel-collapse collapse">
                                       <div class="panel-body">
                                          <table class="table table-striped">
                                             <thead>
                                                <tr>
                                                   <td>
                                                      <b>#</b>
                                                   </td>
                                                   <td>
                                                      <b>{{ trans('app.Checkpoints')}}</b>
                                                   </td>
                                                   <td>
                                                      <b>{{ trans('app.Choose')}}</b>
                                                   </td>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php
                                                   $i = 1;   
                                                   $subcategory =getCheckPointSubCategory($checkoout->checkout_point,$checkoout->vehicle_id); 
                                                   if(!empty($subcategory))
                                                   {
                                                   	foreach($subcategory as $subcategorys)
                                                   	{ ?> 
                                                <tr class="id{{ $subcategorys->checkout_point }}">
                                                   <td class="col-md-1"><?php echo $i++; ?></td>
                                                   <td class="row{{ $subcategorys->checkout_point}} col-md-4">
                                                      <?php echo $subcategorys->checkout_point;
                                                         //echo $subcategorys->id;
                                                         ?>							<?php $data = getCheckedStatus($subcategorys->id,$services->id)?>								
                                                   </td>
                                                   <td>
                                                      <input type="checkbox" <?php echo $data;?> name="chek_sub_points" name="check_sub_points[]" check_id="{{ $subcategorys->id }}" class="check_pt" url="{!! url('jobcard/select_checkpt')!!}"  s_id = "{{ getServiceId($services->id) }}" sale_id = "{{ $services->id }}" sub_pt="{{ $subcategorys->checkout_point }}" main_cat="{{ $checkoout->checkout_point }}">
                                                   </td>
                                                </tr>
                                                <?php }
                                                   } ?>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
									<script>
									$(document).ready(function(){
										var i = 0;
										$('.ob_plus{{$checkoout->id }}').click(function(){
											i = i+1;
											if(i%2!=0){
												$(this).parent().find(".glyphicon-plus:first").removeClass("glyphicon-plus").addClass("glyphicon-minus");
											}else{
												$(this).parent().find(".glyphicon-minus:first").removeClass("glyphicon-minus").addClass("glyphicon-plus");
											}
										});
									});
									</script>
                                 </div>
                              </div>
                              @endforeach
                           </div>
                           <div class="modal-footer">
                              <button type="button" class="btn btn-success col-md-offset-10 check_submit" style="margin-bottom:5px;">{{ trans('app.Submit')}}</button>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <input type="hidden" name="_token" value="{{csrf_token()}}">
               <div class="form-group col-md-12 col-sm-12 col-xs-12">
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

<script>
	$(document).ready(function(){
		var i = 0;
		$('.observation_Plus').click(function(){
			i = i+1;
			if(i%2!=0){
				$(this).parent().find(".glyphicon-minus:first").removeClass("glyphicon-minus").addClass("glyphicon-plus");
				
			}else{
				$(this).parent().find(".glyphicon-plus:first").removeClass("glyphicon-plus").addClass("glyphicon-minus");
			}
		});
	});
</script>
<script>
   $(document).ready(function(){
   	
   	$('.tbl_points, .check_submit').click(function(){
   		
   		var url = "<?php echo url('jobcard/get_obs') ?>"
   		var service_id = $('.service_id').val();
   		
   		$.ajax({
   						type: 'GET',
   						url: url,
   						data : {service_id:service_id},
   						success: function (response)
   							{	
   								
   								$('.main_data').html(response.html);
   								// $('.adddatatable1').DataTable().row.add($(response.html)).draw();
   								$('.modal').modal('hide');
   								
   							},
   
   					    error: function(e) 
   							{
   								console.log(e);
   							}
   						});
   	});
   	
   });
   
</script>		
<!-- Checkpoints in modal -->
<script type="text/javascript">
   $(document).ready(function(){
       $('input.check_pt[type="checkbox"]').click(function(){
   
           if($(this).prop("checked") == true){
   var value = 1;	
               var url = $(this).attr('url');
   var id = $(this).attr('check_id');
   var sale_id = $(this).attr('sale_id');
   var main_cat = $(this).attr('main_cat');
   var sub_pt = $(this).attr('sub_pt');
   
   $.ajax({
   		type: 'GET',
   		url: url,
   		data : {value:value,id:id,service_id:sale_id,main_cat:main_cat,sub_pt:sub_pt},
   		success: function (response)
   			{	
   				
   			},
   
   	    error: function(e) 
   			{
   				// alert("An error occurred: " + e.responseText);
   				console.log(e);
   			}
   		});
           }
           else if($(this).prop("checked") == false){
   var value = 0;
               var url = $(this).attr('url');
   var id = $(this).attr('check_id');
   var sale_id = $(this).attr('sale_id');
   
   $.ajax({
   		type: 'GET',
   		url: url,
   		data : {value:value,id:id,service_id:sale_id},
   		success: function (response)
   			 {	
   				
   			 },
   
   	    error: function(e) 
   			{
   				// alert("An error occurred: " + e.responseText);
   				console.log(e);
   			}
   		});
           }
       });
   });
</script>	
<script>
   $('.sa-warning').click(function(){
   
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
<script>
   $(document).ready(function(){
   
   $('.observationclik').click(function(){
   
   var observation = $('.observation').val();
   
   var checkpoint = $('.checkpoint').val();
   
   var url = $(this).attr('addcheckurl');
   
   $.ajax({
     type:'GET',
     url:url,
     data :{observation:observation,checkpoint:checkpoint},
     success:function(response){   
     },	   
     });
     
   });
   });
   
</script>	
<script>
   $(document).ready(function(){
   
   $('.pointcomment').click(function(){
   
     var co_point = $(this).attr('point_id'); 
   
     var s_id = $(this).attr('s_id');  
   
   var commentname = $('textarea.comment').val();
   var yesno =$('input:radio[name="yesno"][value="yes"]').prop('checked', true);
   var noyes=$('#yesno').attr('checked',true);
    
   var url = $(this).attr('commenturl');
   
   $.ajax({
     type:'GET',
     url:url,
     data :{co_point:co_point,commentname:commentname,s_id:s_id,yesno:yesno},
     success:function(response){
     
     
     },	   
     });
     
   });
   });
   
</script>	
<script>
   $("#add_new_product").click(function(){
   		
   		var row_id = $("#tab_products_detail > tbody > tr").length;
   
   		var url = $(this).attr('url');
   		
   		$.ajax({
                          type: 'GET',
                         url: url,
                        data : {row_id:row_id},
                        success: function (response)
                           {	
   							
                               $("#tab_products_detail > tbody").append(response);
   							// $('#tab_products_detail').DataTable().row.add($(response.html)).draw();
   							return false;
   						},
   					 error: function(e) 
   						{
   								// alert("An error occurred: " + e.responseText);
   								console.log(e);
   						}
          });
   	});
   
   	$('body').on('click','.trash_product',function(){
   		
   		var row_id = $(this).attr('data-id');
   		
   		$('table#tab_products_detail tr#row_id_'+row_id).fadeOut();	
   		return false;
   	});
   	
   	$('body').on('change','.product_id',function(){
   		
   		var row_id = $(this).attr('row_did');
   		
   		var product_id = $(this).val();
   		var url = $(this).attr('url');
   		
   		$.ajax({
                       type: 'GET',
                       url: url,
                       data : {product_id:product_id},
                       success: function (response)
                           {		
   							$('#product_'+row_id).attr('value',response); 
   						},
                       error: function(e) 
   						{
   							// alert("An error occurred: " + e.responseText);
   							console.log(e);
   						}
          });
   	});
</script>
<script>
   $('body').on('keyup','.qty',function(){
   
   		var row_id = $(this).attr('row_id');
   		 
              var qty= $(this).val();
   		var price= $('#product_'+row_id).val();
   		
   		var url = $(this).attr('url');
   		
   				$.ajax({
   					type: 'GET',
   					url: url,
   					data : {qty:qty,price:price},
   					success: function (response)
   						 {	
   							
   							$('#total_'+row_id).attr('value',response); 
   							
   						},
   
   						beforeSend:function()
   						{
   							
   						},
   
   				    error: function(e) 
   						{
   							// alert("An error occurred: " + e.responseText);
   							console.log(e);
   						}
   					});
   					
   				});
   				
</script>
<script>
   $(function(){
   		$('#Selectvehicle').change(function(){
   			var vehicleid = $(this).val();
   			
   			var url = $(this).attr('url');
   			
   				$.ajax({
   					type: 'GET',
   					url: url,
   					data : {vehicleid:vehicleid},
   					success: function (response)
   						 {	
   						  
   							var res_vehicle = jQuery.parseJSON(response);
   							  
   							$('.point').attr('value',res_vehicle.checkout_point);
   						},
   				    error: function(e) 
   						{
   							
   							 console.log(e);
   						}
   					});
   		});
   });
</script>
<script src="{{ URL::asset('vendors/moment/min/moment.min.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ URL::asset('vendors/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<!-- datetimepicker -->
<script>
   $('.datepicker').datetimepicker({
      format: "<?php echo getDatetimepicker(); ?>",
   autoclose:1,
   });
</script>
<script>
   $(document).ready (function(){
    
    $('body').on('change','.product_ids',function(){
   	 var stock = $(this).find(":selected").attr('currnent');
    });
    
   });
</script>
<script>
   $('body').on('click','.delete',function(){
   		
   		var row_id = $(this).attr("data_id_trash");
   		var delete_url = $(this).attr("delete_data_url");
   		var service_id = $(this).attr("service_id");
   		var del_pro = $('.del_pro_'+row_id).attr('value');
   		
   		$.ajax({
   		
   			type:'GET',
   			url:delete_url,
   			data:{ service_id:service_id, del_pro:del_pro },
   			success:function(response)
   			{
   				
   			},
   			error:function(e)
   			{
   				console.log(e);
   			}
   			
   		});
   		$('#row_id_delete_'+row_id).remove();	
   	});
   
</script>
<script>
   $('body').on('click','.trash_product',function(){
   		
   		var row_id = $(this).attr("data-id");
   		var del_oth_pro = $('#othr_prod_'+row_id).attr('othr_prod');
   		var url = $(this).attr('oth_url');
   		
   		$.ajax({
   		
   			type:'GET',
   			url:url,
   			data:{ del_oth_pro:del_oth_pro },
   			success:function(response)
   			{
   				
   			},
   			error:function(e)
   			{
   				console.log(e);
   			}
   			
   		});
   		$('#row_id_'+row_id).fadeOut();	
   	});
	
	$('body').on('change','.product_ids',function(){
			var row_id = $(this).attr('row_did');
			var product_id = $(this).val();
			var qt = $(this).attr('qtyappend');
			if(qt == '')
			{
				qt = $('.qnt_'+row_id).val();
			}
			var url = $(this).attr('url');
			
			$.ajax({
						type: 'GET',
						url: url,
						data : {product_id:product_id},
						success: function (response)
							{
								if(qt != '')
								{
									var ttl = qt*response[0];
									jQuery('.total1_'+row_id).val(ttl); 
								}
								jQuery('.product1_'+row_id).val(response[0]); 
							    $('.unit_'+row_id).html(response[1]);								
																
							},
						error: function(e) {
								console.log(e);
					}
				});
			});
			
		$('body').on('keyup','.qtyt',function(){
		
				var row_id = $(this).attr('row_id1');
				var productid = $('.product1s_'+row_id).find(":selected").val();
				var qty= $(this).val();
				// alert(qty);
				var price= $('.product1_'+row_id).val();
				var url = $(this).attr('url');

				
						$.ajax({
							type: 'GET',
							url: url,
							data : {qty:qty,price:price,productid:productid},
							success: function (response)
								 {	
									
								   var newd = $.trim(response);
								  
								   if(newd == '1')
								   {
										swal('No Product Available');
										jQuery('.qty_'+row_id).val('');
									}else{ 
									
									
									jQuery('.total1_'+row_id).val(''); 
									jQuery('.total1_'+row_id).val(response); 
									// alert('#product1s_'+row_id);
									// alert(qty);
									jQuery('#product1s_'+row_id).attr('qtyappend',qty); 
									 
									}
								},

								beforeSend:function()
								{
									
								},

							error: function(e) 
								{
									
									console.log(e);
								}
							});
			});
   
</script>
@endsection