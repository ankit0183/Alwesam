<?php
if(!function_exists('getCategory'))
{
	function getCategory($id)
	{
		switch($id)
		{
			case 0:
				return 'Vehicle';
				break;
			case 1:
				return 'Part';
				break;
			default:
				return 'Invalid';
				break;
		}
	}
}

if(!function_exists('getPart'))
{
	function getPart($id)
	{
		return DB::table('tbl_products')->find($id);
	}
}

// Get getRegistrationNo
if (!function_exists('getRegistrationNo')) {
	function getRegistrationNo($id)
	{
	     $tbl_sales=DB::table('tbl_sales')->where('vehicle_id','=',$id)->first();
		 
		if(!empty($tbl_sales))
		{
			$registration_no=$tbl_sales->registration_no;
			return $registration_no;
		}
		else
		{
			$tbl_vehicles=DB::table('tbl_vehicles')->where('id','=',$id)->first();
			$regno=$tbl_vehicles->registration_no;
			if(!empty($regno))
			{
				return $regno;
			}
			else
			{
				return '';
			}
		}
	}
}
// Get getProductcode
if (!function_exists('getProductcode')) {
	function getProductcode($id)
	{
	    $product=DB::table('tbl_products')->where('id','=',$id)->first();
		if(!empty($product))
		{
			$code=$product->product_no;
			return $code;
		}
		else
		{
			return '';
		}
	}
}
// Get getCellProduct
if (!function_exists('getTotalProduct')) {
	function getTotalProduct($id,$s_date,$e_date)
	{
		if($s_date == '' && $e_date == '')
		{
			$totalstock=DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->where('product_id','=',$id)
			->get()->toArray();
		}
		else
		{
			$totalstock=DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->whereBetween('date', [$s_date, $e_date])
			->where('product_id','=',$id)
			->get()->toArray();
		}
		
		$stocktotal=0;
		if(!empty($totalstock))
		{
			foreach($totalstock as $totalstocks)
			{
				$total_stock=$totalstocks->qty;
				$stocktotal += $total_stock;
			}
			return $stocktotal;
		}
		else
		{
			return 0;
		}
	}
}
// Get getCellProduct
if (!function_exists('getCellProduct')) {
	function getCellProduct($id,$s_date,$e_date)
	{
		if($s_date == '' && $e_date == '')
		{
			$cellstock=DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')
			->where('product_id','=',$id)
			->get()->toArray();
		}
		else
		{
			$cellstock=DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')
			->whereBetween('service_date', [$s_date, $e_date])
			->where('product_id','=',$id)
			->get()->toArray();
		}
		$celltotal=0;
		if(!empty($cellstock))
		{
			foreach($cellstock as $cellstocks)
			{
				$cell_stock=$cellstocks->quantity;
				$celltotal += $cell_stock;		
			}
			return $celltotal;
		}
		else
		{
			return 0;
		}
	}
}

if (!function_exists('getCellProductSale')) {
	function getCellProductSale($id,$s_date,$e_date)
	{
		if($s_date == '' && $e_date == '')
		{
			$cellstock=DB::table('tbl_sale_parts')
			->where('product_id','=',$id)
			->get()->toArray();
		}
		else
		{
			$cellstock=DB::table('tbl_sale_parts')
			->whereBetween('date', [$s_date, $e_date])
			->where('product_id','=',$id)
			->get()->toArray();
		}
		$celltotal=0;
		if(!empty($cellstock))
		{
			foreach($cellstock as $cellstocks)
			{
				$cell_stock=$cellstocks->quantity;
				$celltotal += $cell_stock;		
			}
			return $celltotal;
		}
		else
		{
			return 0;
		}
	}
}

// Get getStockProduct
if (!function_exists('getStockProduct')) {
	function getStockProduct($id,$s_date,$e_date)
	{
		if($s_date == '' && $e_date == '')
		{
			$totalstock=DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->where('product_id','=',$id)
			->get()->toArray();
			
			$cellstock=DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')
			->where('product_id','=',$id)
			->get()->toArray();
		}
		else
		{
			$totalstock=DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->whereBetween('date', [$s_date, $e_date])
			->where('product_id','=',$id)
			->get()->toArray();
		   
			$cellstock=DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')
			->whereBetween('service_date', [$s_date, $e_date])
			->where('product_id','=',$id)
			->get()->toArray();
			
		}
		
		$stocktotal=0;
		if(!empty($totalstock))
		{
			foreach($totalstock as $totalstocks)
			{
				$total_stock=$totalstocks->qty;
				$stocktotal += $total_stock;
			}
			$currenttotal = $stocktotal;
		}
		else
		{
			$currenttotal= 0;
		}
		
		$celltotal=0;
		if(!empty($cellstock))
		{
			foreach($cellstock as $cellstocks)
			{
				$cell_stock=$cellstocks->quantity;
				$celltotal += $cell_stock;		
			}
			$totalcellcurrent=$celltotal;
		}
		else
		{
			$totalcellcurrent = 0;
		}
		
		$finalcurrenttotal = $currenttotal - $totalcellcurrent;
		return $finalcurrenttotal;
	}
}

