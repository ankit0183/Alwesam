<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Auth;
use URL;
use App\tbl_mail_notifications;
use Mail;
use Illuminate\Mail\Mailer;

class employeecontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	// employee list
   public function employeelist()
   {
	    $userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			$user = DB::table('users')->where('role','=','employee')->orderBy('id','DESC')->get()->toArray();
		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			$user = DB::table('users')->where('role','=','employee')->get()->toArray();
		}
		else
		{
			// $user =DB::table('tbl_services')
										// ->join('users','tbl_services.assign_to','=','users.id')
										// ->where('tbl_services.customer_id','=',Auth::User()->id)
										// ->groupBy("tbl_services.assign_to")
										// ->get();
			$user = DB::table('users')->where('role','=','employee')->get()->toArray();
	    }
		return view('employee.list',compact('user'));
   }

   // employee addform
   public function addemployee()
   {
   		$country = DB::table('tbl_countries')->get()->toArray();
		$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','employee'],['always_visable','=','yes']])->get()->toArray();
	   return view('employee.add',compact('country','tbl_custom_fields'));
   }

   // employee store
   public function store(Request $request)
   {
   	      $this->validate($request, [
			'firstname' => 'required|regex:/^[(a-zA-Z\s)]+$/u',
			'lastname'=>'required|regex:/^[(a-zA-Z\s)]+$/u',
			//'displayname'=>'required|regex:/^[(a-zA-Z\s)]+$/u',
			'designation'=>'required',
			//'email'=>'unique:users',

			//'mobile'=>'required|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
			//'landlineno'=>'max:15|regex:/^[- +()]*[0-9][- +()0-9]*$/',

			// 'join_date'  => 'required|date',
			// 'left_date'  => 'date|after:join_date',
			'image' => 'image|mimes:jpg,png,jpeg',
			'join_date' => 'required',
	      ],[
			'firstname.regex' => 'Enter valid first name',
			'lastname.regex' => 'Enter valid last name',
		]);

		$firstname=Input::get('firstname');
		$email=Input::get('email');
		//$password=Input::get('password');

		if(getDateFormat() == 'm-d-Y')
		{

			$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));

			$join_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('join_date'))));

			$leftdate=Input::get('left_date');

			if($leftdate == '')
			{
				$left_date="";
			}
			else
			{
				$left_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('left_date'))));
			}
		}
		else
		{
			$dob=date('Y-m-d',strtotime(Input::get('dob')));

			$join_date=date('Y-m-d',strtotime(Input::get('join_date')));

			$leftdate=Input::get('left_date');

			if($leftdate == '')
			{
				$left_date="";
			}
			else
			{
				$left_date=date('Y-m-d',strtotime(Input::get('left_date')));
			}

		}
		$user = new User;
		$user->name =$firstname;
		$user->lastname = Input::get('lastname');
		$user->display_name = Input::get('displayname');
		$user->gender = Input::get('gender');
		$user->birth_date =$dob;
		$user->email = $email;
		$user->mobile_no = Input::get('mobile');
		$user->landline_no = Input::get('landlineno');
		$user->address = Input::get('address');
		if(!empty(Input::hasFile('image')))
		{
			$file= Input::file('image');
			$filename=$file->getClientOriginalName();
			$file->move(public_path().'/employee/', $file->getClientOriginalName());
			$user->image = $filename;
		}
		else
		{
			$user->image='avtar.png';
		}

		$user->join_date = $join_date;
		$user->designation = Input::get('designation');
		$user->left_date = $left_date;
		$user->country_id = Input::get('country_id');
		$user->state_id = Input::get('state');
		$user->city_id = Input::get('city');
		$user->role = 'employee';
		$user->timezone="UTC";
		$user->language="en";
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
			$empdata=$val1;
			}
			$user->custom_field = $empdata;
		}
		$user->save();


		return redirect('/employee/list')->with('message','Successfully Submitted');
	}

	// employee edit
	public function edit($id)
	{
		$editid = $id;
		$country = DB::table('tbl_countries')->get()->toArray();
		$state = DB::table('tbl_states')->get()->toArray();
		$city = DB::table('tbl_cities')->get()->toArray();
		$user = DB::table('users')->where('id','=',$id)->first();
		$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','employee'],['always_visable','=','yes']])->get()->toArray();
		return view('employee.edit',compact('country','state','city','user','editid','tbl_custom_fields'));
	}

	// employee update
	public function update($id ,Request $request)
	{
		 $this->validate($request, [
         'firstname' => 'regex:/^[(a-zA-Z\s)]+$/u',
		 'lastname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		// 'displayname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		// 'password'=>'nullable|min:6|max:12|regex:/(^[A-Za-z0-9]+$)+/',
       //  'mobile'=>'required|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
       //  'landlineno'=>'max:15|regex:/^[- +()]*[0-9][- +()0-9]*$/',
		//'password_confirmation' => 'nullable|same:password',
		'designation'=>'required',
		// 'join_date'  => 'required|date',
		 // 'left_date'  => 'date|after:join_date',
		 'image' => 'image|mimes:jpg,png,jpeg',
		 // 'dob' => 'required|date|before:today',
	      ]);

		   $usimgdtaa = DB::table('users')->where('id','=',$id)->first();
			 $email = $usimgdtaa->email;

				if($email != Input::get('email'))
				{
				$this->validate($request, [
					'email' => 'required|email|unique:users'

				]);
				}


		$password =Input::get('password');
		if(getDateFormat()== 'm-d-Y')
	    {
			$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
			$join_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('join_date'))));

			$leftdate=Input::get('left_date');

			if($leftdate == '')
			{
				$left_date="";
			}
			else
			{
				$left_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('left_date'))));
			}
		}
		else
		{
			$dob=date('Y-m-d',strtotime(Input::get('dob')));
			$join_date=date('Y-m-d',strtotime(Input::get('join_date')));

			$leftdate=Input::get('left_date');

			if($leftdate == '')
			{
				$left_date="";
			}
			else
			{
				$left_date=date('Y-m-d',strtotime(Input::get('left_date')));
			}
		}
		$firstname=Input::get('firstname');
		$email=Input::get('email');


		$user = User::find($id);
		$user->name = $firstname;
		$user->lastname = Input::get('lastname');
		$user->display_name = Input::get('displayname');
		$user->gender = Input::get('gender');
		$user->birth_date =$dob;
		$user->email = $email;

		if(!empty($password)){
		$user->password = bcrypt($password);
		}

		$user->mobile_no = Input::get('mobile');
		$user->landline_no = Input::get('landlineno');
		$user->address = Input::get('address');

		if(!empty(Input::hasFile('image')))
		{
			$file= Input::file('image');
			$filename=$file->getClientOriginalName();
			$file->move(public_path().'/employee/', $file->getClientOriginalName());
			$user->image = $filename;
		}


		$user->country_id = Input::get('country_id');
		$user->state_id = Input::get('state');
		$user->city_id = Input::get('city');
		$user->join_date =$join_date;
		$user->designation = Input::get('designation');
		$user->left_date =$left_date;
		$user->role = 'employee';


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
			$empdata=$val1;
			}
			$user->custom_field = $empdata;
		}
		$user->save();

		$logo = DB::table('tbl_settings')->first();
		$systemname=$logo->system_name;
		$emailformats=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
			if($emailformats->is_send == 0)
			{
		if($user->save())
		{
			$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
			$mail_format = $emailformat->notification_text;
			$mail_subjects = $emailformat->subject;
			$mail_send_from = $emailformat->send_from;
			$search1 = array('{ system_name }');
			$replace1 = array($systemname);
			$mail_sub = str_replace($search1, $replace1, $mail_subjects);
			$systemlink = URL::to('/');
			$search = array('{ system_name }','{ user_name }', '{ email }', '{ Password }', '{ system_link }' );
			$replace = array($systemname, $firstname, $email, $password, $systemlink );

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
				$data1 =	Mail::send('customer.customermail',$data, function ($message) use ($data){

							$message->from($data['emailsend'],'noreply');

							$message->to($data['email'])->subject($data['mail_sub1']);

						});
			}
			else
			{
			//live format email

				$headers = 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
				$headers .= 'From:'. $mail_send_from . "\r\n";

				$data = mail($email,$mail_sub,$email_content,$headers);
			}


		}
			}
		return redirect('/employee/list')->with('message','Successfully Updated');
	}

	// employee show
	public function showemployer($id)
	{
		$viewid = $id;
		$user = DB::table('users')->where('id','=',$id)->first();

		$tbl_custom_fields=DB::table('tbl_custom_fields')->where([['form_name','=','employee'],['always_visable','=','yes']])->get()->toArray();

		$emp_free_service=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
									->where('tbl_services.assign_to','=',$id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();

		$emp_paid_service=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.assign_to','=',$id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();

		$emp_repeatjob=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
									->where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.assign_to','=',$id)
								   ->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();

		return view('employee.show',compact('user','viewid','emp_free_service','emp_paid_service','emp_repeatjob','tbl_custom_fields'));
	}

	// employee delete
	public function destory($id)
	{
        $user=DB::table('users')->where('id','=',$id)->delete();
        $tbl_sales=DB::table('tbl_sales')->where('assigne_to','=',$id)->delete();
        $tbl_services=DB::table('tbl_services')->where('assign_to','=',$id)->delete();

        return redirect('employee/list')->with('message','Successfully Deleted');
	}

	// employee free service
	public function free_service()
	{
		$serviceid=Input::get('emp_free');

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

		$html = view('employee.freeservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}

	// employee paid service
	public function paid_service()
	{
		$serviceid=Input::get('emp_paid');

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
			$service_taxes='';
		}

		$discount = $service_tax->discount;
		$logo = DB::table('tbl_settings')->first();

		$html = view('employee.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);


	}

	// employee repeat service
	public function repeat_service()
	{
		$serviceid=Input::get('emp_repeat');
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
			$service_taxes='';
		}

		$discount = $service_tax->discount;

		$logo = DB::table('tbl_settings')->first();

		$html = view('employee.repeatservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);


	}
}
