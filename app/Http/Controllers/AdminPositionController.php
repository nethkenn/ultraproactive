<?php namespace App\Http\Controllers;
use DB;
use Request;
<<<<<<< HEAD
use Validator;
use Datatables;
use App\Tbl_position;
=======
use Redirect;
>>>>>>> eebf8cd45767dc8fac24238bf31c0e4f77169f71

class AdminPositionController extends AdminController
{
	public function index()
	{
		$data["_position"] = DB::table("tbl_admin_position")->where("archived", 0)->get();

		foreach($data["_position"] as $key => $value)
		{
			$module = $value->admin_position_module;
			$modules = explode(',' , $module);
			$ctr = 0;
			foreach($modules as $keys => $values) 
			{
				if($values != 0)
				{
					$ctr++;
				}
			}
			$data["_position"][$key]->modules = $ctr;
	
		}

        return view('admin.utilities.position', $data);
	}

	public function add()
	{
		$data["_module"] = DB::table("tbl_module")->where("archived", 0)->get();
        return view('admin.utilities.position_add', $data);
	}

	public function add_submit()
	{
		$name = Request::input("name");
		$level = Request::input("level");
		$module = Request::input("module");
		foreach ($module as $key => $value) 
		{
			$modules["$key"] = $value;
		}

		$moduless = implode(",", $modules);

		DB::table("tbl_admin_position")->insert(['admin_position_name' => $name, 'admin_position_rank' => $level, 'admin_position_module' => $moduless]);

        return Redirect::to('/admin/utilities/position');
	}
	public function edit()
	{
		$id = Request::input("id");
		$data["_module"] = DB::table("tbl_module")->where("archived", 0)->get();
		$data["position"] = DB::table("tbl_admin_position")->where("archived", 0)->where("admin_position_id", $id)->first();
		$module = $data["position"]->admin_position_module;
		$module_id = explode(',', $module);
		// dd($module_id,$data["_module"]);
	
			foreach ($module_id as $key => $value) 
			{

				$data["_module"][$key]->modules = $value;
				// foreach ($module_ids as $keys => $values) 
				// {
				// 	$data["_module"]->modules = $values;
				// }
			}

		// dd($module_id);
        return view('admin.utilities.position_edit', $data);
	}
	public function edit_submit()
	{
		$name = Request::input("name");
		$level = Request::input("level");
		$module = Request::input("module");
		$id = Request::input("id");
		foreach ($module as $key => $value) 
		{
			$modules["$key"] = $value;
		}

		$moduless = implode(",", $modules);

		DB::table("tbl_admin_position")->where("admin_position_id", $id)->update(['admin_position_name' => $name, 'admin_position_rank' => $level, 'admin_position_module' => $moduless]);

        return Redirect::to('/admin/utilities/position');
	}
	public function delete()
	{
		$id = Request::input("id");
		
		DB::table("tbl_admin_position")->where("admin_position_id", $id)->update(['archived' => "1"]);

        return Redirect::to('/admin/utilities/position');
	}
	public function data()
	{
        $account = Tbl_position::select('*');
        return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$account_id}}">EDIT</a>')
        								->addColumn('archive','<a href="#" account-id="{{$account_id}}">ARCHIVE</a>')
        								->make(true);
	}
}