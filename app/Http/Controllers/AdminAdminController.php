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

class AdminAdminController extends AdminController
{
	public function index()
	{ 
        // $admin = Tbl_admin::select('tbl_admin.*', 'tbl_admin_position.admin_position_name', 'tbl_admin_position.admin_position_rank', 'tbl_account.account_name', 'tbl_account.account_email',DB::raw('count(*) as slot_count, tbl_slot.slot_owner'))
        //                         ->account()->slot()->position()->groupBy('tbl_admin.admin_id')->get();
        // dd($admin);
        Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Admin Maintenance");

        return view('admin.utilities.admin');
	}

    public function data()
    {

        $admin_rank = Admin::info()->admin_position_rank;

        $admin = Tbl_admin::select('tbl_admin.*', 'tbl_admin_position.admin_position_name', 'tbl_admin_position.admin_position_rank', 'tbl_account.account_name', 'tbl_account.account_email',DB::raw('count(*) as slot_count, tbl_slot.slot_owner'))
                                ->account()->slot()->position()->groupBy('tbl_admin.admin_id')->where('tbl_admin_position.admin_position_rank' ,'>', $admin_rank)->get();

        // $admin = Tbl_admin::account()->position()->get();
       return Datatables::of($admin)->addColumn('edit_delete','<a href="admin/utilities/admin_maintenance/edit?admin_id={{$admin_id}}">EDIT</a>|<a class="delete-admin" href="#" admin-id="{{$admin_id}}">DELETE</a>')
                            ->make(true);
    }


    public function admin_add()
    {
        

       
        $data['_account'] = Tbl_account::all();
        $admin_rank = Admin::info()->admin_position_rank;
        $data['_position']= Tbl_position::where('admin_position_rank', '>',  $admin_rank)->get();

        Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Add Admin Maintenance");

        return view('admin.utilities.admin_add', $data);
    }



    public function create_admin()
    {
                
        $rules['account_id'] = 'exists:tbl_account,account_id|check_if_position';
        $rules['admin_position_id'] = 'exists:tbl_admin_position,admin_position_id|check_rank';
        $messages['admin_position_id.check_rank'] = 'You are unauthorized to assign this position.';
        $messages['account_id.check_if_position'] = 'The selected account already has a position.';
        

        Validator::extend('check_rank', function($attribute, $value, $parameters)
        {
            
            $selected_position = Tbl_position::find($value);
            if($selected_position)
            {
                return Admin::info()->admin_position_rank < $selected_position->admin_position_rank;
            }
            else
            {
                return true;
            }
           // die(var_dump( Admin::info()->admin_position_rank, $selected_position->admin_position_rank,Admin::info()->admin_position_rank < $selected_position->admin_position_rank));
        });

        Validator::extend('check_if_position', function($attribute, $value, $parameters)
        {
            $admin = Tbl_admin::where('account_id', $value)->first();
            
            if($admin)
            {
                return false;
            }
            else
            {
                return true;
            }

        });


        $validator = Validator::make(Request::input(), $rules, $messages);

        if ($validator->fails())
        {
            return redirect('admin/utilities/admin_maintenance/add')
                        ->withErrors($validator)
                        ->withInput(Request::input());
        }

            $admin = new Tbl_admin(Request::input());
            $admin->save();
            $new = DB::table('tbl_admin')->where('admin_id',$admin->admin_id)->first();
            Log::Admin(Admin::info()->account_id,Admin::info()->account_username." add an Admin ID #".$admin->admin_id,null,serialize($new));

            return redirect('admin/utilities/admin_maintenance');

    }





    public function admin_edit()
    {
        

        $data['_account'] = Tbl_account::all();
        $admin_rank = Admin::info()->admin_position_rank;
        
        $data['_position']= Tbl_position::where('admin_position_rank', '>',  $admin_rank)->get();

        $seleted_admin = $data['_admin'] = Tbl_admin::position()->findOrFail(Request::input('admin_id'));

        // dd($seleted_admin->admin_position_rank, $admin_rank );

        Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Edit Admin Maintenance Id #".Request::input('admin_id'));
        if($seleted_admin->admin_position_rank <= $admin_rank)
        {
            die('Forbidden');
        }



        return view('admin.utilities.admin_edit',$data);
    }


    public function update_admin()
    {
        // $rules['account_id'] = 'exists:tbl_account,account_id|check_if_position';
        $rules['admin_position_id'] = 'exists:tbl_admin_position,admin_position_id|check_rank';
        $messages['admin_position_id.check_rank'] = 'You are unauthorized to assign this position.';
        // $messages['account_id.check_if_position'] = 'The selected account already has a position.';
        

        Validator::extend('check_rank', function($attribute, $value, $parameters)
        {
            
            $selected_position = Tbl_position::find($value);
            if($selected_position)
            {
                return Admin::info()->admin_position_rank < $selected_position->admin_position_rank;
            }
            else
            {
                return true;
            }
           // die(var_dump( Admin::info()->admin_position_rank, $selected_position->admin_position_rank,Admin::info()->admin_position_rank < $selected_position->admin_position_rank));
        });



        $validator = Validator::make(Request::input(), $rules, $messages);

        if ($validator->fails())
        {
            return redirect('admin/utilities/admin_maintenance/add')
                        ->withErrors($validator)
                        ->withInput(Request::input());
        }



        $old = DB::table('tbl_admin')->where('admin_id',Request::input('admin_id'))->first();
        $admin = Tbl_admin::findOrFail(Request::input('admin_id'));
        $admin->admin_position_id = Request::input('admin_position_id');
        $admin->save();

        $new = DB::table('tbl_admin')->where('admin_id',Request::input('admin_id'))->first();
        Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit Admin ID #".$admin->admin_id,serialize($old),serialize($new));

        return redirect('admin/utilities/admin_maintenance');
    }


    public function delete_admin(Request $request)
    {   
        $old = DB::table('tbl_admin')->where('admin_id',Request::input('admin_id'))->first();
        $admin_rank = Admin::info()->admin_position_rank;
        $seleted_admin = Tbl_admin::position()->findOrFail(Request::input('admin_id'));
        if($seleted_admin->admin_position_rank <= $admin_rank)
        {
            die('Forbidden');
        }
        $seleted_admin->delete();

        Log::Admin(Admin::info()->account_id,Admin::info()->account_username." delete Admin ID #".Request::input('admin_id'),serialize($old));

        return json_encode(true);



    }





}