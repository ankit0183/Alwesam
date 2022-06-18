<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_vehicle_types;
use App\tbl_vehicle_brands;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class VehicalbransControler extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	// vehiclebrand add form
	public function index()
	{   
		$vehicaltypes=DB::table('tbl_vehicle_types')->get()->toArray();
        return view('vehiclebrand.add',compact('vehicaltypes'));    
	}
    
	// vehiclebrand list
    public function listvehicalbrand()
    {
		$vehicalbrand=DB::table('tbl_vehicle_brands')->orderBy('id','DESC')->get()->toArray();
     	return view('vehiclebrand.list',compact('vehicalbrand'));
    }
     
	// vehiclebrand store
    public function store()
    {
		$vehiacal_id=Input::get('vehicaltypes');
      	$vehical_brand=Input::get('vehicalbrand');
        $count = DB::table('tbl_vehicle_brands')->where([['vehicle_id','=',$vehiacal_id],['vehicle_brand','=',$vehical_brand]])->count();
		if ($count==0)
		{
			$vehicalbrands = new tbl_vehicle_brands;
			$vehicalbrands->vehicle_id=$vehiacal_id;
			$vehicalbrands->vehicle_brand=$vehical_brand;
			$vehicalbrands->save();
			return redirect('vehiclebrand/list')->with('message','Successfully Submitted');
        }
       else
        {
			return redirect('vehiclebrand/add')->with('message','Duplicate Data');
        }
    }
	 
	// vehiclebrand delete
	public function destory($id)
	{
	  	$vehicalbrands = DB::table('tbl_vehicle_brands')->where('id','=',$id)->delete();
	  	// $tbl_vehicles = DB::table('tbl_vehicles')->where('vehiclebrand_id','=',$id)->delete();
	  	return redirect('vehiclebrand/list')->with('message','Successfully Deleted');
	}

	 // vehiclebrand edit form
	public function editbrand($id)
	{
		$editid=$id;
	  	$vehicaltypes=DB::table('tbl_vehicle_types')->get()->toArray();
	  	$vehicalbrands=DB::table('tbl_vehicle_brands')->where('id','=',$id)->first();
	  	return view('vehiclebrand/edit',compact('vehicalbrands','vehicaltypes','editid'));
	}

	// vehiclebrand update
	public function brandupdate($id)
	{
	 	$vehiacal_id=Input::get('vehicaltypes');
      	$vehical_brand=Input::get('vehicalbrand');
        $count = DB::table('tbl_vehicle_brands')->where([['vehicle_id','=',$vehiacal_id],['vehicle_brand','=',$vehical_brand],['id','!=',$id]])->count();
		if ($count==0)
		{
			$vehicalbrands =tbl_vehicle_brands::find($id);
			$vehicalbrands->vehicle_id=$vehiacal_id;
			$vehicalbrands->vehicle_brand=$vehical_brand;
			$vehicalbrands->save();
			return redirect('vehiclebrand/list')->with('message','Successfully Updated');
        }
        else
        {    
        	 return redirect('vehiclebrand/list/edit/'.$id)->with('message','Duplicate Data');
        }     
	 }
}