// Get getStockProduct
if (!function_exists('getTotalStock')) {
	function getTotalStock($id)
	{
		$totalstock=DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->where('product_id','=',$id)
			->get()->toArray();
		$stocktotal=0;
		if(!empty($totalstock))
		{
			foreach($totalstock as $totalstocks)
			{
				$total_stock=$totalstocks->qty;
				$stocktotal += $total_stock;
			}
			$total= $stocktotal;
		}
		else
		{
			$total= $stocktotal;
		}
		$cellstock=DB::table('tbl_service_pros')->where('product_id','=',$id)
			->get()->toArray();
		$celltotal=0;
		if(!empty($cellstock))
		{
			foreach($cellstock as $cellstocks)
			{
				$cell_stock=$cellstocks->quantity;
				$celltotal += $cell_stock;		
			}
			$totalcellcurrent=$celltotal;
		}
		else
		{
			$totalcellcurrent=$celltotal;
		}
		
		$totalcurrentstock = $total - $totalcellcurrent;
		return $totalcurrentstock;
	}
}
// Get getEmployeeservice
if (!function_exists('getEmployeeservice')) {
	function getEmployeeservice($id,$salesid,$nowmonthdate,$nowmonthdate1)
	{
		
	
		// $tbl_services=DB::select("SELECT * FROM `tbl_services` WHERE `sales_id` = '$salesid' AND `assign_to` = '$id' AND `done_status` LIKE '2' AND `customer_id` = 6 AND (service_date BETWEEN '" . $nowmonthdate . "' AND  '" . $nowmonthdate1 . "')");
		
		$tbl_services= DB::select("SELECT * FROM tbl_services where (done_status=2) and (assign_to='$id') and (sales_id='$salesid') and(service_date BETWEEN '" . $nowmonthdate . "' AND  '" . $nowmonthdate1 . "')");
		
			
			if(!empty($tbl_services))
			{
				foreach($tbl_services as $tbl_services)
				{
					$assign_to=$tbl_services->assign_to;
					$admin=DB::table('users')->where('id','=',$assign_to)->first();
					$dd=$admin->id;
					return $dd;
				}
			}
			else
			{
				return '';
			}
	}
}
// Get model name in sales module

if (!function_exists('getModelName')) {
	function getModelName($id)
	{
		$tbl_vehicles = DB::table('tbl_vehicles')->where('id','=',$id)->first();

		if(!empty($tbl_vehicles))
		{
			$modelname	 = $tbl_vehicles->modelname;
			return $modelname;
		}
		else
		{
			return '';
		}
	}
}

// Get Unit  name in jobcardproccess module

if (!function_exists('getUnitName')) {
	function getUnitName($id)
	{
		$tbl_product_units = DB::table('tbl_product_units')->where('id','=',$id)->first();

		if(!empty($tbl_product_units))
		{
			$name	 = $tbl_product_units->name;
			return $name;
		}
		else
		{
			return '';
		}
	}
}
// Get invoice number from tbl_invoices
if (!function_exists('getInvoiceNumber')) {
	function getInvoiceNumber($id)
	{
		$data = DB::table('tbl_invoices')->where([['sales_service_id',$id],['job_card','NOT LIKE','J%'],['type',1]])->first();
		
		if(!empty($data))
		{
			$invoice = $data->invoice_number;
			return $invoice;
		}
		else
		{
			return "No data";
		}
	}
}

if (!function_exists('getInvoiceNumbers')) {
	function getInvoiceNumbers($id)
	{
		$data = DB::table('tbl_invoices')->where([['sales_service_id',$id],['type',2]])->first();
		
		if(!empty($data))
		{
			$invoice = $data->invoice_number;
			return $invoice;
		}
		else
		{
			return "No data";
		}
	}
}

// Select Product 
if (!function_exists('getSelectedProduct')) {
	function getSelectedProduct($id,$pro_id)
	{	
		
		$data  = DB::table('tbl_service_pros')->where([['service_id','=',$id],['product_id','=',$pro_id]])->first();
		
		if(!empty($data))
		{
			$p_id = $data->product_id;
			return $p_id;
		}	
	}
}
// Get Sum Of Income 
if (!function_exists('getSumOfIncome')) {
	function getSumOfIncome($id)
	{	
		
		$data  = DB::table('tbl_income_history_records')->where('tbl_income_id','=',$id)->SUM('income_amount');
		
		return $data;	
		
	}
}


// Get Sum Of Expense 
if (!function_exists('getSumOfExpense')) {
	function getSumOfExpense($id)
	{	
		$data  = DB::table('tbl_expenses_history_records')->where('tbl_expenses_id','=',$id)->SUM('expense_amount');
		return $data;
	}
}
// Get Invoice Status 
if (!function_exists('getInvoiceStatus')) {
	function getInvoiceStatus($jobcard)
	{	
		
		$data  = DB::table('tbl_invoices')->where('job_card','=',$jobcard)->first();
		
		if(!empty($data))
		{
			return "Yes";
		}
		else
		{
			return "No";
		}
		
	}
}
// Get status of processed jobcard for gatepass
if (!function_exists('getJobcardStatus')) {
	function getJobcardStatus($jobcard)
	{
		$data  = DB::table('tbl_gatepasses')->where('jobcard_id','=',$jobcard)->first();
		if(!empty($data))
		{
			$jbno = $data->ser_pro_status;
		    return $jbno;
		}
	}
}

// Get status for checked observation points
if (!function_exists('getCheckedStatus')) {
	function getCheckedStatus($id,$ids)
	{	
		
		//var_dump($id,$ids);
		//$data  = DB::table('tbl_service_observation_points')->where([['observation_points_id','=',$id],['services_id','=',$ids]])->first();
		$data  = DB::table('tbl_service_observation_points')
					->join('tbl_service_pros','tbl_service_observation_points.id','=','tbl_service_pros.tbl_service_observation_points_id')
					->where([['tbl_service_observation_points.observation_points_id','=',$id],['tbl_service_observation_points.services_id','=',$ids],['tbl_service_pros.type','=',0]])->first();
		
		if(!empty($data))
		{
			$review = $data->review;
			
			if($review == 1)
			{
				return 'checked' ;
			}
			else
			{
				return '';
			}	 
		}	
	}
}


