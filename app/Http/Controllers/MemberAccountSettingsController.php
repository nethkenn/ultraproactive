<?php namespace App\Http\Controllers;
use Request;
use App\Tbl_lead;
use App\Tbl_account;
use Carbon\Carbon;
use App\Classes\Customer;
use Redirect;
use Session;
use DB;
use Validator;
use Crypt;
use WideImage;
class MemberAccountSettingsController extends MemberController
{
	public function index()
	{	
		$data['error'] = Session::get('message');
		$data['success']  = Session::get('success');
		$data['acc'] = Tbl_account::where('account_id',Customer::id())->first();
		$data['country'] = DB::table('tbl_country')->where('archived',0)->get();
		$customer_birthday = $data['acc']->birthday;
		$data["customer_birthday"] = explode('-', $customer_birthday, 3);



		if(isset($_POST['forsubmit']))
		{	

			$sample = Request::input();
			// foreach($sample as $s)
			// {
			// 	if($s == "")
			// 	{   
			// 		$data = "Please fill all the blanks";
			// 		return Redirect::to('member/settings')->with('message',$data);
			// 	}
			// }

			$data = $this->checkifvalidate(Request::input());
			return Redirect::to('member/settings')->with('message',$data);
		}

		if(isset($_POST['cpass']))
		{

		         	$check_pass = Request::input("old");
		         	$new_pass = Request::input("new");
		         	$rnew_pass = Request::input("rnew");
		         	$data['info'] = Customer::info();
					$admin_id = $data['info']->account_id;
					$password = $data['info']->account_password;
					$password = Crypt::decrypt($password);
					$password_hashed = $new_pass;

					if ($check_pass == $password && $new_pass != "")
					{
						if($new_pass == $rnew_pass)
						{
							$password_hashed = Crypt::encrypt($password_hashed);
							DB:: table ('tbl_account') -> where('account_id','=',$data['info']->account_id) 
		                                  			   -> update(['account_password'=> $password_hashed]);           			                  			  
						}
						else
						{
							$message =  "Password Mismatch";
							return Redirect::to('member/settings')->with('message',$message);
						}
					}
					else if($new_pass != "")
					{
						$message =  "Please put a new password";
						return Redirect::to('member/settings')->with('message',$message);						
					}
					else
					{
						$message =  "Old Password is incorrect";
						return Redirect::to('member/settings')->with('message',$message);
					}

		}

        return view('member.member_settings',$data);
	}
	public function checkifvalidate($data)
	{
		$data2 = null;
		$birthday = $data["ryear"] . "-" . $data["rmonth"]. "-" . $data["rday"];

				$validator = Validator::make(
				[
					// 'account_name' => $data['fname'],
					'account_email'=>$data['email'],
					'account_country_id'=>$data['country'],
					'phone' => $data['cp'],			
					'telephone' => $data['tp'],
					'address' => $data['address'],
					'gender' => $data['gender'],

				],
				[
					// 'account_name' => 'required|min:5|regex:/^[a-zA-Z\s]*$/',
					'account_country_id' => 'required', 
					// 'phone' => 'required',
					'gender' => 'required',
					// 'telephone' => 'required',
					// 'address' => 'required|min:6',
					// 'customer_province' => "required|exists:tbl_location,location_id",
					// 'customer_municipality' => "required|exists:tbl_location,location_id",
					// 'customer_barangay' => "required|exists:tbl_location,location_id",

				]
				);

				$check = DB::table('tbl_account')->where('account_email',$data['email'])->first();
				if(isset($check))
				{
					if($check->account_email == $data['email'])
					{
						$check = true;
					}
					else
					{
						$check = false;
					}
				}
				else
				{
					$check = true;
				}

			if(!$validator->fails() && $check == true)
			{	

					$insert['account_email']		  = $data['email'];
					$insert['account_contact_number'] = $data['cp'];
					$insert['birthday'] = $birthday;
					$insert['account_country_id']	  = $data['country'];
					// $insert['account_name']	 		  = $data['fname'];
					$insert['gender']   =  $data['gender'];
					$insert['telephone']   = $data['tp'];
					$insert['address']   = $data['address'];
					$info = DB::table('tbl_account')->where('account_id',Customer::id())->update($insert);

			}
			else
			{
					$data2['error'] = $validator->messages();
					return $data2;
			}		

	}
	public function upload()
	{
   		include 'resources/assets/wideimage/WideImage.php';

		$target_dir = "resources/assets/uploads_profile_pic/";

		if(!isset($_FILES["fileToUpload"]["name"]))
		{
		        $data = "Sorry, there was an error uploading your file.";
		        return Redirect::to('member/settings')->with('message',$data);
		}
		$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
		$uploadOk = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		$target_file = $target_dir . basename((date('Y-m-d-H-i-s-u')).'.'.$imageFileType);

		// Check if image file is a actual image or fake image
		if(isset($_POST["submit"])) {
			if ($_FILES["fileToUpload"]["tmp_name"] == null) {
				$data = "Please upload an image.";
 				  return Redirect::to('member/settings')->with('message',$data);
			}
		    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
		    if($check !== false) {
		        $data = "File is an image - " . $check["mime"] . ".";
		        $uploadOk = 1;
		    } else {
		        $data = "File is not an image.";
		        $uploadOk = 0;
		        return Redirect::to('member/settings')->with('message',$data);
		    }
		}
		$ctr = 0;
		for($ulet=false;$ulet!=true;$ctr++)
		{
			if (file_exists($target_file)) {
				$target_file = $target_dir . basename((date('Y-m-d-H-i-s-u')).'-'.$ctr.'.'.$imageFileType);
			}	
			else
			{
				
				$ulet = true;
			}		
		}
		// Check if file already exists

		// Check file size
		if ($_FILES["fileToUpload"]["size"] > 500000) {
		    $data = "Sorry, your file is too large.";
		    $uploadOk = 0;
		    return Redirect::to('member/settings')->with('message',$data);
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
		    $data = "Sorry, only JPG, JPEG, PNG  files are allowed.";
		    $uploadOk = 0;
		    return Redirect::to('member/settings')->with('message',$data);
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
		    $data =  "Sorry, your file was not uploaded.";
		    return Redirect::to('member/settings')->with('message',$data);
		// if everything is ok, try to upload file
		} else {
		    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {

		    	$getcurrentimage = DB::table('tbl_account')->where('account_id',Customer::id())->first();

				if(file_exists($getcurrentimage->image))
				{
			    		unlink($getcurrentimage->image);
	    				WideImage::load($target_file)
	    				->resize(300, 300, 'outside')
						->crop('center', 'center', 300, 300)->saveToFile($target_file);
				    	DB::table('tbl_account')->where('account_id',Customer::id())->update(['image'=>$target_file]);
				}
				else
				{
					    WideImage::load($target_file)
	    				->resize(300, 300, 'outside')
						->crop('center', 'center', 300, 300)->saveToFile($target_file);
				    	DB::table('tbl_account')->where('account_id',Customer::id())->update(['image'=>$target_file]);	    	
				}

		    	$data = "Successfuly changed";
		        return Redirect::to('member/settings')->with('success',$data);
		    } else {
		        $data = "Sorry, there was an error uploading your file.";
		        return Redirect::to('member/settings')->with('message',$data);
		    }
		}

	}

}