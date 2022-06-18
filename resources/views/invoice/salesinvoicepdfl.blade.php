<html>
	<head>
	</head>
	<style>
      body{
      font-family: 'Helvetica';
      font-style: normal;
      font-weight: normal;
      color:#333;
      }
      .itemtable th, td {
      padding: 0px 14px 6px 14px;
      font-size:12px;
      }
      
      #imggrapish{
      margin-top: -50px;
      margin-left: 25px;
      }
      page[size="A4"] {
      background: white;
      width: 21cm;
      height: 29.7cm;
      display: block;
      margin: 0 auto;
      margin-bottom: 0.5cm;
      }
      @media print {
      body, page[size="A4"] {
      margin: 0;
      box-shadow: 0;
      }
      }	
   </style>
	<body>
		<div class="row " id="invoice_print">
				<table width="100%" border="0" style="margin:0px 8px 0px 8px;">
						<tr>
						   <td align="center"style="font-size:18px;">INVOICE # {{$invioce->invoice_number}}</td>
						</tr>
				</table>
		    <div id="imggrapish" class="col-md-12 col-sm-12 col-xs-12">
				<table class="table table-bordered" width="100%" border="0" style="border-collapse:collapse;">
					<thead></thead>
					<tfoot></tfoot>
					<tbody>
						<tr>
							<td align="right">
								<?php $nowdate = date("Y-m-d");?>
								<strong>{{ trans('app.Date')}} : </strong><?php echo  date(getDateFormat(),strtotime($nowdate)); ?>
							</td>
						</tr>
					</tbody>
				</table>
				<br/>
			
				<table class="table table-bordered" width="100%" border="0" style="border-collapse:collapse;">
					<thead></thead>
					<tfoot></tfoot>
					<tbody>
						<tr>
							<td colspan="3" align="center"><h3 style="font-size:18px;"><?php echo $logo->system_name; ?></h3></td>
						</tr>
						<tr>
							<td  width="15%" style="vertical-align:top;float:left; width:15%;" align="left" >
								 <span style="float:left; width:100%;">
									<img src="../public/vehicle/service.png" style="width: 230px; height: 90px;">
									<img src="../public/general_setting/<?php echo $logo->logo_image ?>" width="230px" height="70px" style="position: absolute; top: 115px; left: 35px;">
								</span>
							</td>
							<td width="30%" style="float:left;" align="left">
								<span style="float:left;">
									<?php 
									echo $logo->address;
									echo ", <br>".getCityName($logo->city_id);
									echo ", ".getStateName($logo->state_id);
									echo ", ".getCountryName($logo->country_id);
									echo "<br>".$logo->email;
									echo "<br>".$logo->phone_number; 
									?>
								</span>
							</td>
							<td valign="top" style="valign:top;float:left; width:50%;" width="50%">
								<b>{{ trans('app.Bill Number :')}}</b><?php echo $sales->bill_no; echo "<hr/>"?>
								<b>{{ trans('app.Date :')}}</b><?php echo  date(getDateFormat(),strtotime($sales->date)) ; echo "<hr/>"?>
								<b>{{ trans('app.Status :')}}</b><?php if($invioce->payment_status == 0)
										{ echo"Unpaid"; }
										elseif($invioce->payment_status == 1)
										{ echo"Partially Paid"; }
										elseif($invioce->payment_status == 2)
										{ echo"Paid";}
										else
										{echo"Unpaid";}
									 echo "<hr/>"?>
								<b>{{ trans('app.Sale Amount :')}} (<?php echo getCurrencySymbols(); ?>)</b> <?php echo number_format($invioce->grand_total, 2); echo "<hr/>"?>
							</td>
						</tr>
					</tbody>
				</table>
				<hr/>
					
				<table class="table table-bordered" width="100%" border="0" style="border-collapse:collapse;">
					<thead></thead>
					<tfoot></tfoot>
					<tbody>
						<tr>
							<td width="70%" align="left">
								<p style="font-size:14px;">{{ trans('app.Payment To')}} </p>
							</td>
							<td align="left" width="30%">
								<p style="font-size:14px;">{{ trans('app.Bill To')}} </p>
							</td>
						</tr>
						<tr>
							<td valign="top" width="70%" align="left">
								<?php echo getCustomerAddress($sales->customer_id);?><br/><?php echo getCustomerCity($sales->customer_id); echo",";?><br/><?php echo getCustomerState("$sales->customer_id,");echo" ,";echo getCustomerCountry($sales->customer_id);?>
							</td>
							<td valign="top" width="30%" align="left">
								<b>{{ trans('app.Name :')}} </b> <?php echo getCustomerName($sales->customer_id);?><br><b>{{ trans('app.Mobile :')}} </b><?php echo  getCustomerMobile($sales->customer_id); ?>	<br><b>{{ trans('app.Email :')}} </b><?php echo getCustomerEmail($sales->customer_id);?>
							</td>
						</tr>
					</tbody>
				</table>		
				<hr/>			
				<table class="table table-bordered itemtable" width="100%" border="1" style="border-collapse:collapse;">
					<thead>
						<tr class="printimg" style="background-color:#4E5E6A; color:#fff; border-right: 0px;border-left: 0px;">
							<th align="center" style="padding:8px; font-size:14px; border-right: 0px;border-left: 0px;" colspan="4">
							 {{ trans('app.Vehicle Details')}}</th>
						</tr>
						<tr>
							<th align="center" style="padding:8px;">{{ trans('app.Model')}}</th>
							<th align="center" style="padding:8px;">{{ trans('app.Type')}} </th>
							<th align="center" style="padding:8px;">{{ trans('app.Color')}} </th>
							<th align="center" style="padding:8px;">{{ trans('app.Chasis No')}} </th>
							
						</tr>
					</thead>
					<tbody>
					
						<tr>
							<td align="center" style="padding:8px;"><?php echo $vehicale->modelname; ?></td>
							<td align="center" style="padding:8px;"><?php echo getVehicleType($vehicale->vehicletype_id); ?></td>
							<td align="center" style="padding:8px;"><?php echo getVehicleColor($sales->color_id); ?></td>
							<td align="center" style="padding:8px;"><?php echo $vehicale->chassisno; ?></td>
							
						</tr>
					</tbody>
				</table>
				
				<br/>
				<table class="table table-bordered itemtable" width="100%" border="1" style="border-collapse:collapse;">
					<thead>
						<tr class="printimg">
							<th align="center" style="padding:8px;">{{ trans('app.Description')}}</th>
							<th align="center" style="padding:8px;">{{ trans('app.Amount')}} (<?php echo getCurrencySymbols(); ?>)</th>
						</tr>
						
					</thead>
					<tfoot></tfoot>
					<tbody>
						<tr>
							<td align="right" style="padding:8px;"><?php echo $vehicale->modelname;echo":";?></td>
							<td  align="right" style="padding:8px;"><?php $total_price = $sales->total_price; echo number_format($total_price, 2);?></td>						
						</tr>
							
						<?php
						if(!empty($rto))
						{?>
							<tr>
								<td align="right" style="padding:8px;">{{ trans('app.RTO / Registration / C.R. Temp Tax')}}:</td>
								<td align="right" style="padding:8px;"><?php $rto_reg = $rto->registration_tax; echo number_format($rto_reg, 2); ?></td>
							</tr>
							<tr>
								<td align="right" style="padding:8px;">{{ trans('app.Number Plate Charges')}}:</td>
								<td align="right" style="padding:8px;"><?php $rto_plate = $rto->number_plate_charge; echo number_format($rto_plate, 2); ?></td>
							</tr>
							<tr>
								<td align="right" style="padding:8px;">{{ trans('app.Muncipal Road Tax')}}:</td>
								<td align="right" style="padding:8px;"><?php $rto_road = $rto->muncipal_road_tax; echo number_format($rto_road, 2); ?></td>
							</tr>
				  <?php } ?>
							
							<tr>
							<?php if(!empty($rto)){ $rto_charges = $rto_reg + $rto_plate + $rto_road; } ?>
								<td align="right" style="padding:8px;"><b>{{ trans('app.Total Amount')}}:</b></td>
						<?php  if(!empty($rto))
								{ ?>
									<td align="right" style="padding:8px;"><b><?php $total_amt = $total_price + $rto_charges; echo number_format($total_amt, 2); ?></b></td>
									<?php 
								}
								else 
								{ ?>
									<td align="right" style="padding:8px;"><b><?php $total_amt = $total_price; echo number_format($total_amt, 2); ?></b></td>
						  <?php } ?>
							</tr>
							<tr>
								<td align="right" style="padding:8px;">{{ trans('app.Discount')}} (<?php echo $invioce->discount.'%';?>) : </td>
								<td  align="right" style="padding:8px;"><?php $discount = ($total_amt*$invioce->discount)/100; echo number_format($discount, 2); ?></td>
							</tr>
							<tr>
								<td align="right" style="padding:8px;"><b>{{ trans('app.Total')}} :</b></td>
								<td align="right" style="padding:8px;"><?php $after_dis_total = $total_amt - $discount; echo number_format($after_dis_total, 2);?></td>
							</tr>
							<?php
							
							if(!empty($taxes)) 
							{
							$total_tax = 0;
							$taxes_amount = 0;
								foreach($taxes as $tax)
								{
									$taxes_per = preg_replace("/[^0-9,.]/", "", $tax);
									
									$taxes_amount = ($after_dis_total*$taxes_per)/100;
									
									$total_tax +=  $taxes_amount;
								?>
									
									<tr>
										<td align="right" style="padding:8px;"><?php echo $tax; ?>:</td>
										<td align="right" style="padding:8px;"><?php echo number_format($taxes_amount, 2);?> </td>
									</tr>
						<?php	}
								$final_grand_total = $after_dis_total+$total_tax;
							}
							else
							{
								$final_grand_total = $after_dis_total;
								
							}
							?>	
							<tr>
								<td align="right" style="padding:8px;"><b>{{ trans('app.Grand Total')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
								<td align="right" style="padding:8px;"><b><?php $final_grand_total; echo number_format($final_grand_total, 2);?></b></td>
							</tr>
					</tbody>
				</table>
			</div>
		</div>
	</body>
</html>
	