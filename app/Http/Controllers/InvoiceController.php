<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use URL;
use Mail;
use Illuminate\Mail\Mailer;
use App\tbl_invoices;
use App\tbl_services;
use App\tbl_payment_records;
use App\tbl_incomes;
use App\tbl_income_history_records;
use PDF;
class InvoiceController extends Controller
{	
	public function __construct()
    {
		
        $this->middleware('auth');
    }
	
	//get customer
	public function sales_customer()
	{
		$type = input::get('type');
		if($type == 1)
		{
			$customer = DB::table('tbl_sales')->select('customer_id')->groupBy('customer_id')->get()->toArray();
		}
		else
		{
			$customer = DB::table('tbl_services')->where('done_status','=',1)->groupBy('customer_id')->get()->toArray();
		}
			?>
			<?php foreach($customer as $customers)
			{ ?>
				<option value="<?php echo $customers->customer_id;?>"><?php echo getCustomerName($customers->customer_id); ?></option>
			<?php 
			} 	
	}
	
	//invoice add form
    public function index(Request $request)
	{		
		$id=$request->id;
		$characters = '0123456789';
		$code =  substr(str_shuffle($characters),0,8);
		$characterss = '0123456789';
		$codepay =  'P'.''.substr(str_shuffle($characterss),0,6);
		$tax = DB::table('tbl_account_tax_rates')->get()->toArray();
		$tbl_payments = DB::table('tbl_payments')->get()->toArray();
		$tbl_sales = DB::table('tbl_sales')->where('id','=',$id)->first();
		if(!empty($tbl_sales))
		{
			$vehicleid=$tbl_sales->vehicle_id;
			$tbl_rto_taxes=DB::table('tbl_rto_taxes')->where('vehicle_id','=',$vehicleid)->first();
			if(!empty($tbl_rto_taxes))
			{
				$registration_tax= $tbl_rto_taxes->registration_tax;
				$number_plate_charge= $tbl_rto_taxes->number_plate_charge;
				$muncipal_road_tax= $tbl_rto_taxes->muncipal_road_tax;
				$total_rto=$registration_tax + $number_plate_charge + $muncipal_road_tax;
			}
			else
			{
				$total_rto =0;
			
			}
			
		}
		return view('invoice.add',compact('code','tax','customer','tbl_sales','codepay','total_rto','tbl_payments')); 
	}
	
	
	
	public function sale_part_index(Request $request)
	{		
		$id=$request->id;
		$characters = '0123456789';
		$code =  substr(str_shuffle($characters),0,8);
		$characterss = '0123456789';
		$codepay =  'P'.''.substr(str_shuffle($characterss),0,6);
		$tax = DB::table('tbl_account_tax_rates')->get()->toArray();
		$tbl_payments = DB::table('tbl_payments')->get()->toArray();
		$tbl_sales = DB::table('tbl_sale_parts')->where('id','=',$id)->first();
		
		$tbl_saless = DB::table('tbl_sale_parts')->select(DB::raw("SUM(total_price) AS total_price,bill_no,quantity,date,product_id,price ,customer_id,id,salesmanname"))->where('bill_no','=',$tbl_sales->bill_no)->get();
		$tbl_salessd = DB::table('tbl_sale_parts')->where('bill_no','=',$tbl_sales->bill_no)->get();

		if(!empty($tbl_sales))
		{
			$vehicleid=$tbl_sales->product_id;
			$tbl_rto_taxes=DB::table('tbl_rto_taxes')->where('vehicle_id','=',$vehicleid)->first();
			if(!empty($tbl_rto_taxes))
			{
				$registration_tax = $tbl_rto_taxes->registration_tax;
				$number_plate_charge = $tbl_rto_taxes->number_plate_charge;
				$muncipal_road_tax = $tbl_rto_taxes->muncipal_road_tax;
				$total_rto = $registration_tax + $number_plate_charge + $muncipal_road_tax;
			}
			else
			{
				$total_rto =0;
			}
		}
		return view('invoice.sale_part_add',compact('code','tax','customer','tbl_sales','codepay','total_rto','tbl_payments','tbl_saless','tbl_salessd')); 
	}
	
