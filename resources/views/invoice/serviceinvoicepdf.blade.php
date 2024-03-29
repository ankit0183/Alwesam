<html>
   <head></head>
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
						   <td align="center"style="font-size:18px;">INVOICE # {{$service_tax->invoice_number}}</td>
						</tr>
				</table>
		  <div id="imggrapish" class="col-md-12 col-sm-12 col-xs-12">
			  <table width="100%" border="0">
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
			  <table width="100%" border="0">
				 <thead></thead>
				 <tfoot></tfoot>
				 <tbody>
					<tr>
					   <td colspan="3" align="center">
						  <h3 style="font-size:18px;"><?php echo $logo->system_name; ?></h3>
					   </td>
					</tr>
					<tr>
					  <td  width="15%" style="vertical-align:top;float:left; width:15%;" align="left" >
						  <span style="float:left; width:100%;">
						  <img src="./../public/vehicle/service.png" style="width: 230px; height: 90px;">
						  <img src="./../public/general_setting/<?php echo $logo->logo_image ?>" width="230px" height="70px" style="position: absolute; top: 115px; left: 35px;">
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
							 
							<b>{{ trans('app.Name:')}}</b> <?php echo getCustomerName($tbl_services->customer_id); echo "<hr/>"?> 
							<b>{{ trans('app.Address:')}}</b>  <?php echo $customer->address; echo" ,"; echo getCityName("$customer->city_id");?><?php echo",";?><?php echo getStateName("$customer->state_id,");echo" ,";echo getCountryName($customer->country_id); echo "<hr/>"?>
							<b>{{ trans('app.Contact:')}}</b> <?php echo"$customer->mobile_no";  echo "<hr/>"?>
							<b>{{ trans('app.Email :')}}</b> <?php echo $customer->email;  echo "<hr/>" ?>
					   </td>
					</tr>
				 </tbody>
			  </table>
			  <br/>
			  <hr/>
			  <table class="table table-bordered" border="1" width="100%" style="border-collapse:collapse;">
				 <thead></thead>
				 <tfoot></tfoot>
				 <tbody class="itemtable">
					<tr>
					   <th align="center" style="padding:8px;">{{ trans('app.Jobcard Number')}}</th>
					   <th align="center" style="padding:8px;">{{ trans('app.Vehicle Name')}}</th>
					   <th align="center" style="padding:8px;">{{ trans('app.Regi. No.')}}</th>
					   <th align="center" style="padding:8px;">{{ trans('app.In Date')}}</th>
					   <th align="center" style="padding:8px;">{{ trans('app.Out Date')}}</th>
					</tr>
					<tr>
					   <td align="center" style="padding:8px;"><?php  echo"$tbl_services->job_no"; ?></td>
					   <td align="center" style="padding:8px;"><?php echo getVehicleName($job->vehicle_id) ?></td>
					   <td align="center" style="padding:8px;"><?php if(!empty($s_date)) { echo $s_date->registration_no; }else{ echo $vehical->registration_no; } ?> </td>
					   <td align="center" style="padding:8px;"><?php  if(!empty($job)){ echo date(getDateFormat(),strtotime($job->in_date));} ?> </td>
					   <td align="center" style="padding:8px;"><?php  if(!empty($job)){ echo date(getDateFormat(),strtotime($job->out_date)); } ?> </td>
					</tr>
					<tr>
					   <th align="center" style="padding:8px;">{{ trans('app.Repair Category')}}</th>
					   <th align="center" style="padding:8px;">{{ trans('app.Service Type')}}</th>
					   <th align="center" style="padding:8px;" colspan="3">{{ trans('app.Details')}}</th>
					</tr>
					<tr>
					   <td align="center" style="padding:8px;"><?php echo $tbl_services->service_category; ?> </td>
					   <td align="center" style="padding:8px;"><?php echo $tbl_services->service_type; ?> </td>
					   <td align="center" style="padding:8px;" colspan="3"><?php echo $tbl_services->detail; ?> </td>
					</tr>
				 </tbody>
			  </table>
			  <br/>
			  <table class="table table-bordered itemtable" width="100%" border="1" style="border-collapse:collapse;">
				 <thead></thead>
				 <tfoot></tfoot>
				 <tbody>
					
				
					<?php 
					   $total1=0;
					   $i = 1 ;
					   foreach($service_pro as $service_pros)
					   { ?>
					<tr>
					   <td align="center" style="padding:8px;"><?php echo $i++; ?></td>
					   <td align="center" style="padding:8px;"> <?php echo $service_pros->category; ?></td>
					   <td align="center" style="padding:8px;"> <?php echo $service_pros->obs_point; ?></td>
					   <td align="center" style="padding:8px;"> <?php echo getProduct($service_pros->product_id); ?></td>
					   <td align="center" style="padding:8px;"> <?php echo number_format($service_pros->price, 2); ?></td>
					   <td align="center" style="padding:8px;"><?php echo $service_pros->quantity;?></td>
					   <td align="right" style="padding:8px;"><?php echo number_format($service_pros->total_price, 2);?></td>
					   <?php $total1 += $service_pros->total_price;	 ?>
					</tr>
					<?php } ?>
					
					<tr>
					   <th align="center" style="padding:8px;">#</th>
					   <th align="center" style="padding:8px;" colspan="2">{{ trans('app.Charge for')}}</th>
					   <th align="center" style="padding:8px;">{{ trans('app.Product Name')}}</th>
					   <th align="center" style="padding:8px;" colspan="2">{{ trans('app.Price')}} (<?php echo getCurrencySymbols(); ?>)</th>
					   <th align="center" style="padding:8px;">{{ trans('app.Total Price')}} (<?php echo getCurrencySymbols(); ?>) </th>
					</tr>
					<?php 
					   $total2=0;
					   $i = 1 ;
					   foreach($service_pro2 as $service_pros)
					   { ?>
					<tr>
					   <td align="center" style="padding:8px;"><?php echo $i++; ?></td>
					   <td align="center" style="padding:8px;" colspan="2">{{ trans('app.Other Charges')}}</td>
					   <td align="center" style="padding:8px;"><?php echo $service_pros->comment; ?></td>
					   <td align="center" style="padding:8px;" colspan="2"><?php echo number_format((float)$service_pros->total_price, 2); ?></td>
					   <td align="right" style="padding:8px;" ><?php echo number_format((float)$service_pros->total_price, 2); ?></td>
					   <?php $total2 += $service_pros->total_price;  ?>
					</tr>
					<?php } ?>	
					<tr>
					   <td align="center" style="padding:8px;" colspan="6"><b>{{ trans('app.Fix Service Charge')}}<b></td>
					   <td align="right" style="padding:8px;" ><?php $fix = $tbl_services->charge; if(!empty($fix)) { echo number_format($fix, 2); } else { echo 'Free Service'; } ?></td>
					</tr>
				 </tbody>
			  </table>
			 <br/>
			  <table class="table table-bordered itemtable" width="100%" border="1" style="border-collapse:collapse;">
				 <thead></thead>
				 <tfoot></tfoot>
				 <tbody>
					<tr>
					   <td align="right" style="padding:8px;" width="80%"><b>{{ trans('app.Total Service Amount')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
					   <td align="right" style="padding:8px;" ><b><?php $total_amt = $total1 + $total2 + $fix; echo number_format($total_amt, 2);  ?></b></td>
					</tr>
					<tr>
					   <td align="right" style="padding:8px;" width="80%"><b>{{ trans('app.Discount')}} (<?php echo $dis = $service_tax->discount.'%'; ?>):</b></td>
					   <td align="right" style="padding:8px;"><b><?php $dis = $service_tax->discount; $discount = ($total_amt*$dis)/100; echo number_format($discount, 2); ?></b></td>
					</tr>
					<tr>
					   <td align="right" style="padding:8px;" width="80%"><b>{{ trans('app.Total')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
					   <td align="right" style="padding:8px;" ><b><?php $after_dis_total = $total_amt-$discount; echo number_format($after_dis_total, 2); ?></b></td>
					</tr>
					<?php 
					   $all_taxes = 0;
					   $total_tax = 0;
					   if(!empty($service_taxes))
					   {
						foreach($service_taxes as $ser_tax)
						{ 
							$taxes_to_count = preg_replace("/[^0-9,.]/", "", $ser_tax);
						
							$all_taxes = ($after_dis_total*$taxes_to_count)/100;  
							
							$total_tax +=  $all_taxes;
							
						?>
					<tr>
					   <td align="right" style="padding:8px;" width="80%"><b><?php echo $ser_tax;  ?> :</b></td>
					   <td align="right" style="padding:8px;" ><b><?php $all_taxes; echo number_format($all_taxes, 2); ?></b></td>
					</tr>
					<?php 
					   }
					   $final_grand_total = $after_dis_total+$total_tax;
					   }else
					   {
					   $final_grand_total = $after_dis_total;
					   }
					   ?>
					<tr>
					   <td align="right" style="padding:8px;" width="80%"><b>{{ trans('app.Grand Total')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
					   <td align="right" style="padding:8px;"><b><?php $final_grand_total; echo number_format($final_grand_total, 2);?></b></td>
					</tr>
				 </tbody>
			  </table>
			</div>
		</div>
   </body>
</html>