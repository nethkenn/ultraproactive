<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_stockist;
use Datatables;
use App\Tbl_stockist_type;
use Crypt;
use Validator;
class AdminStockistController extends AdminController
{
    public function index()
    {
        return view('admin.maintenance.stockist');
    }


    public function get_data()
    {
        $archived = Request::input('archived');

        $stockist = Tbl_stockist::where(function($query) use ($archived){
            switch ($archived) {
                case "1":
                    $query->where('archive', 1);
                    break;
                
                default:
                    $query->where('archive', 0);
                    break;
            }
        })->get();



        $btn = $archived == 1 ? '<a href="#" class="restore-stockist" stockist-id="{{$stockist_id}}">RESTORE</a> ' : '<a href="#" class="archive-stockist" stockist-id="{{$stockist_id}}">ARCHIVE</a>';
        return Datatables::of($stockist)
                                    ->addColumn('show_pass','<a style="cursor: pointer;" class="show-pass" stockist-id = "{{$stockist_id}}" >SHOW</a>')  
                                    ->addColumn('edit_archive','<a href="admin/admin_stockist/edit/{{$stockist_id}}">EDIT</a> | '. $btn)
                                    ->make(true);
    }



    public function add()
    {
        $data['stockist_type'] = Tbl_stockist_type::all();
        return view('admin.maintenance.stockist_add', $data);
    }

    public function create()
    {
        $rules['stockist_full_name'] = 'required|unique:tbl_stockist,stockist_full_name|regex:/^[A-Za-z0-9\s-_]+$/';
        $msg['stockist_full_name.regex'] = "The Stockist Name can only have letters, numbers, spaces, underscores and dashes.";

        $rules['stockist_type'] = "required|exists:tbl_stockist_type,stockist_type_id";
        $rules['stockist_location'] = "required|unique:tbl_stockist,stockist_location";
        $rules['stockist_address'] = "required|unique:tbl_stockist,stockist_address";
        $rules['stockist_contact_no'] = "required";
        $rules['stockist_email'] = "required|email|unique:tbl_stockist,stockist_email";
        $rules['stockist_un'] = "required|unique:tbl_stockist,stockist_un";
        $rules['stockist_pw'] = "required|min:6";
        
        $validator = Validator::make(Request::input(), $rules, $msg);

        if ($validator->fails())
        {
            return redirect('admin/admin_stockist/add')
                        ->withErrors($validator)
                        ->withInput();
        }

        $stockist = new Tbl_stockist(Request::input());
        $stockist->stockist_pw = Crypt::encrypt(Request::input('stockist_pw'));
        $stockist->save();
        return redirect('admin/admin_stockist');
    }


    public function edit($id)
    {


        $data['stockist'] = Tbl_stockist::findOrFail($id);

        $data['stockist']->stockist_pw = Crypt::decrypt($data['stockist']->stockist_pw);
        $data['stockist_type'] = Tbl_stockist_type::all();
        return view('admin.maintenance.stockist_edit', $data);
    }

    public function update()
    {   

        $stockist_id = Request::input('stockist_id');
        $stockist = Tbl_stockist::findOrFail($stockist_id);

        $rules['stockist_full_name'] = 'required|unique:tbl_stockist,stockist_full_name,'.$stockist_id.',stockist_id|regex:/^[A-Za-z0-9\s-_]+$/';
        $msg['stockist_full_name.regex'] = "The Stockist Name can only have letters, numbers, spaces, underscores and dashes.";

        $rules['stockist_type'] = "required|exists:tbl_stockist_type,stockist_type_id";
        $rules['stockist_location'] = "required|unique:tbl_stockist,stockist_location,".$stockist_id.",stockist_id";
        $rules['stockist_address'] = "required|unique:tbl_stockist,stockist_address,".$stockist_id.",stockist_id";
        $rules['stockist_contact_no'] = "required";
        $rules['stockist_email'] = "required|email|unique:tbl_stockist,stockist_email,".$stockist_id.",stockist_id";
        $rules['stockist_un'] = "required|unique:tbl_stockist,stockist_un,".$stockist_id.",stockist_id";
        $rules['stockist_pw'] = "required|min:6";
        
        $validator = Validator::make(Request::input(), $rules, $msg);

        if ($validator->fails())
        {
            return redirect('admin/admin_stockist/edit/'.$stockist_id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $stockist->stockist_full_name = Request::input('stockist_full_name');
        $stockist->stockist_type = Request::input('stockist_type');
        $stockist->stockist_location = Request::input('stockist_location');
        $stockist->stockist_contact_no = Request::input('stockist_contact_no');
        $stockist->stockist_email = Request::input('stockist_email');
        $stockist->stockist_un = Request::input('stockist_un');
        $stockist->stockist_pw =  Crypt::encrypt(Request::input('stockist_pw'));
        $stockist->save();
        return redirect('admin/admin_stockist');

    }

    public function archive()
    {
        $stockist_id = Request::input('stockist_id');
        $update_stockist = Tbl_stockist::findOrFail($stockist_id);
        $update_stockist->archive = 1;
        $update_stockist->save();
        return $update_stockist;
    }

    public function restore()
    {
        $stockist_id = Request::input('stockist_id');
        $update_stockist = Tbl_stockist::findOrFail($stockist_id);
        $update_stockist->archive = 0;
        $update_stockist->save();
        return $update_stockist;
    }

}
