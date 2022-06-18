<?php
namespace App\Http\Controllers;
use App\User;
use Auth;
use App\tbl_service_pros;
use App\tbl_jobcard_details;
use App\tbl_checkout_categories;
use App\tbl_points;
use App\tbl_service_taxes;
use App\tbl_service_observation_points;
use App\tbl_checkout_results;
use App\tbl_gatepasses;
use Mail;
use Illuminate\Mail\Mailer;
use App\tbl_mail_notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
?>

<?php
class JobCardcontroller extends Controller
{

	public function __construct()
    {
        $this->middleware('auth');
    }


	//invoice addform
	public function add_invoice($id)
	{
		$characters = '0123456789';
		$code =  substr(str_shuffle($characters),0,8);
		$characterss = '0123456789';
		$codepay =  'P'.''.substr(str_shuffle($characterss),0,6);
		$tax = DB::table('tbl_account_tax_rates')->get()->toArray();
		$tbl_payments = DB::table('tbl_payments')->get()->toArray();
		$customer_job = DB::table('tbl_services')->where([['done_status','=',1],['id','=',$id]])->first();
		$service_pro = DB::table('tbl_service_pros')->where([['service_id','=',$id],['chargeable','=',1]])->SUM('total_price');

		$othr_charges =  DB::table('tbl_service_pros')->where([['service_id','=',$id],['product_id','=',null]])->SUM('total_price');

		$service_charge = DB::table('tbl_services')->where('id','=',$id)->first();
		$charge = $service_charge->charge;
		$total_amount = $service_pro + $othr_charges + $charge;

		return view('invoice.add',compact('code','tax','customer_job','total_amount','codepay','tbl_payments'));
	}

	//jobcard add form
	public function jobcard_add()
	{
       $characters = '0123456789';
       $code =  'J'.''.substr(str_shuffle($characters),0,6);

       $employee=DB::table('users')->where('role','employee')->get()->toArray();
       $customer=DB::table('tbl_sales')->groupBy('customer_id')->get()->toArray();

       return view('jobcard.add',compact('employee','customer','code'));
	}

	//getpass invoices/receipt
	public function getpassinvoice()
	{
		$getpassid = Input::get('getid');
		$getpassdata = DB::table('tbl_gatepasses')
						->join('users','users.id','=','tbl_gatepasses.customer_id')
						->join('tbl_vehicles','tbl_gatepasses.vehicle_id','=','tbl_vehicles.id')
						->join('tbl_services','tbl_gatepasses.jobcard_id','=','tbl_services.job_no')
						->select('tbl_gatepasses.*','tbl_services.service_date','tbl_vehicles.modelname','users.name','users.lastname')
						->where('jobcard_id',$getpassid)->first();

		$setting = DB::table('tbl_settings')->first();

		$html = view('gatepass.getpassmodel')->with(compact('getpassid','getpassdata','setting'))->render();
		return response()->json(['success' => true, 'html' => $html]);

	}

