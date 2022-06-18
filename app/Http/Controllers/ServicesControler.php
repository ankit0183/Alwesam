<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_vehicles;
use App\tbl_services;
use App\tbl_service_pros;
use App\tbl_jobcard_details;
use App\users;
use App\tbl_service_observation_points;
use App\Http\Requests;
use DB;
use Auth;
use App\tbl_points;
use App\tbl_vehicle_colors;
use App\tbl_vehicle_discription_records;
use App\tbl_vehicle_images;
use App\User;
use Mail;
use DateTime;
//use Illuminate\Mail\Mailer;
//use App\tbl_mail_notifications;
use Illuminate\Support\Facades\Input;
use Symfony\Component\Console\Input\InputInterface;

class ServicesControler extends Controller
{
	 //  get tables and compact
	  public function __construct()
    {
        $this->middleware('auth');
    }

	//service add form
	public function index()
	{
       $characters = '0123456789';
       $code =  'J'.''.substr(str_shuffle($characters),0,6);
	   $employee=DB::table('users')->where('role','employee')->get()->toArray();
	   //Customer add
	   $customer=DB::table('users')->where('role','Customer')->get()->toArray();
       // $customer=DB::table('tbl_sales')->groupBy('customer_id')->get();
	   $country = DB::table('tbl_countries')->get()->toArray();
	   $onlycustomer=DB::table('users')->where([['role','=','Customer'],['id','=',Auth::User()->id]])->first();
		//vehicle add
		$vehical_type = DB::table('tbl_vehicle_types')->get()->toArray();
	    $vehical_brand = DB::table('tbl_vehicle_brands')->get()->toArray();
	    $fuel_type = DB::table('tbl_fuel_types')->get()->toArray();
	    $color = DB::table('tbl_colors')->get()->toArray();
		$model_name = DB::table('tbl_model_names')->get()->toArray();

	   return view('service.add',compact('employee','customer','code','country','onlycustomer','vehical_brand','vehical_type','fuel_type','color','model_name'));
	}
	//customer add
	public function customeradd(Request $request)
	{

		$firstname=Input::get('firstname');
		$lastname=Input::get('lastname');
		$displayname=Input::get('displayname');
		$gender=Input::get('gender');

		if(getDateFormat() == 'm-d-Y')
		{
		    $dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
		}
		else
		{
			$dob=date('Y-m-d',strtotime(Input::get('dob')));
		}
		$email=Input::get('email');
		$password=Input::get('password');
		$mobile=Input::get('mobile');
//$landlineno=Input::get('landlineno');
		$address=Input::get('address');
		$country=Input::get('country_id');
		$state=Input::get('state_id');
		$city=Input::get('city');

			$customer = new User;
			$customer->name=$firstname;
			$customer->lastname=$lastname;
			$customer->display_name=$displayname;
			$customer->gender=$gender;
			$customer->birth_date=$dob;
			$customer->email=$email;
			$customer->password=bcrypt($password);
			$customer->mobile_no=$mobile;
///$customer->landline_no=$landlineno;
			$customer->address=$address;
			$customer->country_id=$country;
			$customer->state_id=$state;
			$customer->city_id=$city;

			if(!empty(Input::hasFile('image')))
			{
			$file= Input::file('image');
			$filename=$file->getClientOriginalName();
			$file->move(public_path().'/customer/', $file->getClientOriginalName());
			$customer->image=$filename;
			}
			else{
			$customer->image='avtar.png';
			}

			$customer->role="Customer";
			$customer->language="en";
			$customer->timezone="UTC";
			$customer -> save();
			echo $customer->id;
	}

