<?php namespace App\Http\Controllers;
use Datatables;
use DB;
use App\Tbl_account;
use App\Tbl_admin;
use App\Tbl_position;
use App\Classes\Admin;

use App\Http\Requests\AdminAddRequest;
use App\Http\Requests\AdminEditRequest;

use Illuminate\Http\Request;

class AdminAdminController extends AdminController
{
	public function index()
	{ 
        // $admin = Tbl_admin::select('tbl_admin.*', 'tbl_admin_position.admin_position_name', 'tbl_admin_position.admin_position_rank', 'tbl_account.account_name', 'tbl_account.account_email',DB::raw('count(*) as slot_count, tbl_slot.slot_owner'))
        //                         ->account()->slot()->position()->groupBy('tbl_admin.admin_id')->get();
        // dd($admin);
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



        return view('admin.utilities.admin_add', $data);
    }



    public function create_admin(AdminAddRequest $request)
    {
     
            var_dump($request->all());
            $admin = new Tbl_admin($request->all());
            $admin->save();
            return redirect('admin/utilities/admin_maintenance');


        // return "testasfasfg";
    }





    public function admin_edit(Request $request)
    {
        


        $data['_account'] = Tbl_account::all();
        $admin_rank = Admin::info()->admin_position_rank;
        
        $data['_position']= Tbl_position::where('admin_position_rank', '>',  $admin_rank)->get();

        $seleted_admin = $data['_admin'] = Tbl_admin::position()->findOrFail($request->input('admin_id'));

        // dd($seleted_admin->admin_position_rank, $admin_rank );


        if($seleted_admin->admin_position_rank <= $admin_rank)
        {
            die('Forbidden');
        }



        return view('admin.utilities.admin_edit',$data);
    }


    public function update_admin(AdminEditRequest $request)
    {
         $admin = Tbl_admin::findOrFail($request->input('admin_id'));
         $admin->admin_position_id =   $request->input('admin_position_id');
         $admin->save();
         return redirect('admin/utilities/admin_maintenance');
    }


    public function delete_admin(Request $request)
    {   
        $admin_rank = Admin::info()->admin_position_rank;
        $seleted_admin = Tbl_admin::position()->findOrFail($request->input('admin_id'));
        if($seleted_admin->admin_position_rank <= $admin_rank)
        {
            die('Forbidden');
        }
        $seleted_admin->delete();

        return json_encode(true);



    }





}