// Get observation points

if (!function_exists('getObservationPoint')) {
	function getObservationPoint($id)
	{
		$data  = DB::table('tbl_points')->where('id','=',$id)->first();
		if(!empty($data))
		{
			$name = $data->checkout_point;
			return $name;
		}
	}
}

// Get subcategory of the main checkpoints

if (!function_exists('getCheckPointSubCategory')) {
	function getCheckPointSubCategory($id,$vid)
	{	
		
		$data  = DB::table('tbl_points')->where([['checkout_subpoints','=',$id],['vehicle_id','=',$vid]])->get()->toArray();
		
		if(!empty($data))
		{
			return $data;
		}	
	}
}

// Get checkpoints of main category
if (!function_exists('getCheckPoint')) {
	function getCheckPoint($id)
	{	
		$categorypoint = array();
		$categorypoint = DB::table('tbl_points')->where('checkout_subpoints','=',$id)->get()->toArray();
		if(!empty($categorypoint))
		{
			return $categorypoint;
		}
		else
		{
			return $categorypoint;
		}
	}
}

// GET value if Gatepass already created

if (!function_exists('getAlreadypasss')) {
	function getAlreadypasss($job_no)
	{	
		$jobno = DB::table('tbl_gatepasses')->where('jobcard_id',$job_no)->count();
		if($jobno > 0)
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}
}

// Get City Name In Customer,Employee,supplier module
if (!function_exists('getCityName')) {
	function getCityName($id)
	{
		$city = DB::table('tbl_cities')->where('id','=',$id)->first();
		if(!empty($city))
		{
			$city_name = $city->name;
			return $city_name;
		}
	}
}

// Get State Name In Customer,Employee,supplier module
if (!function_exists('getStateName')) {
	function getStateName($id)
	{	
		$state = DB::table('tbl_states')->where('id','=',$id)->first();
		if(!empty($state))
		{
			$state_name = $state->name;
			return $state_name;
		}
	}
}

// Get Country Name In Customer,Employee,supplier module
if (!function_exists('getCountryName')) {
	function getCountryName($id)
	{
		$country = DB::table('tbl_countries')->where('id','=',$id)->first();
		if(!empty($country))
		{
			$country_name = $country->name;
			return $country_name;
		}
	}
}

// Get Product Name In Producttype module
if (!function_exists('getProductName')) {
	function getProductName($id)
	{
		$product_tpye = DB::table('tbl_product_types')->where('id','=',$id)->first();
		if(!empty($product_tpye))
		{
			$product_name = $product_tpye->type;
			
			return $product_name;
		}
	}
}

// Get Product Name In getproducttyid module
if (!function_exists('getproducttyid')) {
	function getproducttyid($id)
	{
		$product_tpye = DB::table('tbl_products')->where('id','=',$id)->first();
		if(!empty($product_tpye))
		{
			$product_type_id = $product_tpye->product_type_id;
			
			return $product_type_id;
		}
	}
}

// Get Product Name In Product module
if (!function_exists('getProduct')) {
	function getProduct($id)
	{
		$product = DB::table('tbl_products')->where('id','=',$id)->first();
		if(!empty($product))
		{
			$productname = $product->name;
			return $productname;
		}
	}
}
// Get Supplier Name In Product module
if (!function_exists('getSupplierName')) {
	function getSupplierName($id)
	{	
		$users = DB::table('users')->where([['id','=',$id],['role','=','Supplier']])->first();
		if(!empty($users))
		{
			$supplier_name = $users->name;
			return $supplier_name;
		}
	}
}

// Get Company Name In Product module
if (!function_exists('getCompanyName')) {
	function getCompanyName($id)
	{	
		$users = DB::table('users')->where([['id','=',$id],['role','=','Supplier']])->first();
		if(!empty($users))
		{
			$display_name = $users->display_name;
			return $display_name;
		}
	}
}

// Get Product List Name In Supplier module
if (!function_exists('getProductList')) {
	function getProductList($id)
	{	
		$tbl_products = DB::table('tbl_products')->where('supplier_id','=',$id)->get()->toArray();
		if(!empty($tbl_products))
		{
			$supplier_id = array();
			foreach($tbl_products as $tbl_productss)
			{ 
				$supplier_id[] = $tbl_productss->name;
			}
			$name = implode(', ',$supplier_id);
			return $name;
		}
		else
		{
			return '';
		}
	}
}


// Get Color Name In Product module
if (!function_exists('getColor')) {
	function getColor($id)
	{
		$color = DB::table('tbl_colors')->where('id','=',$id)->first();
		if(!empty($color))
		{
			$color_name = $color->color;
			return $color_name;
		}
	}
}

// Get RTl value for all module
if (!function_exists('getValue')) {
	function getValue()
	{
		$id = Auth::user()->id;
		$rtls = DB::table('users')->where('id',$id)->first();
		if(!empty($rtls))
		{
			$direction_name = $rtls->gst_no;
			
			return $direction_name;
		}
	}
}

// Get Vehicle Name value In Rto managament module

if (!function_exists('getVehicleName')) {
	function getVehicleName($id)
	{	
		$vehicles  = DB::table('tbl_vehicles')->where('id','=',$id)->first();
		if(!empty($vehicles))
		{
			$vehicle_name = $vehicles->modelname;
			return $vehicle_name;
		}
	}
}

