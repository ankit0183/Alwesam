<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use App\tbl_colors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;

class Colorcontroller extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }

	//color list
    public function index()
	{
		$color = DB::table('tbl_colors')->orderBy('id','DESC')->get()->toArray();
		return view('color.list',compact('color')); 
	}

	//color addform
	public function addcolor()
	{	
		return view('color.add'); 
	}

	//color store
	public function store(Request $request)
	{	
		$color = Input::get('color');
		$count = DB::table('tbl_colors')->where('color','=',$color)->count();
		if($count == 0)
		{
			$colors = new tbl_colors;
			$colors->color = $color;
			$colors->save();
			return redirect('/color/list')->with('message','Successfully Submitted');
		}
		else
		{
			return redirect('/color/add')->with('message','Duplicate Data');
		}
	}

	//color delete
	public function destroy($id)
	{
		$vehicle_colors = DB::table('tbl_vehicle_colors')->where('color',$id)->count();
		if($vehicle_colors > 0)
		{
			return redirect('/color/list')->with('message','This color is used with a vehicle record. So you can not delete it.');
		}
		$colors = DB::table('tbl_colors')->where('id','=',$id)->delete();
		return redirect('/color/list')->with('message','Successfully Deleted');
	}

	//color edit
	public function edit($id)
	{	
		$editid = $id;
		$colors = DB::table('tbl_colors')->where('id','=',$id)->first();
		return view('color.edit',compact('colors','editid'));
	}

	//color update
	public function update($id)
	{
		$color = tbl_colors::find($id);
		$colors = Input::get('color');
		$count = DB::table('tbl_colors')->where([['color','=',$colors],['id','!=',$id]])->count();
		if($count == 0)
		{
			$color->color = $colors;
			$color->save();
			return redirect('/color/list')->with('message','Successfully Updated');
		}
		else
		{
			return redirect('/color/list/edit/'.$id)->with('message','Duplicate Data');
		}
	}
}