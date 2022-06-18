<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_account_tax_rates;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Input;

class AccounttaxControler extends Controller
{
	public function __construct()
    {
		$this->middleware('auth');
    }

	//taxrates addform
	public function index()
	{
		return view('taxrates.add');    
	}

	//taxrates store
	public function store(Request $request)
	{
		$this->validate($request, [
			'tax'=>'numeric',
		]);
		$taxrate = Input::get('taxrate');
		$tax = Input::get('tax');
		$count = DB::table('tbl_account_tax_rates')->where('taxname','=',$taxrate)->count();
		if($count == 0)
		{
			$account = new tbl_account_tax_rates;
			$account->taxname = $taxrate;
			$account->tax = $tax;
			$account->save();
			return redirect('/taxrates/list')->with('message','Successfully Submitted');
		}
		else
		{
			return redirect('/taxrates/add')->with('message','Duplicate Data');
		}
	}

	//taxrates list
	public function taxlist()
	{
		$account = DB::table('tbl_account_tax_rates')->orderBy('id','DESC')->get()->toArray();
		return view('/taxrates/list',compact('account'));
	}

	//taxrates delete
	public function destory($id)
	{
		$account = DB::table('tbl_account_tax_rates')->where('id','=',$id)->delete();
		return redirect('/taxrates/list')->with('message','Successfully Deleted');
	}

	//taxrates edit
	public function accountedit($id)
	{
		$editid = $id;
		$account = DB::table('tbl_account_tax_rates')->where('id','=',$id)->first();
		return view('/taxrates/edit',compact('account','editid'));
	}

	//taxrates update
	public function updateaccount(Request $request,$id)
	{
		$this->validate($request, [
			'tax' => 'numeric',
		]);
		$taxrate = Input::get('taxrate');
		$tax = Input::get('tax');
		$count = DB::table('tbl_account_tax_rates')->where([['taxname','=',$taxrate],['id','!=',$id]])->count();
		if($count == 0)
		{
			$account = tbl_account_tax_rates::find($id);
			$account->taxname = $taxrate;
			$account->tax = $tax;
			$account->save();
			return redirect('/taxrates/list')->with('message','Successfully Updated');
		}
		else
		{
			return redirect('/taxrates/list/edit/'.$id)->with('message','Duplicate Data');
		}
	}
}