<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;

class AdminPositionController extends AdminController
{
	public function index()
	{
		$data["_position"] = DB::table("tbl_admin_position")->where("archived", 0)->get();

		foreach($data["_position"] as $key => $value)
		{
			$module = $value->admin_position_module;
			$modules = explode(',' , $module);
			foreach($modules as $keys => $values) 
			{
				$keys > 0;
			}
			$data["_position"][$key]->modules = count($modules);
	
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
			$modules["$key"] = $key . "-" . $value;
		}

		$moduless = implode(",", $modules);

		DB::table("tbl_admin_position")->insert(['admin_position_name' => $name, 'admin_position_rank' => $level, 'admin_position_module' => $moduless]);

        return Redirect::to('/admin/utilities/position');
	}
	public function edit()
	{
		$data["_module"] = DB::table("tbl_module")->where("archived", 0)->get();
        return view('admin.utilities.position_edit', $data);
	}
}