if (!function_exists('Getvehiclecheckpoint')) {
	function Getvehiclecheckpoint($id)
	{
		$vehicles  = DB::table('tbl_checkout_categories')->where('vehicle_id','=',$id)->get()->toArray();
		if(!empty($vehicles))
		{
			return $vehicles;
		}
		else
		{
			return array();
		}
	}
}

// Get Vehicle type value In vehicle brand module

if (!function_exists('getVehicleBrand')) {
	function getVehicleBrand($id)
	{
		$vehiclebrand  = DB::table('tbl_vehicle_types')->where('id','=',$id)->first();
		if(!empty($vehiclebrand))
		{
			$vehicle_brand = $vehiclebrand->vehicle_type;
			
			return $vehicle_brand;
		}
	}
}


//getVehicleDescription
if (!function_exists('getVehicleDescription')) {
	function getVehicleDescription($id)
	{	
		$VehicalDescription  = DB::table('tbl_vehicles')->where('id','=',$id)->first();
		if(!empty($VehicalDescription))
		{
			$VehicalDescriptions = $VehicalDescription->modelname;
			return $VehicalDescriptions;
		}
	}
}

//Customer Name in View of Sales module
if (!function_exists('getServiceId')) {
	function getServiceId()
	{	
		$data  = DB::table('tbl_services')->orderBy('id','DESC')->first();
		if(!empty($data))
		{
			$id = $data->id;
			return $id;
		}
	}
}

//Get customer full name
if (!function_exists('getCustomerName')) {
	function getCustomerName($id)
	{
		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();
		if(!empty($customer))
		{
			$customer_name = $customer->name;
			$customer_lname = $customer->lastname;
			return $customer_name.' '.$customer_lname;
		}
	}
}

//get Employee full name
if (!function_exists('getAssignedName')) {
	function getAssignedName($id)
	{
		$assigned  = DB::table('users')->where([['id','=',$id],['role','=','employee']])->first();
		if(!empty($assigned))
		{
			$assi_name = $assigned->name;
			$assi_lname = $assigned->lastname;
			return $assi_name.' '.$assi_lname;
		}
	}
}

//Customer Address in View of Sales module
if (!function_exists('getCustomerAddress')) {
	function getCustomerAddress($id)
	{	
		
		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();
		
		if(!empty($customer))
		{
			$customer_address = $customer->address;
			
			return $customer_address;
		}
		
	}
}

//Customer city in View of Sales module
if (!function_exists('getCustomerCity')) {
	function getCustomerCity($id)
	{	
		
		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();
		
		if(!empty($customer))
		{
			$customer_city = getCityName($customer->city_id);
			
			return $customer_city;
		}
		
	}
}
//Customer state in View of Sales module
if (!function_exists('getCustomerState')) {
	function getCustomerState($id)
	{	
		
		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();
		
		if(!empty($customer))
		{
			$customer_state = getStateName($customer->state_id);
			
			return $customer_state;
		}
		
	}
}
//Customer state in View of Sales module
if (!function_exists('getCustomerCountry')) {
	function getCustomerCountry($id)
	{	
		
		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();
		
		if(!empty($customer))
		{
			$customer_country = getCountryName($customer->country_id);
			
			return $customer_country;
		}
		
	}
}

//Customer Mobile in View of Sales module
if (!function_exists('getCustomerMobile')) {
	function getCustomerMobile($id)
	{	
		
		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();
		
		if(!empty($customer))
		{
			$customer_mobile = $customer->mobile_no;
			
			return $customer_mobile;
		}
		
	}
}


//Customer Email in View of Sales module
if (!function_exists('getCustomerEmail')) {
	function getCustomerEmail($id)
	{	
		
		$customer  = DB::table('users')->where([['id','=',$id],['role','=','Customer']])->first();
		
		if(!empty($customer))
		{
			$customer_email = $customer->email;
			
			return $customer_email;
		}
		
	}
}
// Get VehicleType Name In Vehicle module
if (!function_exists('getVehicleType')) {
	function getVehicleType($id)
	{	
		
		$vehical_type = DB::table('tbl_vehicle_types')->where('id','=',$id)->first();
		
		if(!empty($vehical_type))
		{
			$vehical_type_name = $vehical_type->vehicle_type;
			return $vehical_type_name;
		}
		
	}
}

//Vehicle Type in View of Sales module
if (!function_exists('getVehicleType')) {
	function getVehicleType($id)
	{	
		
		$vehi_type  = DB::table('tbl_vehicle_types')->where('id','=',$id)->first();
		
		if(!empty($vehi_type))
		{
			$vehi_type_name = $vehi_type->vehicle_type;
			
			return $vehi_type_name;
		}
		
	}
}


//Vehicle Color in View of Sales module
if (!function_exists('getVehicleColor')) {
	function getVehicleColor($id)
	{	
		
		$color  = DB::table('tbl_colors')->where('id','=',$id)->first();
		
		if(!empty($color))
		{
			$color_name = $color->color;
			
			return $color_name;
		}
		
	}
}


//Total Amount in View of Sales module
if (!function_exists('getTotalAmonut')) {
	function getTotalAmonut($tax,$name,$amount)
	{	
		
		$tax  = DB::table('tbl_sales_taxes')->where([['tax_name','=',$name],['tax','=',$tax]])->first();
		$tax_rate = $tax->tax;
		$total_price = ($tax_rate * $amount)/100;
		return $total_price;
		
	}
}


//Total Amount of rto  in View of Sales module
if (!function_exists('getTotalRto')) {
	function getTotalRto($id)
	{	
		
		$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$id)->first();
		$r_tax = $rto->registration_tax;
		$no_plate = $rto->number_plate_charge;
		$road_tax = $rto->muncipal_road_tax;
		
		$total_rto_charges = $r_tax+$no_plate+$road_tax;
		return $total_rto_charges;
		
	}
}


