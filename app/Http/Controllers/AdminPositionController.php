<?php namespace App\Http\Controllers;
use DB;
// use Request;
// use Validator;
use Datatables;
use App\Tbl_position;
use Redirect;
use App\Tbl_admin_position_has_module;
use App\Tbl_module;
use App\Classes\Globals;
use App\Classes\Admin;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\AdminPositionAddRequest;
use App\Http\Requests\AdminPositionEditRequest;
class AdminPositionController extends AdminController
{
	public function index()
	{

        return view('admin.utilities.position');
	}

	public function add()
	{

		$admin_id = Admin::info()->admin_position_id;
		$data["_module"] = Tbl_admin_position_has_module::module()->where('tbl_admin_position_has_module.admin_position_id', $admin_id)->orderBy('tbl_module.module_name','asc')->get();


        return view('admin.utilities.position_add', $data);
	}

	public function create (AdminPositionAddRequest $request)
	{

			$position = new Tbl_position($request->all());
			$position->save();
			Tbl_admin_position_has_module::where('admin_position_id',$position->admin_position_id)->delete();
			foreach ((array)$request->input('module') as $key => $value)
			{
				$insert['admin_position_id'] = $position->admin_position_id;
				$insert['module_id'] = $value;
				$position_has_module = new Tbl_admin_position_has_module($insert);
				$position_has_module->save();
			}
	        return Redirect::to('/admin/utilities/position');
	}








	public function edit(Request $request)
	{




		$data['_module'] = null;
		$position = $data['position']  = Tbl_position::findOrFail($request->input('admin_position_id'));
		if((integer) $position->admin_position_rank <= (integer) Admin::info()->admin_position_rank)
		{
			die("Forbidden");
		}
		
		$admin_id = Admin::info()->admin_position_id;
		$_module = Tbl_admin_position_has_module::module()->where('tbl_admin_position_has_module.admin_position_id', $admin_id)->get();
		$position_module = Tbl_admin_position_has_module::where('admin_position_id', $request->input('admin_position_id'))->get()->toArray();
		


		foreach ($_module as $key => $value)
		{
			$data['_module'][$key] = $value;
			$data['_module'][$key]->checked = "";
			if(Globals::in_multiarray($value->module_id,$position_module, 'module_id' ))
			{
				$data['_module'][$key]->checked = "checked = 'checked'";
			}

		}

		

        return view('admin.utilities.position_edit', $data);
	}


	public function update(AdminPositionEditRequest $request)
	{
		// dd($request->all());
		$update['admin_position_name'] = $request->input('admin_position_name');
		$update['admin_position_rank'] = $request->input('admin_position_rank');
		Tbl_position::where('admin_position_id',$request->admin_position_id)->update($update);
		Tbl_admin_position_has_module::where('admin_position_id',$request->admin_position_id)->delete();
		foreach ($request->input('module') as $key => $value)
		{
			$insert['admin_position_id'] = $request->admin_position_id;
			$insert['module_id'] = $value;
			$position_has_module = new Tbl_admin_position_has_module($insert);
			$position_has_module->save();
		
		}

		return Redirect::to('/admin/utilities/position');
	}
	public function delete(Request $request)
	{

		$position = $data['position']  = Tbl_position::findOrFail($request->input('admin_position_id'));
		if((integer) $position->admin_position_rank <= (integer) Admin::info()->admin_position_rank)
		{
			die("Forbidden");
		}


		return Tbl_position::where('admin_position_id', $request->input('admin_position_id'))->update(['archived'=>1]);

	}
	public function data(Request $request)
	{

		$admin_rank = Admin::info()->admin_position_rank;
        

        if($request->input('archived'))
        {
        	$account = Tbl_position::where('admin_position_rank', '>' ,$admin_rank)->where('archived',1)->select('*');
        }
        else
        {
        	$account = Tbl_position::where('admin_position_rank', '>' ,$admin_rank)->where('archived',0)->select('*');
        }
         // $account = Tbl_position::all();
        return Datatables::of($account)	->addColumn('edit','<a href="admin/utilities/position/edit?admin_position_id={{$admin_position_id}}">EDIT</a>')
        								->addColumn('archive','<a href="#" class="archived-position" position-id="{{$admin_position_id}}">ARCHIVE</a>')
        								->make(true);
	}
}