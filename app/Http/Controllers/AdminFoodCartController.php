<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminFoodCartController extends AdminController
{
	public function index()
	{
		$data["_foodcart"] = DB::table("tbl_foodcart")->where("archived", 0)->get();
		foreach ($data["_foodcart"] as $key => $value) {
			$get = $value->foodcart_image;
			$imagee = Image::view($get, "500x500");
			$data["_foodcart"][$key]->image = $imagee;
		}

        return view('admin.content.foodcart', $data);
	}
	public function add()
	{
        return view('admin.content.foodcart_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		DB::table("tbl_foodcart")->insert(['foodcart_title' => $title, 'created_at' => $date, 'foodcart_image' => $image]);

        return Redirect::to("/admin/content/foodcart");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["foodcart"] = DB::table("tbl_foodcart")->where("foodcart_id", $id)->first();

		$imagee = Image::view($data["foodcart"]->foodcart_image, "255x255");
		$data["foodcart"]->image = $imagee;

        return view('admin.content.foodcart_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$date = date('Y-m-d H:i:s');
		$image = Request::input("image_file");

		DB::table("tbl_foodcart")->where("foodcart_id", $id)->update(['foodcart_title' => $title, 'updated_at' => $date, 'foodcart_image' => $image]);

        return Redirect::to("/admin/content/foodcart");
	}	
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_foodcart")->where("foodcart_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/foodcart");
	}	
}