<html>
   <head>
      <script language="javascript">
         function PrintElem(el) {
           
         	var restorepage = $('body').html();
         	var printcontent = $('#' + el).clone();
         	$('body').empty().html(printcontent);
         	window.print();
         	$('body').html(restorepage);
         }
      </script>
      <script src="{{ URL::asset('vendors/datatables.net/js/jquery.dataTables.min.js') }}"></script>
      <script>
         $(document).ready(function() {
         $('.adddatatable').DataTable({
         responsive: true,
         paging: false,
         lengthChange: false,
         ordering: false,
         searching: false,
         info: false,
         autoWidth: true,
         sDom: 'lfrtip'
         
         });
         });
      </script>		
   </head>
   <body>
      <div id="sales_print" class="col-md-12">
         <style>
            b, strong {
            font-weight: 500;
            }
            th {
            font-weight: 500;
            }
         </style>
         <table width="100%" border="0">
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
         <div class="row">
			<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom: 20px;">
				<h3 class="text-center"><?php echo $logo->system_name; ?></h3>
			</div>
			<br/>
            <div class="col-md-7 col-sm-7 col-xs-12">
               
               <div class="col-md-6 col-sm-12 col-xs-12 printimg">
                  <img src="{{ URL('public/vehicle/service.png')}}" style="width: 225px; height: 90px;">
                  <img src="{{ url::asset('public/general_setting/'.$logo->logo_image)}}" width="230px" height="70px" style="position: absolute; top: 10px; left: 0px;">
               </div>
               <div class="col-md-6 col-sm-12 col-xs-12">
                  <p>
                     <?php 
                        echo $logo->address;
						echo ", <br>".getCityName($logo->city_id);
                        echo ", ".getStateName($logo->state_id);
                        echo ", ".getCountryName($logo->country_id);
                        echo "<br>".$logo->email;
                        echo "<br>".$logo->phone_number;
                        ?>
                  </p>
               </div>
            </div>
            <div class="col-md-5 col-sm-5 col-xs-12">
               <table class="table" width="100%" style="border-collapse:collapse;">
                  <tr>
                     <th class="cname">{{ trans('app.Name:')}} </th>
                     <td class="cname"> <?php echo getCustomerName($tbl_services->customer_id);?>  </td>
                  </tr>
                  <tr>
                     <th class="cname">{{ trans('app.Address:')}} </th>
                     <td class="cname"> <?php echo $customer->address; echo" ,"; echo getCityName("$customer->city_id");?><?php echo",";?><?php echo getStateName("$customer->state_id,");echo" ,";echo getCountryName($customer->country_id);?></td>
                  </tr>
                  <tr>
                     <th class="cname">{{ trans('app.Contact:')}} </th>
                     <td class="cname"><?php echo"$customer->mobile_no"; ?></td>
                  </tr>
                  <tr>
                     <th class="cname">{{ trans('app.Email :')}} </th>
                     <td class="cname"><?php echo $customer->email ?></td>
                  </tr>
               </table>
            </div>
            <hr/>
            <div class="row">
               <div class="col-md-12 col-sm-12 col-xs-12">
                  <table class="table table-bordered adddatatable" width="100%" border="1"  style="border-collapse:collapse;">
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
                        <tr>
                           <td class="cname text-center"><?php  echo"$tbl_services->job_no"; ?></td>
                           <td class="cname text-center"><?php if(!empty($job->coupan_no)){echo $job->coupan_no;} else{ echo "Paid Service";} ?></td>
                           <td class="cname text-center"><?php echo getVehicleName($job->vehicle_id) ?></td>
                           <td class="cname text-center"><?php if(!empty($s_date)) { echo $s_date->registration_no; }else{echo $vehical->registration_no;} ?> </td>
                           <td class="cname text-center"><?php  if(!empty($job)){ echo date(getDateFormat(),strtotime($job->in_date));} ?> </td>
                           <td class="cname text-center"><?php  if(!empty($job)){ echo date(getDateFormat(),strtotime($job->out_date)); } ?> </td>
                        </tr>
                     </tbody>
                  </table>
                  <table class="table table-bordered adddatatable" width="100%" border="1"  style="border-collapse:collapse;">
                     <thead>
                        <tr>
                          
                           <th class="cname text-center">{{ trans('app.Repair Category')}}</th>
                           <th class="cname text-center">{{ trans('app.Service Type')}}</th>
                           <th class="cname text-center">{{ trans('app.Details')}}</th>
                        </tr>
                     </thead>
                     <tbody>
                        <tr>
                           
                           <td class="cname text-center"><?php echo $tbl_services->service_category; ?> </td>
                           <td class="cname text-center"><?php echo $tbl_services->service_type; ?> </td>
                           <td class="cname text-center"><?php echo $tbl_services->detail; ?> </td>
                        </tr>
                     </tbody>
                  </table>
                  
                  <table class="table table-bordered adddatatable" width="100%" border="1" style="border-collapse:collapse;">
                    
                     <tbody>
                        <?php 
                           $total1=0;
                           $i = 1 ;
                           foreach($service_pro as $service_pros)
                           { ?>
                        <tr>
                           <td class="text-center cname"><?php echo $i++; ?></td>
                           <td class="text-center cname"> <?php echo $service_pros->category; ?></td>
                           <td class="text-center cname"> <?php echo $service_pros->obs_point; ?></td>
                           <td class="text-center cname"> <?php echo getProduct($service_pros->product_id); ?></td>
                           <td class="text-center cname"> <?php echo number_format($service_pros->price, 2); ?></td>
                           <td class="text-center cname"><?php echo $service_pros->quantity;?></td>
                           <td class="text-center cname"><?php echo number_format($service_pros->total_price, 2);?></td>
                           <?php $total1 += $service_pros->total_price;	 ?>
                        </tr>
                        <?php }
                           ?>
                     </tbody>
                  </table>
                  <table class="table table-bordered" width="100%" border="1" style="border-collapse:collapse;">
                     <tr class="printimg">
                        <td class="cname"><b>{{ trans('app.OTHER SERVICE CHARGES')}}</b></td>
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
                           foreach($service_pro2 as $service_pros)
                           { ?>
                        <tr>
                           <td class="text-center cname"><?php echo $i++; ?></td>
                           <td class="text-center cname">{{ trans('app.Other Charges')}}</td>
                           <td class="text-center cname"><?php echo $service_pros->comment; ?></td>
                           <td class="text-center cname"><?php echo number_format((float)$service_pros->total_price, 2); ?></td>
                           <td class="text-center cname"><?php echo number_format((float)$service_pros->total_price, 2); ?></td>
                           <?php $total2 += $service_pros->total_price;  ?>
                        </tr>
                        <?php }
                           ?>	
                     </tbody>
                  </table>
                  <hr>
                  <table class="table table-bordered" width="100%" style="border-collapse:collapse;">
                     <tr>
                        <td class="text-center cname"><b>{{ trans('app.Fix Service Charge')}}<b></td>
                        <td class="text-center cname"><?php $fix = $tbl_services->charge; if(!empty($fix)) { echo number_format($fix, 2); } else { echo 'Free Service'; } ?></td>
                     </tr>
                     <tr>
                        <td class="text-right cname" width="81.5%"><b>{{ trans('app.Total Service Amount')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
                        <td class="text-center cname" ><b><?php $total_amt = $total1 + $total2 + $fix; echo number_format($total_amt, 2);  ?></b></td>
                     </tr>
                     <tr>
                        <td class="text-right cname" width="81.5%"><b>{{ trans('app.Discount')}} (<?php echo $dis = $service_tax->discount.'%'; ?>):</b></td>
                        <td class="text-center cname"><b><?php $dis = $service_tax->discount; $discount = ($total_amt*$dis)/100; echo number_format($discount, 2); ?></b></td>
                     </tr>
                     <tr>
                        <td class="text-right cname" width="81.5%"><b>{{ trans('app.Total')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
                        <td class="text-center cname"><b><?php $after_dis_total = $total_amt-$discount; echo number_format($after_dis_total, 2); ?></b></td>
                     </tr>
                     <?php 
                        if(!empty($service_taxes))
                        {
                        	$all_taxes = 0;
                        	$total_tax = 0;
                        	foreach($service_taxes as $ser_tax)
                        	{ 
                        		$taxes_to_count = preg_replace("/[^0-9,.]/", "", $ser_tax);
                        	
                        		$all_taxes = ($after_dis_total*$taxes_to_count)/100;  
                        		
                        		$total_tax +=  $all_taxes;
                        		
                        ?>
                     <tr>
                        <td class="text-right cname" width="81.5%"><b><?php echo $ser_tax;  ?> % :</b></td>
                        <td class="text-center cname" width="81.5%"><b><?php $all_taxes; echo number_format($all_taxes, 2); ?></b></td>
                     </tr>
                     <?php 
                        }
                        $final_grand_total = $after_dis_total+$total_tax;
                        }
                        else{
                        $final_grand_total = $after_dis_total;
                        }
                        ?>
                     <tr>
                        <td class="text-right cname" width="81.5%"><b>{{ trans('app.Grand Total')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
                        <td class="text-center cname"><b><?php $final_grand_total; echo number_format($final_grand_total, 2);?></b></td>
                     </tr>
					  <?php  
							$paid_amount = $service_tax->paid_amount; 
						    $Adjustmentamount = $final_grand_total - $paid_amount; ?>
					 <tr>
                        <td class="text-right cname" width="81.5%"><b>{{ trans('app.Adjustment Amount')}} (<?php echo getCurrencySymbols(); ?>) :</b></td>
                        <td class="text-center cname"><b><?php $paid_amount; echo number_format($paid_amount, 2);?></b></td>
                     </tr>
					 
					 <tr>
                        <td class="text-right cname" width="81.5%"><b>{{ trans('app.Amount Due') }} ({{ getCurrencySymbols()}}) :</b></td>
                        <td class="text-center cname"><b><?php $Adjustmentamount; echo number_format($Adjustmentamount, 2);?></b></td>
                     </tr>
					 
                  </table>
               </div>
            </div>
         </div>
      </div>
      <div class="row">
         <div class="col-md-12 col-sm-12 col-xs-12 modal-footer">
            <div class="col-md-6 col-sm-6 col-xs-3 modal-footer">
			@if(Auth::user()->role!='employee')
				@if($Adjustmentamount != 0)
					<script src="https://js.stripe.com/v3/"></script>
					<form method="post" action="{{ url('invoice/stripe')}}" class="medium" id="medium">
					  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
					  <input type='hidden' name="invoice_amount" value="{{$Adjustmentamount}}">
					  <input type='hidden' name="invoice_id" value="{{$service_tax->id}}">
					  <input type='hidden' name="invoice_no" value="{{$service_tax->invoice_number}}">
					  
						
					  
					</form>
				@else
					{{-- <input type="submit" class="btn btn-default text-right" value="{{ trans('app.Pay with card')}}" disabled/>	 --}}
				@endif
			@endif
            </div>
            <div class="col-md-6 col-sm-6 col-xs-9 modal-footer" style="text-align:left;">
               <!-- <a href="<?php echo "http://".$_SERVER['SERVER_NAME']."/garage/invoice/list"; ?>" class="btn btn-default ><button type="button" >{{ trans('app.Payment Record')}}</button></a> -->
			   
               <button type="button" class="btn btn-default printbtn" id="" onclick="PrintElem('sales_print')">{{ trans('app.Print')}} </button>
			   <a href="{{ url('invoice/servicepdf/'.$service_tax->id)}}" class="prints"><button type="button" class="btn btn-default" style="margin-left: 15px;" >{{ trans('app.PDF')}}</button></a>
               <a href="" class="prints"><button type="button" class="btn btn-default" style="margin-left: 15px;
                  " >{{ trans('app.Close')}}</button></a>
            </div>
         </div>
      </div>
   </body>
</html>