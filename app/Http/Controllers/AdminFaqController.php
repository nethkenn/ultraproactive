<?php namespace App\Http\Controllers;
use DB;
use Redirect;
use Request;
use App\Classes\Image;
use App\Classes\Admin;
use App\Classes\Log;
class AdminFaqController extends AdminController
{
	public function index()
	{
		$data["category"] = Request::input("type");
		$data["_product"] = DB::table("tbl_faq")->where("faq_type", "product")->where("archived", 0)->get();
		$data["_mindsync"] = DB::table("tbl_faq")->where("faq_type", "mindsync")->where("archived", 0)->get();
		$data["_opportunity"] = DB::table("tbl_faq")->where("faq_type", "opportunity")->where("archived", 0)->get();
		$data["_glossary"] = DB::table("tbl_faq")->where("faq_type", "glossary")->where("archived", 0)->get();

		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits the FAQ ".Request::input("type"));
        return view('admin.content.faq', $data);
	}
	public function add()
	{
		$data["category"] = Request::input("type");
		
		$title = Request::input("title");
		$content = Request::input("content");
		if (isset($title) && isset($content)) 
		{
			$id = DB::table("tbl_faq")->insertGetId(['faq_title' => $title, 'faq_content' => $content, 'faq_type' => $data["category"]]);
			$new = DB::table('tbl_faq')->where('faq_id',$id)->first();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add an FAQ to the ".$data['category'],null,serialize($new));
			return Redirect::to("/admin/content/faq?type=".$data["category"]);
		}
        else
        {
        	return view('admin.content.faq_add', $data);
        }
	}
	public function edit()
	{
		$data["category"] = Request::input("type");
		$id = Request::input("id");
		$data["edit"] = DB::table("tbl_faq")->where("faq_id", $id)->first();
		$title = Request::input("title");
		$content = Request::input("content");
		if (isset($title) && isset($content)) 
		{
			$old = DB::table('tbl_faq')->where('faq_id',$id)->first();
			DB::table("tbl_faq")->where("faq_id", $id)->update(['faq_title' => $title, 'faq_content' => $content]);
			$new = DB::table('tbl_faq')->where('faq_id',$id)->first();
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." Add an FAQ to the ".$data['category'],serialize($old),serialize($new));
			return Redirect::to("/admin/content/faq?type=".$data["category"]);
		}
        else
        {
			Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits the Edit FAQ ".Request::input("type")." id #".$id);
        	return view('admin.content.faq_edit', $data);
        }
	}
	public function delete()
	{
		$id = Request::input("id");
		$type = Request::input("type");
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." archive the FAQ ".Request::input("type")." id #".$id);
		DB::table("tbl_faq")->where("faq_id", $id)->update(['archived' => 1]);
		return Redirect::to("/admin/content/faq?type=".$type);
	}
}