	//add vehicle
	public function vehicleadd()
	{
		$vehical_type=Input::get('vehical_id1');
		$chasicno=Input::get('chasicno1');
		$vehicabrand=Input::get('vehicabrand1');
		$modelyear=Input::get('modelyear1');
		$fueltype=Input::get('fueltype1');
		$modelname=Input::get('modelname1');
		$price=Input::get('price1');
		$odometerreading=Input::get('odometerreading1');
		$domm=Input::get('dom1');
		if(!empty($domm))
		{
			if(getDateFormat()== 'm-d-Y')
			{
				$dom=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dom1'))));

			}
			else
			{
				$dom=date('Y-m-d',strtotime(Input::get('dom1')));
			}

		}
		else{
			$dom='0000-00-00';
		}
		$gearbox=Input::get('gearbox1');
		$gearboxno=Input::get('gearboxno1');
		$engineno=Input::get('engineno1');
		$enginesize=Input::get('enginesize1');
		$keyno=Input::get('keyno1');
		$engine=Input::get('engine1');
		$nogears=Input::get('gearno1');

		$vehical = new tbl_vehicles;
		$vehical->vehicletype_id=$vehical_type;
		$vehical->chassisno =$chasicno;
		$vehical->vehiclebrand_id =$vehicabrand;
		$vehical->modelyear  =$modelyear;
		$vehical->fuel_id  =$fueltype;
		$vehical->modelname  =$modelname;
		$vehical->price  =$price;
		$vehical->odometerreading  =$odometerreading;
		$vehical->dom  =$dom;
		$vehical->gearbox   =$gearbox;
		$vehical->gearboxno   =$gearboxno;
		$vehical->engineno  =$engineno;
		$vehical->enginesize =$enginesize ;
		$vehical->keyno  =$keyno;
		$vehical->engine =$engine;
		$vehical->nogears =$nogears;
		$vehical-> save();
		$vehicles =    DB::table('tbl_vehicles')->orderBy('id','desc')->first();
   		$id = $vehicles->id;
		echo $vehical->id;


	}
	//get regi. number
	public function getregistrationno()
	{
		$vehi_id = Input::get('vehi_id');

		$vehicals = DB::table('tbl_sales')->where('vehicle_id','=',$vehi_id)->first();
		if(!empty($vehicals))
		{
			$reg = $vehicals->registration_no;
		}
		else
		{
			$vehicals = DB::table('tbl_vehicles')->where('id','=',$vehi_id)->first();
			$reg = $vehicals->registration_no;
		}
		return $reg;
	}

	//get vehicle name
	public function get_vehicle_name()
	{
		$cus_id = Input::get('cus_id');
		$vehicals = DB::table('tbl_services')->where('customer_id','=',$cus_id)->groupBy('vehicle_id')->get()->toArray();

		// $vehicals = DB::SELECT("SELECT  tbl_sales.vehicle_id,tbl_services.vehicle_id FROM tbl_services LEFT JOIN tbl_sales ON tbl_sales.customer_id = tbl_services.customer_id where tbl_services.customer_id = 35 OR tbl_sales.customer_id=35;");
		// var_dump($vehicals);
		// exit;
		?>
		<?php foreach($vehicals as $vehical) { ?>
			<option value="<?php echo $vehical->vehicle_id;?>" class="modelnms"><?php echo getVehicleName($vehical->vehicle_id);?></option>
		<?php } ?>
		<?php

	}

