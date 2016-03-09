<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon;
use Datatables;
use Crypt;
use App\Tbl_account;
use App\Tbl_account_field;
use App\Classes\Admin;
use Validator;
use App\Classes\Customer;
use App\Classes\Log;
class AdminAccountBlockController extends AdminController
{
	public function index()
	{
		$data["page"] = "Account Block Maintenance";
		
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Account Block Maintenance");

        return view('admin.maintenance.account_block', $data);
	}

	public function data()
    {
		$admin_rank = Admin::info()->admin_position_rank;
    	$account = Tbl_account::select('tbl_account.*','tbl_admin_position.admin_position_rank','tbl_country.country_name')
    										->where('tbl_account.archived', 0)
    										->where('tbl_account.blocked', Request::input("blocked"))
    										->where('tbl_admin_position.admin_position_rank', '>=',$admin_rank)
    										->OrWhereNull('tbl_admin_position.admin_position_rank')
    										->position()
    										->country()
    										->where('tbl_account.archived',0)
    										->where('tbl_account.blocked', Request::input("blocked"))
    										->get();

        $text = Request::input('blocked') ? 'unblock' : 'block';
        return Datatables::of($account) ->addColumn('block','<a href="admin/maintenance/account_block/'.$text.'?id={{ $account_id }}" style="text-transform: uppercase;">'.$text.'</a>')
        								->make(true);
    }

    public function block()
    {
    	$id = Request::input("id");
    	$update["blocked"] = 1;
    	$update["blocked_date"] = date("Y-m-d H:i:s");
    	$update["blocked_by"] = Admin::info()->account_username;
    	Tbl_account::where("account_id", $id)->update($update);

    	Log::Admin(Admin::info()->account_id,Admin::info()->account_username." blocked Account #". $id);

    	return Redirect::to("/admin/maintenance/account_block");
    }

    public function unblock()
    {
    	$id = Request::input("id");
    	$update["blocked"] = 0;
    	$update["blocked_date"] = null;
    	$update["blocked_by"] = null;
    	Tbl_account::where("account_id", $id)->update($update);

    	Log::Admin(Admin::info()->account_id,Admin::info()->account_username." unblocked Account #". $id);

    	return Redirect::to("/admin/maintenance/account_block/blocked?blocked=1");
    }
}