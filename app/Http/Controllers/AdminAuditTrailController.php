<?php namespace App\Http\Controllers;
use Datatables;
use DB;
use App\Tbl_account;
use App\Tbl_admin;
use App\Tbl_position;
use App\Classes\Admin;

use App\Http\Requests\AdminAddRequest;
use App\Http\Requests\AdminEditRequest;

// use Illuminate\Http\Request;
use Request;
use Validator;
use App\Classes\Log;
use App\Tbl_admin_log;

class AdminAuditTrailController extends AdminController
{
	public function index()
	{ 
        $admin_rank = Admin::info()->admin_position_rank;
        $data['_logs'] = Tbl_admin_log::admin()->account()->position()->where('tbl_admin_position.admin_position_rank' ,'>', $admin_rank)->get();

        return view('admin.report.audit_trail',$data);
	}

	public function view()
	{ 
        $admin_log_id = Request::input('id');
        $get = Tbl_admin_log::admin()->account()->position()->where('admin_log_id',$admin_log_id)->first();
        $data['_old'] = unserialize($get->old_data);
        $data['_new'] = unserialize($get->new_data);
        dd($data);
        return view('admin.report.view_audit_trail',$data);
	}

}