	//get observation points
	public function Get_Observation_Pts()
	{
		$s_id = Input::get('service_id');
		$product = DB::table('tbl_products')->get()->toArray();

		$data = DB::select("select tbl_service_pros.*, tbl_points.*,tbl_service_observation_points.id from tbl_points join tbl_service_observation_points on tbl_service_observation_points.observation_points_id = tbl_points.id join tbl_service_pros on tbl_service_pros.tbl_service_observation_points_id = tbl_service_observation_points.id where tbl_service_observation_points.services_id = $s_id and tbl_service_observation_points.review = 1 and tbl_service_pros.type = 0");

		$html = view('jobcard.observationpoints')->with(compact('s_id','product','data'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}


	//total stock in product
	public function stocktotal()
	{

	}



	//select checkpoints
	public function select_checkpt()
	{

	    $value = Input::get('value');
		$id = Input::get('id');
		$service_id = Input::get('service_id');
		$main_cat = Input::get('main_cat');
		$sub_pt = Input::get('sub_pt');

		 $datas = DB::table('tbl_service_observation_points')->where([['services_id','=',$service_id],['observation_points_id','=',$id]])->first();



			if(!empty($datas))
			{
				$tbl_service_obse_id = $datas->id;
				$review = $datas->review;

				if($review == 1)
				{
					DB::update("update tbl_service_observation_points set review = 0 where services_id='$service_id' and observation_points_id='$id'");

					DB::table('tbl_service_pros')->where([['service_id',$service_id],['tbl_service_observation_points_id',$tbl_service_obse_id]])->delete();
				}
				else
				{
					DB::update("update tbl_service_observation_points set review = 1 where services_id='$service_id' and observation_points_id='$id'");

					$pros = new tbl_service_pros;
					$pros->service_id = $service_id;
					$pros->tbl_service_observation_points_id = $tbl_service_obse_id;
					$pros->type = 0;
					$pros->category = $main_cat;
					$pros->obs_point = $sub_pt;
					$pros->save();
				}
			}
			else
			{
				$data = new tbl_service_observation_points;
				$data->services_id = $service_id;
				$data->observation_points_id = $id;
				$data->review = $value;
				$data->save();

				$pros = new tbl_service_pros;
				$pros->service_id = $service_id;
				$pros->tbl_service_observation_points_id = $data->id;
				$pros->type = 0;
				$pros->category = $main_cat;
				$pros->obs_point = $sub_pt;
				$pros->save();
			}
	}

	//gatepass form
	public function gatepass()
	{
		$characters = '0123456789';
		$code =  'G'.''.substr(str_shuffle($characters),0,6);
    	$suggestions = DB::table('tbl_services')->get()->toArray();

    	foreach ($suggestions as $suggest) {
    		$job_no = $suggest->job_no;
    		$job[] = $job_no;
    	}

        $search_data = json_encode($job);
		return view('\jobcard.gatepass',compact('search_data','code'));
	}

	//get data on seleceted customer from jobcard list
     public function gatedata($id)
	 {
		$characters = '0123456789';
		$code =  'G'.''.substr(str_shuffle($characters),0,6);
    	$suggestions = DB::table('tbl_services')->where('id','=',$id)->first();
		$c_id=$suggestions->customer_id;
		$v_id=$suggestions->vehicle_id;

    	$user = DB::table('users')->where('id','=',$c_id)->first();
    	$vehicle = DB::table('tbl_vehicles')->where('id','=',$v_id)->first();

		return view('jobcard.gatepass',compact('suggestions','code','user','vehicle'));
	 }

	// get data on jobcard select from gatepass addform
	public function getrecord()
	{

		$job_id = Input::get('job_id');

        $all_sql = DB::select("SELECT * FROM `tbl_services`
        		INNER JOIN users ON tbl_services.customer_id = users.id
        		INNER JOIN tbl_vehicles ON tbl_services.vehicle_id = tbl_vehicles.id
				INNER JOIN tbl_jobcard_details ON tbl_services.id = tbl_jobcard_details.service_id
				INNER JOIN tbl_vehicle_types ON tbl_vehicles.vehicletype_id = tbl_vehicle_types.id where tbl_services.job_no='$job_id'");

		$data = str_replace(array('[', ']'), '', htmlspecialchars(json_encode($all_sql), ENT_NOQUOTES));
		echo $data;
	}

	//gatepass store
	public function insert_gatepass_data(Request $request)
    {
		$this->validate($request, [
           // 'today'    => 'date',
		  // 'servie_out_date'      => 'required|date|after:today',
	      ]);
        $job_id = Input::get('jobcard');
		$service=DB::table('tbl_services')->where('job_no','=',$job_id)->first();
		$c_id=$service->customer_id;
		$v_id=$service->vehicle_id;
		if(getDateFormat()== 'm-d-Y')
		{
			$date = str_replace('-','/',input::get('ser_date'));
			$final_date = date("Y-m-d", strtotime($date));
			$out_date=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('servie_out_date'))));
		}
		else
		{
			$date = input::get('ser_date');
			$final_date = date("Y-m-d", strtotime($date));
			$out_date=date('Y-m-d H:i:s',strtotime(Input::get('servie_out_date')));
		}
        $data=new tbl_gatepasses;

        $data->gatepass_no =input::get('gatepass_no');
        $data->jobcard_id = Input::get('jobcard');
        $data->customer_id = $c_id;
        $data->vehicle_id = $v_id;
        $data->ser_pro_status = 1;
        $data->create_by = Auth::user()->id;

        $data->service_out_date =$out_date;

 		$data->save();

		return redirect('jobcard/list')->with('message','Successfully Submitted');
    }
	//jobcard list
	public function indexid($id)
	{
		$services = DB::table('tbl_services')->orderBy('id','DSC')->where([['id','=',$id],['job_no','like','J%']])->get()->toArray();
		$month = date('m');
		$year = date('Y');
		$start_date = "$year/$month/01";
		$end_date = "$year/$month/31";

		$current_month = DB::select("SELECT service_date FROM tbl_services WHERE service_date BETWEEN  '$start_date' AND '$end_date'");
			if(!empty($current_month))
			{
				foreach ($current_month as $list)
				{
					$date[] = $list->service_date;

				}
				$available = json_encode($date);
			}
			else
			{
			$available = json_encode([0]);
			}
		return view('jobcard.list',compact('services','available','servicename','logo','ownservice'));
	}
	//jobcard list
    public function index()
	{
		$userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			if(!empty(Input::get('free')))
			{
				$services = DB::table('tbl_services')->orderBy('service_date','asc')->where([['job_no','like','J%'],['service_type','=','free'],['done_status','=',1]])->get()->toArray();

			}
			elseif(!empty(Input::get('paid')))
			{
				$services = DB::table('tbl_services')->orderBy('service_date','asc')->where([['job_no','like','J%'],['service_type','=','paid'],['done_status','=',1]])->get()->toArray();

			}
			elseif(!empty(Input::get('repeatjob')))
			{
				$services = DB::table('tbl_services')->orderBy('service_date','asc')->where([['job_no','like','J%'],['service_category','=','repeat job'],['done_status','=',1]])->get()->toArray();

			}
			else
			{
				$services = DB::table('tbl_services')->orderBy('id','DSC')->where('job_no','like','J%')->get()->toArray();

			}
		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			if(!empty(Input::get('free')))
			{
				$services = DB::table('tbl_services')->orderBy('service_date','asc')
							->where([['job_no','like','J%'],['service_type','=','free'],['done_status','=',1]])
							->where('assign_to','=',Auth::User()->id)
							->get()->toArray();

			}
			elseif(!empty(Input::get('paid')))
			{
				$services = DB::table('tbl_services')->orderBy('service_date','asc')
										->where([['job_no','like','J%'],['service_type','=','paid'],['done_status','=',1]])
										->where('assign_to','=',Auth::User()->id)
										->get()->toArray();
			}
			elseif(!empty(Input::get('repeatjob')))
			{
				$services = DB::table('tbl_services')->orderBy('service_date','asc')
							->where([['job_no','like','J%'],['service_category','=','repeat job'],['done_status','=',1]])
							->where('assign_to','=',Auth::User()->id)
							->get()->toArray();
			}
			else
			{
				$services = DB::table('tbl_services')->orderBy('id','DSC')->where([['job_no','like','J%'],['assign_to','=',Auth::User()->id]])->get()->toArray();
			}
		}
		else
		{
			if(!empty(Input::get('free')))
			{
				$services = DB::table('tbl_services')->orderBy('service_date','asc')
										->where([['job_no','like','J%'],['service_type','=','free'],['done_status','=',1]])
										->where('customer_id','=',Auth::User()->id)
										->get()->toArray();

			}
			elseif(!empty(Input::get('paid')))
			{
				$services = DB::table('tbl_services')->orderBy('service_date','asc')
										->where([['job_no','like','J%'],['service_type','=','paid'],['done_status','=',1]])
										->where('customer_id','=',Auth::User()->id)
										->get()->toArray();
			}
			elseif(!empty(Input::get('repeatjob')))
			{
				$services = DB::table('tbl_services')->orderBy('service_date','asc')
								->where([['job_no','like','J%'],['service_category','=','repeat job'],['done_status','=',1]])
								->where('customer_id','=',Auth::User()->id)
								->get()->toArray();
			}
			else
			{
				$services = DB::table('tbl_services')->orderBy('id','DSC')->where([['job_no','like','J%'],['customer_id','=',Auth::User()->id]])->get()->toArray();
			}
		}
		$month = date('m');
		$year = date('Y');
		$start_date = "$year/$month/01";
		$end_date = "$year/$month/31";

