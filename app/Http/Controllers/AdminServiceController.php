<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminServiceController extends AdminController
{
	public function index()
	{
		$data["_service"] = DB::table("tbl_service")->where("archived", 0)->get();
		foreach ($data["_service"] as $key => $value) {
			$get = $value->service_image;
			$imagee = Image::view($get, "500x500");
			$data["_service"][$key]->image = $imagee;
		}

        return view('admin.content.service', $data);
	}
	public function add()
	{
        return view('admin.content.service_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$description = Request::input("description");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		DB::table("tbl_service")->insert(['service_title' => $title, 'service_description' => $description, 'created_at' => $date, 'service_image' => $image]);

        return Redirect::to("/admin/content/service");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["service"] = DB::table("tbl_service")->where("service_id", $id)->first();

		$imagee = Image::view($data["service"]->service_image, "255x255");
		$data["service"]->image = $imagee;

        return view('admin.content.service_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$description = Request::input("description");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		DB::table("tbl_service")->where("service_id", $id)->update(['service_title' => $title, 'service_description' => $description, 'updated_at' => $date, 'service_image' => $image]);

        return Redirect::to("/admin/content/service");
	}	
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_service")->where("service_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/service");
	}	
}