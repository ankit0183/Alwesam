<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use App\tbl_expenses;
use App\tbl_expenses_history_records;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use Illuminate\Support\Facades\Session;


class ExpenseController extends Controller
{
   
	 public function __construct()
    {
        $this->middleware('auth');
    }
	
	// expense addform
    public function index()
    {
		return view('expense.add');
    }
	
	// expense store
	public function store()
    {	
		if(getDateFormat()== 'm-d-Y')
	    {
			$dates=date('Y-m-d',strtotime(str_replace('-','/',Input::get('date'))));
		}
		else
		{
			$dates=date('Y-m-d',strtotime(Input::get('date')));
		}
		$tbl_expenses = new tbl_expenses;
		$tbl_expenses->main_label = Input::get('main_label');
		$tbl_expenses->status = Input::get('status');
		$tbl_expenses->date =$dates;
		$tbl_expenses->save();
		
		$expense_entry = Input::get('expense_entry');
		$expense_label = Input::get('expense_label');
		
		foreach($expense_entry as $key => $value)
		{
			$expense_entr = $expense_entry[$key];
			
			$expense_lbls = $expense_label[$key];
			
			$tbl_expense_id = DB::table('tbl_expenses')->orderBy('id','DESC')->first();
			
			$tbl_expenses_history_records = new tbl_expenses_history_records;
			$tbl_expenses_history_records->tbl_expenses_id = $tbl_expense_id->id;
			$tbl_expenses_history_records->expense_amount = $expense_entr;
			$tbl_expenses_history_records->label_expense = $expense_lbls;
			$tbl_expenses_history_records->save();
		}
		return redirect('expense/list')->with('message','Successfully Submitted');		
	}

	// expense list
    public function showall()
    {
		$expense = DB::table('tbl_expenses')
						->join('tbl_expenses_history_records', 'tbl_expenses.id', '=', 'tbl_expenses_history_records.tbl_expenses_id')
						->groupBy('tbl_expenses_history_records.tbl_expenses_id')
						->orderBy('tbl_expenses.id','DESC')
						->get()->toArray();
		
        return view('expense.list',compact('expense'));
    }
	
	// expense edit
    public function edit($id)
    {	
        $first_data = DB::table("tbl_expenses")->where('id', $id )->first();
		
        $sec_data = DB::table("tbl_expenses_history_records")->where('tbl_expenses_id', $id )->get()->toArray();
		
        return view("expense/edit",compact('first_data','sec_data'));
    }

	// expense update
    public function update(Request $request, $id)
    {
		if(getDateFormat()== 'm-d-Y')
	    {
			$dates=date('Y-m-d',strtotime(str_replace('-','/',Input::get('date'))));
		}
		else
		{
			$dates=date('Y-m-d',strtotime(Input::get('date')));
		}
		$tbl_expenses = tbl_expenses::find($id);	
		$tbl_expenses->main_label = Input::get('main_label');
		$tbl_expenses->status = Input::get('status');
		$tbl_expenses->date = $dates;
		$tbl_expenses->save();
			
		$expense_entry = Input::get('expense_entry');
		$expense_label = Input::get('expense_label');
		$id = Input::get('autoid');
		DB::table('tbl_expenses_history_records')->where('tbl_expenses_id',$request->id)->delete();
		foreach($expense_entry as $key => $value)
		{
			$expense_entr = $expense_entry[$key];	
			$expense_lbls = $expense_label[$key];
			
			DB::insert("insert into tbl_expenses_history_records set tbl_expenses_id = $request->id, expense_amount = $expense_entr, label_expense = '$expense_lbls' ");
			
		}
		return redirect('expense/list')->with('message','Successfully Updated');
    }

	// expense delete
    public function destroy($id)
    {
		DB::table('tbl_expenses')->where('id', $id)->delete();
		
		DB::table('tbl_expenses_history_records')->where('tbl_expenses_id', '=', $id)->delete(); 
		       
        return redirect("expense/list")->with('message','Successfully Deleted');
    }

	// monthly expense form
	public function monthly_expense()
    {
        return view("expense/month_expense");
    }
	
	// monthly expense
	public function get_month_expense(Request $request)
    {	
		  $this->validate($request,[  
			// 'start_date'  => 'required|date',
			// 'end_date'  => 'date|after:start_date',
	      ]);
		
		 if(getDateFormat()== 'm-d-Y')
		{
			$start_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('start_date'))));
			$end_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('end_date'))));
		}
		else
		{
			$start_date=date('Y-m-d',strtotime(Input::get('start_date')));
			$end_date=date('Y-m-d',strtotime(Input::get('end_date')));
		}
		$month_expense = DB::table('tbl_expenses')
							->join('tbl_expenses_history_records','tbl_expenses.id','=','tbl_expenses_history_records.tbl_expenses_id')
							->whereBetween('date',[$start_date,$end_date])
							->select('tbl_expenses.*', 'tbl_expenses_history_records.*')
							->orderBy('tbl_expenses_history_records.id','DESC')
							->get()->toArray();
		if(empty($month_expense))
		{
			Session::flash('message', 'Data Not Found !'); 
		}
		return view('expense.expense_report',compact('month_expense','start_date','end_date'));
    }	
}
