<script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script>
		 $(document).ready(function() {
		$('.adddatatable').DataTable({
			responsive: true,
			paging: false,
			lengthChange: false,
			searching: false,
			ordering: false,
			info: false,
			autoWidth: true,
			sDom: 'lfrtip'
		
		});
	});
</script>

	<div class="modal-header" >
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">{{ trans('app.Service Details for Jobcard Number')}} - <?php echo $vhi_no->job_no; ?></h4>
    </div>
    <div class="modal-body" >		
		<div class="row">
			<div class="col-md-7 col-sm-7 col-xs-12">
			
				<h3><?php echo $logo->system_name; ?></h3>
				<div class="col-md-6 col-sm-12 col-xs-12 printimg">
					<img src="{{ URL::asset('public/general_setting/'.$logo->logo_image)}}" width="200px" height="70px">
				</div>
				<div class="col-md-6 col-sm-12 col-xs-12 ">
					<p>
					<?php 
					echo $logo->address;
					echo ", ".getStateName($logo->state_id);
					echo ", ".getCountryName($logo->country_id);
					echo "<br>".$logo->email;
					echo "<br>".$logo->phone_number; 
					?>
					</p>
				</div>
			</div>
			<div class="col-md-5 col-sm-5 col-xs-12">
				<table class="table">
				  <tbody>
					<tr>
					  <th>{{ trans('app.Name:')}}</th>
					  <td class="cname"><?php echo getCustomerName($custo_info->id) ?></td>
					</tr>
					<tr>
					  <th>{{ trans('app.Address:')}}</th>
					  <td class="cname"><?php echo getCustomerAddress($custo_info->id).",".getCityName($custo_info->city_id).",".getStateName($custo_info->state_id).", ".getCountryName($custo_info->country_id); ?></td>
					</tr>
					<tr>
					  <th>{{ trans('app.Contact:')}}</th>
					  <td class="cname"><?php echo $custo_info->mobile_no;; ?></td>
					</tr>
					<tr>
					  <th>{{ trans('app.Email :')}}</th>
					  <td class="cname"><?php echo $custo_info->email; ?></td>
					</tr>
				  </tbody>
				 </table>
			</div>
		</div>		
		<hr>		
		<div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12">	
					<table class="table table-bordered adddatatable" width="100%">
						<thead>
						<tr>
							<th class="cname text-center">{{ trans('app.Jobcard Number')}}</th>
							<th class="cname text-center">{{ trans('app.Coupon Number')}}</th>
							<th class="cname text-center">{{ trans('app.Vehicle Name')}}</th>
							<th class="cname text-center">{{ trans('app.Regi. No.')}}</th>
							<th class="cname text-center">{{ trans('app.In Date')}}</th>
							<th class="cname text-center">{{ trans('app.Out Date')}}</th>								
						</tr>
						</thead>
						<tbody>
						@if(!empty($used_cpn_data))
						<tr>
							<td class="cname text-center"><?php echo $used_cpn_data->jocard_no; ?></td>						
							<td class="cname text-center"><?php if(!empty($used_cpn_data->coupan_no)){echo $used_cpn_data->coupan_no;} else{ echo "Paid Service";} ?></td>
							<td class="cname text-center"><?php echo getVehicleName($used_cpn_data->vehicle_id) ?></td>
							<td class="cname text-center"><?php echo $regi->registration_no;  ?></td>
							<td class="cname text-center"><?php echo date(getDateFormat(),strtotime($used_cpn_data->in_date)); ?></td>
							<td class="cname text-center"><?php echo date(getDateFormat(),strtotime($used_cpn_data->out_date)); ?></td>
							
						</tr>
						@endif
						</tbody>
					</table>
					<table class="table table-bordered adddatatable" width="100%">
						<thead>
							<tr>
								<th class="cname text-center">{{ trans('app.Assigned To')}}</th>
								<th class="cname text-center">{{ trans('app.Repair Category')}}</th>
								<th class="cname text-center">{{ trans('app.Service Type')}}</th>
								<th class="cname text-center">{{ trans('app.Details')}}</th>
							</tr>	
						</thead>
						<tbody>
							<tr>
								<td class="cname text-center"><?php echo getAssignedName($vhi_no->assign_to); ?></td>
								<td class="cname text-center"><?php echo $vhi_no->service_category; ?></td>
								<td class="cname text-center"><?php echo $vhi_no->service_type; ?></td>
								<td class="cname text-center"><?php echo $vhi_no->detail; ?></td>
							</tr>					
					  </tbody>
					</table>
					<hr>
					
					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
						<tbody>
							<tr class="printimg">
								<td class="cname">{{ trans('app.SERVICE CHARGES')}}</td>
							</tr>
						</tbody>
					</table>
					<table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">
						<thead>				
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">{{ trans('app.Category')}}</th>
								<th class="text-center">{{ trans('app.Observation Point')}}</th>
								<th class="text-center">{{ trans('app.Product Name')}}</th>
								<th class="text-center">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
								<th class="text-center">{{ trans('app.Quantity')}} </th>
								<th class="text-center">{{ trans('app.Total Price')}} (<?php echo getCurrencySymbols(); ?>) </th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$total1=0;
							$i = 1 ; 
							if(!empty($all_data))
							{
								foreach($all_data as $ser_proc)
								{
								?>
								<tr>
									<td class="text-center cname"><?php echo $i++; ?></td>
									<td class="text-center cname"> <?php echo $ser_proc->category; ?></td>
									<td class="text-center cname"> <?php echo $ser_proc->obs_point; ?></td>
									<td class="text-center cname"> <?php echo getProduct($ser_proc->product_id); ?></td>
									<td class="text-center cname"> <?php echo $ser_proc->price; ?></td>
									<td class="text-center cname"><?php echo $ser_proc->quantity;?></td>
									<td class="text-center cname"><?php echo $ser_proc->total_price;?></td>
									
									<?php  if(!empty($ser_proc->total_price)){ $total1 += $ser_proc->total_price; }?>
								</tr>
								<?php 
								} 
							}
							?>
						 </tbody>
					</table>
					<table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
							<tr class="printimg">
								<td class="cname" colspan="7">{{ trans('app.OTHER SERVICE CHARGES')}}</td>
							</tr>
					</table>
					<table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">
						<thead>	
							<tr>
								<th class="text-center">#</th>
								<th class="text-center">{{ trans('app.Charge for')}}</th>
								<th class="text-center">{{ trans('app.Product Name')}}</th>
								<th class="text-center">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
								<th class="text-center">{{ trans('app.Total Price')}} (<?php echo getCurrencySymbols(); ?>) </th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$total2=0;
							$i = 1 ; 
							if(!empty($all_data2))
							{
								foreach($all_data2 as $ser_proc2)
								{
								?>
								<tr>
									<td class="text-center cname"><?php echo $i++; ?></td>
									<td class="text-center cname">{{ trans('app.Other Charges')}}</td>
									<td class="text-center cname"><?php echo $ser_proc2->comment; ?></td>
									<td class="text-center cname"><?php echo $ser_proc2->total_price; ?></td>
									<td class="text-center cname"><?php echo $ser_proc2->total_price; ?></td>
									<?php if(!empty($ser_proc2->total_price)){ $total2 += $ser_proc2->total_price; }  ?>
								</tr>
								<?php 
								}
							}
							?>
						</tbody>
					</table>
				
			</div>
		</div>
	</div>
	
	<div class="modal-footer">
		<button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('app.Close')}}</button>
    </div>