<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon\Carbon;
use Datatables;
use App\Tbl_membership;

use Validator;

class AdminMembershipController extends AdminController
{
	public function index()
	{
        return view('admin.maintenance.membership');
	}
	public function data()
	{
        $account = Tbl_membership::select('*')->where('tbl_membership.archived',Request::input('archived'));

        $text = Request::input('archived') ? 'RESTORE' : 'ARCHIVE';
		$class = Request::input('archived') ? 'restore-membership' : 'archive-membership';	
		
        return Datatables::of($account)	->addColumn('entry','<input type="checkbox" disabled="disabled" {{ $membership_entry == 1 ? "checked" : "" }}>')
        								->addColumn('upgrade','<input type="checkbox" disabled="disabled" {{ $membership_upgrade == 1 ? "checked" : "" }}>')
        								->addColumn('edit','<a href="admin/maintenance/membership/edit?id={{$membership_id}}">EDIT</a>')
        								->addColumn('archive','<a class="'.$class.'" href="#" membership-id="{{ $membership_id}}">'.$text.'</a>')
        								->make(true);
	
	}
	public function edit()
	{



		$data["page"] = "Edit Membership Maintenance";
		$data['_error'] = null;
		$membership = Tbl_membership::findOrFail(Request::input('id'));
		$id = $membership->membership_id;
		$data['membership'] = $membership;
		

		if(isset($_POST['membership_name']))
		{

			$rules['membership_name'] = 'required|unique:tbl_membership,membership_name,'.$id.',membership_id|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['membership_price'] = 'required|unique:tbl_membership,membership_price,'.$id.',membership_id|numeric|min:0';
			$rules['discount'] = 'numeric|min:0|max:100';
			$rules['membership_entry'] = 'numeric|numeric|min:0|max:1';
			$rules['membership_upgrade'] = 'numeric|min:0|max:1';
			$rules['max_income'] = 'numeric|min:1';
			$rules['member_upgrade_pts'] = 'numeric|min:0';
			$message = [
				'product_name.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',
					];

			$validator = Validator::make(Request::input(),$rules,$message);
			
			if (!$validator->fails())
			{

				$insert['membership_name'] = strtoupper(Request::input('membership_name'));
				$insert['membership_price'] = Request::input('membership_price');
				$insert['membership_entry'] = Request::input('membership_entry');
				$insert['membership_upgrade'] = Request::input('membership_upgrade');
				$insert['max_income'] = Request::input('max_income');
				$insert['discount'] = Request::input('discount');
				$insert['member_upgrade_pts'] = Request::input('member_upgrade_pts');
				$membership = Tbl_membership::where('membership_id',$id)->update($insert);
				return Redirect('admin/maintenance/membership');
			}
			else
			{
				$errors =  $validator->errors();
				$data['_error']['membership_name'] = $errors->get('membership_name');
				$data['_error']['membership_price'] = $errors->get('membership_price');
				$data['_error']['membership_entry'] = $errors->get('membership_entry');
				$data['_error']['membership_upgrade'] = $errors->get('membership_upgrade');
				$data['_error']['max_income'] = $errors->get('max_income');
				$data['_error']['discount'] = $errors->get('discount');
				$data['_error']['member_upgrade_pts'] = $errors->get('member_upgrade_pts');
			}

			
		}

		return view('admin.maintenance.membership_edit',$data);
	}


	public function add()
	{

		$data["page"] = "Add Product Maintenance";
		$data['_error'] = null;

		if(isset($_POST['membership_name']))
		{

			$rules['membership_name'] = 'required|unique:tbl_membership,membership_name|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['membership_price'] = 'required|unique:tbl_membership,membership_price|numeric|min:0';
			$rules['discount'] = 'numeric|min:0|max:100';
			$rules['max_income'] = 'numeric|min:1';
			$rules['member_upgrade_pts'] = 'numeric|min:0';


			$message = [
				'product_name.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',
					];

			$validator = Validator::make(Request::input(),$rules,$message);
			
			if (!$validator->fails())
			{

				$insert['membership_name'] = strtoupper(Request::input('membership_name'));
				$insert['membership_price'] = Request::input('membership_price');
				$insert['membership_entry'] = Request::input('membership_entry');
				$insert['membership_upgrade'] = Request::input('membership_upgrade');
				$insert['discount'] = Request::input('discount');
				$insert['max_income'] = Request::input('max_income');
				$insert['member_upgrade_pts'] = Request::input('member_upgrade_pts');
				// dd($insert);
				$membership = new Tbl_membership($insert);
			
				$membership->save();

				return Redirect('admin/maintenance/membership');
			}
			else
			{

				$errors =  $validator->errors();
				
				$data['_error']['membership_name'] = $errors->get('membership_name');
				$data['_error']['membership_price'] = $errors->get('membership_price');
				$data['_error']['discount'] = $errors->get('discount');
				$data['_error']['membership_entry'] = $errors->get('membership_entry');
				$data['_error']['membership_upgrade'] = $errors->get('membership_upgrade');
				$data['_error']['max_income'] = $errors->get('max_income');
				$data['_error']['member_upgrade_pts'] = $errors->get('member_upgrade_pts');

			}

			
		}

		return view('admin.maintenance.membership_add',$data);
	}


	public function archive_membership()
	{	

		$id = Request::input('id');
		$data['query'] = Tbl_membership::where('membership_id',$id)->update(['archived'=>'1']);

		return json_encode($data);
	}

	public function restore_membership()
	{	
		$id = Request::input('id');
		$data['query'] = Tbl_membership::where('membership_id',$id)->update(['archived'=>'0']);

		return json_encode($data);
	}

}