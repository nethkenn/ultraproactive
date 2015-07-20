<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;

class AdminEarnController extends AdminController
{
	public function index()
	{
		$data["_earn"] = DB::table("tbl_earn")->where("archived", 0)->get();
	
        return view('admin.content.earn', $data);
	}
	public function add()
	{
        return view('admin.content.earn_add');
	}
	public function add_submit()
	{
		$title = Request::input("title");
		$description = Request::input("description");
		$date = date('Y-m-d H:i:s');

		DB::table("tbl_earn")->insert(['earn_title' => $title, 'earn_description' => $description, 'created_at' => $date]);

        return Redirect::to("/admin/content/earn");
	}	
	public function edit()
	{
		$id = Request::input("id");
		$data["earn"] = DB::table("tbl_earn")->where("earn_id", $id)->first();

        return view('admin.content.earn_edit', $data);
	}
	public function edit_submit()
	{
		$id = Request::input("id");
		$title = Request::input("title");
		$description = Request::input("description");
		$date = date('Y-m-d H:i:s');

		DB::table("tbl_earn")->where("earn_id", $id)->update(['earn_title' => $title, 'earn_description' => $description, 'updated_at' => $date]);

        return Redirect::to("/admin/content/earn");
	}	
	public function delete()
	{
		$id = Request::input("id");

		DB::table("tbl_earn")->where("earn_id", $id)->update(['archived' => 1]);

        return Redirect::to("/admin/content/earn");
	}	
}