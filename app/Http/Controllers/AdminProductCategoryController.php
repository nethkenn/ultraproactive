<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminProductCategoryController extends AdminController
{
	public function index()
	{
		$data["_product_category"] = DB::table("tbl_product_category")->where("archived", 0)->get();
	
        return view('admin.maintenance.product_category', $data);
	}
	public function add()
	{
        return view('admin.maintenance.product_category_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$date = date('Y-m-d H:i:s');

		DB::table("tbl_product_category")->insert(['product_category_name' => $title, 'created_at' => $date]);

        return Redirect::to("/admin/maintenance/product_category");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["product_category"] = DB::table("tbl_product_category")->where("product_category_id", $id)->first();

        return view('admin.maintenance.product_category_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$date = date('Y-m-d H:i:s');

		DB::table("tbl_product_category")->where("product_category_id", $id)->update(['product_category_name' => $title, 'updated_at' => $date]);

        return Redirect::to("/admin/maintenance/product_category");
	}	
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_product_category")->where("product_category_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/maintenance/product_category");
	}	
}