	//invoice list
	public function showall()
	{	
		$userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			$invoice = DB::table('tbl_invoices')->where('type','!=',2)->orderBy('id','DESC')->get()->toArray();
			$updatekey = DB::table('updatekey')->first();
			$logo = DB::table('tbl_settings')->first();
		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			$invoice = DB::table('tbl_services')
						->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
						->where('tbl_services.assign_to','=',Auth::User()->id)
						->where('type','!=',2)
						->orderBy('tbl_invoices.id','DESC')->get()->toArray();
			$updatekey = DB::table('updatekey')->first();
			$logo = DB::table('tbl_settings')->first();
		}
		else
		{
			$invoice = DB::table('tbl_invoices')->where('customer_id','=',$userid)->where('type','!=',2)->orderBy('id','DESC')->get()->toArray();
			$updatekey = DB::table('updatekey')->first();
			$logo = DB::table('tbl_settings')->first();
		}
		return view('invoice.list',compact('invoice','updatekey','logo'));
	}

	public function viewSalePart()
	{
		$userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			$invoice = DB::table('tbl_invoices')->where('type',2)->orderBy('id','DESC')->get()->toArray();
			$updatekey = DB::table('updatekey')->first();
			$logo = DB::table('tbl_settings')->first();
		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			$invoice = DB::table('tbl_services')
											->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
											->where('tbl_services.assign_to','=',Auth::User()->id)
											->where('type',2)
											->orderBy('tbl_invoices.id','DESC')->get()->toArray();
			
			$updatekey = DB::table('updatekey')->first();
			$logo = DB::table('tbl_settings')->first();
		}
		else
		{
			$invoice = DB::table('tbl_invoices')->where('customer_id','=',$userid)->where('type',2)->orderBy('id','DESC')->get()->toArray();
			$updatekey = DB::table('updatekey')->first();
			$logo = DB::table('tbl_settings')->first();
		}
		return view('invoice.salepartlist',compact('invoice','updatekey','logo'));
	}

	//get jobcard number
	public function get_jobcard_no()
	{	
		$cus_id = Input::get('cus_name');
		$invoice_job = DB::table('tbl_invoices')->where('customer_id','=',$cus_id)->select('job_card')->get()->toArray();
		$invoice_jobss = array();
		foreach($invoice_job as $invoice_jobs)
		{
			$invoice_jobss[] =  $invoice_jobs->job_card;
		}
		$job = DB::table('tbl_services')->where([['customer_id','=',$cus_id],['done_status','=',1],['job_no','like','J%']])->whereNotIn('tbl_services.job_no',$invoice_jobss)->get()->toArray();
		
		?>
		<?php foreach($job as $job) { ?>
			<option class="invoice_job_number" value="<?php echo $job->job_no;?>" ><?php echo $job->job_no; ?></option>	
		<?php } ?>
		<?php 
	}
	
	//get service number
	public function get_service_no()
	{		
		$job_no = Input::get('job_no');
		$invoice_data = substr($job_no,0,1);
		if($invoice_data == "J")
		{
			$job = DB::table('tbl_services')->where([['job_no','=',$job_no],['done_status','=',1],['job_no','like','J%']])->first();
			$ser_id = $job->id;
			$cus_id = $job->customer_id;
			$service_pro = DB::table('tbl_service_pros')->where([['service_id','=',$ser_id],['chargeable','=',1]])->SUM('total_price');
			
			$othr_charges =  DB::table('tbl_service_pros')->where([['service_id','=',$ser_id],['product_id','=',0]])->SUM('total_price');
			
			$service_charge = DB::table('tbl_services')->where('id','=',$ser_id)->first();
			$charge = $service_charge->charge;
			
			$total_amount = $service_pro + $othr_charges + $charge;
			
			if(!empty($total_amount))
			{
				return array($ser_id, $total_amount, $cus_id);
			}
			else
			{
				return array($ser_id, 0, 0);
			}
		}
		else
		{
			$vehi_price = DB::table('tbl_sales')->where('vehicle_id',$job_no)->first();
			$price = $vehi_price->total_price;
			$cust = $vehi_price->customer_id;
			$id = $vehi_price->id;
			$tbl_rto_taxes = DB::table('tbl_rto_taxes')->where('vehicle_id',$job_no)->first();
			if(!empty($tbl_rto_taxes))
			{
				$regi = $tbl_rto_taxes->registration_tax;
				$plate = $tbl_rto_taxes->number_plate_charge;
				$road = $tbl_rto_taxes->muncipal_road_tax;
				$total_amount = $price + $regi + $plate + $road;
			}
			else
			{
				$total_amount = $price;
			}
			if(!empty($total_amount))
			{
				return array($id, $total_amount, $cust);
			}
			else
			{
				return 0;
			}
		}
	}
	//get invoice into outsanding amount 
	public function get_invoice()
	{		
		$invoiceid = Input::get('invoiceid');
		$invoice_job = DB::table('tbl_invoices')->where('invoice_number','=',$invoiceid)->first();
		if(!empty($invoice_job))
		{
			$ser_id=$invoice_job->customer_id;
			$grand_total=$invoice_job->grand_total;
			$paid_amount=$invoice_job->paid_amount;
			$total=$grand_total - $paid_amount ;
			return array($ser_id, $total);
		}
		else
		{
			return 01;
		}
	}
	//get vehicle total price 
	public function get_vehicle_total()
	{
		$vehi_id = Input::get('vehi_id');
		$vehi_data = DB::table('tbl_sales')->where('vehicle_id',$vehi_id)->first();
		$total_price1 = $vehi_data->total_price;
		$tbl_rto_taxes=DB::table('tbl_rto_taxes')->where('vehicle_id','=',$vehi_id)->first();
		if(!empty($tbl_rto_taxes))
		{
			$registration_tax= $tbl_rto_taxes->registration_tax;
			$number_plate_charge= $tbl_rto_taxes->number_plate_charge;
			$muncipal_road_tax= $tbl_rto_taxes->muncipal_road_tax;
			$total_rto=$registration_tax + $number_plate_charge + $muncipal_road_tax;
			$total_price= $total_price1 + $total_rto;
		}
		else
		{
			$total_price= $total_price1;
		}
		$sale_id = $vehi_data->id;
		return array($sale_id, $total_price);
	}
	
	//get vehicle
	public function get_vehicle()
	{
		$cus_id = Input::get('cus_name');
		$invoice_job = DB::table('tbl_invoices')->where('customer_id','=',$cus_id)->select('job_card')->get()->toArray();
		$invoice_jobss = array();
		foreach($invoice_job as $invoice_jobs)
		{
			$invoice_jobss[] =  $invoice_jobs->job_card;
		}
		$job = DB::table('tbl_sales')->where('customer_id','=',$cus_id)->whereNotIn('tbl_sales.vehicle_id',$invoice_jobss)->get()->toArray();
		?>
		<?php foreach($job as $job) { ?>
			<option class="invoice_vehicle_name" value="<?php echo $job->vehicle_id;?>" ><?php echo getVehicleName($job->vehicle_id) ?></option>	
		<?php } ?>
		<?php 
	}
	
	public function get_part()
	{
		$cus_id = Input::get('cus_name');
		$invoice_job = DB::table('tbl_invoices')->where('customer_id','=',$cus_id)->select('job_card')->get()->toArray();
		$invoice_jobss = array();
		foreach($invoice_job as $invoice_jobs)
		{
			$invoice_jobss[] =  $invoice_jobs->job_card;
		}
		$job = DB::table('tbl_sales')->where('customer_id','=',$cus_id)->where('product_id','!=',NULL)->get()->toArray();
		?>
		<?php foreach($job as $job) { ?>
			<option class="invoice_vehicle_name" value="<?php echo $job->product_id;?>" ><?php echo getPart($job->product_id)->name ?></option>	
		<?php } ?>
		<?php 
	}
	
	//invoice store
	public function store()
	{
	
		    if(getDateFormat()== 'm-d-Y')
			{
				$dates=date('Y-m-d',strtotime(str_replace('-','/',Input::get('Date'))));
			}
			else
			{
				$dates=date('Y-m-d',strtotime(Input::get('Date')));
			}
			$sales_service_id=Input::get('jobcard_no');
			$type=Input::get('Invoice_type');
			$invoice_number = Input::get('Invoice_Number');
			
			$invoice= new tbl_invoices;
			$invoice->invoice_number = $invoice_number;
			$invoice->payment_number = Input::get('paymentno');
			$invoice->customer_id = Input::get('Customer');
			$jobcard = Input::get('Job_card');
			$vehicle = Input::get('Vehicle');
			if($type != 2)
			{
				if(!empty($jobcard))
				{ $invoice->job_card = $jobcard; }
				else
				{ $invoice->job_card = $vehicle; }
			}
			else
			{
				$invoice->job_card == 'NULL';
			}
			$invoice->date = $dates;
			$invoice->payment_type = Input::get('Payment_type');
			$invoice->payment_status = Input::get('Status');
			if(!empty(Input::get('Tax')))
			{
				$invoice->tax_name = implode(', ',Input::get('Tax'));
			}
			// $invoice->tax_name = $taxes;
			$invoice->total_amount = Input::get('Total_Amount');
			$invoice->grand_total = Input::get('grandtotal');
			$invoice->paid_amount = Input::get('paidamount');
			$invoice->amount_recevied = Input::get('paidamount');
			$invoice->discount = Input::get('Discount');
			$invoice->details = Input::get('Details');
			$invoice->type = $type;
			$invoice->sales_service_id =$sales_service_id;
			$invoice->save();
			
			$tbl_invoicess = DB::table('tbl_invoices')->orderBy('id','desc')->first();
			$invoiceid=$tbl_invoicess->id;
			
			$tbl_payment_records = new  tbl_payment_records;
			$tbl_payment_records->invoices_id = $invoiceid;
			$tbl_payment_records->payment_number = Input::get('paymentno');
			$tbl_payment_records->amount = Input::get('paidamount');
			$tbl_payment_records->payment_type = Input::get('Payment_type');
			$tbl_payment_records->payment_date = $dates;
			$tbl_payment_records->save();
			
			if($type == 0)
			{
				$main_label="Service";
			}
			elseif($type == 1)
			{
				$main_label="Sales";
			}
			else
			{ 
				$main_label="Sale Part";
			}
			$tbl_incomes = new tbl_incomes;
			$tbl_incomes->invoice_number=$invoice_number;
			$tbl_incomes->payment_number=Input::get('paymentno');
			$tbl_incomes->customer_id=Input::get('Customer');
			$tbl_incomes->status=Input::get('Status');
			$tbl_incomes->payment_type =Input::get('Payment_type');
			$tbl_incomes->date=$dates;
			$tbl_incomes->main_label=$main_label;
			$tbl_incomes->save();
			
			$tbl_income_id = DB::table('tbl_incomes')->orderBy('id','DESC')->first();
		
			$tbl_income_history_records = new tbl_income_history_records;
			$tbl_income_history_records->tbl_income_id = $tbl_income_id->id;
			$tbl_income_history_records->income_amount = Input::get('paidamount');
			$tbl_income_history_records->income_label = $main_label;
			$tbl_income_history_records->save();
			//email format
			//invoice for sales in email
		
			if(!empty($type == 1))
			{
				
				//PDF download
					if(!empty($sales_service_id))
					{
						$id = $sales_service_id;
						$invoice_number = $invoice_number;			
					}
					else
					{
						$id = $serviceid;
						$auto_id =$invoice->id;
					}
						
					$viewid = $id;
					$sales = DB::table('tbl_sales')->where('id','=',$id)->first();
					$v_id = $sales->vehicle_id;
					$vehicale =  DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
					if($sales_service_id)
					{
						$invioce = DB::table('tbl_invoices')->where([['sales_service_id',$id],['invoice_number',$invoice_number]])->first();
					}
					else
					{
						$invioce = DB::table('tbl_invoices')->where('id',$auto_id)->first();
					}	
					if(!empty($invioce->tax_name))
					{
						$taxes = explode(', ',$invioce->tax_name);
					}
					else
					{
						$taxes='';
					}
					
				
					$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$v_id)->first();
					$logo = DB::table('tbl_settings')->first();	
				
					$pdf = PDF::loadView('invoice.salesinvoicepdfl',compact('viewid','vehicale','sales','logo','invioce','taxes','rto'));
					
					$str = "1234567890";
					$str1 = str_shuffle($str);
					
					$pdf->save('public/pdf/sales/'.$str1.'.pdf');
					
					// return $pdf->download('salesinvoice.pdf');
					
					
					
					
				//end pdf
				
				$sales = DB::table('tbl_sales')->where('id','=',$sales_service_id)->first();
				
				$v_id = $sales->vehicle_id;
				$c_id = $sales->customer_id;
				$bill_no = $sales->bill_no;
				$s_date = $sales->date;
				$totalamount = $sales->total_price;
				$total_price = $sales->total_price;
				
				if(!empty($rto))
				{
					$rto_reg = $rto->registration_tax; 
					$rto_plate = $rto->number_plate_charge;
					$rto_road = $rto->muncipal_road_tax;
				}
				if(!empty($rto)){ $rto_charges = $rto_reg + $rto_plate + $rto_road; }
				if(!empty($rto))
				{ 
					$total_amt = $total_price + $rto_charges;
				}else{
					$total_amt = $total_price;
				}
				$discount = ($total_amt*$invioce->discount)/100;
				$after_dis_total = $total_amt - $discount;
				if(!empty($taxes)) 
				{
					$total_tax = 0;
					$taxes_amount = 0;
					foreach($taxes as $tax)
					{
						$taxes_per = preg_replace("/[^0-9,.]/", "", $tax);
						
						$taxes_amount = ($after_dis_total*$taxes_per)/100;
						
						$total_tax +=  $taxes_amount;
					}
					$final_grand_total = $after_dis_total+$total_tax;
				}
				else
				{
					$final_grand_total = $after_dis_total;
				}
				
				$vehicale =  DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
				//$taxes = DB::table('tbl_sales_taxes')->where('sales_id','=',$id)->get();
				$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$v_id)->first();
				$invioce = DB::table('tbl_invoices')->where('sales_service_id',$sales_service_id)->first();
				if(!empty($invioce->tax_name))
				{
					$taxes = explode(', ',$invioce->tax_name);
				}
				else
				{
					$taxes='';
				}
				$user=DB::table('users')->where('id','=',$c_id)->first();
				$email=$user->email;
				$firstname=$user->name;
				$logo = DB::table('tbl_settings')->first();
				$systemname=$logo->system_name;
				$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','Sales_notification')->first();
				if($emailformats->is_send == 0)
				{
					if($invoice->save())
					{
						//dynamic email data
						 $emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','Sales_notification')->first();
						 
						$mail_format = $emailformat->notification_text;		
						$mail_subjects = $emailformat->subject;		 
						$mail_send_from = $emailformat->send_from; 
						$search1 = array('{ system_name }','{ invoice_ID }');
						$replace1 = array($systemname,$invoice_number);
						$mail_sub = str_replace($search1, $replace1, $mail_subjects);
						$search = array('{ system_name }','{ Customer_name }', '{ amount }','{ date }','{ invoice }');
						$replace = array($systemname, $firstname,$final_grand_total,$s_date,'invoice');
						
						$email_content = str_replace($search, $replace, $mail_format);
			
						$server = $_SERVER['SERVER_NAME'];
						if(isset($_SERVER['HTTPS'])){
							$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
						}
						else{
							$protocol = 'http';
						}		
						$url = URL::to('/public/pdf/sales/'.$str1.'.pdf');
						
						$fileatt = "test.pdf"; // Path to the file                  
					
						$fileatt_type = "application/pdf"; // File Type  
						$fileatt_name = $str1.'.pdf'; // Filename that will be used for the file as the attachment  
						$email_from = $mail_send_from; // Who the email is from  
						$email_subject = $mail_sub; // The Subject of the email  
						$email_message = $email_content;
						
						$email_to = $email; // Who the email is to  
						/* $headers = "{$from}";  */
						$headers = "From: ".$email_from;  
						
						$file = fopen($url,'rb');  


						$contents = file_get_contents($url); // read the remote file
						touch('temp.pdf'); // create a local EMPTY copy
						file_put_contents('temp.pdf', $contents);


						$data = fread($file,filesize("temp.pdf"));  
						// $data = fread($file,19189);  
						fclose($file);  
						$semi_rand = md5(time());  
						$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
							
						$headers .= "\nMIME-Version: 1.0\n" .  
									"Content-Type: multipart/mixed;\n" .  
									" boundary=\"{$mime_boundary}\"";  
						$email_message .= "This is a multi-part message in MIME format.\n\n" .  
										"--{$mime_boundary}\n" .  
										"Content-Type:text/html; charset=\"iso-8859-1\"\n" .  
									   "Content-Transfer-Encoding: 7bit\n\n" .  
						$email_message .= "\n\n";  
						// $data = chunk_split(base64_encode($data));   
						$data = chunk_split(base64_encode(file_get_contents('temp.pdf')));
						$email_message .= "--{$mime_boundary}\n" .  
										  "Content-Type: {$fileatt_type};\n" .  
										  " name=\"{$fileatt_name}\"\n" .  
										  //"Content-Disposition: attachment;\n" .  
										  //" filename=\"{$fileatt_name}\"\n" .  
										  "Content-Transfer-Encoding: base64\n\n" .  
										 $data .= "\n\n" .  
										  "--{$mime_boundary}--\n";  
										  
						$actual_link = $_SERVER['HTTP_HOST'];
						$startip='0.0.0.0';
						$endip='255.255.255.255';
						if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
						{
							//local format email
						
							$data=array(
							'email'=>$email,
							'mail_sub1' => $mail_sub,
							'email_content1' => $email_content,
							'emailsend' =>$mail_send_from,
							'logo' => $logo,
							'rto' => $rto,
							'taxes' => $taxes,
							'vehicale' => $vehicale,
							'sales' => $sales,
							'pdf'=>$pdf->output(),
							'str'=>$str1.'.pdf',
							);
							 
							  
							$data1 =	Mail::send('sales.salesmail',$data, function ($message) use ($data){

									$message->from($data['emailsend'],'noreply');
									$message->attachData($data['pdf'], "salesinvoice.pdf");
									$message->to($data['email'])->subject($data['mail_sub1']);
								});
						}
						else
						{					  
							$ok = mail($email_to, $email_subject, $email_message, $headers);
						}	
					}
				}
				//Generating free service coupons in sales 
				
				$sales = DB::table('tbl_sales')->where('id','=',$sales_service_id)->first();
				$salesid=$sales->id;
				$c_id=$sales->customer_id;
				$v_id = $sales->vehicle_id;
				$vehicle =  DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
				$manufacturer=getVehicleBrands($vehicle->vehiclebrand_id);
				$modelname=$vehicle->modelname;
				
				$tbl_services=DB::table('tbl_services')->where('sales_id','=',$salesid)->get()->toArray();
				foreach($tbl_services as $tbl_servicess)
				{
					$coupons=$tbl_servicess->job_no;
				}
				$user=DB::table('users')->where('id','=',$c_id)->first();
				$email=$user->email;
				$firstname=$user->name;
				$logo = DB::table('tbl_settings')->first();
				$systemname=$logo->system_name;
				$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','free_service_coupons')->first();
				if($emailformats->is_send == 0)
				{
					if($invoice->save())
					{
						$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','free_service_coupons')->first();
						$mail_format = $emailformat->notification_text;		
						$mail_subjects = $emailformat->subject;		
						$mail_send_from = $emailformat->send_from;
						
						$search1 = array('{ manufacturer }','{ model_Number }');
						$replace1 = array($manufacturer,$modelname);
						
						$mail_sub = str_replace($search1, $replace1, $mail_subjects);
						
						$message = '<html><body>';
						$message .= '<br/><table rules="all" style="border-color: #666;" border="1" cellpadding="10">';
						$message .= "<tr style='background: #eee;'><td><strong>Free-service coupan</strong> </td></tr>";
						foreach($tbl_services as $tbl_servicess)
						{
							$message .= "<tr><td>".$tbl_servicess->job_no ."</td></tr>";
							
						}
						$message .= "</table><br/><br/>";
						$message .= "</body></html>";
						
						$search = array('{ system_name }','{ Customer_name }', '{ manufacturer }','{ model_Number }','{ coupon_list }');
						$replace = array($systemname, $firstname,$manufacturer,$modelname,$message);
						
						$email_content = str_replace($search, $replace, $mail_format);
						$actual_link = $_SERVER['HTTP_HOST'];
						$startip='0.0.0.0';
						$endip='255.255.255.255';
						if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
						{
							//local format email
						
							$data=array(
							'email'=>$email,
							'mail_sub1' => $mail_sub,
							'email_content1' => $email_content,
							'emailsend' =>$mail_send_from,
									
							);
							$data1 =	Mail::send('sales.salescouponfree',$data, function ($message) use ($data){

									$message->from($data['emailsend'],'noreply');

									$message->to($data['email'])->subject($data['mail_sub1']);
								
								});	
						}
						else
						{
							//live format email
							
							$headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
							$headers .= 'From:'. $mail_send_from . "\r\n";
							
							$data = mail($email,$mail_sub,$email_content,$headers);
						}
					}
				}
			}
			// invoice for service in message 
			if(!empty($type == 0))
			{
				
				//pdf download
				
					$serviceid =$sales_service_id;
		
					$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
					
					$c_id=$tbl_services->customer_id;
					$v_id=$tbl_services->vehicle_id;
					
					$s_id = $tbl_services->sales_id;
					$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
					
					$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
					$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
					
					$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
					
					$customer=DB::table('users')->where('id','=',$c_id)->first();
					$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
															  ->where('type','=',0)
															  ->where('chargeable','=',1)
															  ->get()->toArray();
					
					$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
															  ->where('type','=',1)->get()->toArray();
							
					$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get();
					
					$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
					if(!empty($service_tax->tax_name))
					{
						$service_taxes = explode(', ', $service_tax->tax_name);
					}
					else
					{
						$service_taxes='';
					}
					
					$discount = $service_tax->discount;
					$logo = DB::table('tbl_settings')->first();
					
					$pdf = PDF::loadView('invoice.serviceinvoicepdf',compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','service_taxes','discount'));
					$str = "1234567890";
					$str1 = str_shuffle($str);
					
					$pdf->save('public/pdf/service/'.$str1.'.pdf');
					
				//End pdf
				
				//email format	
				$tbl_services = DB::table('tbl_services')->where('id','=',$sales_service_id)->first();
		
				$c_id=$tbl_services->customer_id;
				$title=$tbl_services->title;
				$v_id=$tbl_services->vehicle_id;
				
				$s_id = $tbl_services->sales_id;
				$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
				
				$job=DB::table('tbl_jobcard_details')->where('service_id','=',$sales_service_id)->first();
				$outdate = $job->out_date;
				$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
				
				$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
				
				$customer=DB::table('users')->where('id','=',$c_id)->first();
				
				$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$sales_service_id)->first();
				if(!empty($service_tax->tax_name))
				{
					$service_taxes = explode(', ', $service_tax->tax_name);
				}
				else
				{
					$service_taxes='';
				}
				
				$discount = $service_tax->discount;
				
				$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$sales_service_id)
														  ->where('type','=',0)
														  ->where('chargeable','=',1)
														  ->get()->toArray();
				
				$total1=0;
				$i = 1 ;
				foreach($service_pro as $service_pros)
				{ 
					$total1 += $service_pros->total_price;
				}
				$total2=0;
				$i = 1 ;
				foreach($service_pro2 as $service_pros)
				{	
					$total2 += $service_pros->total_price;
				}
				$fix = $tbl_services->charge; 
				$total_amt = $total1 + $total2 + $fix;
				$dis = $service_tax->discount; $discount = ($total_amt*$dis)/100;
				$after_dis_total = $total_amt-$discount;
				$all_taxes = 0;
				$total_tax = 0;
				if(!empty($service_taxes))
				{
					foreach($service_taxes as $ser_tax)
					{ 
						$taxes_to_count = preg_replace("/[^0-9,.]/", "", $ser_tax);
					
						$all_taxes = ($after_dis_total*$taxes_to_count)/100;  
						
						$total_tax +=  $all_taxes;
					}
					$final_grand_total = $after_dis_total+$total_tax;	
				}
				else
				{
					$final_grand_total = $after_dis_total;
				}
				$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$sales_service_id)->get()->toArray();
				
				$logo = DB::table('tbl_settings')->first();
				$systemname=$logo->system_name;
				
				$user=DB::table('users')->where('id','=',$c_id)->first();
				$email=$user->email;
				$firstname=$user->name;	
				$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','done_service_invoice')->first();
				if($emailformats->is_send == 0)
				{
				if($invoice->save())
				{
					$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','done_service_invoice')->first();
						$mail_format = $emailformat->notification_text;		
						$mail_subjects = $emailformat->subject;		
						$mail_send_from = $emailformat->send_from;
						
						$search1 = array('{ jobcard_no }');
						$replace1 = array($jobcard);
						$mail_sub = str_replace($search1, $replace1, $mail_subjects);
				
						$search = array('{ system_name }','{ Customer_name }', '{ service_title }','{ service_date }','{ total_amount }','{ Invoice }');
						$replace = array($systemname, $firstname,$title,$outdate,$final_grand_total,'invoice');
						
						$email_content = str_replace($search, $replace, $mail_format);
						
						//live format email
						
							$server = $_SERVER['SERVER_NAME'];
							if(isset($_SERVER['HTTPS'])){
								$protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
							}
							else{
								$protocol = 'http';
							}		
							// $url = "$protocol://$server/garage/public/pdf/service/".$str1.'.pdf';
							$url = URL::to('/public/pdf/service/'.$str1.'.pdf');
							$fileatt = "test.pdf"; // Path to the file                  
						
							$fileatt_type = "application/pdf"; // File Type  
							$fileatt_name = $str1.'.pdf'; // Filename that will be used for the file as the attachment  
							$email_from = $mail_send_from; // Who the email is from  
							$email_subject = $mail_sub; // The Subject of the email  
							$email_message = $email_content;
							
							$email_to = $email; // Who the email is to  
							/* $headers = "{$from}";  */
							$headers = "From: ".$email_from;  
							
							$file = fopen($url,'rb');  


							$contents = file_get_contents($url); // read the remote file
							touch('temp.pdf'); // create a local EMPTY copy
							file_put_contents('temp.pdf', $contents);


							$data = fread($file,filesize("temp.pdf"));  
							// $data = fread($file,19189);  
							fclose($file);  
							$semi_rand = md5(time());  
							$mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";  
								
							$headers .= "\nMIME-Version: 1.0\n" .  
										"Content-Type: multipart/mixed;\n" .  
										" boundary=\"{$mime_boundary}\"";  
							$email_message .= "This is a multi-part message in MIME format.\n\n" .  
											"--{$mime_boundary}\n" .  
											"Content-Type:text/html; charset=\"iso-8859-1\"\n" .  
										   "Content-Transfer-Encoding: 7bit\n\n" .  
							$email_message .= "\n\n";  
							// $data = chunk_split(base64_encode($data));   
							$data = chunk_split(base64_encode(file_get_contents('temp.pdf')));
							$email_message .= "--{$mime_boundary}\n" .  
											  "Content-Type: {$fileatt_type};\n" .  
											  " name=\"{$fileatt_name}\"\n" .  
											  //"Content-Disposition: attachment;\n" .  
											  //" filename=\"{$fileatt_name}\"\n" .  
											  "Content-Transfer-Encoding: base64\n\n" .  
											 $data .= "\n\n" .  
											  "--{$mime_boundary}--\n"; 

					// $actual_link = $_SERVER['HTTP_HOST'];
					// $startip='0.0.0.0';
					// $endip='255.255.255.255';
					// if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
					// {
					// 	//local format email
						
					// 	$data=array(
					// 	'email'=>$email,
					// 	'mail_sub1' => $mail_sub,
					// 	'emailsend' =>$mail_send_from,
					// 	'email_content1' => $email_content,
						
					// 	'service_pro' => $service_pro,
					// 	'service_pro2' => $service_pro2,
					// 	'tbl_services' => $tbl_services,
					// 	'sales' => $sales,
					// 	'job' => $job,
					// 	's_date' => $s_date,
					// 	'vehical' => $vehical,
					// 	'customer' => $customer,
					// 	'tbl_service_observation_points' => $tbl_service_observation_points,
					// 	'service_tax' => $service_tax,
					// 	'logo' => $logo,
					// 	'pdf'=>$pdf->output(),
					// 	'str'=>$str1.'.pdf',
					// 	);
					// 	$data1 =	Mail::send('jobcard.servicedone',$data, function ($message) use ($data){

					// 			$message->from($data['emailsend'],'noreply');
					// 			$message->attachData($data['pdf'], "serviceinvoice.pdf");
					// 			$message->to($data['email'])->subject($data['mail_sub1']);
					// 		});
					// }	
					// else
					// {
					// 	$ok = mail($email_to, $email_subject, $email_message, $headers);
					// }
				}
			}
		}
		if(!empty($type == 2))
		{
			
				//PDF download
				if(!empty($sales_service_id))
				{
					$id = $sales_service_id;
					$invoice_number = $invoice_number;			
				}
				else
				{
					$id = $serviceid;
					$auto_id =$invoice->id;
				}
			
				$viewid = $id;
				
				
				$sales = DB::table('tbl_sale_parts')->where('id','=',$id)->first();
				$v_id = $sales->product_id;
				
				$vehicale =  DB::table('tbl_products')->where('id','=',$v_id)->first();
			
				if($sales_service_id)
				{
					$invioce = DB::table('tbl_invoices')->where([['sales_service_id',$id],['invoice_number',$invoice_number]])->first();
					
				}
				else
				{
					$invioce = DB::table('tbl_invoices')->where('id',$auto_id)->first();
				}	
				if(!empty($invioce->tax_name))
				{
					$taxes = explode(', ',$invioce->tax_name);
				}
				else
				{
					$taxes='';
				}

				$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$v_id)->first();
				$logo = DB::table('tbl_settings')->first();	
			
				$pdf = PDF::loadView('invoice.sales_partinvoicepdfl',compact('viewid','vehicale','sales','logo','invioce','taxes','rto'));
				
				$str = "abcdefghijklmnopqrstuvwxyz";
				$str1 = str_shuffle($str);
				
				$pdf->save('public/pdf/sales/'.$str1.'.pdf');
				
				// return $pdf->download('salesinvoice.pdf');
		
				//end pdf
				
				
			return redirect('/sales_part/list')->with('message','Successfully Submitted');
		}
		return redirect('invoice/list')->with('message','Successfully Submitted');
	}
	
	public function sale_part_store()
	{
		
		    if(getDateFormat()== 'm-d-Y')
			{
				$dates=date('Y-m-d',strtotime(str_replace('-','/',Input::get('Date'))));
			}
			else
			{
				$dates=date('Y-m-d',strtotime(Input::get('Date')));
			}
			$sales_service_id=Input::get('jobcard_no');
			$type=Input::get('Invoice_type');
			$invoice_number = Input::get('Invoice_Number');
			
			$invoice= new tbl_invoices;
			$invoice->invoice_number = $invoice_number;
			$invoice->payment_number = Input::get('paymentno');
			$invoice->customer_id = Input::get('Customer');
			$jobcard = Input::get('Job_card');
			$vehicle = Input::get('Vehicle');
			if(!empty($jobcard))
			{ $invoice->job_card = $jobcard; }
			else
			{ $invoice->job_card = $vehicle; }
			$invoice->date = $dates;
			$invoice->payment_type = Input::get('Payment_type');
			$invoice->payment_status = Input::get('Status');
			if(!empty(Input::get('Tax')))
			{
				$invoice->tax_name = implode(', ',Input::get('Tax'));
			}
			// $invoice->tax_name = $taxes;
			$invoice->total_amount = Input::get('Total_Amount');
			$invoice->grand_total = Input::get('grandtotal');
			$invoice->paid_amount = Input::get('paidamount');
			$invoice->amount_recevied = Input::get('paidamount');
			$invoice->discount = Input::get('Discount');
			$invoice->details = Input::get('Details');
			$invoice->type = $type;
			$invoice->sales_service_id =$sales_service_id;
			$invoice->save();
			
			$tbl_invoicess = DB::table('tbl_invoices')->orderBy('id','desc')->first();
			$invoiceid=$tbl_invoicess->id;
			
			$tbl_payment_records = new  tbl_payment_records;
			$tbl_payment_records->invoices_id = $invoiceid;
			$tbl_payment_records->payment_number = Input::get('paymentno');
			$tbl_payment_records->amount = Input::get('paidamount');
			$tbl_payment_records->payment_type = Input::get('Payment_type');
			$tbl_payment_records->payment_date = $dates;
			$tbl_payment_records->save();
			
			if($type == 0)
			{
				$main_label="Service";
			}
			elseif($type == 1)
			{
				$main_label="Sales";
			}
			else
			{ 
				$main_label="Sale Part";
			}
			$tbl_incomes = new tbl_incomes;
			$tbl_incomes->invoice_number=$invoice_number;
			$tbl_incomes->payment_number=Input::get('paymentno');
			$tbl_incomes->customer_id=Input::get('Customer');
			$tbl_incomes->status=Input::get('Status');
			$tbl_incomes->payment_type =Input::get('Payment_type');
			$tbl_incomes->date=$dates;
			$tbl_incomes->main_label=$main_label;
			$tbl_incomes->save();
			
			$tbl_income_id = DB::table('tbl_incomes')->orderBy('id','DESC')->first();
		
			$tbl_income_history_records = new tbl_income_history_records;
			$tbl_income_history_records->tbl_income_id = $tbl_income_id->id;
			$tbl_income_history_records->income_amount = Input::get('paidamount');
			$tbl_income_history_records->income_label = $main_label;
			$tbl_income_history_records->save();
			//email format
			//invoice for sales in email
			
		if(!empty($type == 2))
		{
			
				//PDF download
				if(!empty($sales_service_id))
				{
					$id = $sales_service_id;
					$invoice_number = $invoice_number;			
				}
				else
				{
					$id = $serviceid;
					$auto_id =$invoice->id;
				}
			
				$viewid = $id;
				
				
				$sales = DB::table('tbl_sale_parts')->where('id','=',$id)->first();
				$v_id = $sales->product_id;
				
				$vehicale =  DB::table('tbl_products')->where('id','=',$v_id)->first();
			
				if($sales_service_id)
				{
					$invioce = DB::table('tbl_invoices')->where([['sales_service_id',$id],['invoice_number',$invoice_number]])->first();
					
				}
				else
				{
					$invioce = DB::table('tbl_invoices')->where('id',$auto_id)->first();
				}	
				if(!empty($invioce->tax_name))
				{
					$taxes = explode(', ',$invioce->tax_name);
				}
				else
				{
					$taxes='';
				}

				$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$v_id)->first();
				$logo = DB::table('tbl_settings')->first();	
			
				$pdf = PDF::loadView('invoice.sales_partinvoicepdfl',compact('viewid','vehicale','sales','logo','invioce','taxes','rto'));
				
				$str = "abcdefghijklmnopqrstuvwxyz";
				$str1 = str_shuffle($str);
				
				$pdf->save('public/pdf/sales/'.$str1.'.pdf');
				
				// return $pdf->download('salesinvoice.pdf');
		
				//end pdf
				
				
			return redirect('/sales_part/list')->with('message','Successfully Submitted');
		}
	}

	//invoice pay 
	public function pay(Request $request)
	{
		$id=$request->id;
		$characters = '0123456789';
		$code =  'P'.''.substr(str_shuffle($characters),0,6);
		$tbl_invoices = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$total=$tbl_invoices->grand_total;
		$paid_amount=$tbl_invoices->paid_amount;
		$dueamount=$total - $paid_amount;
		$tbl_payments = DB::table('tbl_payments')->get()->toArray();
		return view('invoice/pay',compact('tbl_invoices','customer','tax','code','dueamount','tbl_payments'));
	}
	
	//invoice pay update
	public function payupdate(Request $request, $id)
	{
		if(getDateFormat()== 'm-d-Y')
		{
			$paymentdate=date('Y-m-d',strtotime(str_replace('-','/',Input::get('Date'))));
		}
		else
		{	
			$paymentdate=date('Y-m-d',strtotime(Input::get('Date')));
		}
		$tbl_payment_records = new tbl_payment_records;
		$tbl_payment_records->invoices_id =$id;
		$tbl_payment_records->amount =Input::get('receiveamount');
		$tbl_payment_records->payment_type =Input::get('Payment_type');
		$tbl_payment_records->payment_date =$paymentdate;
		$tbl_payment_records->note =Input::get('note');
		$tbl_payment_records->payment_number =Input::get('paymentno');
		$tbl_payment_records->save();
		
		$tbl_invoices = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$invoice_number=$tbl_invoices->invoice_number;
		$customer_id=$tbl_invoices->customer_id;
		$paid_amount=$tbl_invoices->paid_amount;
		$grandtotal=$tbl_invoices->grand_total;
		$amount =Input::get('receiveamount');
		$total=$paid_amount + $amount;
		
		
		$tblin = tbl_invoices::find($id);
		$tblin->paid_amount =$total;
		if($grandtotal == $total )
		{
			$status=2;
			$tblin->payment_status =$status;
			
		}elseif($grandtotal > $total && $total > 0)
		{
			$status=1;
			$tblin->payment_status =$status;
			
		}elseif($total == 0)
		{
			$status=0;
			$tblin->payment_status =$status;
		}
		$tblin->save();
		
		if($tbl_invoices->type == 0)
		{
			$main_label="Service";
		}
		elseif($tbl_invoices->type == 1)
		{
			$main_label="Sales";
		}
		else
		{ 
			$main_label="";
		}
		$tbl_incomes = new tbl_incomes;
		$tbl_incomes->invoice_number=$invoice_number;
		$tbl_incomes->payment_number=Input::get('paymentno');
		$tbl_incomes->customer_id=$customer_id;
		$tbl_incomes->status=$status;
		$tbl_incomes->payment_type =Input::get('Payment_type');
		$tbl_incomes->date=$paymentdate;
		$tbl_incomes->main_label=$main_label;
		$tbl_incomes->save();
		
		$tbl_income_id = DB::table('tbl_incomes')->orderBy('id','DESC')->first();
	
		$tbl_income_history_records = new tbl_income_history_records;
		$tbl_income_history_records->tbl_income_id = $tbl_income_id->id;
		$tbl_income_history_records->income_amount = $amount;
		$tbl_income_history_records->income_label = $main_label;
		$tbl_income_history_records->save();
		
		return redirect('/invoice/list')->with('message','Successfully Submitted');	
	}
	//invoice edit
	public function edit($id)
	{	
		$invoice_edit = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$type = $invoice_edit->type; 
		
		if($type == 1)
		{
			$customer = DB::table('tbl_sales')->select('customer_id')->groupBy('customer_id')->get()->toArray();
		}
		else
		{
			$customer = DB::table('tbl_services')->where('done_status','=',1)->groupBy('customer_id')->get()->toArray();
		}
		$total=$invoice_edit->grand_total;
		$paid_amount=$invoice_edit->paid_amount;
		$dueamount=$total - $paid_amount;
		$tax = DB::table('tbl_account_tax_rates')->get()->toArray();
		$tbl_payments = DB::table('tbl_payments')->get()->toArray();
		return view('invoice/edit',compact('invoice_edit','customer','tax','dueamount','tbl_payments'));
	}
	//invoice update
	public function update($id)
	{
		$tbl_invoices = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$paid_amount=$tbl_invoices->paid_amount;
		$invoice_number=$tbl_invoices->invoice_number;
		
		$payment_number=$tbl_invoices->payment_number;
		
		$type=$tbl_invoices->type;
		$amount_recevied=0;
		$amount_recevied=$tbl_invoices->amount_recevied;
		
		$paidamount=Input::get('paidamount');
		
		if($amount_recevied > $paidamount )
		{
			$amount = $amount_recevied - $paidamount;
			$paid_amount1=$paid_amount - $amount;
		}
		if($amount_recevied < $paidamount )
		{
			$amount = $paidamount - $amount_recevied;
			$paid_amount1=$paid_amount + $amount;
		}
		if($amount_recevied == $paidamount )
		{
			$paid_amount1=$paid_amount;
		}
			if(getDateFormat()== 'm-d-Y')
			{
				$dates=date('Y-m-d',strtotime(str_replace('-','/',Input::get('Date'))));
			}
			else
			{
				$dates=date('Y-m-d',strtotime(Input::get('Date')));
			}
			$invoice = tbl_invoices::find($id);
			// $taxes = implode(', ',Input::get('Tax'));
			
			$invoice->invoice_number = Input::get('Invoice_Number');
			$invoice->customer_id = Input::get('Customer');
			$invoice->job_card = Input::get('Job_card');
			$invoice->date =$dates;
			$invoice->payment_type = Input::get('Payment_type');
			$invoice->payment_status = Input::get('Status');
			if(!empty(Input::get('Tax')))
			{
				$invoice->tax_name = implode(', ',Input::get('Tax'));
			}
			// $invoice->tax_name = $taxes;
			$invoice->total_amount = Input::get('Total_Amount');
			$invoice->grand_total = Input::get('grandtotal');
			$invoice->discount = Input::get('Discount');
			$invoice->amount_recevied = Input::get('paidamount');
			$invoice->paid_amount = $paid_amount1;
			$invoice->details = Input::get('Details');
			$invoice->sales_service_id = Input::get('jobcard_no');
			$invoice->save();
			
			$tbl_payment_records=DB::table('tbl_payment_records')->where([['invoices_id','=',$id],['payment_number','=',$payment_number]])->first();
			if(!empty($tbl_payment_records))
			{
				$paymentno=$tbl_payment_records->payment_number;
				$payid=$tbl_payment_records->id;
				$invoiceid=$tbl_payment_records->invoices_id;
				
				$tbl_payment_records =tbl_payment_records::find($payid);
				$tbl_payment_records->invoices_id = $invoiceid;
				$tbl_payment_records->payment_number = $paymentno;
				$tbl_payment_records->amount = Input::get('paidamount');
				$tbl_payment_records->payment_type = Input::get('Payment_type');
				$tbl_payment_records->payment_date = $dates;
				$tbl_payment_records->save();
				
				if($type == 0)
				{
					$main_label="Service";
				}
				elseif($type == 1)
				{
					$main_label="Sales";
				}
				else
				{ 
					$main_label="";
				}
				$tbl_incomes=DB::table('tbl_incomes')->where([['invoice_number','=',$invoice_number],['payment_number','=',$payment_number]])->first();
				
				$incomesid=$tbl_incomes->id;
				
				$tbl_incomes = tbl_incomes::find($incomesid);
				$tbl_incomes->invoice_number=$invoice_number;
				$tbl_incomes->payment_number=$payment_number;
				$tbl_incomes->customer_id=Input::get('Customer');
				$tbl_incomes->status=Input::get('Status');
				$tbl_incomes->payment_type =Input::get('Payment_type');
				$tbl_incomes->date=$dates;
				$tbl_incomes->main_label=$main_label;
				$tbl_incomes->save();
				
				$tbl_income_id=DB::table('tbl_income_history_records')->where('tbl_income_id','=',$incomesid)->first();
				
				$tbl_incomeid= $tbl_income_id->id;
				$tbl_income_history_records = tbl_income_history_records::find($tbl_incomeid);
				$tbl_income_history_records->tbl_income_id = $incomesid;
				$tbl_income_history_records->income_amount =Input::get('paidamount');
				$tbl_income_history_records->income_label = $main_label;
				$tbl_income_history_records->save();
			}
			else
			{
				$tbl_payment_records = new  tbl_payment_records;
				$tbl_payment_records->invoices_id = $id;
				$tbl_payment_records->payment_number = $payment_number;
				$tbl_payment_records->amount = Input::get('paidamount');
				$tbl_payment_records->payment_type = Input::get('Payment_type');
				$tbl_payment_records->payment_date = $dates;
				$tbl_payment_records->save();
				
				if($type == 0)
				{
					$main_label="Service";
				}
				elseif($type == 1)
				{
					$main_label="Sales";
				}
				else
				{ 
					$main_label="";
				}
				$tbl_incomes = new tbl_incomes;
				$tbl_incomes->invoice_number=$invoice_number;
				$tbl_incomes->payment_number=$payment_number;
				$tbl_incomes->customer_id=Input::get('Customer');
				$tbl_incomes->status=Input::get('Status');
				$tbl_incomes->payment_type =Input::get('Payment_type');
				$tbl_incomes->date=$dates;
				$tbl_incomes->main_label=$main_label;
				$tbl_incomes->save();
				
				$tbl_income_id = DB::table('tbl_incomes')->orderBy('id','DESC')->first();
			
				$tbl_income_history_records = new tbl_income_history_records;
				$tbl_income_history_records->tbl_income_id = $tbl_income_id->id;
				$tbl_income_history_records->income_amount = Input::get('paidamount');
				$tbl_income_history_records->income_label = $main_label;
				$tbl_income_history_records->save();
				
			}
	
			return redirect('invoice/list')->with('message','Successfully Updated');;	
	}
	
	//invoice paymentview
	public function paymentview()
	{
		$invoice_id = Input::get('invoice_id');
		$tbl_invoices= DB::table('tbl_invoices')->where('id','=',$invoice_id)->first();
		$tbl_payment_records= DB::table('tbl_payment_records')->where('invoices_id','=',$invoice_id)->get()->toArray();
		$html = view('invoice.paymentview')->with(compact('tbl_invoices','tbl_payment_records'))->render();
		return response()->json(['success' => true, 'html' => $html]);;
	}

	//invoice delete
	public function destroy($id)
	{	
		
		$tbl_payment_records=DB::table('tbl_payment_records')->where('invoices_id','=',$id)->delete();
		$tbl_invoices=DB::table('tbl_invoices')->where('id','=',$id)->first();
		$invoice_no=$tbl_invoices->invoice_number;
		$incomes_id=DB::table('tbl_incomes')->where('invoice_number','=',$invoice_no)->first();
		if(!empty($incomes_id))
		{
		$incomeid=$incomes_id->id;
		$tbl_incomes=DB::table('tbl_income_history_records')->where('tbl_income_id','=',$incomeid)->delete();
		$tbl_incomes=DB::table('tbl_incomes')->where('invoice_number','=',$invoice_no)->delete();
		}
		tbl_invoices::destroy($id);
		return redirect('/invoice/list')->with('message','Successfully Deleted');;
	}	
	
	//Service pdf
	public function servicepdf($id)
	{
		$tbl_invoices = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$serviceid = $tbl_invoices->sales_service_id;
		
		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();
		
		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;
		
		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
		
		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
		
		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		
		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->where('chargeable','=',1)
												  ->get()->toArray();
		
		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();
				
		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get();
		
		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes='';
		}
		
		$discount = $service_tax->discount;
		$logo = DB::table('tbl_settings')->first();
		
		$pdf = PDF::loadView('invoice.serviceinvoicepdf',compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','service_taxes','discount'));
	    return $pdf->download('invoicepdf.pdf');
	}
	
	
	
	//Sales pdf
	public function salespdf($id)
	{
		$invioces = DB::table('tbl_invoices')->where('id','=',$id)->first();
		$sales_service_id=$invioces->sales_service_id;
		$invoice_number=$invioces->invoice_number;
		if(!empty($sales_service_id))
		{
			$id1 = $sales_service_id;
			$invoice_number = $invoice_number;			
		}
		else
		{
			$id = $serviceid;
			$auto_id =$invoice->id;
			
		}
			
		$viewid = $id;
		$sales = DB::table('tbl_sales')->where('id','=',$id1)->first();
		$v_id = $sales->vehicle_id;
		$vehicale =  DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		if($sales_service_id)
		{
			$invioce = DB::table('tbl_invoices')->where([['sales_service_id',$id1],['invoice_number',$invoice_number]])->first();
		}
		else
		{
			$invioce = DB::table('tbl_invoices')->where('id',$id)->first();
		}	
		if(!empty($invioce->tax_name))
		{
			$taxes = explode(', ',$invioce->tax_name);
		}
		else
		{
			$taxes='';
		}
		
	
		$rto = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$v_id)->first();
		$logo = DB::table('tbl_settings')->first();	
	
		$pdf = PDF::loadView('invoice.salesinvoicepdfl',compact('viewid','vehicale','sales','logo','invioce','taxes','rto'));
		 return $pdf->download('invoicesalespdf.pdf');
	}
}
