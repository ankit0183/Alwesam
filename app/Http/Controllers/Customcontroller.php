<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use App\tbl_custom_fields;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use App\Http\Requests;
use DB;

class Customcontroller extends Controller
{
	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//customfields list
	public function index()
	{	
		$tbl_custom_fields=DB::table('tbl_custom_fields')->orderBy('id','DESC')->get()->toArray();
		return view('Customfields.list',compact('tbl_custom_fields')); 
	}
	
    //customfields addform
	public function add()
	{	
		return view('Customfields.addcustom'); 
	}
	 
	//customfields store
	public function store()
	{
		$colomfield=Input::get('colomfield');
		$lable=Input::get('labelname');
		
		$tbl_custom_fields=new tbl_custom_fields;
		$tbl_custom_fields->form_name=Input::get('formname');
		$tbl_custom_fields->label=$lable;
		$tbl_custom_fields->type=Input::get('typename');
		$tbl_custom_fields->required=Input::get('required');
		$tbl_custom_fields->always_visable=Input::get('visable');
		
		$tbl_custom_fields->save();
		
		return redirect('/setting/custom/list')->with('message','Successfully Submitted');
	}
	
	//customfields delete
	public function delete($id)
	{
		$tbl_custom_fields=DB::table('tbl_custom_fields')->where('id','=',$id)->delete();
		return redirect('/setting/custom/list')->with('message','Successfully Deleted');
	}
	
	//customfields edit
	public function edit($id)
	{
		$tbl_custom_fields=DB::table('tbl_custom_fields')->where('id','=',$id)->first();
		return view('Customfields.editcustom',compact('id','tbl_custom_fields')); 
	}
	
	//customfields update
	public function update($id)
	{
		$tbl_custom_fields=tbl_custom_fields::find($id);
		$tbl_custom_fields->form_name=Input::get('formname');
		$tbl_custom_fields->label=Input::get('labelname');
		$tbl_custom_fields->type=Input::get('typename');
		$tbl_custom_fields->required=Input::get('required');
		$tbl_custom_fields->always_visable=Input::get('visable');
		
		$tbl_custom_fields->save();
		return redirect('/setting/custom/list')->with('message','Successfully Updated');
	}	
}	
