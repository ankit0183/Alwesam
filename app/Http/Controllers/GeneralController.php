<?php

namespace App\Http\Controllers;
use App\User;
use App\tbl_settings;
use App\tbl_business_hours;
use App\tbl_holidays;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use File;

class GeneralController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//general settings form
    public function index()
	{		
		$settings_data = DB::table('tbl_settings')->first();
		$country = DB::table('tbl_countries')->get()->toArray();
		$state = DB::table('tbl_states')->get()->toArray();
		$city = DB::table('tbl_cities')->get()->toArray();
		
		return view('general_setting.list',compact('settings_data','country','state','city')); 
	}
	
	//general settings store
	public function store(Request $request)
	{
		$this->validate($request, [
        'System_Name' => 'regex:/^[(a-zA-Z\s)]+$/u',
        'Phone_Number' => 'required|max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
        'Email' => 'email',
        'Paypal_Id' => 'email',
		'Logo_Image' => 'image|mimes:jpg,png,jpeg',
        'Cover_Image' => 'image|mimes:jpg,png,jpeg',
		]);
		
		$settings_data = DB::table('tbl_settings')->first();
		
		$logo = $settings_data->logo_image;
		$cover = $settings_data->cover_image;
		
		$sys_name = Input::get('System_Name');
		$strt_year = Input::get('start_year');
		$ph_no = Input::get('Phone_Number');
		$email = Input::get('Email');
		$coutry = Input::get('country_id');
		$state = Input::get('state_id');
		$city = Input::get('city');
		$paypal_id = Input::get('Paypal_Id');
		$address = Input::get('address');
		
		$data = tbl_settings::find(1);
		$data->address = $address;
		$data->system_name = $sys_name;
		$data->starting_year = $strt_year;
		$data->phone_number = $ph_no;
		$data->email = $email;
		$data->city_id = $city;
		$data->state_id = $state;
		$data->country_id = $coutry;
		if(Input::hasFile('Logo_Image'))
		
			{
				
				$file = Input::file('Logo_Image');
				
				$extension =$file->getClientOriginalExtension();
				$filename=str_random(15).'.'.$extension; 
				$file->move(public_path().'/general_setting/', $filename);
				$data->logo_image = $filename;
			}
		
		
		if(Input::hasFile('Cover_Image'))
		{
			
             $file2 = Input::file('Cover_Image');
             $extension1 =$file2->getClientOriginalExtension();
			 $filename1=str_random(15).'.'.$extension1; 
             $file2->move(public_path() . '/general_setting/', $filename1);
             $data->cover_image = $filename1;
		}
		
		 $data->paypal_id = $paypal_id;
		 
		 $data->save();
									
		return redirect('/setting/general_setting/list')->with('message','Successfully Updated');	
	}

}	
