<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\tbl_products;
use App\tbl_sales;
use App\tbl_services;
use App\tbl_jobcard_details;
use App\tbl_vehicles;
use App\tbl_business_hours;
use App\Http\Requests;
use DB;
use Auth;
use Mail;
//use Illuminate\Mail\Mailer;
//use App\tbl_mail_notifications;
use DateTime;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Config;

class homecontroller extends Controller
{
   
    public function __construct()
    {
        $this->middleware('auth');
    }
   
   
    public function dashboard()
    {
		
		$set_email_send = Session::get('email_sended');
		
		//timezone in run
		$users = DB::table('users')->where('id','=',Auth::user()->id)->first();
		$timezone=$users->timezone;
		
		config(['app.timezone' => $timezone]);
		$currentfirstdate = new Carbon('first day of this month');
		$currentlastdate = new Carbon('last day of this month');
		
		$startdate = new Carbon('first day of next month');
		$lastdate = new Carbon('last day of next month');
		
		$nowmonthdate=$startdate->format('Y-m-d');
		$nowmonthdate1=$lastdate->format('Y-m-d');
		$nowdate=date('Y-m-d');
		$m1=$startdate->format('M');
		$y1=$startdate->format('Y');
		
		$laststart = new Carbon('first day of last month');
		$lastend = new Carbon('last day of last month');
		$laststart1=$laststart->format('Y-m-d');
		$lastend1=$lastend->format('Y-m-d');
		$m=$laststart->format('m');
		$y=$laststart->format('Y');
		
		
		$admin=DB::table('users')->where('role','=','admin')->first();
		$firstname=$admin->name;
		$email=$admin->email;
		$monthservice= DB::select("SELECT * FROM tbl_services where (done_status=1) and (service_date BETWEEN '" . $laststart1 . "' AND  '" . $lastend1 . "')");
		
		
		
		
		$logo = DB::table('tbl_settings')->first();
		$systemname=$logo->system_name;
		//Email notification for last monthly service for admin
		
		
		
		
			
		
		
		//Monthly  service barchart
		$nowmonth = date('F-Y');
		$start = new Carbon('first day of this month');
		$end = new Carbon('last day of this month');
		
		 $dates = [];
        for($date = $start; $date->lte($end); $date->addDay())
		{
			$dates[] = $date->format('d');
	    }
		
		$month = date('m');
		$year = date('Y');
		$start_date = "$year/$month/01";
        $end_date = "$year/$month/30";
		
		//top five vehicle service
		$vehical= DB::select("SELECT count(id) as count,`vehicle_id` as vid FROM tbl_services where (done_status=1) and (service_date BETWEEN '" . $start_date . "' AND  '" . $end_date . "') group by `vehicle_id` limit 5");
		
		//top five employee performance
		$performance= DB::select("SELECT count(id) as count,`assign_to` as a_id FROM tbl_services where (done_status=1) and (service_date BETWEEN '" . $start_date . "' AND  '" . $end_date . "') group by `assign_to` limit 5");
		
		// ontime service 
		$datediff = DB::select("SELECT DATEDIFF(tbl_gatepasses.service_out_date,tbl_services.service_date) as days,COUNT(tbl_services.job_no) as counts FROM `tbl_services` join tbl_gatepasses on tbl_services.job_no=tbl_gatepasses.jobcard_id where tbl_services.done_status=1 and (tbl_services.service_date BETWEEN '" . $start_date . "' AND  '" . $end_date . "') and (tbl_gatepasses.service_out_date BETWEEN '" . $start_date . "' AND  '" . $end_date . "')GROUP BY days ");
		
		if(!empty($datediff))
		{
			foreach($datediff as $datediffs)
			{
			$days = $datediffs->days;
			if($days == 0)
			{
				$one_day = $datediffs->counts;
				
			}
			if($days == 1)
			{
				$two_day = $datediffs->counts;
			
			}
			if($days >1)
			{
				$more = $datediffs->counts;
			
			}
			}
			
		}
		
		$userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			
			 //count employee,customer,supplier,product,sales,service
			$employee =DB::table('users')->where('role','=','employee')->count();
			$Customer =DB::table('users')->where('role','=','Customer')->count();
			$Supplier =DB::table('users')->where('role','=','Supplier')->count();
			$product =DB::table('tbl_products')->count();
			$sales =DB::table('tbl_sales')->count();
			$service =DB::table('tbl_services')->where('job_no','like','J%')->count();

			//free service
			$sale=DB::table('tbl_services')
										// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
										// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
										->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])->orderBy('tbl_services.id','=','desc')->take(5)
										->select('tbl_services.*')
										->get()->toArray();
			//Paid service						
			$sale1=DB::table('tbl_services')
										// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
										// ->join('tbl_vehicles', 'tbl_vehicles.id', '=', 'tbl_services.vehicle_id')
										// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
										->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])->orderBy('tbl_services.id','=','desc')->take(5)
										->select('tbl_services.*')
										->get()->toArray();
			//Repeat job service
			$sale2=DB::table('tbl_services')
										// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
										// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
										->where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									   ->orderBy('tbl_services.id','=','desc')->take(5)
										->select('tbl_services.*')
										->get()->toArray();
			//Recent join customer
			$Customere =DB::table('users')->where('role','=','Customer')->orderBy('id','=','desc')->take(5)->get()->toArray();
			
			//Calendar Events 
			$serviceevent=DB::table('tbl_services')->where('tbl_services.done_status','!=',2)->get()->toArray();
			
			//holiday show Calendar
			$holiday =DB::table('tbl_holidays')->ORDERBY('date','ASC')->get()->toArray();
		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			
			//free service
			$sale=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
									->where('tbl_services.assign_to','=',Auth::User()->id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();
			
			$sale1=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.assign_to','=',Auth::User()->id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();
		   
			
			$sale2=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
									->where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.assign_to','=',Auth::User()->id)
								   ->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();	
					
			//Recently Joined customer
			$Customere =DB::table('users')
										->join('tbl_services','users.id','=','tbl_services.customer_id')
										->where([['tbl_services.assign_to','=',Auth::User()->id],['tbl_services.done_status','!=',2]])
										->orderBy('tbl_services.assign_to','=','desc')
										->groupBy("tbl_services.customer_id")
										->take(5)->get()->toArray();
            
			//Calendar Events 
			$serviceevent=DB::table('tbl_services')->where([['done_status','!=',2],['assign_to','=',Auth::User()->id]])->get()->toArray();
			
			//opening hours
			$openinghours =DB::table('tbl_business_hours')->ORDERBY('day','ASC')->get()->toArray();
			
			//holiday
			$holiday =DB::table('tbl_holidays')->ORDERBY('date','ASC')->get()->toArray();
			
			//upcoming service
			$nowdate=date('Y-m-d');
			$upcomingservice=DB::table('tbl_services')->where([['assign_to','=',Auth::User()->id],['job_no','like','C%'],['service_date','>',$nowdate]])->take(5)->get()->toArray();
			
		}
		else
		{
			$sale=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','free']])
									->where('tbl_services.customer_id','=',Auth::User()->id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();
			
			$sale1=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
		                            ->where([['tbl_services.done_status','!=',2],['tbl_services.service_type','=','paid']])
									->where('tbl_services.customer_id','=',Auth::User()->id)
									->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();
		
			$sale2=DB::table('tbl_services')
									// ->join('tbl_sales', 'tbl_sales.vehicle_id', '=', 'tbl_services.vehicle_id')
									// ->join('tbl_invoices','tbl_services.id','=','tbl_invoices.sales_service_id')
									->where([['tbl_services.done_status','!=',2],['tbl_services.service_category','=','repeat job']])
									->where('tbl_services.customer_id','=',Auth::User()->id)
								   ->orderBy('tbl_services.id','=','desc')->take(5)
									->select('tbl_services.*')
									->get()->toArray();	
					
			//Calendar Events 
			$serviceevent=DB::table('tbl_services')->where([['done_status','!=',2],['customer_id','=',Auth::User()->id]])->get()->toArray();
			
			//opening hours
			$openinghours =DB::table('tbl_business_hours')->ORDERBY('day','ASC')->get()->toArray();
			//holiday
			$holiday =DB::table('tbl_holidays')->ORDERBY('date','ASC')->get()->toArray();
			//upcoming service
			$nowdate=date('Y-m-d');
			$upcomingservice=DB::table('tbl_services')->where([['customer_id','=',Auth::User()->id],['job_no','like','C%'],['service_date','>',$nowdate]])->take(5)->get();
		}
	
		

         return view('dashboard.dashboard',compact('employee','Customer','Supplier','product','sales','service','Customere','c_service','up_servic','sale','sale1','sale2','customersale','customersale1','customersale2','service_month','dates','data','week_numbers','vehical','performance','Monsales','Tuesales','Wedsales','Thusales','Frisales','Satsales','serviceevent','ontimeservice','ontimeservice48after','ontimeservice48','ontimeservice24','hourdiff','ontimeservice1','one_day','two_day','more','nowmonth','openinghours','holiday','upcomingservice'));
		 
    }

	//free service modal
    public function openmodel()
    {
		$serviceid = Input::get('open_id');
		
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
		
		$html = view('dashboard.freeservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);
		
	}

	//paid service modal
    public function closemodel()
    {
		$serviceid = Input::get('open_id');
		
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
			$service_taxes="";
		}
		$discount = $service_tax->discount;
		$logo = DB::table('tbl_settings')->first();
		
		
		$html = view('dashboard.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','service_taxes','discount'))->render();
		return response()->json(['success' => true, 'html' => $html]);
		
	}
	
	//repeat service modal
    public function upmodel()
    {
		$serviceid = Input::get('open_id');
		
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
			$service_taxes="";
		}
		$discount = $service_tax->discount;
		
		$logo = DB::table('tbl_settings')->first();
		
		
		$html = view('dashboard.paidservice')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','discount','service_taxes'))->render();
		return response()->json(['success' => true, 'html' => $html]);
		
	}	
}
