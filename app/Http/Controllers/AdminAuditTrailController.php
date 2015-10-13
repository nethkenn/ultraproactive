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

}