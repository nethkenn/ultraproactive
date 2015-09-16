<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Classes\Compute;
use Crypt;
class AdminDevelopersController extends AdminController
{
	public function migration()
	{
		$id_code = 'ultratop';
		//tbl_members , tbl_binary_points , tbl_binary_pairings , tbl_encashment, tbl_bonuses
		$right = DB::table('tbl_binary_points')->select('points', DB::raw('SUM(points) as total_amount'))->where('id_code',$id_code)->where('position',"right")->first();
		$left  = DB::table('tbl_binary_points')->select('points', DB::raw('SUM(points) as total_amount'))->where('id_code',$id_code)->where('position',"left")->first();
		$minus = DB::table('tbl_binary_pairings')->select('points', DB::raw('SUM(points) as total_amount'))->where('username',$id_code)->first();
		
		$right = $right->total_amount - $minus->total_amount;
		$left  = $left->total_amount - $minus->total_amount;
		
		$slot_wallet  = DB::table('tbl_bonuses')   ->select('amount', DB::raw('SUM(amount) as total_amount'))->where('recepient_code',$id_code)
											       ->whereIn('bonus_type',['PAIR','DSI'])
											       ->first();
        $slot_gc      = DB::table('tbl_bonuses')   ->select('amount', DB::raw('SUM(amount) as total_amount'))->where('recepient_code',$id_code)
											       ->whereIn('bonus_type',['DGC','PGC'])
											       ->first();
		$minus_wallet = DB::table('tbl_encashment')->select('amount', DB::raw('SUM(amount) as total_amount'))->where('id_code',$id_code)
											  	   ->first();
		$minus_gc 	  = DB::table('tbl_encashment')->select('gc', DB::raw('SUM(gc) as total_amount'))->where('id_code',$id_code)
											  	   ->first();

		$slot_wallet  = $slot_wallet->total_amount - $minus_wallet->total_amount;

		$slot_gc = $slot_gc->total_amount - $minus_gc->total_amount;

		dd($right,$left,$slot_wallet,$slot_gc);
		// Continue processing...



		if(Request::input('migrate'))
		{

			DB::table('tbl_account')->delete();
			DB::table('tbl_slot')->delete();

			$get = DB::table('tbl_members')->where('tbpi_ctr','!=',1)->get();
			foreach($get as $key => $g)
			{



		       	$password =   DB::table('tbl_members')->select((DB::raw("DECODE(password, 'yourtheboss2014') AS decoded")))
			      									  ->selectRaw('password as encoded')
												      ->where('tbpi_ctr', '=', $g->tbpi_ctr)->first();

			    if($g->relationship == "NA" || $g->relationship == "-" || $g->relationship == "N/A" || $g->relationship == "n/a")
			    {
			    	$bene_id = null;
			    	$beneficiary_id = null;
			    }
			    else
			    {
			    	$bene_id = DB::table('tbl_beneficiary_rel')->where('relation',$g->relationship)->first();
			    	if(!$bene_id)
			    	{
			    		$bene_id = DB::table('tbl_beneficiary_rel')->where('relation',$g->relationship)->insertGetId(['relation'=>$g->relationship]);
			    	}
			    	else
			    	{
			    		$bene_id = $bene_id->beneficiary_rel_id;
			    	}

			    	$beneficiary_id = DB::table('tbl_beneficiary')->insertGetId(['whole_name'=>$g->beneficiary,'beneficiary_rel_id'=>$bene_id]);


			    }



				if($g->sex == "F")
				{
					$gender = "Female";
				}								      
				else
				{
					$gender = "Male";
				}

				if($g->address == "NA" || $g->address == "-" || $g->address == "N/A" || $g->address == "n/a")
				{
					$address = "";
				}
				else
				{
					$address = $g->address;
				}

				if($g->middlename == "NA" || $g->middlename == "N/A" || $g->middlename == "-" || $g->middlename == "n/a")
				{
					$fullname = $g->firstname." ".$g->lastname;
				}
				else
				{
					$fullname = $g->firstname." ".$g->middlename." ".$g->lastname;
				}

				if($g->landline == "NA" || $g->landline == "-" || $g->landline == "N/A" || $g->landline == "n/a")
				{
					$landline = "";
				}
				else
				{
					$landline = $g->landline;
				}

				if($g->mobile == "NA" || $g->mobile == "-" || $g->mobile == "N/A" || $g->landline == "n/a")
				{
					$mobile = "";
				}
				else
				{
					$mobile = $g->mobile;
				}

	
				$insert['account_name'] = $fullname;
				$insert['account_email'] = $g->email;
				$insert['account_username'] = $g->username;
				$insert['account_contact_number'] = $mobile;
				$insert['account_country_id'] = 
				$insert['birthday'] = $g->birthdate;
				$insert['telephone'] = $landline;
				$insert['gender'] = $gender;
				$insert['address'] = $address;
				$insert['account_password'] = Crypt::encrypt($password);
				$insert['custom_field_value'] = " ";
				$insert['image'] = "";
				$insert['account_created_from'] = "Old System";
				$insert['archived'] = 0;
				$insert['beneficiary_id'] = $beneficiary_id;
				$insert['account_date_created'] = $g->date_registered;

				$account_id = DB::table('tbl_account')->insertGetId($insert);

				$insert = null;

				$slot_wallet = 0;
				$slot_gc = 0;

				$oldwallet = DB::table('tbl_bonuses')->where('recepient_code',$g->username)->get();

				/*DGC,DSI,PAIR,PGC*/

				foreach($oldwallet as $old)
				{
					if($old->bonus_type == "DGC")
					{
						$slot_gc = $slot_gc + $old->amount;
					}
					elseif ($old->bonus_type == "PGC") 
					{
						$slot_gc = $slot_gc + $old->amount;
					}
					elseif ($old->bonus_type == "PAIR") 
					{
						$slot_wallet = $slot_wallet + $old->amount;
					}
					elseif ($old->bonus_type == "DSI") 
					{
						$slot_wallet = $slot_wallet + $old->amount;
					}
				} 


				if($g->username=="ULTRATOP")
				{
					$insert['slot_owner'] = $account_id;
					$insert['slot_membership'] = 1;
					if($g->status_type == "PAID")
					{
						$slot_type = "PS";
					}
					else if($g->status_type == "FREE")
					{
						$slot_type = "FS";
					}
					else if($g->status_type == "CD")
					{
						$slot_type = "CD";
					}
					$insert["slot_type"] = $slot_type;
					$insert["slot_rank"] = 1;
					$insert["slot_sponsor"] = 999999999;
					$insert["slot_placement"] = 999999999;
					$insert["slot_position"] = "left";
					$insert["slot_wallet"] = $slot_wallet;
					$insert["slot_gc"] = $slot_gc;
					DB::table('tbl_slot')->insert($insert);
				}
				else
				{

				}

				$insert = null;
			}
			

		}

        return view('admin.developer.migration');
	}
	
}