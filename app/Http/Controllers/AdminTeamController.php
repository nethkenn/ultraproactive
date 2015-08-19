<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminTeamController extends AdminController
{
	public function index()
	{
		$data["_team"] = DB::table("tbl_team")->where("archived", 0)->get();
		foreach ($data["_team"] as $key => $value) {
			$get = $value->team_image;
			$imagee = Image::view($get, "500x500");
			$data["_team"][$key]->image = $imagee;
		}

        return view('admin.content.team', $data);
	}
	public function add()
	{
        return view('admin.content.team_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$description = Request::input("description");
		$role = Request::input("role");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		DB::table("tbl_team")->insert(['team_title' => $title, 'team_description' => $description, 'team_role' => $role, 'created_at' => $date, 'team_image' => $image]);

        return Redirect::to("/admin/content/team");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["team"] = DB::table("tbl_team")->where("team_id", $id)->first();

		$imagee = Image::view($data["team"]->team_image, "255x255");
		$data["team"]->image = $imagee;

        return view('admin.content.team_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$role = Request::input("role");
		$description = Request::input("description");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		DB::table("tbl_team")->where("team_id", $id)->update(['team_title' => $title, 'team_description' => $description, 'team_role' => $role, 'updated_at' => $date, 'team_image' => $image]);

        return Redirect::to("/admin/content/team");
	}	
	public function sort()
	{
		$data["_team"] = DB::table("tbl_team")->where("archived", 0)->orderBy("team_sort", "asc")->get();

		return view('admin.content.team_sort', $data);
	}
	public function sort_submit()
	{
		$sort = Request::input("sort");
		$sort_insert = explode("&", $sort);
		if (isset($sort)) 
		{
			foreach ($sort_insert as $key => $value) 
			{
				$sort_id = explode("=", $value);
				$sort_convert = $sort_id["1"];
				DB::table("tbl_team")->where("team_id", $sort_convert)->update(['team_sort' => $key]);
			}

			return Redirect::to("/admin/content/team");
		}
		else
		{
			return Redirect::to("/admin/content/team");
		}
	}
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_team")->where("team_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/team");
	}	
}