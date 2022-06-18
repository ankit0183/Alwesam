<?php

namespace App\Http\Controllers;

use DB;
use URL;
use Auth;
use Mail;
use App\User;
use App\tbl_sales;
use App\tbl_colors;
use App\tbl_services;
use App\tbl_vehicles;
use App\Http\Requests;
use App\tbl_rto_taxes;
use App\tbl_sales_taxes;
//use Illuminate\Mail\Mailer;
use Illuminate\Http\Request;
//use App\tbl_mail_notifications;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class Customercontroller extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

	//customer addform
	public function customeradd()
	{
		$country = DB::table('tbl_countries')->get()->toArray();
		$onlycustomer=DB::table('users')->where([['role','=','Customer'],['id','=',Auth::User()->id]])->first();
		$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','customer'],['always_visable','=','yes']])->get()->toArray();
	   return view('customer.add',compact('country','onlycustomer','tbl_custom_fields'));
	}
	//customer store
	public function storecustomer(Request $request)
	{
		 $this->validate($request, [
         'firstname' => 'regex:/^[(a-zA-Z\s)]+$/u',
		 'lastname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		// 'displayname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		 'mobile'=>'required|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
        // 'landlineno'=>'max:15|regex:/^[- +()]*[0-9][- +()0-9]*$/',
		 'image' => 'image|mimes:jpg,png,jpeg',
		//  'password'=>'|min:6',
		//  'password_confirmation' => '|same:password',
		 ],[
			// 'displayname.regex' => 'Enter valid display name',
			 'firstname.regex' => 'Enter valid first name',
			 'lastname.regex' => 'Enter valid last name',
			// 'landlineno.regex' => 'Enter valid landline no',
		 ]);

		$firstname=Input::get('firstname');
		$lastname=Input::get('lastname');
		$displayname=Input::get('displayname');
		$password=Input::get('password');
		$gender=Input::get('gender');
		$birthdate= Input::get('dob');
		if(!empty($birthdate))
		{
			if(getDateFormat() == 'm-d-Y')
			{
				$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
			}
			else
			{
				$dob=date('Y-m-d',strtotime(Input::get('dob')));
			}
		}else{
			$dob = null;
		}

		$email=Input::get('email');
		if(!empty($email))
		{
			$email = $email;
		}else{
			$email =null;
		}

		$mobile=Input::get('mobile');
		$landlineno=Input::get('landlineno');
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
			$customer->landline_no=$landlineno;
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
			//custom field
			$custom=Input::get('custom');
			$custom_fileld_value=array();
			$custom_fileld_value_jason_array=array();
			if(!empty($custom))
			{
				foreach($custom as $key=>$value)
				{
				$custom_fileld_value[]=array("id" => "$key", "value" => "$value");
				}

				$custom_fileld_value_jason_array['custom_fileld_value']=json_encode($custom_fileld_value);

				foreach($custom_fileld_value_jason_array as $key1=>$val1)
				{
				$customerdata=$val1;
				}
				$customer->custom_field = $customerdata;
			}
			$customer -> save();
			if(!is_null($email ))
			{
				//email format
			}

		    return redirect('/customer/list')->with('message','Successfully Submitted');
	}

	//customer list
	public function index()
	{
		$userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			$customer=DB::table('users')->where('role','=','Customer')->orderBy('id','DESC')->get()->toArray();


		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			// $customer =DB::table('tbl_services')
										// ->join('users','tbl_services.customer_id','=','users.id')
										// ->where([['tbl_services.assign_to','=',Auth::User()->id],['done_status','=',1]])
										// ->groupBy("tbl_services.customer_id")
										// ->get();
			$customer=DB::table('users')->where('role','=','Customer')->orderBy('id','DESC')->get()->toArray();

		}
		else
		{
			$customer=DB::table('users')->where([['role','=','Customer'],['id','=',Auth::User()->id]])->orderBy('id','DESC')->get()->toArray();
	    }
		return view('customer.list',compact('customer','onlycustomer'));
	}

	//customer show
	public function customershow($id)
	{
		$userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			$viewid = $id;
			$customer=DB::table('users')->where('id','=',$id)->first();

			$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','customer'],['always_visable','=','yes']])->get()->toArray();

			$freeservice=DB::table('tbl_services')
										// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
										// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
										->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
										->where('tbl_services.customer_id','=',$id)
										->orderBy('tbl_services.id','=','desc')->take(5)
										->select('tbl_services.*')
										->get()->toArray();
			$paidservice=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.customer_id','=',$id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();

			$repeatjob=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
									->where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.customer_id','=',$id)
								   ->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();
		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			$viewid = $id;
			$customer=DB::table('users')->where('id','=',$id)->first();


			$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','customer'],['always_visable','=','yes']])->get()->toArray();

			$freeservice=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
									->where('tbl_services.assign_to','=',$userid)
									->where('tbl_services.customer_id','=',$id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();

			$paidservice=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.assign_to','=',$userid)
									->where('tbl_services.customer_id','=',$id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();

			$repeatjob=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
									->where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.assign_to','=',$userid)
									->where('tbl_services.customer_id','=',$id)
								   ->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();
		}
		else
		{
			$viewid = $id;
			$customer=DB::table('users')->where('id','=',$id)->first();

			$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','customer'],['always_visable','=','yes']])->get()->toArray();

			$freeservice=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
									->where('tbl_services.customer_id','=',$id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();

			$paidservice=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.customer_id','=',$id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();

			$repeatjob=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
									->where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.customer_id','=',$id)
								   ->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();
		}
		return view('customer.view',compact('customer','viewid','freeservice','paidservice','repeatjob','tbl_custom_fields'));
	}

	// free service modal
	public function free_open_model()
	{
		$serviceid=Input::get('f_serviceid');

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
												  ->get()->toArray();

		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();

		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();

		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes = '';
		}
		$discount = $service_tax->discount;

		$logo = DB::table('tbl_settings')->first();

		$html = view('customer.freeservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}

	// paid service modal
	public function paid_open_model()
	{
		$serviceid=Input::get('p_serviceid');

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

		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();

		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes = '';
		}

		$discount = $service_tax->discount;
		$logo = DB::table('tbl_settings')->first();

		$html = view('customer.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}

	// repeat service modal
	public function repeat_job_model()
	{
		$serviceid=Input::get('r_service');
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
												  ->get()->toArray();

		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();

		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();

		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes = '';
		}

		$discount = $service_tax->discount;

		$logo = DB::table('tbl_settings')->first();

		$html = view('customer.repeatservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);

	}

	// customer delete
    public function destory($id)
	 {

		$customer = DB::table('users')->where('id','=',$id)->delete();
		$tbl_incomes = DB::table('tbl_incomes')->where('customer_id','=',$id)->delete();
		$tbl_invoices = DB::table('tbl_invoices')->where('customer_id','=',$id)->delete();
		$tbl_jobcard_details = DB::table('tbl_jobcard_details')->where('customer_id','=',$id)->delete();
		$tbl_gatepasses = DB::table('tbl_gatepasses')->where('customer_id','=',$id)->delete();
		$tbl_sales = DB::table('tbl_sales')->where('customer_id','=',$id)->delete();
		$tbl_services = DB::table('tbl_services')->where('customer_id','=',$id)->delete();

		return redirect('/customer/list')->with('message','Successfully Deleted');
	 }

	 // customer edit
     public function customeredit($id)
	 {
	    $editid=$id;
		$country = DB::table('tbl_countries')->get()->toArray();
		$state = DB::table('tbl_states')->get()->toArray();
		$city = DB::table('tbl_cities')->get()->toArray();
		$customer=DB::table('users')->where('id','=',$id)->first();
		$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','customer'],['always_visable','=','yes']])->get()->toArray();

		 return view('customer.update',compact('country','customer','state','city','editid','tbl_custom_fields'));
	 }

	// customer update
    public function customerupdate($id, Request $request)
	{
		  $this->validate($request, [
         'firstname' => 'regex:/^[(a-zA-Z\s)]+$/u',
		 'lastname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		// 'displayname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		 'mobile'=>'required|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
        // 'landlineno'=>'max:15|regex:/^[- +()]*[0-9][- +()0-9]*$/',
		 'image' => 'image|mimes:jpg,png,jpeg',
		// 'password'=>'|min:6',
		// 'password_confirmation' => '|same:password',

	      ],[
			//'displayname.regex' => 'Enter valid display name',
			'firstname.regex' => 'Enter valid first name',
			'lastname.regex' => 'Enter valid last name',
		//	'landlineno.regex' => 'Enter valid landline no',
		]);

		   $usimgdtaa = DB::table('users')->where('id','=',$id)->first();
			 $email = $usimgdtaa->email;
				if(!empty($email))
				{
					if($email != Input::get('email'))
					{
					$this->validate($request, [
						'email' => 'email'

					]);
					}
				}


		$firstname=Input::get('firstname');
		$lastname=Input::get('lastname');
		$displayname=Input::get('displayname');
		$gender=Input::get('gender');
		if(!empty(Input::get('dob')))
		{
			if(getDateFormat() == 'm-d-Y')
			{
				$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
			}
			else
			{
				$dob=date('Y-m-d',strtotime(Input::get('dob')));
			}
		}else{
			$dob=null;
		}

		$email=Input::get('email');
		$password =Input::get('password');
		$mobile=Input::get('mobile');
		$landlineno=Input::get('landlineno');
		$address=Input::get('address');
		$country=Input::get('country_id');
		$state=Input::get('state_id');
		$city=Input::get('city');

		$customer = User::find($id);

		$customer->name=$firstname;
		$customer->lastname=$lastname;
		$customer->display_name=$displayname;
		$customer->gender=$gender;
		$customer->birth_date=$dob;


		$customer->email=$email;

		if(!empty($password)){
		$customer->password=bcrypt($password);
		}

		$customer->mobile_no=$mobile;
		$customer->landline_no=$landlineno;
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


		$customer->role="Customer";

		//custom field
		$custom=Input::get('custom');
		$custom_fileld_value=array();
		$custom_fileld_value_jason_array=array();
		if(!empty($custom))
		{
			foreach($custom as $key=>$value)
			{
			$custom_fileld_value[]=array("id" => "$key", "value" => "$value");
			}

			$custom_fileld_value_jason_array['custom_fileld_value']=json_encode($custom_fileld_value);

			foreach($custom_fileld_value_jason_array as $key1=>$val1)
			{
			$customerdata=$val1;
			}
			$customer->custom_field = $customerdata;
		}
		$customer -> save();

		// if(!empty($email))
		// {
		// 	//email format
		// 	$logo = DB::table('tbl_settings')->first();
		// 	$systemname=$logo->system_name;
		// 	$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
		// 	if($emailformats->is_send == 0)
		// 	{
		// 		if($customer -> save())
		// 		{
		// 			$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
		// 			$mail_format = $emailformat->notification_text;
		// 			$mail_subjects = $emailformat->subject;
		// 			$mail_send_from = $emailformat->send_from;
		// 			$search1 = array('{ system_name }');
		// 			$replace1 = array($systemname);
		// 			$mail_sub = str_replace($search1, $replace1, $mail_subjects);

		// 			 $systemlink = URL::to('/');

		// 			$search = array('{ system_name }','{ user_name }', '{ email }', '{ Password }', '{ system_link }' );
		// 			$replace = array($systemname, $firstname, $email, $password, $systemlink);

		// 			$email_content = str_replace($search, $replace, $mail_format);


		// 			$actual_link = $_SERVER['HTTP_HOST'];
		// 			$startip='0.0.0.0';
		// 			$endip='255.255.255.255';
		// 			if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
		// 			{
		// 				//local format email

		// 				$data=array(
		// 				'email'=>$email,
		// 				'mail_sub1' => $mail_sub,
		// 				'email_content1' => $email_content,
		// 				'emailsend' =>$mail_send_from,
		// 				);
		// 						$data1 = Mail::send('customer.customermail',$data, function ($message) use ($data){

		// 						$message->from($data['emailsend'],'noreply');

		// 						$message->to($data['email'])->subject($data['mail_sub1']);

		// 					});
		// 			}
		// 			else
		// 			{
		// 					//Live format email
		// 				$headers = 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
		// 				$headers .= 'From:'. $mail_send_from . "\r\n";
		// 				mail($email,$mail_sub,$email_content,$headers);
		// 			}
		// 		}
		// 	}
		// }


		return redirect('/customer/list')->with('message','Successfully Updated');
	}
}
