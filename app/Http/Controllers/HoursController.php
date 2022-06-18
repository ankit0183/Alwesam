<?php

namespace App\Http\Controllers;
use App\User;
use App\tbl_business_hours;
use App\tbl_holidays;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use File;

class HoursController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	// businesshours list
    public function index()
	{	
		$tbl_holidays =DB::table('tbl_holidays')->ORDERBY('date','ASC')->get()->toArray();
		$tbl_hours=DB::table('tbl_business_hours')->ORDERBY('day','ASC')->get()->toArray();
		return view('Businesshours.list',compact('tbl_holidays','tbl_hours')); 
	}
	
	// businesshours store
	public function hours(Request $request)
	{	 
		$day=Input::get('day');
		$start=Input::get('start');
		$to=Input::get('to');
		$tbl_business_hours=DB::table('tbl_business_hours')->where('day','=',$day)->count();
		
		if($start <= $to)
		{
			if($tbl_business_hours == 0)
			{
				
				$tbl_business_hours = new tbl_business_hours;
				$tbl_business_hours->day =$day;
				$tbl_business_hours->from =$start;
				$tbl_business_hours->to =$to;
				$tbl_business_hours->save(); 
				
				return redirect('/setting/hours/list')->with('message','Successfully Submitted');	
			}
			else
			{
				$business_hours=DB::table('tbl_business_hours')->where('day','=',$day)->first(); 
				$id=$business_hours->id;
				$tbl_business_hours =tbl_business_hours::find($id);
				$tbl_business_hours->day =$day;
				$tbl_business_hours->from =$start;
				$tbl_business_hours->to =$to;
				$tbl_business_hours->save(); 
				
				return redirect('/setting/hours/list')->with('message','Successfully Updated');	
			}
		}
        else
		{
			return redirect('/setting/hours/list')->with('message1','Please select time which is greater than start time');	
		}		
		
	}
	
	// holiday store
	public function holiday()
	{
		if(getDateFormat()== 'm-d-Y')
		{
			$date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('adddate'))));
			$count=DB::table('tbl_holidays')->where('date','=',$date)->count();
			$adddate=date('Y-m-d',strtotime(str_replace('-','/',Input::get('adddate'))));
		}
		else
		{
			$date=date('Y-m-d',strtotime(Input::get('adddate')));
			$count=DB::table('tbl_holidays')->where('date','=',$date)->count();
			$adddate=date('Y-m-d',strtotime(Input::get('adddate')));
		}
		$addtitle=Input::get('addtitle');
		$adddescription=Input::get('adddescription');
		if($count == 0)
		{
		$tbl_business_hours= new tbl_holidays;
		$tbl_business_hours->title=$addtitle;
		$tbl_business_hours->date=$adddate;
		$tbl_business_hours->description=$adddescription;
		$tbl_business_hours->save();
		return redirect('/setting/hours/list')->with('message','Successfully Submitted');
		}
		else
		{
			return redirect('/setting/hours/list')->with('message1','Date is already inserted');
		}		
	}
	
	// holiday delete
	public function deleteholiday($id)
	{
		$tbl_holidays=DB::table('tbl_holidays')->where('id','=',$id)->delete();
		return redirect('/setting/hours/list')->with('message','Successfully Deleted');
	}
	
	// business hours store
	public function deletehours($id)
	{
		
		$tbl_business_hours=DB::table('tbl_business_hours')->where('id','=',$id)->delete();
		return redirect('/setting/hours/list')->with('message','Successfully Deleted');
	}
}	