//Get Observation Type Name in Observation Point List Module
if (!function_exists('getObservationTypeName')) {
	function getObservationTypeName($id)
	{	
		
		$o_type = DB::table('tbl_observation_types')->where('id','=',$id)->first();
		
		if(!empty($o_type))
		{
			$type_name = $o_type->type;
			
		
			return $type_name;
		}
		
	}
}

//Fuel type  in View of vehicle  module
if (!function_exists('getFuelType')) {
	function getFuelType($id)
	{	
		
		$fueal_type  = DB::table('tbl_fuel_types')->where('id','=',$id)->first();
		
		if(!empty($fueal_type))
		{
			$fuel_type_name = $fueal_type->fuel_type;
			
			return $fuel_type_name;
		}
		
	}
}

//Vehicle Brand  in View of vehicle module
if (!function_exists('getVehicleBrands')) {
	function getVehicleBrands($id)
	{	
		
		$vehi_brand = DB::table('tbl_vehicle_brands')->where('id','=',$id)->first();
		
		if(!empty($vehi_brand))
		{
			$vehicalbrand = $vehi_brand->vehicle_brand;
			
			return $vehicalbrand;
		}
		
	}
}



//Get Color Name in View of vehicle module
if (!function_exists('getColorName')) {
	function getColorName($id)
	{	
		
		$color = DB::table('tbl_colors')->where('id','=',$id)->first();
		if(!empty($color))
		{
		$color_name = $color->color;

		return $color_name;
		}
    }
}


//getcolourcode 

if (!function_exists('getColourCode')) {
	function getColourCode($id)
	{	
		$colourname = getColorName($id);
		switch ($colourname) {
		    case "red":
		        return "#ff0000";
		        break;
		    case "blue":
		        return "#0000FF";
		        break;
		    case "green":
		        echo "#008000";
		        break;
		    case "Black ":
		        return "#000000";
		        break;
		    case "Brown ":
		        return "#A52A2A";
		        break;
		    case "Grey ":
		        echo "##808080";
		        break;
		     case "Pink ":
		        return "##FFC0CB";
		        break;
		    case "Purple ":
		        return "##800080";
		        break;
		    case "Yellow ":
		        echo "###FFFF00";
		        break;

		    default:
		        echo "#696969";
         }
		
    }
}

//Get Checked Value In Jobcard Detail
if (!function_exists('getCheckvalue')) {
	function getCheckvalue($services_id,$observation_points_id)
	{	
		
		$getdata = DB::table('tbl_service_observation_points')->where([['services_id','=',$services_id],['observation_points_id','=',$observation_points_id]])->count();
		if($getdata>0)
		{
			return 'checked';
		}else
		{
			return '';
		}
	}
}

//Get Checked Value In Jobcard Detail
if (!function_exists('getCheckReview')) {
	function getCheckReview($services_id,$observation_points_id)
	{	
		
		$getdata = DB::table('tbl_service_observation_points')->where([['services_id','=',$services_id],['observation_points_id','=',$observation_points_id]])->first();
		
		if(!empty($getdata))
		{
			$review = $getdata->review;
			return $review;
		}
	}
}

// get vehicle first image
if (!function_exists('getVehicleImage')) {
	function getVehicleImage($id)
	{	
		
		$vehicleimage = DB::table('tbl_vehicle_images')->where('vehicle_id','=',$id)->first();
		if(!empty($vehicleimage))
		{
			$vehiclefisrtimage =	$vehicleimage->image;
			return $vehiclefisrtimage;
		}else{
			$vehiclefisrtimage ='avtar.png';
			return $vehiclefisrtimage;
		}
	}
}


//Get AssigineTo  Value In Service(module) List  Detail
if (!function_exists('getAssignTo')) {
	function getAssignTo($id)
	{	
		
		$AssignTo  = DB::table('users')->where('id','=',$id)->first();
		
		if(!empty($AssignTo))
		{
			$AssignTo_name = $AssignTo->name;
			
			return $AssignTo_name;
		}
		
	}
}

//Set the logo of get pass invoice
if (!function_exists('getLogoInvoice')) {
	function getLogoInvoice()
	{	
		
		$logo = DB::table('tbl_settings')->first();
		$logo_img = $logo->logo_image;

		return $logo_img;
	}
}

//Set the Coupan no in Service List
if (!function_exists('getAllCoupon')) {
	function getAllCoupon($cid,$vid)
	{	
		
		$all_coupan = DB::table('tbl_services')->where([['customer_id','=',$cid],['vehicle_id','=',$vid],['job_no','like','C%']])->get()->toArray();
		
		return $all_coupan;
	}
}

//Set the Used Coupon no in Service List
if (!function_exists('getUsedCoupon')) {
	function getUsedCoupon($cid,$vid,$cupanno)
	{	
		
		$used_coupon = DB::table('tbl_jobcard_details')->where([['customer_id','=',$cid],['vehicle_id','=',$vid],['coupan_no','=',$cupanno]])->first();
		
		if(!empty($used_coupon))
		{
			
			$done_status = $used_coupon->done_status;
			return  $done_status;
		}
		
		
	}
}

