<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon\Carbon;
use Datatables;
use App\Tbl_membership;
use App\Tbl_product_discount;
use Validator;
use App\Classes\Log;
use App\Classes\Admin;
use App\Tbl_product;
class AdminMembershipController extends AdminController
{
	public function index()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Membership");
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
        								->addColumn('product_discount','<a href="admin/maintenance/membership/product_discount?id={{$membership_id}}">SET</a>')
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
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." view Edit Membership id #".$id);

		if(isset($_POST['membership_name']))
		{

			$rules['membership_name'] = 'required|unique:tbl_membership,membership_name,'.$id.',membership_id|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['membership_price'] = 'required|unique:tbl_membership,membership_price,'.$id.',membership_id|numeric|min:0';
			// $rules['discount'] = 'numeric|min:0|max:100';
			$rules['membership_entry'] = 'numeric|numeric|min:0|max:1';
			$rules['membership_upgrade'] = 'numeric|min:0|max:1';
			$rules['max_income'] = 'numeric|min:1';
			$rules['global_pool_sharing'] = 'numeric|min:0';
			// $rules['member_upgrade_pts'] = 'numeric|min:0';
			$message = [
				'product_name.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',
					];

			$validator = Validator::make(Request::input(),$rules,$message);
			
			if (!$validator->fails())
			{
				$old = DB::table('tbl_membership')->where('membership_id',$id)->first();
				$insert['membership_name'] = strtoupper(Request::input('membership_name'));
				$insert['membership_price'] = Request::input('membership_price');
				$insert['membership_entry'] = Request::input('membership_entry');
				$insert['membership_upgrade'] = Request::input('membership_upgrade');
				$insert['max_income'] = Request::input('max_income');
				// $insert['discount'] = Request::input('discount');
				$insert['slot_limit'] = Request::input('slot_limit');
				$insert['global_pool_sharing'] = Request::input('global_pool_sharing');
				// $insert['member_upgrade_pts'] = Request::input('member_upgrade_pts');
				$membership = Tbl_membership::where('membership_id',$id)->update($insert);

				$new = DB::table('tbl_membership')->where('membership_id',$id)->first();

				Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit Membership id #".$id,serialize($old),serialize($new));

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
				// $data['_error']['discount'] = $errors->get('discount');
				$data['_error']['slot_limit'] = $errors->get('slot_limit');
				$data['_error']['global_pool_sharing'] = $errors->get('global_pool_sharing');
				// $data['_error']['member_upgrade_pts'] = $errors->get('member_upgrade_pts');
			}

			
		}

		return view('admin.maintenance.membership_edit',$data);
	}

	public function product_discount()
	{
		$data['product_discount'] = Tbl_product_discount::where('membership_id',Request::input('id'))->product()->get();
		$data['_product'] = Tbl_product::where('archived',0)->get();
		$data['membership'] = Tbl_membership::where('membership_id',Request::input('id'))->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." view Set product membership discount id #".Request::input('id'));
		if(isset($_POST['product']))
		{
			$this->put_product_discounted(Request::input());
			$data['product_discount'] = Tbl_product_discount::where('membership_id',Request::input('id'))->product()->get();
			$data['_product'] = Tbl_product::where('archived',0)->get();
			$data['membership'] = Tbl_membership::where('membership_id',Request::input('id'))->first();
		}

		return view('admin.maintenance.membership_product_discount',$data);
	}

	public function put_product_discounted($data)
	{	
		$id = $data['id'];

		$old = DB::table('tbl_product_discount')->where('membership_id',$id)->get();

		Tbl_product_discount::where('membership_id',$id)->delete();
		foreach($data['product'] as $key => $p)
		{
			$insert['product_id'] = $key;
			$insert['discount'] = $p['quantity'];
			$insert['membership_id'] = $id;
			Tbl_product_discount::insert($insert);
		}

		$new = DB::table('tbl_product_discount')->where('membership_id',$id)->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." change the Set of product discount id membership #".$id,serialize($old),serialize($new));
	}

	public function add()
	{

		$data["page"] = "Add Product Maintenance";
		$data['_error'] = null;

		if(isset($_POST['membership_name']))
		{

			$rules['membership_name'] = 'required|unique:tbl_membership,membership_name|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['membership_price'] = 'required|unique:tbl_membership,membership_price|numeric|min:0';
			// $rules['discount'] = 'numeric|min:0|max:100';
			$rules['max_income'] = 'numeric|min:1';
			$rules['global_pool_sharing'] = 'numeric|min:0';
			// 	$rules['member_upgrade_pts'] = 'numeric|min:0';


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
				// $insert['discount'] = Request::input('discount');
				$insert['max_income'] = Request::input('max_income');
				$insert['slot_limit'] = Request::input('slot_limit');
				$insert['global_pool_sharing'] = Request::input('global_pool_sharing');
				// $insert['member_upgrade_pts'] = Request::input('member_upgrade_pts');
				// dd($insert);
				$membership = new Tbl_membership($insert);
			
				$membership->save();

				$new = DB::table('tbl_membership')->where('membership_id',$membership->membership_id)->first();
				Log::Admin(Admin::info()->account_id,Admin::info()->account_username." add membership #".$membership->membership_id,null,serialize($new));
				return Redirect('admin/maintenance/membership');
			}
			else
			{

				$errors =  $validator->errors();
				
				$data['_error']['membership_name'] = $errors->get('membership_name');
				$data['_error']['membership_price'] = $errors->get('membership_price');
				// $data['_error']['discount'] = $errors->get('discount');
				$data['_error']['membership_entry'] = $errors->get('membership_entry');
				$data['_error']['membership_upgrade'] = $errors->get('membership_upgrade');
				$data['_error']['max_income'] = $errors->get('max_income');
				$data['_error']['slot_limit'] = $errors->get('slot_limit');
				$data['_error']['global_pool_sharing'] = $errors->get('global_pool_sharing');
				// 	$data['_error']['member_upgrade_pts'] = $errors->get('member_upgrade_pts');

			}

			
		}

		return view('admin.maintenance.membership_add',$data);
	}


	public function archive_membership()
	{	
		$id = Request::input('id');
		$data['query'] = Tbl_membership::where('membership_id',$id)->update(['archived'=>'1']);
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive membership #".$id);
		return json_encode($data);
	}

	public function restore_membership()
	{	
		$id = Request::input('id');
		$data['query'] = Tbl_membership::where('membership_id',$id)->update(['archived'=>'0']);
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." restore membership #".$id);
		return json_encode($data);
	}

}