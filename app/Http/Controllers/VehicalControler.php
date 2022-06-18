<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\tbl_vehicle_types;
use App\tbl_vehicle_brands;
use App\tbl_fuel_types;
use App\tbl_model_names;
use App\tbl_colors;
use App\tbl_vehicles;
use App\tbl_vehicle_discription_records;
use App\tbl_vehicle_images;
use App\tbl_vehicle_colors;
use App\Http\Requests;
use DB;
use URL;
use auth;
use Illuminate\Support\Facades\Input;

class VehicalControler extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

	//vehicle description
    public function decription()
    {
     	return view ('vehicle.description');
    }
	
	 //  get tables and compact
	public function index()
	{        
	    $vehical_type = DB::table('tbl_vehicle_types')->get()->toArray();
	    $vehical_brand = DB::table('tbl_vehicle_brands')->get()->toArray();
	    $fuel_type = DB::table('tbl_fuel_types')->get()->toArray();
	    $color = DB::table('tbl_colors')->get()->toArray();
		$model_name = DB::table('tbl_model_names')->get()->toArray();
		return view ('vehicle.add',compact('vehical_type','vehical_brand','fuel_type','color','model_name'));    
	}
	
	//  Add vehical type
	public function vehicaltypeadd(Request $request)
	{		
		$vehical_type=Input::get('vehical_type');
		
		$count = DB::table('tbl_vehicle_types')->where('vehicle_type','=',$vehical_type)->count();
		
		if ($count==0)
		{
			$vehicaltype = new tbl_vehicle_types;
			$vehicaltype -> vehicle_type = $vehical_type;
			$vehicaltype -> save();
			 echo $vehicaltype->id;		
		}
		else
		{
			return "01";
		}
	}
	
	// Add vehical brand
	public function vehicalbrandadd()
	{
        $vehical_id= Input::get('vehical_id');
		$vehical_brand1= Input::get('vehical_brand');		
		$count = DB::table('tbl_vehicle_brands')->where([['vehicle_id','=',$vehical_id],['vehicle_brand','=',$vehical_brand1]])->count();
		
		if( $count == 0)
		{
			$vehical_brand= new tbl_vehicle_brands;
			$vehical_brand ->vehicle_id=$vehical_id;
			$vehical_brand ->vehicle_brand = $vehical_brand1;
			$vehical_brand->save(); 
			echo $vehical_brand->id;
		}
		else
		{
			return "01";
		}
	}
	
   //Add fuel type
	public function fueladd()
	{
		$fuel_type1=Input::get('fuel_type');
		$count =  DB::table('tbl_fuel_types')->where('fuel_type','=',$fuel_type1)->count();
		if($count == 0)
        {
			$fueltype = new tbl_fuel_types;
			$fueltype ->fuel_type = $fuel_type1;
			$fueltype -> save();
			 return $fueltype->id;
		}
        else
        {
        	return "01";
        }
    }
	
	// Add Vehicle Model
	public function add_vehicle_model()
	{
		$model_name = Input::get('model_name');		
		$count = DB::table('tbl_model_names')->where('model_name','=',$model_name)->count();		
		if($count == 0)
		{
			$tbl_model_names = new tbl_model_names;
			$tbl_model_names->model_name = $model_name;
			$tbl_model_names->save();
			
			 return $tbl_model_names->id;
		}
		else
		{
			return "01";
		}
	}
	
   // Vehical type two brand select
	public function vehicaltype()
	{
		$id = Input::get('vehical_id');
		$vehical_brand = DB::table('tbl_vehicle_brands')->where('vehicle_id','=',$id)->get()->toArray();
		if(!empty($vehical_brand))
		{
			foreach($vehical_brand as $vehical_brands)
			{ ?>
				<option value="<?php echo  $vehical_brands->id; ?>"  class="brand_of_type"><?php echo $vehical_brands->vehicle_brand; ?></option>
			<?php } 
		}	
	}
	
	// Vehical type Delete

   public function deletevehicaltype()
	{
		$id = Input::get('vtypeid');
		DB::table('tbl_vehicle_types')->where('id','=',$id)->delete();			
		DB::table('tbl_vehicle_brands')->where('vehicle_id','=',$id)->delete();			
	}
	 
	// Vehical brand Delete
    public function deletevehicalbrand()
    {	
		$id = Input::get('vbrandid');
     	DB::table('tbl_vehicle_brands')->where('id','=',$id)->delete();
     }

    // Fual type Delete
    public function fueltypedelete()
    {  	
       	$id= Input::get('fueltypeid');
       	$fuel=DB::table('tbl_fuel_types')->where('id','=',$id)->delete();
       	// $tbl_vehicles=DB::table('tbl_vehicles')->where('fuel_id','=',$id)->delete();	
    }
	   
	// Vehical Model Name Delete
	public function delete_vehi_model()
	{	
		$id = Input::get('mod_del_id');
		tbl_model_names::destroy($id);	
	}
	   
	// Vehical save
	public function vehicalstore(Request $request)
	{
		 $this->validate($request, [  
        // 'price' => 'numeric',
	      ]);
		$vehical_type=Input::get('vehical_id');
		$chasicno=Input::get('chasicno');
		$vehicabrand=Input::get('vehicabrand');
		$modelyear=Input::get('modelyear');
		$fueltype=Input::get('fueltype');
		$modelname=Input::get('modelname');
		$price=Input::get('price');
		$odometerreading=Input::get('odometerreading');
		if(getDateFormat()== 'm-d-Y')
		{
			$dom=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dom'))));
		}
		else
		{
			$dom=date('Y-m-d',strtotime(Input::get('dom')));
		}
		$gearbox=Input::get('gearbox');
		$gearboxno=Input::get('gearboxno');
		$engineno=Input::get('engineno');
		$enginesize=Input::get('enginesize');
		$keyno=Input::get('keyno');
		$engine=Input::get('engine');
		$nogears=Input::get('gearno');
     
		$vehical = new tbl_vehicles;
		$vehical->vehicletype_id=$vehical_type;
		$vehical->chassisno =$chasicno;
		$vehical->vehiclebrand_id =$vehicabrand;
		$vehical->modelyear  =$modelyear;
		$vehical->fuel_id  =$fueltype;
		$vehical->modelname  =$modelname;
		$vehical->price  =$price;
		$vehical->odometerreading  =$odometerreading;
		$vehical->dom  =$dom;
		$vehical->gearbox   =$gearbox;
		$vehical->gearboxno   =$gearboxno;
		$vehical->engineno  =$engineno;
		$vehical->enginesize =$enginesize ;
		$vehical->keyno  =$keyno;
		$vehical->engine =$engine;
		$vehical->nogears =$nogears;
		$vehical-> save();

   		$vehicles =    DB::table('tbl_vehicles')->orderBy('id','desc')->first();
   		$id = $vehicles->id;
        $descriptionsdata = Input::get('description');
     
		foreach($descriptionsdata as $key => $value)
		{
			$desc = $descriptionsdata[$key];
			$descriptions = new tbl_vehicle_discription_records;
		    $descriptions->vehicle_id = $id;
		    $descriptions->vehicle_description=$desc;
		    $descriptions->save();
		}     
       $vehicals =DB::table('tbl_vehicles')->orderBy('id','desc')->first();
       $id = $vehicles->id;	
	   
	   if(!empty(Input::hasFile('image')))
		{
			$files= Input::file('image');
			
			foreach($files as $file)
			{
				$filename = $file->getClientOriginalName();
				$file->move(public_path().'/vehicle/', $file->getClientOriginalName());
				$images = new tbl_vehicle_images; 
				$images->vehicle_id = $id;
				$images->image = $filename;
				$images->save();
			}
		}
		$vehicles = DB::table('tbl_vehicles')->orderBy('id','desc')->first();
   		$id = $vehicles->id;
        $colores = Input::get('color');
        
        foreach ($colores as $key => $value)
		{
         	$colorse = $colores[$key];
         	$color1 = new tbl_vehicle_colors;
         	$color1->vehicle_id = $id;
		    $color1->color=$colorse;
		    $color1->save();   	 
         }
        return redirect('/vehicle/list')->with('message','Successfully Submitted');
	}
	
	//vehical list
	public function vehicallist()
	{    
	  $userid=Auth::User()->id;
		if(!empty(getActiveCustomer($userid)=='yes'))
		{
			//$vehical_type = DB::table('tbl_vehicle_types')->get();
			$vehical=DB::table('tbl_vehicles')->orderBy('id','DESC')->get()->toArray();
			//$image=DB::table('tbl_vehicle_images')->get();
		}
		elseif(!empty(getActiveEmployee($userid)=='yes'))
		{
			$vehical=DB::table('tbl_vehicles')->orderBy('id','DESC')->get()->toArray();
			// $vehical=DB::table('tbl_services')
										// ->join('tbl_vehicles','tbl_services.vehicle_id','=','tbl_vehicles.id')
										// ->where([['tbl_services.assign_to','=',$userid],['done_status','=',1]])
										// ->groupby('tbl_services.vehicle_id')
										// ->orderBy('tbl_vehicles.id','DESC')->get();
		}
		else
		{
			$vehical=DB::table('tbl_vehicles')->orderBy('id','DESC')->get()->toArray();
			// $vehical=DB::table('tbl_sales')
										// ->join('tbl_vehicles','tbl_sales.vehicle_id','=','tbl_vehicles.id')
										// ->where('tbl_sales.customer_id','=',$userid)->orderBy('tbl_vehicles.id','DESC')->get();
		}
	   
		return view('vehicle.list',compact('vehical','vehical_type','image'));
	}
	
	// Vehical  Delete
    public function destory($id)	
	{
		
		$tbl_checkout_categories = DB::table('tbl_checkout_categories')->where('vehicle_id','=',$id)->delete();
		$tbl_points = DB::table('tbl_points')->where('vehicle_id','=',$id)->delete();
		$tbl_rto_taxes = DB::table('tbl_rto_taxes')->where('vehicle_id','=',$id)->delete();
		$color1 = DB::table('tbl_vehicle_colors')->where('vehicle_id','=',$id)->delete();
		$images = DB::table('tbl_vehicle_images')->where('vehicle_id','=',$id)->delete();
		$descriptions = DB::table('tbl_vehicle_discription_records')->where('vehicle_id','=',$id)->delete();
		$vehical = DB::table('tbl_vehicles')->where('id','=',$id)->delete();
         return redirect('vehicle/list')->with('message','Successfully Deleted');
	}	

    // Vehical  Edit
    public function editvehical($id)
	{  
		$editid=$id;
	    $vehical_type = DB::table('tbl_vehicle_types')->get()->toArray();
	    $vehical_brand= DB::table('tbl_vehicle_brands')->get()->toArray();
	    $fueltype = DB::table('tbl_fuel_types')->get()->toArray();

	    $color= DB::table('tbl_colors')->get()->toArray();
	    $colors1 =DB::table('tbl_vehicle_colors')->where('vehicle_id','=',$id)->get()->toArray();
	    $images1=DB::table('tbl_vehicle_images')->where('vehicle_id','=',$id)->get()->toArray();
	    $vehicaldes=DB::table('tbl_vehicle_discription_records')->where('vehicle_id','=',$id)->get()->toArray();
	    $vehicaledit=DB::table('tbl_vehicles')->where('id','=',$id)->first();
        $model_name = DB::table('tbl_model_names')->get()->toArray();	
		return view ('vehicle.edit',compact('vehicaledit','vehicaldes','vehical_type','vehical_brand','fueltype','color','editid','colors1','images1','model_name'));
	 }	 	
	 
    // vehical Update
	public function updatevehical($id,Request $request)
	{
		
	  $this->validate($request, [  
         'price' => 'numeric',
	      ]);
      $vehical_type=Input::get('vehical_id');
      $chasicno=Input::get('chasicno');
      $vehicabrand=Input::get('vehicabrand');
      $modelyear=Input::get('modelyear');
       $fueltype=Input::get('fueltype');
       $modelname=Input::get('modelname');  
       $price=Input::get('price');
   
        $odometerreading=Input::get('odometerreading');
		if(getDateFormat()== 'm-d-Y')
		{
			$dom=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dom'))));
		}
		else
		{
			$dom=date('Y-m-d',strtotime(Input::get('dom')));
		}
        $gearbox=Input::get('gearbox');
        $gearboxno=Input::get('gearboxno');
        $engineno=Input::get('engineno');
        $enginesize=Input::get('enginesize');
        $keyno=Input::get('keyno');
        $engine=Input::get('engine');
        $nogears=Input::get('gearno');

        $vehical = tbl_vehicles::find($id);
        $vehical->vehicletype_id=$vehical_type;
        $vehical->chassisno =$chasicno;
        $vehical->vehiclebrand_id =$vehicabrand;
        $vehical->modelyear  =$modelyear;
        $vehical->fuel_id  =$fueltype;
        $vehical->modelname  =$modelname;
        $vehical->price  =$price;
        $vehical->odometerreading  =$odometerreading;
        $vehical->dom  =$dom;
        $vehical->gearbox   =$gearbox;
        $vehical->gearboxno   =$gearboxno;
        $vehical->engineno  =$engineno;
        $vehical->enginesize =$enginesize ;
        $vehical->keyno  =$keyno;
        $vehical->engine =$engine;
        $vehical->nogears =$nogears;
        $vehical-> save();
		
   		$colores = Input::get('color');
		$tbl_vehicale_colors = DB::table('tbl_vehicle_colors')->where('vehicle_id','=',$id)->delete();
		if(!empty($colores))
		{
			foreach ($colores as $key => $value)
			{
				$colorse = $colores[$key];
				$color1 = new tbl_vehicle_colors;
				$color1->vehicle_id = $id;
				$color1->color=$colorse;
				$color1->save();  	 
			}
		}
		$files = Input::file('image');
		if(!empty($files))
		{
			foreach($files as $file)
			{
				if(Input::hasFile('image'))
				{
					$filename = $file->getClientOriginalName();
					$file->move(public_path().'/vehicle/', $file->getClientOriginalName());
					$images = new tbl_vehicle_images; 
					$images->vehicle_id = $id;
					$images->image = $filename;
					$images->save();
				}
				
			}
		}
		else
		{
			$images = new tbl_vehicle_images; 
			$images->vehicle_id = $id;
			$images->image = "'avtar.png'";
			$images->save();
		}
		
        $descriptionsdata = Input::get('description');
        $tbl_vehicle_discription_records = DB::table('tbl_vehicle_discription_records')->where('vehicle_id','=',$id)->delete();
		if(!empty($descriptionsdata))
		{
			foreach($descriptionsdata as $key => $value)
			{
				$desc = $descriptionsdata[$key];
				$descriptions = new tbl_vehicle_discription_records;
				$descriptions->vehicle_id = $id;
				$descriptions->vehicle_description=$desc;
				$descriptions->save();
			}
		}
		return redirect('/vehicle/list')->with('message','Successfully Updated');
	 }

	//vehicle show
	public function vehicalshow($id)
	{
		$view_id = $id;
	 	$vehical=DB::table('tbl_vehicles')->where('id','=',$id)->first();
	 	$image=DB::table('tbl_vehicle_images')->where('vehicle_id','=',$id)->get()->toArray();
		if(!empty($image))
		{
			foreach ($image as $images)
			{
				// $image_name[] = "http://".$_SERVER['SERVER_NAME']."/garage/public/vehicle/".$images->image;
				$image_name[] = URL::to('/public/vehicle/'.$images->image);						
			}
		}
		else
		{
			$image_name[] = URL::to('/public/vehicle/avtar.png');
			
		}
		$available = json_encode($image_name);
	 	$col = DB::table('tbl_vehicle_colors')->where('vehicle_id','=',$id)->get()->toArray();
	 	$desription = DB::table('tbl_vehicle_discription_records')->where('vehicle_id','=',$id)->get()->toArray();
	 	return view('/vehicle/view',compact('vehical','image','col','desription','available','view_id'));
	
	}
	
	//get description
	public function getDescription()
	{
		$row_id = Input::get('row_id');
		$ids = $row_id+1;
		$html = view('vehicle.newdescription')->with(compact('row_id','ids'))->render();
		return response()->json(['success' => true, 'html' => $html]);
	 }
	
	//delete description
	public function deleteDescription()
	{
		$id=Input::get('description');
		$description=DB::table('tbl_vehicle_discription_records')->where('id','=',$id)->delete();
	}
	
	//get color
	public function getcolor()
	{
		$color_id = Input::get('color_id');
		$color = DB::table('tbl_colors')->get()->toArray();
		$idc=$color_id+1;
		
		$html = view('vehicle.newcoloradd')->with(compact('color_id','color','idc'))->render();
		return response()->json(['success' => true, 'html' => $html]);	
	}
	
	//color delete
	public function deletecolor()
	{
		$id=Input::get('color_id');
		$color=DB::table('tbl_vehicle_colors')->where('id','=',$id)->delete();
	}
	
	//get images
	public function getImages()
	{
		$image_id = Input::get('image_id');
		$idi=$image_id+1;
		?>
			<tr id="image_id_<?php echo $idi;?>">
									<td>
									<input type="file" id="tax_<?php echo $idi;?>"  name="image[]"  class="form-control dropify tax" data-max-file-size="5M" >
									<div class="dropify-preview">
										<span class="dropify-render"></span>
											<div class="dropify-infos">
												<div class="dropify-infos-inner">
													<p class="dropify-filename">
														<span class="file-icon"></span> 
														<span class="dropify-filename-inner"></span>
													</p>
												</div>
											</div>
									</div>								
									</td>							
									<td>
										<span class="trash_accounts" data-id="<?php echo $idi;?>"><i class="fa fa-trash"></i> Delete</span>
									</td>
									</tr>
									<script>

						$(document).ready(function(){
							// Basic
							$('.dropify').dropify();

							// Translated
							$('.dropify-fr').dropify({
								messages: {
									default: 'Glissez-déposez un fichier ici ou cliquez',
									replace: 'Glissez-déposez un fichier ou cliquez pour remplacer',
									remove:  'Supprimer',
									error:   'Désolé, le fichier trop volumineux'
								}
							});

							// Used events
							var drEvent = $('#input-file-events').dropify();

							drEvent.on('dropify.beforeClear', function(event, element){
								return confirm("Do you really want to delete \"" + element.file.name + "\" ?");
							});

							drEvent.on('dropify.afterClear', function(event, element){
								alert('File deleted');
							});

							drEvent.on('dropify.errors', function(event, element){
								console.log('Has Errors');
							});

							var drDestroy = $('#input-file-to-destroy').dropify();
							drDestroy = drDestroy.data('dropify')
							$('#toggleDropify').on('click', function(e){
								e.preventDefault();
								if (drDestroy.isDropified()) {
									drDestroy.destroy();
								} else {
									drDestroy.init();
								}
							})
						});
					
					</script>
		<?php
	}	
	
	//delete images
	public function deleteImages()
	{
		$id=Input::get('delete_image');
		$image=DB::table('tbl_vehicle_images')->where('id','=',$id)->delete();
	}
}