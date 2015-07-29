<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminPartnerController extends AdminController
{
	public function index()
	{
		$data["_partner"] = DB::table("tbl_partner")->where("archived", 0)->get();
		foreach ($data["_partner"] as $key => $value) {
			$get = $value->partner_image;
			$imagee = Image::view($get);
			$data["_partner"][$key]->image = $imagee;
		}

        return view('admin.content.partner', $data);
	}
	public function add()
	{
        return view('admin.content.partner_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$date = date('Y-m-d H:i:s');
		$link = Request::input("link");
		$image = Request::input("image_file");

		DB::table("tbl_partner")->insert(['partner_title' => $title, 'created_at' => $date, 'partner_image' => $image, 'partner_link' => $link]);

        return Redirect::to("/admin/content/partner");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["partner"] = DB::table("tbl_partner")->where("partner_id", $id)->first();

		$imagee = Image::view($data["partner"]->partner_image, "255x255");
		$data["partner"]->image = $imagee;

        return view('admin.content.partner_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$link = Request::input("link");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		DB::table("tbl_partner")->where("partner_id", $id)->update(['partner_title' => $title, 'updated_at' => $date, 'partner_image' => $image, 'partner_link' => $link]);

        return Redirect::to("/admin/content/partner");
	}	
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_partner")->where("partner_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/partner");
	}	
}