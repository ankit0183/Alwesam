<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Auth; 
use DB;
use \Validator;
use Illuminate\Support\Facades\Input;
use App\User;
use Mail;
use Illuminate\Mail\Mailer;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordResetController extends Controller
{
	//password reset link
	public function forgotpassword(Request $request)
	{	
		$token=Input::get('_token');
		$email=Input::get('email');
		$user=DB::table('users')->where('email','=',$email)->first();
		
		if($user != '')
		{
			$name=$user->name;
			$pass=$user->password;	
			
			$actual_link = $_SERVER['HTTP_HOST'];
			$startip='0.0.0.0';
			$endip='255.255.255.255';
			$link = url('passwords/reset/'.$token.'/'.$email);
			 $email_content="To Reset Your Password Please Click...".$link;
			$mail_sub="Reset Password";
			$mail_send_from="sales@dasinfomedia.com";
			
			if(($actual_link == 'localhost' || $actual_link == 'localhost:8080') || ($actual_link >= $startip && $actual_link <=$endip ))
			{
				$data = array(		
						'email' =>$email,
						'password'=>$pass,
						'name' => $name,
						'token'=>$token
						);
						Mail::send('home',$data, function ($message) use ($data){
							$message->from('sales@dasinfomedia.com', 'Reset Password');
							$message->to($data['email'])->subject("Reset Password");
						});
			}
			else
			{
				//Live format email
				
					$headers = 'Content-type: text/plain; charset=iso-8859-1' . "\r\n";
					$headers .= 'From:'. $mail_send_from . "\r\n";
			
					$data = mail($email,$mail_sub,$email_content,$headers);
			}
			
			
				return redirect('/password/reset')->with('message','Your password reset link has been sent to your email address !');
			
		}
		else
		{
			
		return redirect('/password/reset')->with('message','Email Address you have entered is not match with our records !');
		}
	}
	
	//reset password form
	public function geturl($token,$email)
	{
		return view('auth.passwords.reset',compact('token','email'));
	}
	
	//new password
	public function passwordnew(Request $request)
	{
		$this->validate($request, [
		'password' => 'required|min:6|max:12|regex:/^(?=.*[a-zA-Z])(?=.*\d).+$/',
		'password_confirmation' => 'required|same:password',
		'password.required'=>'Password Field is required',
		'password_confirmation.required'=>'Confirm Password Field is required',
		'password_confirmation.same'=>'Confirm Password must be same as password',
		]);
		$email=Input::get('email');
		$user=DB::table('users')->where('email','=',$email)->first();
		$id = $user->id;

		$user = User::find($id);
		$user->password=bcrypt(Input::get("password_confirmation"));
		$user->save();
		return redirect('/')->with('message','Your Password Has Been Successfully Changed !');
	} 
}