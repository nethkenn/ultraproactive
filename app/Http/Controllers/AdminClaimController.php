<?php namespace App\Http\Controllers;
use App\Tbl_voucher;
use App\Tbl_voucher_has_product;
use Datatables;
use Request;
use Validator;
use app\Classes\Admin;
use Crypt;
class AdminClaimController extends AdminController
{
	public function index()
	{
        return view('admin.transaction.claim');
	}


	public function data()
	{


		$voucher = Tbl_voucher::all();

		return Datatables::of($voucher)	->editColumn('status','{{$status}}')
										->addColumn('cancel_or_view_voucher','<a class="cancel-voucher" voucher-id="">Cancel</a>|<a class="view-voucher" voucher-id="">View Voucher</a>')
			                            ->make(true);
	}

	public function check()
	{
		$data['_message'] = [];

		if(isset($_POST['voucher_id']))
		{
			// dd(Request::input('voucher_id'));


			// $rules['voucher_id'] = 
			// $rules['voucher_code'] = 
			   
			// $voucher = Tbl_voucher::where('voucher_id', Request::input('voucher_id'))->where('voucher_code', Request::input('voucher_code'))->get();
			$admin_pass = Crypt::decrypt(Admin::info()->account_password);


			dd($admin_pass, Request::input('account_password') , $admin_pass == Request::input('account_password'));

	        Validator::extend('foo', function($attribute, $value, $parameters)
            {

            	// global $admin_pass;
            	
            


            });
	        $rules['account_password'] = 'required:';


			$validator = Validator::make(Request::input(),$rules);

			// dd($validator->fails());

			dd($validator->messages()->all());

		}



		return view('admin.transaction.claim_check', $data);
	}






}