<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Tbl_stockist_type;
use Datatables;
use Request;
use Validator;
class AdminStockistTypeController extends AdminController
{
	public function index()
	{
		return view('admin.maintenance.stockist_type');
	}

	public function get_data()
	{
		$archived = Request::input('archived');

		$stockist_type = Tbl_stockist_type::where(function($query) use($archived)
		{

			switch ($archived)
			{
				case 1:
					$query->where('archive', 1);
					break;
				
				default:
					$query->where('archive',0);
			}

		})->get();

		$btn = $archived == 1 ? '<a href="#" class="restore-stockist-type" stockist_type_id="{{$stockist_type_id}}">RESTORE</a> ' : '<a href="#" class="archive-stockist-type" stockist_type_id="{{$stockist_type_id}}">ARCHIVE</a>';
		return Datatables::of($stockist_type)	
							        ->addColumn('edit_archive','<a href="admin/stockist_type/edit/{{$stockist_type_id}}">EDIT</a> | '. $btn)
							        ->make(true);
	}
	
	public function add()
	{
		return view('admin.maintenance.stockist_type_add');
	}


	public function create()
	{
		$rules['stockist_type_name'] = 'required|unique:tbl_stockist_type,stockist_type_name|regex:/^[A-Za-z0-9\s-_]+$/';
				$msg['stockist_type_name.regex'] = "The Type Name can only have letters, numbers, spaces, underscores and dashes.";

		$rules['stockist_type_discount'] = "numeric|min:0|max:100";
		$rules['stockist_type_package_discount'] = "numeric|min:0|max:100";
		$rules['stockist_type_minimum_order'] = "numeric|min:0";
		
		$validator = Validator::make(Request::input(), $rules, $msg);

        if ($validator->fails())
        {
            return redirect('admin/stockist_type/add')
                        ->withErrors($validator)
                        ->withInput();
        }


		$stockist_type = new Tbl_stockist_type(Request::input());
		$stockist_type->save();


		if($stockist_type)
		{

		}
		return redirect('admin/stockist_type');
	}


	public function edit($id)
	{


		$data['stockist_type'] = Tbl_stockist_type::findOrFail($id);
		return view('admin.maintenance.stockist_type_edit', $data);
	}

	public function update()
	{
		// dd(Request::input());

		$stockist_type_id = Request::input('stockist_type_id');
		$update_stockist_type = Tbl_stockist_type::findOrFail($stockist_type_id);

		
		$rules['stockist_type_name'] = 'required|unique:tbl_stockist_type,stockist_type_name,'.$stockist_type_id.',stockist_type_id|regex:/^[A-Za-z0-9\s-_]+$/';
		$msg['stockist_type_name.regex'] = "The Type Name can only have letters, numbers, spaces, underscores and dashes.";

		$rules['stockist_type_discount'] = "numeric|min:0";
		$rules['stockist_type_package_discount'] = "numeric|min:0";
		$rules['stockist_type_minimum_order'] = "numeric|min:0";
		
		$validator = Validator::make(Request::input(), $rules, $msg);

        if ($validator->fails())
        {
            return redirect('admin/stockist_type/edit/'.$stockist_type_id)
                        ->withErrors($validator)
                        ->withInput();
        }

        $update_stockist_type->stockist_type_name = Request::input('stockist_type_name');
        $update_stockist_type->stockist_type_discount = Request::input('stockist_type_discount');
        $update_stockist_type->stockist_type_package_discount = Request::input('stockist_type_package_discount');
        $update_stockist_type->stockist_type_minimum_order = Request::input('stockist_type_minimum_order');
        $update_stockist_type->save();

        return redirect('admin/stockist_type');

	}

	public function archive()
	{

		$stockist_type_id = Request::input('stockist_type_id');
		$update_stockist_type = Tbl_stockist_type::findOrFail($stockist_type_id);
		$update_stockist_type->archive = 1;
		$update_stockist_type->save();
		return $update_stockist_type;
	}


	public function restore()
	{
		$stockist_type_id = Request::input('stockist_type_id');
		$update_stockist_type = Tbl_stockist_type::findOrFail($stockist_type_id);
		$update_stockist_type->archive = 0;
		$update_stockist_type->save();
		return $update_stockist_type;
	}





}
