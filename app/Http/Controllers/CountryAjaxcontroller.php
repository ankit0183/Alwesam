<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth; 
use DB;
use \Validator;
use Illuminate\Support\Facades\Input;

class CountryAjaxcontroller extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//get state
    public function getstate()
	{ 
			$id = Input::get('countryid');
			
			$states = DB::table('tbl_states')->where('country_id','=',$id)->get()->toArray();
			if(!empty($states))
			{
				foreach($states as $statess)
				{ ?>
				
				<option value="<?php echo  $statess->id; ?>"  class="states_of_countrys"><?php echo $statess->name; ?></option>
				
				<?php }
			}
	}
	
	//get city
	public function getcity()
	{ 
			$stateid = Input::get('stateid');
			$citie = DB::table('tbl_cities')->where('state_id','=',$stateid)->get()->toArray();
			if(!empty($citie))
			{
				foreach($citie as $cities)
				{ ?>
				
				<option value="<?php echo  $cities->id; ?>"  class="cities"><?php echo $cities->name; ?></option>
				
				<?php }
			}
	}
}
