<?php

namespace App\Http\Controllers;
use App\User;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests;
use DB;
use URL;
use Mail;
class Profilecontroller extends Controller
{	
	public function __construct()
    {
        $this->middleware('auth');
    }
	
	//profile list
    public function index()
	{	
	    $profile=DB::table('users')->where('id','=',Auth::User()->id)->first();
		
		return view('profile.list',compact('profile'));
	}

	//profile update
	public function update($id, Request $request)
	{
		$this->validate($request, [  
         'firstname' => 'regex:/^[(a-zA-Z\s)]+$/u',
		 'lastname'=>'regex:/^[(a-zA-Z\s)]+$/u',
		 'password'=>'min:6|max:12|regex:/(^[A-Za-z0-9]+$)+/',
         'mobile'=>'max:15|min:10|regex:/^[- +()]*[0-9][- +()0-9]*$/',
		 'password_confirmation' => 'same:password',
		 'image' => 'image|mimes:jpg,png,jpeg',
		 // 'dob' => 'required',
	      ]);
		  
		 $usimgdtaa = DB::table('users')->where('id','=',$id)->first();
			 $email = $usimgdtaa->email;

				if($email != Input::get('email'))
				{
				$this->validate($request, [
					'email' => 'required|email|unique:users'
				   
				]);
				}
		   
		$firstname=Input::get('firstname');
		$lastname=Input::get('lastname');
		
		$gender=Input::get('gender');
		$dd=Input::get('dob');
		if(!empty($dd))
		{
			if(getDateFormat()== 'm-d-Y')
			{
				$dob=date('Y-m-d',strtotime(str_replace('-','/',Input::get('dob'))));
			}
			else
			{
				$dob=date('Y-m-d',strtotime(Input::get('dob')));
			}
		}
		else
		{
			$dob="";
		}
		$email=Input::get('email');
		$password=(Input::get('password'));
		$mobile=Input::get('mobile');
		
		$profile = User::find($id);
		$profile->name=$firstname;
		$profile->lastname=$lastname;
		$profile->gender=$gender;
		$profile->birth_date=$dob;	
		$profile->email=$email;
	
		if(!empty($password)){
		$profile->password=bcrypt($password);
		}
		
		$profile->mobile_no=$mobile;
		if(!empty(Input::hasFile('image')))
			{
			$file= Input::file('image');
			$filename=$file->getClientOriginalName();
			
			if($usimgdtaa->role == "admin")
			{
				$file->move(public_path().'/admin/', $file->getClientOriginalName());
			}
			elseif($usimgdtaa->role == "Customer")
			{
				$file->move(public_path().'/customer/', $file->getClientOriginalName());	
			}
			elseif($usimgdtaa->role == "employee")
			{
				$file->move(public_path().'/employee/', $file->getClientOriginalName());	
			}
			elseif($usimgdtaa->role == "supportstaff")
			{
				$file->move(public_path().'/supportstaff/', $file->getClientOriginalName());	
			}
			elseif($usimgdtaa->role == "accountant")
			{
				$file->move(public_path().'/accountant/', $file->getClientOriginalName());	
			}
			$profile->image=$filename;
			}
		 $profile->save();
		//email format
			$logo = DB::table('tbl_settings')->first();
			$systemname=$logo->system_name;
			if($profile -> save())
			{
				$emailformat=DB::table('tbl_mail_notifications')->where('notification_for','=','User_registration')->first();
				$mail_format = $emailformat->notification_text;		
				$mail_subjects = $emailformat->subject;		
				$mail_send_from = $emailformat->send_from;
				$search1 = array('{ system_name }');
				$replace1 = array($systemname);
				$mail_sub = str_replace($search1, $replace1, $mail_subjects);
				
				 $systemlink = URL::to('/');
				
				$search = array('{ system_name }','{ user_name }', '{ email }', '{ Password }', '{ system_link }' );
				$replace = array($systemname, $firstname, $email, $password, $systemlink);
				
				$email_content = str_replace($search, $replace, $mail_format);
				
												
			    $actual_link = $_SERVER['HTTP_HOST'];
			    $startip='0.0.0.0';
			    $endip='255.255.255.255';
				if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
				{
					//local format email
				
					$data=array(
					'email'=>$email,
					'mail_sub1' => $mail_sub,
					'email_content1' => $email_content,
					'emailsend' =>$mail_send_from, 
					);
							$data1 = Mail::send('customer.customermail',$data, function ($message) use ($data){

							$message->from($data['emailsend'],'noreply');

							$message->to($data['email'])->subject($data['mail_sub1']);

						});
				}
				else
				{						
						//Live format email
					$headers = 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
					$headers .= 'From:'. $mail_send_from . "\r\n";
					mail($email,$mail_sub,$email_content,$headers);
				}
			}
		return redirect('/setting/profile')->with('message','Successfully Updated');	
	}	
}	