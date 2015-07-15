<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminSlideController extends AdminController
{
	public function index()
	{
		$data["_slide"] = DB::table("tbl_slide")->where("archived", 0)->get();
		foreach ($data["_slide"] as $key => $value) {
			$get = $value->slide_image;
			$imagee = Image::view($get);
			$data["_slide"][$key]->image = $imagee;
		}

        return view('admin.maintenance.slide', $data);
	}
	public function add()
	{
        return view('admin.maintenance.slide_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		DB::table("tbl_slide")->insert(['slide_title' => $title, 'created_at' => $date, 'slide_image' => $image]);

        return Redirect::to("/admin/maintenance/slide");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["slide"] = DB::table("tbl_slide")->where("slide_id", $id)->first();

		$imagee = Image::view($data["slide"]->slide_image, "255x255");
		$data["slide"]->image = $imagee;

        return view('admin.maintenance.slide_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		DB::table("tbl_slide")->where("slide_id", $id)->update(['slide_title' => $title, 'updated_at' => $date, 'slide_image' => $image]);

        return Redirect::to("/admin/maintenance/slide");
	}	
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_slide")->where("slide_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/maintenance/slide");
	}	
}