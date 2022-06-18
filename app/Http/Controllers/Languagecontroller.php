<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;

class Languagecontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	// language list 
    public function index()
	{	
		$user = DB::table('users')->where('id','=',Auth::user()->id)->first();
		return view('language.list',compact('user')); 
	}
	
	// direction list 
	public function index1()
	{	
		return view('direction.list'); 
	}
	
	//direction store
	public function store1()
	{
		$direction = Input::get('direction');
		$dire_table = DB::table('tbl_language_directions')->orderBy('id','desc')->first();
		$id = $dire_table->id;
		DB::update("update tbl_language_directions set direction='$direction' where id=$id");
		return redirect('/setting/language/direction/list')->with('message','Successfully Updated');
	}
	
	//language store
	public function store()
	{	
		$lang= Input::get('language');
		
		$id = Auth::user()->id;
		$users = DB::table('users')->where('id','=',$id)->first();
		$language = $users->language;
		DB::update("update users set language='$lang' where id=$id");
		
		if($lang == 'ar')
		{
			$dire_table = DB::table('tbl_language_directions')->orderBy('id','desc')->first();
			$id = $dire_table->id;
			DB::update("update tbl_language_directions set direction='rtl' where id=$id");
		}
		else
		{	
			$dire_table = DB::table('tbl_language_directions')->orderBy('id','desc')->first();
			$id = $dire_table->id;
			DB::update("update tbl_language_directions set direction='ltr' where id=$id");			
		}
		return redirect('/setting/timezone/list')->with('message','Successfully Updated');
		
	}
}	