// Get A Access Rights Setting  In User Side PAge for all Module
if (!function_exists('getAccessStatusUser')) {
	function getAccessStatusUser($menu_name,$id)
	{	
		
		$user = DB::table('users')->where('id','=',$id)->first();
		
		$userrole = $user->role;
		
		if($userrole == 'admin')
		{
			return 'yes';
		}
		else
		{
		  if($userrole == 'Customer')
		  {			  
			$acess = DB::table('tbl_accessrights')->where('menu_name','=',$menu_name)->first();
			
			$customers = $acess->customers;
			
			if($customers == 1)
			{
				return 'yes';
				
			}elseif($customers == 0)
			{
				return 'no';
			}
		  }
		  elseif($userrole == 'employee')
		  {			  
			$acess = DB::table('tbl_accessrights')->where('menu_name','=',$menu_name)->first();
			$employee = $acess->employee;
			if($employee == 1)
			{
				return 'yes';
				
			}elseif($employee == 0)
			{
				return 'no';
			}
		  }
		  elseif($userrole == 'supportstaff')
		  {			  
			$acess = DB::table('tbl_accessrights')->where('menu_name','=',$menu_name)->first();
			$support_staff = $acess->support_staff;
			if($support_staff == 1)
			{
				return 'yes';
				
			}elseif($support_staff == 0)
			{
				return 'no';
			}
		  }
		  elseif($userrole == 'accountant')
		  {			  
			$acess = DB::table('tbl_accessrights')->where('menu_name','=',$menu_name)->first();
			$accountant = $acess->accountant;
			if($accountant == 1)
			{
				return 'yes';
				
			}elseif($accountant == 0)
			{
				return 'no';
			}
		  }	
	}
}
}

// Get active Admin list in data list
if (!function_exists('getActiveAdmin')) {
	function getActiveAdmin($id)
	{	
		
		$data  = DB::table('users')->where('id','=',$id)->first();
		
		if(!empty($data))
		{
			$userrole = $data->role;
			if($userrole == 'admin')
			{
				
				return "yes";
				
			}
			else
			{	
				return "no";
			}
		}
	}
  }
// Get active Customer list in data list
if (!function_exists('getActiveCustomer')) {
	function getActiveCustomer($id)
	{	
		
		$data  = DB::table('users')->where('id','=',$id)->first();
		
		if(!empty($data))
		{
			$userrole = $data->role;
			if($userrole == 'admin' || $userrole == 'supportstaff' || $userrole == 'accountant')
			{
				
				return "yes";
				
			}
			else
			{	
				return "no";
			}
		}
	}
  }

 // Get active Employee list in data list
if (!function_exists('getActiveEmployee')) {
	function getActiveEmployee($id)
	{	
		
		$data  = DB::table('users')->where('id','=',$id)->first();
		
		if(!empty($data))
		{
			$userrole = $data->role;
			if($userrole == 'employee')
			{
				
				return "yes";
			}
			else
			{
				
				return "no";
			}
		}
	}
  }
  
  // Get active Admin list in data list
if (!function_exists('getCustomersactive')) {
	function getCustomersactive($id)
	{	
		
		$data  = DB::table('users')->where('id','=',$id)->first();
		
		if(!empty($data))
		{
			$userrole = $data->role;
			if($userrole == 'Customer')
			{
				
				return "yes";
				
			}
			else
			{	
				return "no";
			}
		}
	}
  }
  
// Get active jobcard list in Customer data list
if (!function_exists('getCustomerJobcard')) {
	function getCustomerJobcard($id)
	{	
		
		$service=DB::table('tbl_services')->where([['customer_id','=',$id],['job_no','like','J%']])->get()->toArray();
	
		if(!empty($service))
		{  
	       return "yes";
		}
		else
		{

			return "no";
		}
			
	}
  }


// Get Login Customer in Sales data list

if (!function_exists('getCustomerSales')) {
	function getCustomerSales($id)
	{	
		
		$sales=DB::table('tbl_sales')->where('customer_id','=',$id)->get()->toArray();
	
		if(!empty($sales))
		{  
	       return "yes";
		}
		else
		{

			return "no";
		}
			
	}
  }
  
// Get active Service list in Customer data list
if (!function_exists('getCustomerService')) {
	function getCustomerService($id)
	{	
		
		$service=DB::table('tbl_services')->where([['customer_id','=',$id],['job_no','like','J%']])->get()->toArray();
	
		if(!empty($service))
		{  
	       return "yes";
		}
		else
		{

			return "no";
		}
			
	}
  }

// Get active Customer list in data list
if (!function_exists('getCustomerList')) {
	function getCustomerList($id)
	{	
		
		$data  = DB::table('users')->where('id','=',$id)->first();
		
		if(!empty($data))
		{
			$userrole = $data->role;
			if($userrole == 'Customer'  )
			{
				$service=DB::table('tbl_services')->where([['customer_id','=',$id],['job_no','like','J%'],['done_status','=',1]])->get()->toArray();
				if(!empty($service))
				{  
				   return "yes";
				}
				else
				{

					return "no";
				}
			
			}
			else
			{
				return "no";
			}
		}
	}
  }

 
  // Count Number of service in dashboard
if (!function_exists('getNumberOfService')) {
	function getNumberOfService($id)
	{	
		$y = date("Y");
		$m = date("m");
		
		$d = $id;
		
		$datess = "$y/$m/$d";
		
		$data = DB::table('tbl_services')->where('done_status','!=',2)->whereDate('service_date','=',$datess)->count();
		
		return $data;
	}
  }

  
  
  // Current  stock 
if (!function_exists('getCurrentStock')) {
	function getCurrentStock($p_id)
	{	
		$stockproduct=DB::table('tbl_service_pros')->where('product_id','=',$p_id)->get()->toArray();
			$selltotal=0;
			foreach($stockproduct as $stockproducts)
			{
				$qty=$stockproducts->quantity;
				$selltotal +=$qty;
			}
			
			$allstock=DB::table('tbl_purchase_history_records')->where('product_id','=',$p_id)->get()->toArray();
			$alltotal=0;
			foreach($allstock as $allstocks)
			{
				$qtys=$allstocks->qty;
				$alltotal +=$qtys;
			}
			
			$currentstock=$alltotal - $selltotal;
			return $currentstock;
	}
  }

