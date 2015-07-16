<?php namespace App\Http\Controllers;
use App\Classes\Customer;
use DB;

class MemberCodeController extends MemberController
{
	public function index()
	{
		$id = Customer::id();
		$data = $this->getslotbyid($id);

        return view('member.code_vault',$data);
	}

	public function getslotbyid($id)
	{
		$data['code'] = DB::table('tbl_membership_code')->where('tbl_membership_code.archived',0)
											  ->join('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id')
											  ->join('tbl_code_type','tbl_code_type.code_type_id','=','tbl_membership_code.code_type_id')
											  ->join('tbl_membership','tbl_membership.membership_id','=','tbl_membership_code.membership_id')
											  ->join('tbl_product_package','tbl_product_package.product_package_id','=','tbl_membership_code.product_package_id')
											  ->join('tbl_admin','tbl_admin.admin_id','=','tbl_membership_code.admin_id')
											  ->where('tbl_membership_code.account_id','=',$id)
											  ->orderBy('tbl_membership_code.account_id','ASC')
											  ->get();


		$data['count']= DB::table('tbl_membership_code')->where('archived',0)->where('account_id','=',$id)->count();
		return $data;
	}
}