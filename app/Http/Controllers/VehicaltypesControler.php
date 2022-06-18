<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\tbl_vehicle_types;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class VehicaltypesControler extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//  get tables and compact
	public function index()
	{   
        return view('vehicletype.add');    
	}

	//store vehicaltypes
	public function storevehicaltypes()
	{
	 	$vehicaltype = Input::get('vehicaltype');
		$count = DB::table('tbl_vehicle_types')->where('vehicle_type','=',$vehicaltype)->count();
		if ($count==0)
		{
			$vehicaltypes= new tbl_vehicle_types;
			$vehicaltypes->vehicle_type = $vehicaltype;
			$vehicaltypes -> save();
			return redirect('/vehicletype/list')->with('message','Successfully Submitted');
	 	}
	 	else
		{
			 
	 	 	return redirect('/vehicletype/vehicletypeadd')->with('message','Duplicate data');
	 	} 	 
	}

	//vehicaltype list
	public function vehicaltypelist()
	{
        $vehicaltypes= DB::table('tbl_vehicle_types')->orderBy('id','DESC')->get()->toArray();
	 	return view('vehicletype.list',compact('vehicaltypes'));
	}

	//vehicaltype delete
	public function destory($id)
	{
        $vehicaltypes = DB::table('tbl_vehicle_types')->where('id','=',$id)->delete();
		// $tbl_vehicles = DB::table('tbl_vehicles')->where('vehicletype_id','=',$id)->delete();
		$tbl_vehicles = DB::table('tbl_vehicle_brands')->where('vehicle_id','=',$id)->delete();
		
        return redirect('/vehicletype/list')->with('message','Successfully Deleted');
	}

	//vehicaltype edit form
	public function editvehicaltype($id)
	{
        $editid=$id;
        $vehicaltypes = DB::table('tbl_vehicle_types')->where('id','=',$id)->first();
		return view('/vehicletype/edit',compact('vehicaltypes','editid'));
	}

	//vehicaltype update
	public function updatevehicaltype($id)
	{
		$vehicaltypes1=Input::get('vehicaltype');
	 	$count = DB::table('tbl_vehicle_types')->where([['vehicle_type','=',$vehicaltypes1],['id','!=',$id]])->count();
		if ($count==0)
		{
			$vehicaltypes= tbl_vehicle_types::find($id);
			$vehicaltypes->vehicle_type=$vehicaltypes1;
			$vehicaltypes->save();
			return redirect('vehicletype/list')->with('message','Successfully Updated');
	   }
	   else
	   {
			return redirect('vehicletype/list/edit/'.$id)->with('message','Duplicate Data');;
	   }
	 }
}