// Get logo system in app blade

if (!function_exists('getLogoSystem')) {
	function getLogoSystem()
	{	
		
		$logo = DB::table('tbl_settings')->first();
		$logo_image=$logo->logo_image;
			return $logo_image;
		
	}
}

// Get  system name in app blade

if (!function_exists('getNameSystem')) {
	function getNameSystem()
	{	
		
		$system_name = DB::table('tbl_settings')->first();
		$system_name=$system_name->system_name;
			return $system_name;
		
	}
}
// Get date format in all project
if (!function_exists('getDateFormat')) {
	function getDateFormat()
	{	
		
		$dateformat=DB::table('tbl_settings')->first();
		
		if(!empty($dateformat))
		{
			$dateformate= $dateformat->date_format;
			return $dateformate;
			// if($dateformate == 'm-d-Y')
			// {
				// $dateformats= "mm-dd-yyyy";
				// return $dateformats;
			// }
			// elseif($dateformate == 'Y-m-d')
			// {
				// $dateformats= "yyyy-mm-dd";
				// return $dateformats;
			// }
			// elseif($dateformate == 'd-m-Y')
			// {
				// $dateformats= "dd-mm-yyyy";
				// return $dateformats;
			// }
			// elseif($dateformate == 'M-d-Y')
			// {
				// $dateformats= "M-dd-yyyy";
				// return $dateformats;
			// }
			
		}	
		
	}
}


// Get date format in datepicker
if (!function_exists('getDatepicker')) {
	function getDatepicker()
	{	
		$dateformat=DB::table('tbl_settings')->first();
		$dateformate= $dateformat->date_format;
		if(!empty($dateformate))
		{
			if($dateformate == 'm-d-Y')
			{
				$dateformats= "mm-dd-yyyy";
				return $dateformats;
			}
			elseif($dateformate == 'Y-m-d')
			{
				$dateformats= "yyyy-mm-dd";
				return $dateformats;
			}
			elseif($dateformate == 'd-m-Y')
			{
				$dateformats= "dd-mm-yyyy";
				return $dateformats;
			}
			elseif($dateformate == 'M-d-Y')
			{
				$dateformats= "MM-dd-yyyy";
				return $dateformats;
			}
			
		}	
	}
}

// Get date format in Datetimepicker
if (!function_exists('getDatetimepicker')) {
	function getDatetimepicker()
	{	
		
		$dateformate= getDateFormat();
		if(!empty($dateformate))
		{
			if($dateformate == 'm-d-Y')
			{
				$dateformats= "mm-dd-yyyy hh:ii:ss";
				return $dateformats;
			}
			elseif($dateformate == 'Y-m-d')
			{
				$dateformats= "yyyy-mm-dd  hh:ii:ss";
				return $dateformats;
			}
			elseif($dateformate == 'd-m-Y')
			{
				$dateformats= "dd-mm-yyyy hh:ii:ss";
				return $dateformats;
			}
			elseif($dateformate == 'M-d-Y')
			{
				$dateformats= "M-dd-yyyy hh:ii:ss";
				return $dateformats;
			}
			
		}	
	}
}
// Get Day Name in View Of general_setting 
if (!function_exists('getDayName')) {
	function getDayName($id)
	{	
		
		switch ($id) {
		    case "1":
		        return "Monday";
		        break;
		    case "2":
		        return "Tuesday";
		        break;
		    case "3":
		        echo "Wednesday";
		        break;
		    case "4":
		        return "Thursday";
		        break;
		    case "5":
		        return "Friday";
		        break;
		    case "6":
		        echo "Saturday";
		        break;
		     case "7":
		        return "Sunday";
		        break;
		   

		    default:
		        echo "Sunday";
         }
		
    }
}

// Get from open hours time in View Of general_setting 
if (!function_exists('getOpenHours')) {
	function getOpenHours($id)
	{	
		$tbl_hours=DB::table('tbl_business_hours')->where('from','=',$id)->first();
		$pm = $tbl_hours->from;
			if($pm >=12)
			{ 
				if($pm == 12)
				{
					$pmfinal=$pm;
					$final=$pmfinal.''.":00 PM";
					 return $final;
				}
				else
				{
					$pmfinal=$pm-12;
					$final=$pmfinal.''.":00 PM";
					return $final;
				}
			}
			else
			{
				if($pm == 0)
				{
					$pmfinal=$pm +12;
					$final=$pmfinal.''.":00 AM";
					return $final;
				}
				else
				{
					$pmfinal=$pm;
					$final=$pmfinal.''.":00 AM";
					return $final;
				}
			}
	}
}

// Get close hours time in View Of general_setting 
if (!function_exists('getCloseHours')) {
	function getCloseHours($id)
	{	
		$tbl_hours=DB::table('tbl_business_hours')->where('to','=',$id)->first();
		$am = $tbl_hours->to;
			if($am >=12)
			{ 
				if($am == 12)
				{
					$pmfinal=$am;
					$final=$pmfinal.''.":00 PM";
					return $final;
				}
				else
				{
					$pmfinal=$am-12;
					$final=$pmfinal.''.":00 PM";
					return $final;
				}
			}
			else
			{
				if($am == 0)
				{
					$pmfinal=$am +12;
					$final=$pmfinal.''.":00 AM";
					return $final;
				}
				else
				{
					$pmfinal=$am;
					$final=$pmfinal.''.":00 AM";
					return $final;
				}
			}
	}
}

