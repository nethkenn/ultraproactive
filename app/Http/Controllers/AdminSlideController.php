<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Classes\Log;
use App\Classes\Admin;
class AdminSlideController extends AdminController
{
	public function index()
	{
		$data["_slide"] = DB::table("tbl_slide")->where("archived", 0)->get();
		foreach ($data["_slide"] as $key => $value) {
			$get = $value->slide_image;
			$imagee = Image::view($get, "500x500");
			$data["_slide"][$key]->image = $imagee;
		}
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Slide Maintenance");
        return view('admin.content.slide', $data);
	}
	public function add()
	{
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Add Slide Maintenance");
        return view('admin.content.slide_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		$id = DB::table("tbl_slide")->insertGetId(['slide_title' => $title, 'created_at' => $date, 'slide_image' => $image]);
		$new = DB::table("tbl_slide")->where("slide_id", $id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add Slide Id #".$id,null,serialize($new));
        return Redirect::to("/admin/content/slide");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["slide"] = DB::table("tbl_slide")->where("slide_id", $id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Edit Slide Maintenance Id #".$id);
		$imagee = Image::view($data["slide"]->slide_image, "255x255");
		$data["slide"]->image = $imagee;

        return view('admin.content.slide_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");
		$old = DB::table("tbl_slide")->where("slide_id", $id)->first();
		DB::table("tbl_slide")->where("slide_id", $id)->update(['slide_title' => $title, 'updated_at' => $date, 'slide_image' => $image]);
		$new = DB::table("tbl_slide")->where("slide_id", $id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Edit Slide Id #".$id,serialize($old),serialize($new));
        return Redirect::to("/admin/content/slide");
	}	
	public function delete()
	{
		$id = Request::input("id");
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive Slide Id #".$id);
		DB::table("tbl_slide")->where("slide_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/slide");
	}	
}