<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_vehicals;
use App\tbl_vehicle_discription_records;
use App\Http\Requests;
use DB;
use Illuminate\Support\facades\Input;

class VehicalDiscriptionsControler extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//vehicaldiscriptions add form
	public function index()
	{   
		$vehicalname=DB::table('tbl_vehicals')->get()->toArray();
        return view('vehicaldiscriptions.add',compact('vehicalname'));    
	}

	//vehicaldiscriptions list
	public function vehicaldeslist()
	{
		$vdescription=DB::table('tbl_vehicle_discription_records')->get()->toArray();
		return view('vehicaldiscriptions.list',compact('vdescription'));	
	}

   //vehicaldiscriptions store
   public function vehicalstore()
   {
		$vehicle_id=Input::get('vehicaltypes');
		$vehicaldescription=Input::get('vehicaldescription');
		$vdescription= new tbl_vehicle_discription_records;
		$vdescription ->vehicle_id =$vehicle_id;
		$vdescription->vehicle_description=$vehicaldescription;
		$vdescription ->save();
		return redirect('vehicaldiscriptions/list')->with('message','Successfully Inserted');
   }

   //vehicaldiscriptions delete
   public function destory($id)
   {
		$vdescription=DB::table('tbl_vehicle_discription_records')->where('id','=',$id)->delete();
		return redirect('vehicaldiscriptions/list')->with('message','Successfully Deleted');
   }
	
	
	//vehicaldiscriptions editform
	public function editdescription($id)
	{
		$editid = $id;
		$vehicalname=DB::table('tbl_vehicals')->get()->toArray();
		$vdescription=DB::table('tbl_vehicle_discription_records')->where('id','=',$id)->first();
		return view('vehicaldiscriptions/edit',compact('vdescription','vehicalname','editid'));
	}

	//vehicaldiscriptions update
	public function updatedescription($id)
	{
		$vehicle_id=Input::get('vehicaltypes');
   	    $vehicaldescription=Input::get('vehicaldescription');
		$vdescription=tbl_vehicle_discription_records::find($id);
		$vdescription ->vehicle_id =$vehicle_id;
		$vdescription->vehicle_description=$vehicaldescription;
		$vdescription ->save();
		return redirect('vehicaldiscriptions/list')->with('message','Successfully Updated');
	}
}