//Get data  value in custom field

if (!function_exists('getCustomData')) {
	function getCustomData($tbl_custom,$userid)
	{
	   $userdata=DB::table('users')->where('id','=',$userid)->first();
	   
	   $jsonn=$userdata->custom_field;
	   
		$jsonns = json_decode($jsonn);
		if(!empty($jsonns))
		{
			foreach ($jsonns as $key=>$value)
			{
					$ids = $value->id;
					$value1 = $value->value;
					
					
					if($tbl_custom == $ids)
					 {
						return $value1;
					 }
					
			}
		}
	} 
		
	}

// Get Currency symbols in all module

if (!function_exists('getCurrencySymbols')) {
	function getCurrencySymbols()
	{	
		
		$setting = DB::table('tbl_settings')->first();
		$id=$setting->currancy;
		
		$currancy= DB::table('currencies')->where('id','=',$id)->first();
		
		if(!empty($currancy))
		{
			$symbol = $currancy->symbol;
			 return $symbol;
		}
		
	}
}


// Get current stock in stock  module

if (!function_exists('getStockCurrent')) {
	function getStockCurrent($id)
	{	
		
		$product = DB::table('tbl_stock_records')->where('product_id','=',$id)->first();
		$stock=$product->no_of_stoke;
		
		$cellstock=DB::table('tbl_service_pros')->where('product_id','=',$id)->get()->toArray();
		$celltotal=0;
		foreach($cellstock as $cellstocks)
		{
			$cell_stock=$cellstocks->quantity;
			$celltotal += $cell_stock;		
		}
	
		if(!empty($product))
		{
			$finalstock= $stock - $celltotal;
			 return $finalstock;
		}
		
	}
}

// Get  languagechange
if (!function_exists('getLanguageChange')) {
	function getLanguageChange()
	{	
		
		$userid=Auth::User()->id;
		$data=DB::table('users')->where('id','=',$userid)->first();
		$language=$data->language;
		
		if(!empty($language))
		{
			if($language == 'en')
			{
				$language= "English";
				return $language;
			}
			elseif($language == 'de')
			{
				$language= "Spanish";
				return $language;
			}
			elseif($language == 'gr')
			{
				$language= "Greek";
				return $language;
			}
			elseif($language == 'ar')
			{
				$language= "Arabic";
				return $language;
			}
			elseif($language == 'ger')
			{
				$language= "German";
				return $language;
			}
			elseif($language == 'pt')
			{
				$language= "Portuguese";
				return $language;
			}
			elseif($language == 'fr')
			{
				$language= "french";
				return $language;
			}
			elseif($language == 'it')
			{
				$language= "Italian";
				return $language;
			}
			elseif($language == 'sv')
			{
				$language= "Swedish";
				return $language;
			}
			elseif($language == 'dt')
			{
				$language= "Dutch";
				return $language;
			}
			elseif($language == 'hi')
			{
				$language= "Hindi";
				return $language;
			}
			elseif($language == 'zhcn')
			{
				$language= "Chinese";
				return $language;
			}
		}	
	}
}

// Get Payment Method  in all module

if (!function_exists('GetPaymentMethod')) {
	function GetPaymentMethod($id)
	{	
		
		$tbl_payments = DB::table('tbl_payments')->where('id','=',$id)->first();
		
		if(!empty($tbl_payments))
		{
			$payment=$tbl_payments->payment;
			 return $payment;
		}
		else{
			if($id =='')
			{
				$payment='';
			     return $payment;
			}
			else
			{
				$payment='stripe';
				 return $payment;
			}
		}
		
	}
}

// Get Unit  name in Stock module

if (!function_exists('getUnitMeasurement')) {
	function getUnitMeasurement($id)
	{
		
		$tbl_products = DB::table('tbl_products')->where('id','=',$id)->get()->toArray();
		
		if(!empty($tbl_products))
		{
			 $unit = array();
			 foreach($tbl_products as $tbl_productss)
			 { 
				 $unit[] = $tbl_productss->unit;
			 }
			 
			$tbl_product_units = DB::table('tbl_product_units')->where('id','=',$unit)->first();
			if(!empty($tbl_product_units))
			{
				$name= $tbl_product_units->name;
				
				return $name;
			}
			else
			{
				return '';
			}
		}
		else
		{
			return '';
		}
	}
	}
			
// Get  purchase date
if (!function_exists('getPurchaseDate')) {
	function getPurchaseDate($id)
	{	
		
		$tbl_purchases = DB::table('tbl_purchases')->where('id','=',$id)->first();
		
		if(!empty($tbl_purchases))
		{
			$date = $tbl_purchases->date;
			return $date;
		}
		
	}
}	

// Get PurchaseSupplier
if (!function_exists('getPurchaseSupplier')) {
	function getPurchaseSupplier($id)
	{	
		
		$tbl_purchases = DB::table('tbl_purchases')->where('id','=',$id)->first();
		
		if(!empty($tbl_purchases))
		{
			$supplier_id = $tbl_purchases->supplier_id;
			return $supplier_id;
		}
		
	}
}

// Get  purchase date
if (!function_exists('getPurchaseCode')) {
	function getPurchaseCode($id)
	{	
		
		$tbl_purchases = DB::table('tbl_purchases')->where('id','=',$id)->first();
		
		if(!empty($tbl_purchases))
		{
			$purchase_no = $tbl_purchases->purchase_no;
			return $purchase_no;
		}
		
	}
}		

?>