<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use Illuminate\Http\Request;
use Request;
use App\Tbl_membership;
use App\Tbl_code_type;
use App\Tbl_product_package;
use App\Tbl_account;
use App\Tbl_inventory_update_type;
use App\Tbl_membership_code;
use Carbon\Carbon;
use Datatables;
use Validator;

class AdminCodeController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		// $membership_code = Tbl_membership_code::getCodeType()->getMembership()->getPackage()->getInventoryType()->get();

		// dd($membership_code);


		// $membership_code = Tbl_membership_code::getUsedBy()->get();
		// dd($membership_code);


		// foreach ($membership_code as $key => $value) {
		// 	echo $value->account_name;
		// }

		// dd($membership_code);
		$data['_account'] = Tbl_account::all();

		 return view('admin.maintenance.code', $data);
	}



	public function ajax_get_membership_code()
    {


        $membership_code = Tbl_membership_code::getCodeType()->getMembership()->getPackage()->getInventoryType()->getUsedBy();
         // $membership_code = Tbl_membership_code::get();
        if(Request::input('status')==null)
        {
        	$membership_code->whereNull ('tbl_account.account_id')->where('used',0)->where('blocked',0);
        }

        if(Request::input('status')=='unused')
        {
        	$membership_code->where('used',0)->where('blocked',0)->whereNotNull('tbl_account.account_id');

        }

       	if(Request::input('status')=='used')
        {
        	$membership_code->where('used',1)	->where('blocked',0)
        										->where('tbl_account.account_id','<>','')
        										->whereNotNull('tbl_account.account_id');
        }

        if(Request::input('status')=='blocked')
        {
        	$membership_code->where('blocked',1);
        					
        }


        $membership_code->groupBy('tbl_membership_code.code_pin')->get();


        return Datatables::of($membership_code)	

        ->addColumn('delete','<a href="#" class="block-membership-code" membership-code-id ="{{$code_pin}}">BLOCK</a>')
        								->addColumn('transfer','<a class="transfer-membership-code"  href="#" membership-code-id="{{$code_pin}}" account-id="{{$account_id}}">TRANSFER</a>')
        								->editColumn('created_at','{{$created_at->format("F d, Y g:ia")}}')
        								->editColumn('inventory_update_type_id','<input type="checkbox" {{$inventory_update_type_id == 1 ? \'checked="checked"\' : \'\'}} name="" value="" readonly disabled>')
        								->editColumn('account_name','{{$account_name or "No owner"}}')
        								->make(true);


    }


	public function code_generator()
	{
		
		$chars="0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$res = "";
		for ($i = 0; $i < 8; $i++) {
		    $res .= $chars[mt_rand(0, strlen($chars)-1)];
		}

		return $res;

	}


	public function check_code()
	{



		$stop=false;
		while($stop==false)
		{
			$code = $this->code_generator();

			$check = Tbl_membership_code::where('code_activation', $code )->first();
			if($check==null)
			{
				$stop = true;
			}
		}

		return $code;
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function add_code()
	{

		$data['_error'] = null;
		$data['_membership'] = Tbl_membership::all();
		$data['_code_type'] = Tbl_code_type::all();
		$data['_prod_package'] = Tbl_product_package::all();
		$data['_account'] = Tbl_account::all();
		$data['_inventory_update_type'] = Tbl_inventory_update_type::all();

		if(isset($_POST['membership_id']))
		{

			$rules['code_type_id'] = 'required|exists:tbl_code_type,code_type_id';
			$rules['membership_id'] = 'required|exists:tbl_membership,membership_id';
			$rules['product_package_id'] = 'required|exists:tbl_product_package,product_package_id';
			$rules['inventory_update_type_id'] = 'required|exists:tbl_inventory_update_type,inventory_update_type_id';
			$rules['account_id'] = 'exists:tbl_account,account_id';
			$rules['code_multiplier'] = 'min:1|integer';
			

			$validator = Validator::make(Request::input(),$rules);
			
			if (!$validator->fails())
			{
				for ($i=0; $i < Request::input('code_multiplier'); $i++)
				{ 
					$membership_code = new Tbl_membership_code(Request::input());
					$membership_code->code_activation = $this->check_code();
					$membership_code->account_id =  Request::input('account_id') ?: null;
					$membership_code->created_at = Carbon::now();
					$membership_code->save();
				}


				return Redirect('admin/maintenance/codes');

			}
			else
			{
				$error =  $validator->errors();

				$data['_error']['code_type_id'] = $error->get('code_type_id');
				$data['_error']['membership_id'] = $error->get('membership_id');
				$data['_error']['product_package_id'] = $error->get('product_package_id');
				$data['_error']['inventory_update_type_id'] = $error->get('inventory_update_type_id');
				$data['_error']['account_id'] = $error->get('account_id');
				$data['_error']['code_multiplier'] = $error->get('code_multiplier');


			}

			
		}

		return view('admin.maintenance.code_add',$data);
	}

	public function block()
	{	


		$query = Tbl_membership_code::where('code_pin', Request::input('code_pin'))
										->where('used', 0)
										->firstOrFail();
		$query->update(['blocked'=>1]);

		return json_encode($query);
	}

	public function transfer_code()
	{	


		$account_id = intval(Request::input('account_id'));
		

		$query = Tbl_membership_code::where('code_pin', Request::input('code_pin'))
										->where('used', 0)
										->where('blocked', 0)
										->firstOrFail();
									
		if(!empty($account_id))
		{
			$query->update(['account_id'=>Request::input('account_id')]);
		}

		return json_encode($query);


		
	}

	public function verify_code()
	{	

		$data['_error'] = null;

		$code =  Tbl_membership_code::where('code_pin', Request::input('code_pin'))->getUser()->first();
										// ->first();
		
		if($code)
		{
			if($code->blocked == 0)
			{
				$code->stat  = $code->used == 0 ? 'Unused' : 'Used';
			}
			else
			{
				$code->stat = 'block';
			}
		}

		return json_encode($code);



		
	}




}
