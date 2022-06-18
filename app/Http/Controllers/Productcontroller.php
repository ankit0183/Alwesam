<?php

namespace App\Http\Controllers;
use App\User;
use App\tbl_colors;
use Auth;
use App\tbl_products;
use App\tbl_product_units;
use App\tbl_product_types;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;

class Productcontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//product list
    public function index()
	{
		$product = DB::table('tbl_products')->orderBy('id','DESC')->get()->toArray();
		return view('product.list',compact('product')); 
	}
	//product list
    public function indexid($id)
	{	
		$product = DB::table('tbl_products')->where('id','=',$id)->get()->toArray();
		return view('product.list',compact('product')); 
	}
	//product add form
	public function addproduct()
	{
		$characters = '0123456789';
		$code =  'PR'.''.substr(str_shuffle($characters),0,6);
		$color = DB::table('tbl_colors')->get()->toArray();
		$product = DB::table('tbl_product_types')->get()->toArray();
		$supplier = DB::table('users')->where('role','=','Supplier')->get()->toArray();
		$unitproduct = DB::table('tbl_product_units')->get()->toArray();
		return view('product.add',compact('supplier','product','color','code','unitproduct')); 
	}
	
	//product type
	public function addproducttype()
	{		
		$product = Input::get('product_type');
		$product_get = DB::table('tbl_product_types')->where('type','=',$product)->count();
		
		if($product_get == 0)
		{
			$product_type = new tbl_product_types;
			$product_type->type = $product;
			$product_type->save();
			 return $product_type->id;
		}else
		{
			return '01';
		}
		         
	}
	
	//add color
	public function coloradd()
	{   
		    $color_name = Input::get('c_name');
			$colors = DB::table('tbl_colors')->where('color','=',$color_name)->count();
			
			if($colors == 0)
			{
			 $color = new tbl_colors;
			 $color->color=$color_name;
			 $color->save();
				echo $color->id;
			}
			else
			{
				
				 return '01';
			}	
	}
	
	//color delete
	public function colordelete()
	{
		$id = Input::get('colorid');
		
		$color =DB::table('tbl_colors')->where('id','=',$id)->delete();
	}
	
	//add unit
	public function unitadd()
	{
		
		$unitname = Input::get('unit_measurement');
		$uintcount=DB::table('tbl_product_units')->where('name','=',$unitname)->count();
		if($uintcount == 0)
		{
		$product_unit= new tbl_product_units;
		$product_unit->name = $unitname;
		$product_unit->save();
		  echo $product_unit->id;
		}
		else
		{
			return '01';
		}	
	}
	
	//unit delete
	public function unitdelete()
	{
		$unitid=Input::get('unitid');
		
		$productunit=DB::table('tbl_product_units')->where('id','=',$unitid)->delete();
	}
	
	// product store
	public function store(Request $request)
	{
		$this->validate($request, [ 
			'price'=>'required|numeric',
			'category'=>'required',
		  ]);
		  
		if(getDateFormat()== 'm-d-Y')
		{
			$dates=date('Y-m-d',strtotime(str_replace('-','/',Input::get('p_date'))));
		}
		else
		{
			$dates=date('Y-m-d',strtotime(Input::get('p_date')));	
		}
		$product = new tbl_products;
		$product->product_no = Input::get('p_no');
		$product->product_date = $dates;
		if(!empty(Input::hasFile('image')))
		{
			$file= Input::file('image');
			$filename=$file->getClientOriginalName();
			$file->move(public_path().'/product/', $file->getClientOriginalName());
			$product->product_image =$filename ;
		}
		else
		{
			$product->product_image='avtar.png';
		}
		$product->name = Input::get('name');
		$product->product_type_id = Input::get('p_type');
		$product->color_id = Input::get('color');
		$product->price = Input::get('price');
		$product->supplier_id = Input::get('sup_id');
		$product->warranty = Input::get('warranty');
		$product->category = Input::get('category');
		$product->unit = Input::get('unit');
		$product->save();
		
		return redirect('/product/list')->with('message','Successfully Submitted');
	}
	
	//product delete
	public function destroy($id)
	{	
		$product = DB::table('tbl_products')->where('id','=',$id)->delete();
		return redirect('/product/list')->with('message','Successfully Deleted');
	}
	
	//product edit
	public function edit($id)
	{	
		$editid = $id;
		$color = DB::table('tbl_colors')->get()->toArray();
		$product_type = DB::table('tbl_product_types')->get()->toArray();
		$supplier = DB::table('users')->where('role','=','Supplier')->get()->toArray();
		$product = DB::table('tbl_products')->where('id','=',$id)->first();
		$unitproduct = DB::table('tbl_product_units')->get()->toArray();
		return view('product.edit',compact('editid','color','product_type','supplier','product','unitproduct'));
	}
	
	//product update
	public function update(Request $request ,$id)
	{
		$this->validate($request, [ 
			'price'=>'required|numeric',
			'category'=>'required',
		  ]);
		if(getDateFormat()== 'm-d-Y')
		{
			$dates=date('Y-m-d',strtotime(str_replace('-','/',Input::get('p_date'))));
		}
		else
		{
			$dates=date('Y-m-d',strtotime(Input::get('p_date')));	
		}
		$product = tbl_products::find($id);
		$product->product_no = Input::get('p_no');
		$product->product_date =$dates;
		
		
		if(!empty(Input::hasFile('image')))
			{
				$file= Input::file('image');
				$filename=$file->getClientOriginalName();
				$file->move(public_path().'/product/', $file->getClientOriginalName());
				$product->product_image = $filename;
			}
		
			
		$product->name = Input::get('name');
		$product->product_type_id = Input::get('p_type');
		$product->color_id = Input::get('color');
		$product->price = Input::get('price');
		$product->supplier_id = Input::get('sup_id');
		$product->warranty = Input::get('warranty');
		$product->category = Input::get('category');
		$product->unit = Input::get('unit');
		$product->save();
		
		return redirect('/product/list')->with('message','Successfully Updated');
	}
	
	//product delete
	public function deleteproducttype()
	{
		$id = Input::get('ptypeid');
		$p_type = DB::table('tbl_product_types')->where('id','=',$id)->delete();
		$p_type = DB::table('tbl_products')->where('product_type_id','=',$id)->delete();
		
	}
}	
