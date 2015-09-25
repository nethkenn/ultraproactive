<?php namespace App\Http\Controllers;
use DB;
use Request;
use App\Tbl_deduction;
use App\Tbl_country;
use App\Rel_deduction_country;
use Redirect;
use App\Classes\Admin;
use App\Classes\Log;
class AdminDeductionController extends AdminController
{
	public function index()
	{	
		$status = Request::input('archived');
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Deduction Maintenance");
		if($status == "")
		{
			$status = 0;
		}
		else
		{
			$status = 1;
		}

		$data['deduction'] = $this->getdata($status);
	
        return view('admin.maintenance.encashment_deduction',$data);
	}
	public function add()
	{
	 $data['country'] = $this->getcountry();
	 if(isset($_POST['amt']))
	 {
	 	$this->post(Request::input());
	 	return Redirect::to('admin/maintenance/deduction');
	 }
	 else
	 {
	 	Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Add Deduction Maintenance");
	 }
	 return view('admin.maintenance.encashment_deduction_add',$data);
	}
	public function edit()
	{
		$data['d'] = Tbl_deduction::where('deduction_id',Request::input('id'))->first();
		$data['country'] = $this->getcountry();
		


		if(isset($_POST['amt']))
		{
		 	$e = $this->repost(Request::input(),Request::input('id'));
	
	 		return Redirect::to('admin/maintenance/deduction');
		}
		else
		{
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Edit Deduction Maintenance id #".Request::input('id'));
		}

		return view('admin.maintenance.encashment_deduction_edit',$data);	
	}
	public function archive()
	{

	}
	public function restore()
	{

	}
	public function getdata($data)
	{
		$data =Tbl_deduction::where('tbl_deduction.archived',$data)->country()->get();
		return $data;
	}
	public function getcountry()
	{
		$data = Tbl_country::where('archived',0)->get();
		return $data;
	}
	// public function editgetcountry($c)
	// {
	// 	$data = Tbl_country::where('tbl_country.archived',0)->where('country_id','!=',$c)->get();
	// 	return $data;
	// }
	public function post($data)
	{
		$data['amt'] = str_replace(' ', '', $data['amt']);
		$inserts['deduction_amount'] = $data['amt']; 
		$inserts['deduction_label'] = $data['label'];
		$inserts['target_country'] = $data['country'];
		

		if(substr($data['amt'], -1) == "%")
		{
		   $inserts['percent'] = 1;
		   $sign = "Percentage";
		}
		else
		{
		   $inserts['percent'] = 0;
		   $sign = "Whole value";
		}	


		$id = Tbl_deduction::insertGetId($inserts);
		if($data['country'] == "All Country")
		{
			$country = Tbl_country::where('archived',0)->get();
			foreach($country as $key => $c)
			{
				$insert['deduction_id'] = $id;
				$insert['country_id'] = $c->country_id;
				Rel_deduction_country::insert($insert);
			}
		}
		else
		{
			$c = Tbl_country::where('country_id',$data['country'])->first();
			$insert['deduction_id'] = $id;
			$insert['country_id'] = $c->country_id;
			Rel_deduction_country::insert($insert);
		}

		$new = DB::table('rel_deduction_country')->where('deduction_id',$id)->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add Deduction id #".$id." = ".$sign,null,serialize($new));
	}
	public function repost($data,$id)
	{
		$old = DB::table('rel_deduction_country')->where('deduction_id',$id)->get();
		Rel_deduction_country::where('deduction_id',$id)->delete();
		$data['amt'] = str_replace(' ', '', $data['amt']);
		$inserts['deduction_amount'] = $data['amt']; 
		$inserts['deduction_label'] = $data['label'];
		$inserts['target_country'] = $data['country'];


		if(substr($data['amt'], -1) == "%")
		{
		   $inserts['percent'] = 1;
		   $sign = "Percentage";
		}
		else
		{
		   $inserts['percent'] = 0;
		   $sign = "Whole value";
		}	

		Tbl_deduction::where('deduction_id',$id)->update($inserts);
		if($data['country'] == "All Country")
		{
			$country = Tbl_country::where('archived',0)->get();
			foreach($country as $key => $c)
			{
				$insert['deduction_id'] = $id;
				$insert['country_id'] = $c->country_id;
				Rel_deduction_country::insert($insert);
			}
		}
		else
		{
			$c = Tbl_country::where('country_id',$data['country'])->first();
			$insert['deduction_id'] = $id;
			$insert['country_id'] = $c->country_id;
			Rel_deduction_country::insert($insert);
		}
		$new = DB::table('rel_deduction_country')->where('deduction_id',$id)->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Edit Deduction id #".Request::input('id')." to ".$sign,serialize($old),serialize($new));
	}
}