	//add_jobcard store
	public function add_jobcard()
	{


		$job_no = Input::get('job_no');
		$service_id = Input::get('service_id');
		if(getDateFormat() == 'm-d-Y')
		{
			$in_dat=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('in_date'))));
			$out_dat=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('out_date'))));
		}
		else
		{
			$in_dat=date('Y-m-d H:i:s',strtotime(Input::get('in_date')));
			$out_dat=date('Y-m-d H:i:s',strtotime(Input::get('out_date')));
		}
		$cus_id = Input::get('cust_id');
		$vehi_id = Input::get('vehi_id');
		$kms = Input::get('kms');
		$coupan_no = Input::get('coupan_no');
        $customer_sug =  Input::get('customer_sug');
        $customer_comp =  Input::get('customer_comp');
		$product = Input::get('product');
		$sub_product = Input::get('sub_product');
		$comment = Input::get('comment');
		$obs_auto_id = Input::get('obs_id');
			if(!empty($product))
			{
				foreach($product as $key => $value)
				{
					$category = $product[$key];
					$sub = $sub_product[$key];
					$comm = $comment[$key];
					$obs_au_id = $obs_auto_id[$key];

					$tbl_service_pros = new tbl_service_pros;
					$tbl_service_pros->service_id = $service_id;
					$tbl_service_pros->category = $category;
					$tbl_service_pros->obs_point = $sub;
					$tbl_service_pros->category_comments = $comm;
					$tbl_service_pros->tbl_service_observation_points_id = $obs_au_id;
					$tbl_service_pros->save();
				}
			}
		$tbl_jobcard_details = new tbl_jobcard_details;
		$tbl_jobcard_details->customer_id = $cus_id;
		$tbl_jobcard_details->vehicle_id = $vehi_id;
		$tbl_jobcard_details->service_id = $service_id;
		$tbl_jobcard_details->jocard_no = $job_no;
		$tbl_jobcard_details->in_date = $in_dat;
		$tbl_jobcard_details->out_date = $out_dat;
		$tbl_jobcard_details->kms_run = $kms;
        $tbl_jobcard_details->customer_comp = $customer_comp;
        $tbl_jobcard_details->customer_sug = $customer_sug;
		if(!empty($coupan_no))
		{
		$tbl_jobcard_details->coupan_no = $coupan_no;
		}
		$tbl_jobcard_details->save();

		// //email format
		// $user=DB::table('users')->where('id','=',$cus_id)->first();
		// $email=$user->email;
		// $firstname=$user->name;
		// $logo = DB::table('tbl_settings')->first();
		// $systemname=$logo->system_name;
		// $servicedetails=DB::table('tbl_services')->where('job_no','=',$job_no)->first();
		// $details=$servicedetails->detail;
		// $emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','successful_jobcard')->first();
		// if($emailformats->is_send == 0)
		// {
		// 	if($tbl_jobcard_details->save())
		// 	{
		// 		$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','successful_jobcard')->first();
		// 		$mail_format = $emailformat->notification_text;
		// 		$mail_subjects = $emailformat->subject;
		// 		$mail_send_from = $emailformat->send_from;
		// 		$search1 = array('{ jobcard_number }');
		// 		$replace1 = array($job_no);
		// 		$mail_sub = str_replace($search1, $replace1, $mail_subjects);

		// 		$search = array('{ system_name }','{ Customer_name }', '{ jobcard_number }', '{ service_date }', '{ detail }');
		// 		$replace = array($systemname, $firstname, $job_no, $in_dat,$details);

		// 		$email_content = str_replace($search, $replace, $mail_format);
		// 		$actual_link = $_SERVER['HTTP_HOST'];
		// 		$startip='0.0.0.0';
		// 		$endip='255.255.255.255';
		// 		if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
		// 		{
		// 			//local format email

		// 			$data=array(
		// 			'email'=>$email,
		// 			'mail_sub1' => $mail_sub,
		// 			'email_content1' => $email_content,
		// 			'emailsend' =>$mail_send_from,
		// 			);
		// 			$data1 =	Mail::send('customer.customermail',$data, function ($message) use ($data){

		// 					$message->from($data['emailsend'],'noreply');

		// 					$message->to($data['email'])->subject($data['mail_sub1']);
		// 				});
		// 		}
		// 		else
		// 		{
		// 			//live format email

		// 			$headers = 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
		// 			$headers .= 'From:'. $mail_send_from . "\r\n";

		// 			$data = mail($email,$mail_sub,$email_content,$headers);
		// 		}

		// 		}

		// }
		return redirect('jobcard/list')->with('message','Successfully Submitted');
	}

	//jobcard store
	public function store(Request $request)
    {
		$this->validate($request, [
         'charge' => 'nullable|numeric',
	      ]);
	  $job=Input::get('jobno');
      $vehicalname = Input::get('vehicalname');
	  if(getDateFormat()== 'm-d-Y')
	  {
		$date=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('date'))));
	  }
	  else
	  {
		 $date=date('Y-m-d H:i:s',strtotime(Input::get('date')));
	  }


      $title = Input::get('title');
      $AssigneTo = Input::get('AssigneTo');
	  $service_category = Input::get('repair_cat');
	  $ser_type=Input::get('service_type');
	   if($ser_type=='free')
	   {
		 $charge="0";
	   }
	   if($ser_type=='paid')
	  {
			$charge=Input::get('charge');
	  }
      $Customername=Input::get('Customername');
      $detail=Input::get('details');

      $reg_no=Input::get('reg_no');

      $services= new tbl_services;
      $services->job_no=$job;
      $services->vehicle_id=$vehicalname;
      $services->service_date=$date;
      $services->title=$title;
      $services->assign_to=$AssigneTo;
      $services->service_category=$service_category;
      $services->done_status=0;
      $services->charge=$charge;
      $services->customer_id=$Customername;
      $services->detail=$detail;
      $services->service_type=$ser_type;
      $services->save();

	  $vehicalname=Input::get('vehicalname');
	  $Customername=Input::get('Customername');
      $service_data = DB::table('tbl_services')->orderBy('id','DESC')->first();
	  $veh_id = $service_data->vehicle_id;
	  $ser_id = $service_data->id;
	  $cus_id = $service_data->customer_id;

	 $job_card_data = DB::table('tbl_jobcard_details')->where([['customer_id','=',$cus_id],['vehicle_id','=',$veh_id]])->get()->toArray();
	 if(!empty($job_card_data))
	 {
		foreach ($job_card_data as $job_card_datas) {
			$counpan_no[]= $job_card_datas->coupan_no;
	 }

		$free_coupan = DB::table('tbl_services')->where([['customer_id','=',$Customername], ['service_type','=','free'], ['vehicle_id','=',$vehicalname],['job_no','like','C%']])->whereNotIn('job_no',$counpan_no)->get()->toArray();
	 }
	 else
	 {
		  $free_coupan = DB::table('tbl_services')->where([['customer_id','=',$Customername], ['service_type','=','free'], ['vehicle_id','=',$vehicalname], ['job_no','like','C%']])->get()->toArray();
	 }

	  $sale_date = DB::table('tbl_sales')->where('vehicle_id','=',$veh_id)->first();
	  if(!empty( $sale_date))
	  {
		  $color_id = $sale_date->color_id;
		  $color = DB::table('tbl_colors')->where('id','=',$color_id)->first();
	  }

	  $vehical = DB::table('tbl_vehicles')->where('id','=',$veh_id)->first();
	  $tbl_checkout_categories = DB::table('tbl_checkout_categories')->where('vehicle_id','=',$veh_id)->orWhere('vehicle_id','=',0)->get()->toArray();

	  $obs_point = DB::table('tbl_service_observation_points')->where([['services_id','=',$ser_id],['review','=',1]])->get()->toArray();

	  $sale_regi = DB::table('tbl_sales')->where('vehicle_id','=',$vehicalname)->first();

	  if(!empty($sale_regi))
	  {
		  // $regi_no = $sale_regi->registration_no;

			DB::update("update tbl_sales set registration_no = '$reg_no' where vehicle_id = $vehicalname");

	  }
	  else
	  {
		  DB::update("update tbl_vehicles set registration_no = '$reg_no' where id = $vehicalname");
	  }
	  $logo = DB::table('tbl_settings')->first();

	  return view('/service/jobcard_form',compact('service_data','vehical','tbl_checkout_categories','sale_date','color','obs_point','free_coupan','logo'));
    }

	//select checkpoints
	public function select_checkpt()
	{
		$value = Input::get('value');
		$id = Input::get('id');
		$service_id = Input::get('service_id');

		 $datas = DB::table('tbl_service_observation_points')->where([['services_id','=',$service_id],['observation_points_id','=',$id]])->first();

			if(!empty($datas))
			{
				$review = $datas->review;

				if($review == 1)
				{
					DB::update("update tbl_service_observation_points set review = 0 where services_id='$service_id' and observation_points_id='$id'");
				}
				else
				{
					DB::update("update tbl_service_observation_points set review = 1 where services_id='$service_id' and observation_points_id='$id'");
				}
			}
			else
			{
				$data = new tbl_service_observation_points;
				$data->services_id = $service_id;
				$data->observation_points_id = $id;
				$data->review = $value;
				$data->save();
			}
	}

	//get obs. points
	public function Get_Observation_Pts()
	{
		$s_id = Input::get('service_id');
		$product = DB::table('tbl_products')->get();
		$data = DB::table('tbl_points')
					->join('tbl_service_observation_points', 'tbl_service_observation_points.observation_points_id', '=', 'tbl_points.id')
					->where([['tbl_service_observation_points.services_id', '=', $s_id],['review','=',1]])
					->select('tbl_points.*', 'tbl_service_observation_points.id')
					->get()->toArray();
		$html = view('service.observationpoin')->with(compact('s_id','product','data'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}

	//service list
    public function servicelist()
    {
		$month = date('m');
		$year = date('Y');

		$start_date = "$year/$month/01";
		$end_date = "$year/$month/30";
		$current_month= DB::select("SELECT service_date FROM tbl_services where service_date BETWEEN  '$start_date' AND '$end_date'");

		   if(!empty($current_month))
		   {
			 foreach ($current_month as $list)
				   {
					 $date[] = $list->service_date;
				   }

				$available = json_encode($date);
			}

		$ser_id_jobcard_details = DB::table('tbl_jobcard_details')->get()->toArray();
		foreach($ser_id_jobcard_details as $ser_id)
		{
		  $servi_id = $ser_id->service_id;
		}

		$userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			$service=DB::table('tbl_services')->where('job_no','like','J%')->orderBy('id','DESC')->get()->toArray();
		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			// $service=DB::table('tbl_services')->where([['job_no','like','J%'],['assign_to','=',Auth::User()->id]])->orderBy('id','DESC')->get()->toArray();
		}
		else
		{
			$service=DB::table('tbl_services')->where([['job_no','like','J%'],['customer_id','=',Auth::User()->id]])->orderBy('id','DESC')->get()->toArray();

	    }
		return view('/service/list',compact('service','selectdate','available','current_month','servi_id'));

    }

	//service delete
	public function destory($id)
	{
		$service1=DB::table('tbl_jobcard_details')->where('service_id','=',$id)->first();
		$tbl_invoices1=DB::table('tbl_invoices')->where('sales_service_id','=',$id)->first();
		if(!empty($tbl_invoices1))
		{
			$in_id=$tbl_invoices1->id;
			$tbl_payment_records=DB::table('tbl_payment_records')->where('invoices_id','=',$in_id)->delete();
			$tbl_invoices=DB::table('tbl_invoices')->where('id','=',$in_id)->first();
			$invoice_no=$tbl_invoices->invoice_number;
			$incomes_id=DB::table('tbl_incomes')->where('invoice_number','=',$invoice_no)->first();
			if(!empty($incomes_id))
			{
			$incomeid=$incomes_id->id;
			$tbl_incomes=DB::table('tbl_income_history_records')->where('tbl_income_id','=',$incomeid)->delete();
			$tbl_incomes=DB::table('tbl_incomes')->where('invoice_number','=',$invoice_no)->delete();
			}

		}
		if(!empty($service1))
		{
		$jobid=$service1->jocard_no;
		$tbl_gatepasses=DB::table('tbl_gatepasses')->where('jobcard_id','=',$jobid)->delete();
		}
		$tbl_jobcard_details=DB::table('tbl_jobcard_details')->where('service_id','=',$id)->delete();
		$tbl_service_pros=DB::table('tbl_service_pros')->where('service_id','=',$id)->delete();
		$tbl_invoices=DB::table('tbl_invoices')->where('sales_service_id','=',$id)->delete();
		$tbl_services=DB::table('tbl_services')->where('id','=',$id)->delete();

		return redirect('/service/list')->with('message','Successfully Deleted');
	}

	//service edit
   public function serviceedit($id)
   {
     $vehical = DB::table('tbl_vehicles')->get()->toArray();
     $employee = DB::table('users')->where('role','employee')->get()->toArray();
     $customer = DB::table('users')->where('role','Customer')->get()->toArray();
     $service = DB::table('tbl_services')->where('id','=',$id)->first();
	 $cus_id = $service->customer_id;
	 $vah_id = $service->vehicle_id;
     $tbl_sales = DB::table('tbl_sales')->where('vehicle_id',$vah_id)->first();
	 if(!empty($tbl_sales))
	 {
		$regi = DB::table('tbl_sales')->where('customer_id',$cus_id)->first();
	 }
	 else
	 {
		$regi = DB::table('tbl_vehicles')->where('id',$vah_id)->first();
	 }

   	return view('/service/edit',compact('service','vehical','employee','customer','regi'));
   }

   //service update
   public function serviceupdate(Request $request, $id)
   {
	  $this->validate($request, [
         'charge' => 'nullable|numeric',
	      ]);
      $job=Input::get('jobno');
      $vehicalname=Input::get('vehicalname');
	  if(getDateFormat()== 'm-d-Y')
	  {
		$date=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('date'))));
	  }
	  else
	  {
		$date=date('Y-m-d H:i:s',strtotime(Input::get('date')));
	  }
      $title=Input::get('title');
	  $service_category = Input::get('repair_cat');
      $donestatus=Input::get('donestatus');
	  $ser_type=Input::get('service_type');

	   if($ser_type=='free')
	   {
		 $charge="0";
	   }
	   if($ser_type=='paid')
	  {
		$charge=Input::get('charge');
	  }

      $Customername=Input::get('Customername');
      $details=Input::get('details');

      $services= tbl_services::find($id);

      $services->job_no=$job;
      $services->vehicle_id=$vehicalname;
      $services->service_date=$date;
      $services->title=$title;
      //$services->assign_to=$AssigneTo;
      $services->service_category=$service_category;
      $services->charge=$charge;

	  $tblservice=DB::table('tbl_services')->where('id','=',$id)->first();
	  $status=$tblservice->done_status;
	  if($status == 0)
	  {
      $services->done_status=0;
	  }elseif($status == 1)
	  {
		$services->done_status=1;
	  }elseif($status == 2)
	  {
		$services->done_status=2;
	  }
      $services->customer_id=$Customername;
      $services->detail=$details;
      $services->service_type=$ser_type;
      $services->save();
      return redirect('/service/list')->with('message','Successfully Updated');;

   }

	//get used coupon data
   public function Used_Coupon_Data()
   {
		$cpn_no = Input::get('coupon_no');

		$used_cpn_data = DB::table('tbl_jobcard_details')->where('coupan_no',$cpn_no)->first();
		$status = $used_cpn_data->done_status;
		$jb_no = $used_cpn_data->jocard_no;

		$vhi_no = DB::table('tbl_services')->where('job_no',$cpn_no)->first();
		$vehi_name = $vhi_no->vehicle_id;
		$regi = DB::table('tbl_sales')->where('vehicle_id',$vehi_name)->first();
		$ser_tab = DB::table('tbl_services')->where('job_no',$jb_no)->first();
		$logo = DB::table('tbl_settings')->first();

		if(!empty($used_cpn_data))
		{
			$service_id = $used_cpn_data->service_id;
			$cus_id = $used_cpn_data->customer_id;
			$custo_info = DB::table('users')->where('id',$cus_id)->first();
			$mob = $custo_info->mobile_no;
			$city = $custo_info->city_id;
			$state = $custo_info->state_id;
			$country = $custo_info->country_id;

			$all_data = DB::table('tbl_service_pros')->where([['service_id',$service_id],['type','=',0]])->get()->toArray();
			$all_data2 = DB::table('tbl_service_pros')->where([['service_id',$service_id],['type','=',1]])->get()->toArray();
		}

		$html = view('service.couponmodel')->with(compact('service_id','custo_info','logo','mob','custo_info','status','vehi_name','regi','city','state','country','all_data','all_data2','used_cpn_data','vhi_no','ser_tab','cpn_no'))->render();
		return response()->json(['success' => true, 'html' => $html]);
   }

   //service modal view
   public function serviceview()
   {
		$ser_id = Input::get('servicesid');


		$vhi_no = DB::table('tbl_services')->where('id',$ser_id)->first();
		$vehi_name = $vhi_no->vehicle_id;
		$cus_id = $vhi_no->customer_id;

		$tbl_sales = DB::table('tbl_sales')->where('vehicle_id',$vehi_name)->first();
		 if(!empty($tbl_sales))
		 {
			$regi = DB::table('tbl_sales')->where('vehicle_id',$vehi_name)->first();
		 }
		 else
		 {
			$regi = DB::table('tbl_vehicles')->where('id',$vehi_name)->first();
		 }
		$logo = DB::table('tbl_settings')->first();
		$custo_info = DB::table('users')->where('id',$cus_id)->first();

		// $mob = $custo_info->mobile_no;
		// $city = $custo_info->city_id;
		// $state = $custo_info->state_id;
		// $country = $custo_info->country_id;
		$used_cpn_data = DB::table('tbl_jobcard_details')->where('service_id',$ser_id)->first();
		if(!empty($used_cpn_data))
		{
			$status = $used_cpn_data->done_status;
			$service_id = $used_cpn_data->service_id;
			// $cus_id = $used_cpn_data->customer_id;



			$all_data = DB::table('tbl_service_pros')->where([['service_id',$service_id],['type','=',0]])->get()->toArray();
			$all_data2 = DB::table('tbl_service_pros')->where([['service_id',$service_id],['type','=',1]])->get()->toArray();
		}

		$html = view('service.servicemodel')->with(compact('service_id','custo_info','logo','mob','custo_info','status','vehi_name','regi','city','state','country','all_data','all_data2','used_cpn_data','vhi_no',''))->render();
		return response()->json(['success' => true, 'html' => $html]);
   }
}
