<?php

namespace App\Http\Controllers;
use App\User;
use App\tbl_settings;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;

class Timezonecontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//timezone list
    public function index()
	{	
		$user = DB::table('users')->where('id','=',Auth::user()->id)->first();
		$currancy=DB::table('tbl_currency_records')->get()->toArray();
		$currencies=DB::table('currencies')->get()->toArray();
		
		$tbl_settings=DB::table('tbl_settings')->first();		
		return view('timezone.list',compact('user','currancy','tbl_settings','currencies')); 
	}
	
	//timezone store
	// public function store()
	// {	
		// $time= Input::get('timezone');	
		// $id = Auth::user()->id;	
		// $users = DB::table('users')->where('id','=',$id)->first();
		// DB::update("update users set timezone='$time' where id=$id");
		// return redirect('/setting/timezone/list')->with('message','Successfully Updated');		
	// }
	
	//date store
	// public function datestore()
	// {	
		// $date=Input::get('dateformat');
		// $dateformat=DB::table('tbl_settings')->first();
		// $first=$dateformat->id;
		// DB::update("update tbl_settings set date_format='$date' where id=$first");
		// return redirect('/setting/timezone/list')->with('message','Successfully Updated');
	// }
	
	//currency store
	public function currancy()
	{	
	
		$time= Input::get('timezone');	
		$id = Auth::user()->id;	
		$users = DB::table('users')->where('id','=',$id)->first();
		DB::update("update users set timezone='$time' where id=$id");
		
		$lang= Input::get('language');
		
		$id = Auth::user()->id;
		$users = DB::table('users')->where('id','=',$id)->first();
		$language = $users->language;
		DB::update("update users set language='$lang' where id=$id");
		
		if($lang == 'ar')
		{
			$id = Auth::user()->id;
			
			
			DB::update("update users set gst_no='rtl' where id=$id");
		}
		else
		{	
			$id = Auth::user()->id;
			DB::update("update users set gst_no='ltr' where id=$id");
		}
		
		$date=Input::get('dateformat');
		if(!empty($date))
		{
		$dateformat=DB::table('tbl_settings')->first();
		$first=$dateformat->id;
		DB::update("update tbl_settings set date_format='$date' where id=$first");
		}
		$Currency=Input::get('Currency');	
		if(!empty($Currency))
		{
		$Currencyformat=DB::table('tbl_settings')->first();
		$id=$Currencyformat->id;
		DB::update("update tbl_settings set currancy='$Currency' where id=$id");
		}
		return redirect('/setting/timezone/list')->with('message','Successfully Updated');
	}
}	
