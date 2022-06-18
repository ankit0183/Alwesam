<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth; 
use DB;
use App\User;
use Illuminate\Support\Facades\Input;

class Accessrightscontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//accessright list
    public function index()
	{	
		$accessright=DB::table('tbl_accessrights')->get()->toArray();
		return view('accessrights.accessright',compact('accessright'));
	}
	
	//accessright store
	public function store()
	{
		$Customers=Input::get('Customers_id');
		$value = Input::get('value');
		DB::update("update tbl_accessrights set customers='$value' where id='$Customers'");
		
	}
	//emp store
	public function Employeestore()
	{
		$Employee_id=Input::get('Employee_id');
		$value = Input::get('value');
		DB::update("update tbl_accessrights set employee='$value' where id='$Employee_id'");
	}
	
	//staff store
	public function staffstore()
	{
		$Support_staff_id=Input::get('Support_staff_id');
		$value = Input::get('value');
		DB::update("update tbl_accessrights set support_staff='$value' where id='$Support_staff_id'");
	}
	
	//accountant store
	public function Accountantstore()
	{
		$Accountant_id=Input::get('Accountant_id');
		$value = Input::get('value');
		DB::update("update tbl_accessrights set accountant='$value' where id='$Accountant_id'");
	}
}
