<?php

namespace App\Http\Controllers;
use App\tbl_stock_records;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;

class Reportcontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//sales list in report
    public function sales()
	{
		$s_date = '';
		$e_date = '';
		$all_customer = 'all';
		$all_salesman = 'all';
		$Sales =DB::select("SELECT count(*) as counts, RIGHT(YEAR(`date`),4) as date FROM tbl_sales group by YEAR(`date`) ORDER BY date ASC");
		
		$title_report = 'All Sales';	
		$date_report = 'Year';	
		$title = 'Sales';
		
		$Select_customer=DB::table('users')->where('role','=','Customer')->get()->toArray();
		$Select_salesman=DB::table('users')->where('role','=','employee')->get()->toArray();
		$salesreport=DB::table('tbl_sales')->orderby('id','DESC')->get()->toArray();
		return view('report.sales.list',compact('all_customer','Select_customer','salesreport','Sales','title_report','date_report','title','Select_salesman','all_salesman'));	
	}
	
	//sales list based on date in report
	public function record_sales(Request $request)
	{	
		$this->validate($request,[  
			// 'start_date'  => 'required|date',
			// 'end_date'  => 'date|after:start_date',
	      ]);
		if(getDateFormat()== 'm-d-Y')
		{
			$s_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('start_date'))));
			$e_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('end_date'))));
		}
		else
		{  
			$s_date=date('Y-m-d',strtotime(Input::get('start_date')));
			$e_date=date('Y-m-d',strtotime(Input::get('end_date')));
		}
		$all_customer=Input::get('s_customer');
		$all_salesman=Input::get('s_salesman');
		
		if($s_date =="" && $e_date =="" && $all_customer =='all' && $all_salesman == 'all')
		{
			
			$Sales = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`date`),4) as date FROM tbl_sales where customer_id='$all_customer' group by YEAR(`date`) ORDER BY date ASC");
			
			$title_report = 'All Sales';	
			$date_report = 'Year';
			$title = 'Sales';	
			
			$salesreport = DB::table('tbl_sales')->get()->toArray();
		}
		
		elseif($s_date !="" && $e_date !="" && $all_customer =='all' && $all_salesman == 'all')
		{
			$Sales = DB::select("select count(*) as counts, CONCAT(MONTHNAME(`date`),'-',RIGHT(YEAR(`date`),4)) as date FROM tbl_sales where date BETWEEN  '$s_date' AND '$e_date' GROUP BY MONTH(date), YEAR(date)");
			
			$title_report = 'All Sales';	
			$date_report = 'Year';
			$title = 'Sales';	
			$salesreport = DB::table('tbl_sales')->whereBetween('date', array($s_date, $e_date))->get()->toArray();
		}
		else if($s_date =="" && $e_date =="" && $all_customer !='all' && $all_salesman == 'all')
		{
			$Sales = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`date`),4) as date FROM tbl_sales where customer_id='$all_customer' group by YEAR(`date`) ORDER BY date ASC");
			$title_report = 'All Sales';	
			$date_report = 'Year';
			$title = 'Sales';	
			$salesreport = DB::table('tbl_sales')->where('customer_id','=',$all_customer)->get()->toArray();
		}
		else if($s_date !="" && $e_date !="" && $all_customer !='all' && $all_salesman == 'all')
		{
			$Sales = DB::select("select count(*) as counts, CONCAT(MONTHNAME(`date`),'-',RIGHT(YEAR(`date`),4)) as date FROM tbl_sales where date BETWEEN  '$s_date' AND '$e_date' and customer_id='$all_customer' GROUP BY MONTH(date), YEAR(date)");
			
			$title_report = 'All Sales';	
			$date_report = 'Year';
			$title = 'Sales';	
			$salesreport = DB::table('tbl_sales')->whereBetween('date', array($s_date, $e_date))->where('customer_id','=',$all_customer)->get()->toArray();
		}
		
		else if($s_date !="" && $e_date !="" && $all_customer =='all' && $all_salesman != 'all')
		{
			$Sales = DB::select("select count(*) as counts, CONCAT(MONTHNAME(`date`),'-',RIGHT(YEAR(`date`),4)) as date FROM tbl_sales where date BETWEEN  '$s_date' AND '$e_date' and salesmanname='$all_salesman' GROUP BY MONTH(date), YEAR(date)");
			
			$title_report = 'All Sales';	
			$date_report = 'Year';
			$title = 'Sales';	
			$salesreport = DB::table('tbl_sales')->whereBetween('date', array($s_date, $e_date))->where('salesmanname','=',$all_salesman)->get()->toArray();
			
		}
		else if($s_date !="" && $e_date !="" && $all_customer !='all' && $all_salesman != 'all')
		{
			$Sales = DB::select("select count(*) as counts, CONCAT(MONTHNAME(`date`),'-',RIGHT(YEAR(`date`),4)) as date FROM tbl_sales where date BETWEEN  '$s_date' AND '$e_date' and customer_id='$all_customer' and salesmanname='$all_salesman' GROUP BY MONTH(date), YEAR(date)");
			
			$title_report = 'All Sales';	
			$date_report = 'Year';
			$title = 'Sales';	
			$salesreport = DB::table('tbl_sales')->whereBetween('date', array($s_date, $e_date))->where([['salesmanname','=',$all_salesman],['customer_id','=',$all_customer]])->get()->toArray();
			
		}
		
		$Select_customer=DB::table('users')->where('role','=','Customer')->get()->toArray();
		$Select_salesman=DB::table('users')->where('role','=','employee')->get()->toArray();
		return view('report.sales.list',compact('Select_customer','salesreport','all_customer','s_date','e_date','Sales','title_report','date_report','title','all_salesman','Select_salesman'));
	}
	
	
	//service list in report
    public function service()
	{
		$all_service = Input::get('service_select');
		$title_report = 'All Service';	
		$date_report = 'Year';
		$title = 'Service';	
		$servicereport=DB::table('tbl_services')->where('done_status','=',1)->get()->toArray();
		
		$service=DB::select("SELECT count(*) as counts, RIGHT(YEAR(`service_date`),4) as date FROM tbl_services where done_status=1  group by YEAR(`service_date`) ORDER BY service_date ASC");
		
		return view('report.service.list',compact('all_service','servicereport','title_report','date_report','title','service'));
	}
	
	//service list based on date in report
	public function record_service(Request $request)
	{	
		$this->validate($request,[  
			// 'start_date'  => 'required|date',
			// 'end_date'  => 'date|after:start_date',
	      ]);
		if(getDateFormat()== 'm-d-Y')
		{
			$s_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('start_date'))));
			$e_date=date('Y-m-d',strtotime(str_replace('-','/',Input::get('end_date'))));
		}
		else
		{  
			$s_date=date('Y-m-d',strtotime(Input::get('start_date')));
			$e_date=date('Y-m-d',strtotime(Input::get('end_date')));
		}
		$all_service = Input::get('service_select');
		
		if($s_date =="" && $e_date =="" && $all_service =='all'){
			
			$service = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`service_date`),4) as date FROM tbl_services where (done_status=1) group by YEAR(`service_date`) ORDER BY date ASC");
			$title_report = 'All Service';	
			$date_report = 'Year';
			$title = 'Service';	
			
			$servicereport = DB::table('tbl_services')->where('done_status','=',1)->get()->toArray();
			
		}
		elseif($s_date =="" && $e_date =="" && $all_service =='free'){
			
			$service = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`service_date`),4) as date FROM tbl_services where (service_type='$all_service') and (done_status=1) group by YEAR(`service_date`) ORDER BY date ASC");
			$title_report = 'All Service';	
			$date_report = 'Year';
			$title = 'Service';	
			
			$servicereport = DB::table('tbl_services')->where([['done_status','=',1],['service_type','=',$all_service]])->get()->toArray();
			
		}
		elseif($s_date =="" && $e_date =="" && $all_service =='paid'){
			
			$service = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`service_date`),4) as date FROM tbl_services where (service_type='$all_service') and (done_status=1) group by YEAR(`service_date`) ORDER BY date ASC");
			$title_report = 'All Service';	
			$date_report = 'Year';
			$title = 'Service';	
			
			$servicereport = DB::table('tbl_services')->where([['done_status','=',1],['service_type','=',$all_service]])->get()->toArray();
			
		}
		elseif($s_date !="" && $e_date !="" && $all_service =='all')
		{
			$service = DB::select("select count(*) as counts, CONCAT(MONTHNAME(`service_date`),'-',RIGHT(YEAR(`service_date`),4)) as date FROM tbl_services where  (service_date BETWEEN  '$s_date' AND '$e_date') and (done_status=1) GROUP BY MONTH(service_date), YEAR(service_date)");
			
			
			$title_report = 'All Service';	
			$date_report = 'Year';
			$title = 'Service';	
			$servicereport = DB::table('tbl_services')->where('done_status','=',1)
														->whereBetween('service_date', array($s_date, $e_date))->get()->toArray();
														
		}
		
		elseif($s_date !="" && $e_date !="" && $all_service =='free')
		{
			$service = DB::select("select count(*) as counts, CONCAT(MONTHNAME(`service_date`),'-',RIGHT(YEAR(`service_date`),4)) as date FROM tbl_services where  (service_date BETWEEN  '$s_date' AND '$e_date') and (done_status=1) and (service_type='$all_service')GROUP BY MONTH(service_date), YEAR(service_date)");
			
			$title_report = 'All Service';	
			$date_report = 'Year';
			$title = 'Service';	
			$servicereport = DB::table('tbl_services')->where('done_status','=',1)
													->where('service_type','=',$all_service)
													->whereBetween('service_date', array($s_date, $e_date))->get()->toArray();
		}
		
		elseif($s_date !="" && $e_date !="" && $all_service =='paid')
		{
			$service = DB::select("select count(*) as counts, CONCAT(MONTHNAME(`service_date`),'-',RIGHT(YEAR(`service_date`),4)) as date FROM tbl_services where  (service_date BETWEEN  '$s_date' AND '$e_date') and (done_status=1) and (service_type='$all_service')GROUP BY MONTH(service_date), YEAR(service_date)");
			
			$title_report = 'All Service';	
			$date_report = 'Year';
			$title = 'Service';	
			$servicereport = DB::table('tbl_services')->where('done_status','=',1)
													->where('service_type','=',$all_service)
													->whereBetween('service_date', array($s_date, $e_date))->get()->toArray();
		}
		return view('report.service.list',compact('Select_customer','servicereport','all_customer','s_date','e_date','service','title_report','date_report','title','all_service'));		
	}
  
	//product list in report
	public function product()
	{
		$all_product = 'all';
		$all_item = 'item';
		$title_report = 'All Product';	
		$date_report = 'Year';
		$title = 'Product';
		
		$product=DB::select("SELECT count(*) as counts, RIGHT(YEAR(`product_date`),4) as date FROM tbl_stock_records INNER JOIN tbl_products
						ON tbl_stock_records.product_id=tbl_products.id group by YEAR(`product_date`) ORDER BY product_date ASC");
		$Select_product=DB::table('tbl_product_types')->get()->toArray();
		$productname=DB::table('tbl_products')->get()->toArray();
		
		// $productreport=DB::table('tbl_purchases')
		// ->JOIN('tbl_purchase_history_records','tbl_purchase_history_records.purchase_id','=','tbl_purchases.id')
		// ->JOIN('tbl_products','tbl_products.id','=','tbl_purchase_history_records.product_id')
		// ->orderBy('tbl_purchase_history_records.purchase_id','desc')
		// ->GROUPBY('tbl_purchase_history_records.product_id')
		// ->select('tbl_purchases.date','tbl_purchases.supplier_id','tbl_products.id','tbl_products.product_no','tbl_products.name','tbl_products.product_type_id','tbl_purchase_history_records.qty','tbl_purchase_history_records.price')
		// ->get();
		
		$productreport = DB::SELECT("SELECT * FROM tbl_purchase_history_records JOIN tbl_products on tbl_products.id = tbl_purchase_history_records.product_id WHERE purchase_id IN (SELECT MAX(purchase_id) FROM tbl_purchase_history_records GROUP by product_id) GROUP by product_id");
		
		// dd($productreport);
		// exit;
		return view('report.product.list',compact('all_product','all_item','Select_product','productreport','title_report','date_report','title','product','productname'));
	}
	public function producttype()
	{
		$id = Input::get('m_id');
		if($id == 'all')
		{
			
			$all_item ="item";
			?>
			<option value="item"<?php if($all_item=='item'){ echo 'selected'; } ?>>Items</option>
			<?php 
			$tbl_products = DB::table('tbl_products')->get()->toArray();
		}
		else
		{
			$all_item ="item";
			?>
			<option value="item"<?php if($all_item=='item'){ echo 'selected'; } ?>>Items</option>
			<?php 
			$tbl_products = DB::table('tbl_products')->where('product_type_id','=',$id)->get()->toArray();
		}
		
		if(!empty($tbl_products))
		{  
			
			foreach($tbl_products as $tbl_productss)
			{ ?>
				<option value="<?php echo  $tbl_productss->id; ?>"><?php echo $tbl_productss->name; ?></option>
			<?php } 
		}	
	}
	//product list based on date in report
	public function record_product(Request $request)
	{	
		$this->validate($request,[  
			// 'start_date'  => 'required|date',
			// 'end_date'  => 'date|after:start_date',
	    ]);

		$all_product = Input::get('s_product');
		$all_item = Input::get('product_name');
		
		
		if($all_product =='all' && $all_item =='item')
		{	
			$product=DB::select("SELECT count(*) as counts, RIGHT(YEAR(`product_date`),4) as date FROM tbl_stock_records INNER JOIN tbl_products
						ON tbl_stock_records.product_id=tbl_products.id group by YEAR(`product_date`) ORDER BY product_date ASC");
			$title_report = 'All Product';	
			$date_report = 'Year';
			$title = 'Product';	
			// $productreport=DB::table('tbl_purchases')
			// ->JOIN('tbl_purchase_history_records','tbl_purchase_history_records.purchase_id','=','tbl_purchases.id')
			// ->JOIN('tbl_products','tbl_products.id','=','tbl_purchase_history_records.product_id')
			// ->orderBy('tbl_purchase_history_records.purchase_id','desc')
			// ->GROUPBY('tbl_purchase_history_records.product_id')
			// ->select('tbl_purchases.date','tbl_purchases.supplier_id','tbl_products.id','tbl_products.product_no','tbl_products.name','tbl_products.product_type_id','tbl_purchase_history_records.qty','tbl_purchase_history_records.price')
			// ->get();
			$productreport = DB::SELECT("SELECT * FROM tbl_purchase_history_records JOIN tbl_products on tbl_products.id = tbl_purchase_history_records.product_id WHERE purchase_id IN (SELECT MAX(purchase_id) FROM tbl_purchase_history_records GROUP by product_id) GROUP by product_id");
			$productname=DB::table('tbl_products')->get()->toArray();
		}
		else if($all_product !='all' && $all_item =='item')
		{
			$product = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`product_date`),4) as date FROM tbl_products where product_type_id='$all_product' group by YEAR(`product_date`) ORDER BY product_date ASC");
			$title_report = 'All Product';	
			$date_report = 'Year';
			$title = 'Product';
			// $productreport=DB::table('tbl_purchases')
			// ->JOIN('tbl_purchase_history_records','tbl_purchase_history_records.purchase_id','=','tbl_purchases.id')
			// ->JOIN('tbl_products','tbl_products.id','=','tbl_purchase_history_records.product_id')
			// ->orderBy('tbl_purchase_history_records.purchase_id','desc')
			// ->GROUPBY('tbl_purchase_history_records.product_id')
			// ->where('product_type_id','=',$all_product)
			// ->select('tbl_purchases.date','tbl_purchases.supplier_id','tbl_products.id','tbl_products.product_no','tbl_products.name','tbl_products.product_type_id','tbl_purchase_history_records.qty','tbl_purchase_history_records.price')
			// ->get();
			$productreport = DB::SELECT("SELECT * FROM tbl_purchase_history_records JOIN tbl_products on tbl_products.id = tbl_purchase_history_records.product_id WHERE purchase_id IN (SELECT MAX(purchase_id) FROM tbl_purchase_history_records GROUP by product_id) and (tbl_products.product_type_id='$all_product') GROUP by product_id");
			$productname = DB::table('tbl_products')->where('tbl_products.product_type_id','=',$all_product)->get()->toArray();
			// $productreport = DB::table('tbl_stock_records')->JOIN('tbl_products','tbl_stock_records.product_id','=','tbl_products.id')->where('product_type_id','=',$all_product)->get();
		}
		else if($all_product == 'all' && $all_item != 'item')
		{
			$product = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`product_date`),4) as date FROM tbl_products where name='$all_item' group by YEAR(`product_date`) ORDER BY product_date ASC");
			$title_report = 'All Product';	
			$date_report = 'Year';
			$title = 'Product';
			
			$productname = DB::table('tbl_products')->get()->toArray();
			
			$productreport = DB::SELECT("SELECT * FROM tbl_purchase_history_records JOIN tbl_products on tbl_products.id = tbl_purchase_history_records.product_id WHERE purchase_id IN (SELECT MAX(purchase_id) FROM tbl_purchase_history_records GROUP by product_id) and (tbl_products.id='$all_item') GROUP by product_id");
			// $productreport=DB::table('tbl_purchases')
			// ->JOIN('tbl_purchase_history_records','tbl_purchase_history_records.purchase_id','=','tbl_purchases.id')
			// ->JOIN('tbl_products','tbl_products.id','=','tbl_purchase_history_records.product_id')
			// ->orderBy('tbl_purchase_history_records.purchase_id','desc')
			// ->GROUPBY('tbl_purchase_history_records.product_id')
			// ->where('tbl_products.id','=',$all_item)
			// ->select('tbl_purchases.date','tbl_purchases.supplier_id','tbl_products.id','tbl_products.product_no','tbl_products.name','tbl_products.product_type_id','tbl_purchase_history_records.qty','tbl_purchase_history_records.price')
			// ->get();
			
			// $productreport = DB::table('tbl_stock_records')->JOIN('tbl_products','tbl_stock_records.product_id','=','tbl_products.id')->where('name','=',$all_item)->get();
		}
		else if($all_product != 'all' && $all_item != 'item')
		{
			$product = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`product_date`),4) as date FROM tbl_products where (product_type_id='$all_product') and (name='$all_item') group by YEAR(`product_date`) ORDER BY product_date ASC");
			$title_report = 'All Product';	
			$date_report = 'Year';
			$title = 'Product';	
			// $productreport=DB::table('tbl_purchases')
			// ->JOIN('tbl_purchase_history_records','tbl_purchase_history_records.purchase_id','=','tbl_purchases.id')
			// ->JOIN('tbl_products','tbl_products.id','=','tbl_purchase_history_records.product_id')
			// ->orderBy('tbl_purchase_history_records.purchase_id','desc')
			// ->GROUPBY('tbl_purchase_history_records.product_id')
			// ->where([['tbl_products.id','=',$all_item],['tbl_products.product_type_id','=',$all_product]])
			// ->select('tbl_purchases.date','tbl_purchases.supplier_id','tbl_products.id','tbl_products.product_no','tbl_products.name','tbl_products.product_type_id','tbl_purchase_history_records.qty','tbl_purchase_history_records.price')
			// ->get();
			
			$productreport = DB::SELECT("SELECT * FROM tbl_purchase_history_records JOIN tbl_products on tbl_products.id = tbl_purchase_history_records.product_id WHERE purchase_id IN (SELECT MAX(purchase_id) FROM tbl_purchase_history_records GROUP by product_id) and (tbl_products.product_type_id='$all_product') and (tbl_products.id='$all_item') GROUP by product_id");
			
			$productname = DB::table('tbl_products')->where('tbl_products.product_type_id','=',$all_product)->get()->toArray();
			// $productreport = DB::table('tbl_stock_records')->JOIN('tbl_products','tbl_stock_records.product_id','=','tbl_products.id')->where([['name','=',$all_item],['product_type_id','=',$all_product]])->get();
		}	
		$Select_product = DB::table('tbl_product_types')->get();
		return view('report.product.list',compact('all_product','all_item','Select_product','productreport','product','title_report','date_report','title','s_date','e_date','productname'));
	}	
	
	public function array_sort_by_column(&$array, $column, $direction = SORT_ASC)
	{
		$reference_array = array();
		foreach($array as $key => $row)
		{
			$reference_array[$key] = $row->date;
		}
		array_multisort($reference_array, $direction, $array);
	}
	//productuses list report
	public function productuses()
	{	
		$id = 1;
		$totalstock1 = DB::table('tbl_purchase_history_records')
			->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->where('tbl_purchase_history_records.product_id','=',$id)
		    // ->orderby('tbl_purchases.date','ASC')
			->select('tbl_purchases.date as date','tbl_purchases.supplier_id','tbl_purchase_history_records.qty','tbl_purchases.purchase_no')
			->get()->toArray();
			
		$cellstock1 = DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')
			->where('product_id','=',$id)
			// ->orderby('tbl_services.service_date','ASC')
			->select('tbl_services.customer_id','tbl_services.assign_to','tbl_services.job_no','tbl_services.service_date as date','tbl_service_pros.quantity')
			->get()->toArray();
		$arr = array_merge($totalstock1,$cellstock1);
		$common_array = $this->array_sort_by_column($arr,'date');
		
		$s_date = '';
		$e_date = '';
		$all_product = 'all';
		$all_item = 'item';

		$productreport = DB::SELECT("SELECT * FROM tbl_purchase_history_records JOIN tbl_products on tbl_products.id = tbl_purchase_history_records.product_id WHERE purchase_id IN (SELECT MAX(purchase_id) FROM tbl_purchase_history_records GROUP by product_id) GROUP by product_id");
		
		$Select_product = DB::table('tbl_product_types')->get()->toArray();
		$productname = DB::table('tbl_products')->get()->toArray();
		return view('report.product.product_uses',compact('all_product','all_item','Select_product','productname','productreport','s_date','e_date'));
	}
	
	//uses_product list record in report
	public function uses_product()
	{
		if(getDateFormat()== 'm-d-Y')
		{
			$s_date = date('Y-m-d',strtotime(str_replace('-','/',Input::get('start_date'))));
			$e_date = date('Y-m-d',strtotime(str_replace('-','/',Input::get('end_date'))));
		}
		else
		{  
			$s_date = date('Y-m-d',strtotime(Input::get('start_date')));
			$e_date = date('Y-m-d',strtotime(Input::get('end_date')));
		}
		$all_product = Input::get('m_product');
		$all_item = Input::get('product_name');
		if($s_date != "" && $e_date != "" && $all_product == 'all' && $all_item == 'item')
		{
			$productreport = DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->JOIN('tbl_products','tbl_products.id','=','tbl_purchase_history_records.product_id')
			->whereBetween('date', [$s_date, $e_date])
			->GROUPBY('tbl_purchase_history_records.product_id')
			->get()->toArray();

			$productname = DB::table('tbl_products')->get()->toArray();
		}
		elseif($s_date != "" && $e_date != "" && $all_product == 'all' && $all_item != 'item')
		{
			$productreport = DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->JOIN('tbl_products','tbl_products.id','=','tbl_purchase_history_records.product_id')
			->whereBetween('date', [$s_date, $e_date])
			->where('tbl_products.id','=',$all_item)
			->GROUPBY('tbl_purchase_history_records.product_id')
			->get()->toArray();
			
			$productname = DB::table('tbl_products')->get()->toArray();
		}
		elseif($s_date != "" && $e_date != "" && $all_product != 'all' && $all_item != 'item')
		{
			$productreport = DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->JOIN('tbl_products','tbl_products.id','=','tbl_purchase_history_records.product_id')
			->whereBetween('date', [$s_date, $e_date])
			->where([['tbl_products.id','=',$all_item],['tbl_products.product_type_id','=',$all_product]])
			->GROUPBY('tbl_purchase_history_records.product_id')
			->get()->toArray();
			
			$productname = DB::table('tbl_products')->where('product_type_id','=',$all_product)->get()->toArray();
		}
		elseif($s_date != "" && $e_date != "" && $all_product != 'all' && $all_item == 'item')
		{
			$productreport = DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->JOIN('tbl_products','tbl_products.id','=','tbl_purchase_history_records.product_id')
			->whereBetween('date', [$s_date, $e_date])
			->where('tbl_products.product_type_id','=',$all_product)
			->GROUPBY('tbl_purchase_history_records.product_id')
			->get()->toArray();
			
			$productname = DB::table('tbl_products')->where('product_type_id','=',$all_product)->get()->toArray();
		}
		
		$Select_product = DB::table('tbl_product_types')->get()->toArray();
		
		return view('report.product.product_uses',compact('all_product','all_item','Select_product','productname','productreport','s_date','e_date'));
		
	}
	
	public function modalview()
	{
		$id=Input::get('productid');
		$s_date=Input::get('s_date');
		$e_date=Input::get('e_date');
		
		if($s_date == '' && $e_date == '')
		{
			$totalstock1 = DB::table('tbl_purchase_history_records')
			->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->where('tbl_purchase_history_records.product_id','=',$id)
		    ->orderby('tbl_purchases.date','ASC')
			->select('tbl_purchases.date as date','tbl_purchases.supplier_id','tbl_purchase_history_records.qty','tbl_purchases.purchase_no','tbl_purchases.id')
			->get()->toArray();
			
			$cellstock1 = DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')
			->where('product_id','=',$id)
			->orderby('tbl_services.service_date','ASC')
			->select('tbl_services.customer_id','tbl_services.assign_to','tbl_services.job_no','tbl_services.service_date as date','tbl_service_pros.quantity','tbl_services.id')
			->get()->toArray();
			$totalstock = array_merge($totalstock1,$cellstock1);
			$common_array = $this->array_sort_by_column($totalstock,'date');
		}
		else
		{
			$totalstock1 = DB::table('tbl_purchase_history_records')
			->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->where('tbl_purchase_history_records.product_id','=',$id)
			->whereBetween('tbl_purchases.date', [$s_date, $e_date])
		    ->orderby('tbl_purchases.date','ASC')
			->select('tbl_purchases.date as date','tbl_purchases.supplier_id','tbl_purchase_history_records.qty','tbl_purchases.purchase_no','tbl_purchases.id')
			->get()->toArray();
			
			$cellstock1 = DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')
			->where('product_id','=',$id)
			->whereBetween('tbl_services.service_date', [$s_date, $e_date])
			->orderby('tbl_services.service_date','ASC')
			->select('tbl_services.customer_id','tbl_services.assign_to','tbl_services.job_no','tbl_services.service_date as date','tbl_service_pros.quantity','tbl_services.id')
			->get()->toArray();
			
			$totalstock = array_merge($totalstock1,$cellstock1);
			$common_array = $this->array_sort_by_column($totalstock,'date');
		}
		$html = view('report.product.model')->with(compact('totalstock','cellstock','id','stockdatas'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}
	
	public function modalviewPart()
	{

		$id = Input::get('productid');
		$s_date = Input::get('s_date');
		$e_date = Input::get('e_date');
		
		if($s_date == '' && $e_date == '')
		{
			$totalstock1 = DB::table('tbl_purchase_history_records')
			->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')
			->where('tbl_purchase_history_records.product_id','=',$id)
		    ->orderby('tbl_purchases.date','ASC')
			->select('tbl_purchases.date as date','tbl_purchases.supplier_id as salesmanname','tbl_purchase_history_records.qty','tbl_purchases.purchase_no','tbl_purchases.id','tbl_purchases.supplier_id')
			->get()->toArray();
			
			$cellstock3 = DB::table('tbl_sale_parts')
			->where('product_id','=',$id)
			->get()->toArray();
			
			$cellstock2 = DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')
			->where('product_id','=',$id)
			->orderby('tbl_services.service_date','ASC')
			->select('tbl_services.customer_id','tbl_services.assign_to as salesmanname','tbl_services.job_no','tbl_services.service_date as date','tbl_service_pros.quantity','tbl_services.id')
			->get()->toArray();
			
			$totalstock = array_merge($totalstock1,$cellstock3,$cellstock2);
			
			$common_array = $this->array_sort_by_column($totalstock,'date');
		}
		else
		{
			$totalstock1 = DB::table('tbl_purchase_history_records')->JOIN('tbl_purchases','tbl_purchases.id','=','tbl_purchase_history_records.purchase_id')->where('tbl_purchase_history_records.product_id','=',$id)->whereBetween('tbl_purchases.date', [$s_date, $e_date])->orderby('tbl_purchases.date','ASC')->select('tbl_purchases.date as date','tbl_purchases.supplier_id as salesmanname','tbl_purchase_history_records.qty','tbl_purchases.purchase_no','tbl_purchases.id' ,'tbl_purchases.supplier_id')->get()->toArray();
			
			$cellstock3 = DB::table('tbl_sale_parts')->where('product_id','=',$id)->whereBetween('date', [$s_date, $e_date])->get()->toArray();
			
			$cellstock2 = DB::table('tbl_service_pros')->JOIN('tbl_services','tbl_services.id','=','tbl_service_pros.service_id')
			->where('product_id','=',$id)
			->whereBetween('tbl_services.service_date', [$s_date, $e_date])
			->orderby('tbl_services.service_date','ASC')
			->select('tbl_services.customer_id','tbl_services.assign_to as salesmanname','tbl_services.job_no','tbl_services.service_date as date','tbl_service_pros.quantity','tbl_services.id')
			->get()->toArray();
			
			
			$totalstock = array_merge($totalstock1,$cellstock2,$cellstock3);
			$common_array = $this->array_sort_by_column($totalstock,'date');
		}
		$html = view('report.product.modelsale')->with(compact('totalstock','cellstock','id','stockdatas','cellstock3'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}
	
	//service by emp. list in report
	public function servicebyemployee()
	{
		$all_employee = 'all';
		$title_report = 'All Service';	
		$date_report = 'Year';
		$title = 'Service';	
		$servicereport = DB::table('tbl_services')->where('done_status','=',1)->get()->toArray();
		$service = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`service_date`),4) as date FROM tbl_services where done_status=1  group by YEAR(`service_date`) ORDER BY service_date ASC");
		$Select_employee = DB::table('users')->where('role','=','employee')->get()->toArray();
		return view('report.service.empservicelist',compact('all_employee','Select_employee','servicereport','title_report','date_report','title','service'));	
	}
	
	//service emp. list based on date in report
	public function employeeservice(Request $request)
	{	
		$this->validate($request,[  
			// 'start_date'  => 'required|date',
			// 'end_date'  => 'date|after:start_date',
	    ]);
		if(getDateFormat() == 'm-d-Y')
		{
			$s_date = date('Y-m-d',strtotime(str_replace('-','/',Input::get('start_date'))));
			$e_date = date('Y-m-d',strtotime(str_replace('-','/',Input::get('end_date'))));
		}
		else
		{  
			$s_date = date('Y-m-d',strtotime(Input::get('start_date')));
			$e_date = date('Y-m-d',strtotime(Input::get('end_date')));
		}
		$all_employee = Input::get('s_customer');
		if($s_date == "" && $e_date == "" && $all_employee == 'all')
		{
			$service = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`service_date`),4) as date FROM tbl_services where (assign_to='$all_employee') and (done_status=1) group by YEAR(`service_date`) ORDER BY date ASC");
			$title_report = 'All Service';	
			$date_report = 'Year';
			$title = 'Service';	
			$servicereport = DB::table('tbl_services')->where('done_status','=',1)->get()->toArray();		
		}
		elseif($s_date != "" && $e_date != "" && $all_employee == 'all')
		{
			$service = DB::select("select count(*) as counts, CONCAT(MONTHNAME(`service_date`),'-',RIGHT(YEAR(`service_date`),4)) as date FROM tbl_services where  (service_date BETWEEN  '$s_date' AND '$e_date') and (done_status=1) GROUP BY MONTH(service_date), YEAR(service_date)");
			$title_report = 'All Service';
			$date_report = 'Year';
			$title = 'Service';
			$servicereport = DB::table('tbl_services')->where('done_status','=',1)->whereBetween('service_date', array($s_date, $e_date))->get()->toArray();
		}
		else if($s_date == "" && $e_date == "" && $all_employee != 'all')
		{
			$service = DB::select("SELECT count(*) as counts, RIGHT(YEAR(`service_date`),4) as date FROM tbl_services where (assign_to='$all_employee') and (done_status=1) group by YEAR(`service_date`) ORDER BY service_date ASC");
			$title_report = 'All Service';
			$date_report = 'Year';
			$title = 'Service';
			$servicereport = DB::table('tbl_services')->where([['assign_to','=',$all_employee],['done_status','=',1]])->get()->toArray();
		}
		else if($s_date != "" && $e_date != "" && $all_employee != 'all')
		{
			$service = DB::select("select count(*) as counts, CONCAT(MONTHNAME(`service_date`),'-',RIGHT(YEAR(`service_date`),4)) as date FROM tbl_services where (service_date BETWEEN  '$s_date' AND '$e_date') and (done_status=1) and assign_to='$all_employee' GROUP BY MONTH(service_date), YEAR(service_date)");
			$title_report = 'All Service';
			$date_report = 'Year';
			$title = 'Service';
			$servicereport = DB::table('tbl_services')->where('done_status','=',1)->whereBetween('service_date', array($s_date, $e_date))->where('assign_to','=',$all_employee)->get()->toArray();
		}
		$Select_employee = DB::table('users')->where('role','=','employee')->get()->toArray();
		return view('report.service.empservicelist',compact('Select_employee','servicereport','all_employee','s_date','e_date','service','title_report','date_report','title'));		
	}	
}