		$current_month = DB::select("SELECT service_date FROM tbl_services WHERE service_date BETWEEN  '$start_date' AND '$end_date'");
			if(!empty($current_month))
			{
				foreach ($current_month as $list)
				{
					$date[] = $list->service_date;

				}
				$available = json_encode($date);
			}
			else
			{
			$available = json_encode([0]);
			}

		return view('jobcard.list',compact('services','available','servicename','logo','ownservice'));
	}

	// checkpoint store
	public function pointadd()
	{
		$pointname=Input::get('name');

		$point= new tbl_checkout_categories;
		$point->checkout_point=$pointname;
		$point->create_by = Auth::user()->id;
		$point->save();
	}

	// add comment
	public function commentpoint()
	{
		$point_id=Input::get('co_point');
		$comment=Input::get('commentname');
		$s_id=Input::get('s_id');
		$tbl_checkout_results=new tbl_checkout_results;
		$tbl_checkout_results->point_id=$point_id;
		$tbl_checkout_results->comment=$comment;
		$tbl_checkout_results->service_id=$s_id;
		$tbl_checkout_results->comment_by=Auth::user()->id;
		$tbl_checkout_results->save();
	}

	// store checked points
	public function addcheckresult()
	{
		$c_category=Input::get('observation');
		$o_point=Input::get('checkpoint');

		$r_point=Input::get('resultname');
		$tbl_point= new tbl_points;
		$tbl_point->checkout_categories_id=$c_category;
		$tbl_point->checkout_point=$o_point;
		$tbl_point->create_by=Auth::user()->id;
		$tbl_point->save();
	}

	// add observation
	public function addobservation()
	{
		$value = Input::get('value');
		$o_point_id = Input::get('o_point_id');
		$service_id = Input::get('service_id');

		if($value == 1)
		{
			$tbl_service_observation_points = new tbl_service_observation_points;
			$tbl_service_observation_points->services_id = $service_id;
			$tbl_service_observation_points->observation_points_id = $o_point_id;
			$tbl_service_observation_points->review = 1;
			$tbl_service_observation_points->save();
		}

		if($value == 0)
		{
			$data = DB::table('tbl_service_observation_points')->where([['services_id','=',$service_id],['observation_points_id','=',$o_point_id]])->delete();
		}
	}

	//jobcard store
	public function store(Request $request)
	{

	    $job_no = Input::get('job_no');
		$service_id = Input::get('service_id');
		if(getDateFormat()== 'm-d-Y')
		{
			$in_date=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('in_date'))));
			$odate=date('Y-m-d H:i:s',strtotime(str_replace('-','/',Input::get('out_date'))));
		}
		else
		{
			$in_date=date('Y-m-d H:i:s',strtotime(Input::get('in_date')));
			$odate=date('Y-m-d H:i:s',strtotime(Input::get('out_date')));
		}
		$kms = Input::get('kms');
		$customer_sug = Input::get('customer_sug');
        $customer_comp = Input::get('customer_comp');


		$coupan_no = Input::get('coupan_no');

		$out_date = DB::update("update tbl_jobcard_details set out_date='$odate' where service_id=$service_id");


		$product2 = Input::get('product2');
		$chargeable = Input::get('yesno_');
		$obs_auto_id = Input::get('obs_id');

		if(!empty($product2))
		{
			foreach($product2['product_id'] as $key => $value)
			{
				$charge_abl = $chargeable[$key];
				$obs_auto = $obs_auto_id[$key];
				$product_id2 = $product2['product_id'][$key];
				$price2 = $product2['price'][$key];
				$qty2 = $product2['qty'][$key];
				$total2 = $product2['total'][$key];
				$category = $product2['category'][$key];
				$sub = $product2['sub_points'][$key];
				$comment = $product2['comment'][$key];


				$old_data = DB::table('tbl_service_pros')->where([['service_id','=',$service_id], ['category','=',$category], ['obs_point','=',$sub]])->count();

				 if($old_data ==0)
				{

					$tbl_service_pros = new tbl_service_pros;
					$tbl_service_pros->service_id = $service_id;

					$tbl_service_pros->product_id = $product_id2;
					$tbl_service_pros->tbl_service_observation_points_id = $obs_auto;

					$tbl_service_pros->quantity = $qty2;
					$tbl_service_pros->price = $price2;
					$tbl_service_pros->total_price = $total2;
					$tbl_service_pros->category = $category;
					$tbl_service_pros->obs_point = $sub;
					$tbl_service_pros->category_comments = $comment;
					$tbl_service_pros->chargeable = $charge_abl;
					$tbl_service_pros->save();
				}
				else
				{
					DB::update("update tbl_service_pros set
														product_id = $product_id2,
														quantity = $qty2,
														price = $price2,
														total_price = $total2,
														chargeable = $charge_abl,
														category_comments='$comment'
														where service_id = $service_id and category = '$category' and obs_point = '$sub'");
				}
			}
		}
		$ot_product = Input::get('other_product');
		$ot_price = Input::get('other_price');

		if(!empty($ot_product))
		{
			foreach($ot_product as $key => $value)
			{
				$prod = $ot_product[$key];
				$pri = $ot_price[$key];

				$othr_pr = DB::table('tbl_service_pros')->where([['service_id','=',$service_id], ['comment','=',$prod]])->count();
				if($othr_pr == 0)
				{
					$tbl_service_pros = new tbl_service_pros;
					$tbl_service_pros->service_id = $service_id;
					$tbl_service_pros->comment = $prod;
					$tbl_service_pros->total_price = $pri;
					$tbl_service_pros->type = 1;
					$tbl_service_pros->save();
				}
			}
		}
		$tblcountjob=DB::table('tbl_jobcard_details')->where('jocard_no','=',$job_no)->count();
		if($tblcountjob == 0)
		{
			$servicedd=DB::table('tbl_services')->where('job_no','=',$job_no)->first();
			$cus_id=$servicedd->customer_id;
			$vehi_id=$servicedd->vehicle_id	;

			$tbl_jobcard_details = new tbl_jobcard_details;
			$tbl_jobcard_details->customer_id = $cus_id;
			$tbl_jobcard_details->vehicle_id = $vehi_id;
			$tbl_jobcard_details->service_id = $service_id;
			$tbl_jobcard_details->jocard_no = $job_no;
			$tbl_jobcard_details->in_date = $in_date;
			$tbl_jobcard_details->out_date = $odate;
			$tbl_jobcard_details->kms_run = $kms;
            $tbl_jobcard_details->customer_sug = $customer_sug;
            $tbl_jobcard_details->customer_comp = $customer_comp;


			if(!empty($coupan_no))
			{
			$tbl_jobcard_details->coupan_no = $coupan_no;
			}
			$tbl_jobcard_details->save();
		}
        else
		{
			DB::table('tbl_jobcard_details')
								        ->where('service_id', $service_id)
								        ->update(['out_date' => $odate, 'kms_run' => $kms, 'customer_sug' => $customer_sug, 'customer_comp' => $customer_comp]);
		}
		DB::update("update `tbl_services` set done_status=1 where id=$service_id");
		DB::update("update `tbl_jobcard_details` set done_status=1 where service_id=$service_id");


		return redirect('jobcard/list')->with('message','Successfully Submitted');
	}

	// add products
	public function addproducts(Request $request)
	{
		$id = $request->row_id;
		$ids = $id+1;
		$rowid = 'row_id_'.$ids;
		?>

		<tr id="<?php echo $rowid;?>">
		<td>
			<input type="text" name="other_product[]" class="form-control" maxlength="50">
		</td>

		<td>
			<input type="text" name="other_price[]" class="form-control other_service_price" id="oth_price" value="<?php if(!empty($pros)) { echo $product->total_price; }?>" maxlength="8" onkeyup="if (/\D/g.test(this.value)) this.value = this.value.replace(/\D/g,'')">
		</td>

		<td>
			<span class="trash_product" style="cursor: pointer;" data-id="<?php echo $ids; ?>"><i class="fa fa-trash fa-2x"></i></span>
		</td>
		</tr>
		<?php
	}

	// price of product
	public function getprice()
	{
		$product_id = Input::get('product_id');
		if(!empty($product_id))
		{
		$t_record = DB::table('tbl_products')->where('id','=',$product_id)->first();
		$unit = getUnitName($t_record->unit);
		$price = $t_record->price;
		return array($price, $unit);

		}
		else
		{
			return 0;
		}
	}

	// get total price for product
	public function gettotalprice()
	{

		$productid=Input::get('productid');
		$cellstock=DB::table('tbl_service_pros')->where('product_id','=',$productid)->get()->toArray();
		$celltotal=0;
		foreach($cellstock as $cellstocks)
		{
			$cell_stock=$cellstocks->quantity;
			$celltotal += $cell_stock;
		}
		$stockdata=DB::table('tbl_stock_records')
						->join('tbl_products','tbl_stock_records.product_id','=','tbl_products.id')
						->join('tbl_purchase_history_records','tbl_products.id','=','tbl_purchase_history_records.product_id')
						->join('tbl_purchases','tbl_purchase_history_records.purchase_id','=','tbl_purchases.id')
						->where('tbl_products.id','=',$productid)
						->get()->toArray();

				$total=0;
				if(!empty($stockdata))
				{
					foreach($stockdata as $stockdatas)
					{

						$total += $stockdatas->qty;

					}
				}

			$Currentstock = $total - $celltotal;

			$qty = Input::get('qty');
			if($qty > $Currentstock   )
				{
					echo 1;
				}
				else
				{
					$price = Input::get('price');
					$total = $qty * $price;
					echo $total;
				}

	}

	//jobcard view form(process job)
	public function view($id)
	{
		$viewid = $id;

		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$id)->get()->toArray();
		$services = DB::table('tbl_services')->where('id','=',$id)->first();
		$v_id = $services->vehicle_id;

		$s_id = $services->sales_id;


			$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();
			$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();
			if(!empty($s_date))
			{
				$color_id = $s_date->color_id;
				$color = DB::table('tbl_colors')->where('id','=',$color_id)->first();
			}
				$service_data = DB::table('tbl_services')->latest()->first();
		 if(!empty($v_id)){
			 $vehicale = DB::table('tbl_vehicles')->where('id','=',$v_id)->first();
		 }

		$job = DB::table('tbl_jobcard_details')->where('service_id','=',$id)->first();

		$pros = DB::table('tbl_service_pros')->where([['service_id','=',$id],['type','=','1']])->get()->toArray();

		$pros2 = DB::table('tbl_service_pros')->where([['service_id','=',$id],['type','=','0']])->get()->toArray();


		$product = DB::table('tbl_products')->get()->toArray();

		$obser_id = DB::table('tbl_service_observation_points')->where('services_id',$viewid)->get()->toArray();

		$tbl_observation_points = DB::table('tbl_observation_points')->where('observation_type_id','=',1)->get()->toArray();
		$tbl_observation_service = DB::table('tbl_observation_points')->where('observation_type_id','=',2)->get()->toArray();
		$vehicalemodel = DB::table('tbl_vehicles')->get()->toArray();
		$tbl_checkout_categories=DB::table('tbl_checkout_categories')->where('vehicle_id','=',$v_id)->orWhere('vehicle_id','=',0)->get()->toArray();
		$tbl_points=DB::table('tbl_points')->get()->toArray();

		   $c_point=DB::table('tbl_checkout_categories')->get()->toArray();
			if(!empty($c_point))
			{
			 $point_count=count($c_point);


				   $total=ceil($point_count/3);
				   $categorypoint=(array_chunk($c_point,$total));
				   $first = $categorypoint[0];
				   //$second = $categorypoint[1];
			}

				   $tax = DB::table('tbl_account_tax_rates')->get()->toArray();

				   $logo = DB::table('tbl_settings')->first();

		$data = DB::select("select tbl_service_pros.*, tbl_points.*,tbl_service_observation_points.id from tbl_points join tbl_service_observation_points on tbl_service_observation_points.observation_points_id = tbl_points.id join tbl_service_pros on tbl_service_pros.tbl_service_observation_points_id = tbl_service_observation_points.id where tbl_service_observation_points.services_id = $viewid and tbl_service_observation_points.review = 1 and tbl_service_pros.type = 0");

		return view('jobcard.view',compact('viewid','services','tbl_observation_points','tbl_observation_service','tbl_service_observation_points','vehicale','sales','product','s_id','job','pros','pros2','tbl_checkout_categories','first','second','three','vehicalemodel','tbl_points','s_date','color','service_data','tax','logo','obser_id','data'));
	}

	//get points
	public function getpoint()
	{
		$vid=Input::get('vehicleid');
		$tbl_checkout_categories=DB::table('tbl_checkout_categories')->where('vehicle_id','=',$vid)->first();
		$record = json_encode($tbl_checkout_categories);
		echo $record;
	}

	//modal for view
	public function modalview()
	{

		$serviceid = Input::get('serviceid');

		$tbl_services = DB::table('tbl_services')->where('id','=',$serviceid)->first();

		$c_id=$tbl_services->customer_id;
		$v_id=$tbl_services->vehicle_id;

		$s_id = $tbl_services->sales_id;
		$sales = DB::table('tbl_sales')->where('id','=',$s_id)->first();

		$job=DB::table('tbl_jobcard_details')->where('service_id','=',$serviceid)->first();
		$s_date = DB::table('tbl_sales')->where('vehicle_id','=',$v_id)->first();

		$vehical=DB::table('tbl_vehicles')->where('id','=',$v_id)->first();

		$customer=DB::table('users')->where('id','=',$c_id)->first();
		$service_pro=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',0)
												  ->where('chargeable','=',1)
												  ->get()->toArray();

		$service_pro2=DB::table('tbl_service_pros')->where('service_id','=',$serviceid)
												  ->where('type','=',1)->get()->toArray();

		$tbl_service_observation_points = DB::table('tbl_service_observation_points')->where('services_id','=',$serviceid)->get()->toArray();

		$service_tax = DB::table('tbl_invoices')->where('sales_service_id','=',$serviceid)->first();
		if(!empty($service_tax->tax_name))
		{
			$service_taxes = explode(', ', $service_tax->tax_name);
		}
		else
		{
			$service_taxes='';
		}
		$discount = $service_tax->discount;
		$logo = DB::table('tbl_settings')->first();
		$updatekey = DB::table('updatekey')->first();
		$s_key = $updatekey->secret_key;
		$p_key = $updatekey->publish_key;
		$html = view('invoice.serviceinvoicemodel')->with(compact('serviceid','tbl_services','sales','logo','job','s_date','vehical','customer','service_pro','service_pro2','tbl_service_observation_points','service_tax','service_taxes','discount','p_key','paid_amount'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	}

	// delete data on re-process
	public function delete_on_reprocess()
	{
		$service_id = Input::get('service_id');
		$del_pro = Input::get('del_pro');

		DB::table('tbl_service_pros')->where([['service_id',$service_id],['tbl_service_observation_points_id',$del_pro]])->delete();

		DB::table('tbl_service_observation_points')->where([['services_id',$service_id],['id',$del_pro]])->delete();

	}

	// other product delete on re-process
	public function oth_pro_delete()
	{
		$del_oth_pro = Input::get('del_oth_pro');

		$del=DB::table('tbl_service_pros')->where('id',$del_oth_pro)->delete();

    if (!empty($del)) {
        echo $del;
    }
    }
}
