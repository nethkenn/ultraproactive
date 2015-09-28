<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Classes\Admin;
use App\Classes\Log;
class AdminProductCategoryController extends AdminController
{
	public function index()
	{
		$data["_product_category"] = DB::table("tbl_product_category")->where("archived", 0)->get();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Product Category");
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

		$id = DB::table("tbl_product_category")->insertGetId(['product_category_name' => $title, 'created_at' => $date]);
		$new = DB::table("tbl_product_category")->where('product_category_id',$id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." add Product Category id #".$id,null,serialize($new));
        return Redirect::to("/admin/maintenance/product_category");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["product_category"] = DB::table("tbl_product_category")->where("product_category_id", $id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit Product Category id #".$id);
        return view('admin.maintenance.product_category_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$date = date('Y-m-d H:i:s');
		$old = DB::table("tbl_product_category")->where("product_category_id", $id)->first();
		DB::table("tbl_product_category")->where("product_category_id", $id)->update(['product_category_name' => $title, 'updated_at' => $date]);
		$new = DB::table("tbl_product_category")->where("product_category_id", $id)->first();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit Product Category id #".$id,serialize($old),serialize($new));
        return Redirect::to("/admin/maintenance/product_category");
	}	
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_product_category")->where("product_category_id", $id)->update(['archived' => 1]);
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." delete Product Category id #".$id);
        return Redirect::to("/admin/maintenance/product_category");
	}	
}