<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Tbl_stockist_user;
use App\Tbl_stockist;
use Datatables;
use Crypt;
use Validator;
class AdminStockistUserController extends AdminController
{
	public function index()
	{
		// dd(Tbl_stockist_user::stockist()->get())
		return view('admin.maintenance.stockist_user');
	}



	public function get_data()
    {
        $archived = Request::input('archived');

        $stockist = Tbl_stockist_user::select('tbl_stockist.stockist_full_name', 'tbl_stockist_user.*')->stockist()->where(function($query) use ($archived){
            switch ($archived) {
                case "1":
                    $query->where('tbl_stockist_user.archive', 1);
                    break;
                
                default:
                    $query->where('tbl_stockist_user.archive', 0);
                    break;
            }
        })->get();

        

        $btn = $archived == 1 ? '<a href="#" class="restore-stockist-user" stockist-user-id="{{$stockist_user_id}}">RESTORE</a> ' : '<a href="#" class="archive-stockist-user" stockist-user-id="{{$stockist_user_id}}">ARCHIVE</a>';
        return Datatables::of($stockist)
                                    ->editColumn('stockist_pw','{{Crypt::decrypt($stockist_pw)}}') 
                                    ->addColumn('edit_archive','<a href="admin/admin_stockist_user/edit/{{$stockist_user_id}}">EDIT</a> | '. $btn)
                                    ->make(true);
    }


    public function add()
    {
        $data['_stockist'] = Tbl_stockist::all();
        return view('admin.maintenance.stockist_user_add', $data);
    }


    public function create()
    {

    	$rules['stockist_un'] = 'required|unique:tbl_stockist_user,stockist_un|regex:/^[A-Za-z0-9\s-_]+$/';
        $msg['stockist_un.regex'] = "The Stockist Name can only have letters, numbers, spaces, underscores and dashes.";
        $rules['stockist_id'] = 'required|exists:tbl_stockist,stockist_id';
        $rules['stockist_email'] = 'required|email|unique:tbl_stockist_user,stockist_email';
        $rules['stockist_pw'] = 'required|min:6';


        $validator = Validator::make(Request::input(), $rules, $msg);

        if ($validator->fails())
        {
            return redirect('admin/admin_stockist_user/add')
                        ->withErrors($validator)
                        ->withInput();
        }

       $stockist_user = new Tbl_stockist_user(Request::input());
       $stockist_user->stockist_pw = Crypt::encrypt(Request::input('stockist_pw'));
       
       $stockist_user->save();
       return redirect('admin/admin_stockist_user');


    }

    public function edit($id)
    {

    	$data['_stockist'] = Tbl_stockist::all();
    	$data['selected_user'] = Tbl_stockist_user::findOrFail($id);
    	$data['selected_user']->stockist_pw = Crypt::decrypt($data['selected_user']->stockist_pw);

    	return view('admin.maintenance.stockist_user_edit', $data);

   	}


   	public function update($id)
    {

    	$seleted_user = Tbl_stockist_user::findOrFail($id);

    	$rules['stockist_un'] = 'required|unique:tbl_stockist_user,stockist_un,'.$seleted_user->stockist_user_id.',stockist_user_id|regex:/^[A-Za-z0-9\s-_]+$/';
        $msg['stockist_un.regex'] = "The Stockist Name can only have letters, numbers, spaces, underscores and dashes.";
        
        // $rules['stockist_id'] = 'required|exists:tbl_stockist,stockist_id';
        $rules['stockist_email'] = 'required|email|unique:tbl_stockist_user,stockist_email,'.$seleted_user->stockist_user_id.',stockist_user_id';
        $rules['stockist_pw'] = 'required|min:6';


        $validator = Validator::make(Request::input(), $rules, $msg);

        if ($validator->fails())
        {
            return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
        }

        $seleted_user->stockist_email = Request::input('stockist_email');
        $seleted_user->stockist_un = Request::input('stockist_un');
        $seleted_user->stockist_pw = Crypt::encrypt(Request::input('stockist_pw'));
        $seleted_user->save();
        return redirect('admin/admin_stockist_user');
    }


    public function archive()
    {
        $stockist_user_id = Request::input('stockist_user_id');
        $update_stockist_user = Tbl_stockist_user::findOrFail($stockist_user_id);
        $update_stockist_user->archive = 1;
        $update_stockist_user->save();
        return $update_stockist_user;
    }

    public function restore()
    {
        $stockist_user_id = Request::input('stockist_user_id');
        $update_stockist_user = Tbl_stockist_user::findOrFail($stockist_user_id);
        $update_stockist_user->archive = 0;
        $update_stockist_user->save();
        return $update_stockist_user;
    }

}