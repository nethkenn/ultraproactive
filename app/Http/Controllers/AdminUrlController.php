<?php namespace App\Http\Controllers;
use Request;
use App\Tbl_account;
use App\Tbl_admin;
use DB;
use App\Classes\Admin;
use Redirect;
use Session;
use App\Tbl_admin_position_has_module;
use App\Tbl_module;
use gapi;
use Validator;

// use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class AdminUrlController extends AdminController
{

	public function index()
	{

		return view('admin.utilities.admin_url');

	}

	public function create_url()
	{


		$new_admin_url = Session::get('new_admin_url');
		$url_segment_array = explode("/", $new_admin_url);

		$requests['new_admin_url'] = $new_admin_url;
		$rules['new_admin_url'] = 'required';

		$requests['module_name'] = Request::input('module_name');
		$rules['module_name'] = 'required|unique:tbl_module,module_name';

		$requests['url_segment'] = Request::input('url_segment');
		$rules['url_segment'] = 'required|unique:tbl_module,url_segment|check_segment';
		$messages['url_segment.check_segment'] = "The :attribute word must belong to new admin url segment/s.";
		
		Validator::extend('check_segment', function($attribute, $value, $parameters) use($url_segment_array)
		{
			return in_array($value, $url_segment_array);
        });
		

		$validator = Validator::make($requests , $rules, $messages);

        if ($validator->fails())
        {
            return back()
                        ->withErrors($validator)
                        ->withInput(Request::input());
        }

        $new_module = new Tbl_module(Request::input());
        $new_module->save();

        $insert_position_has_module['admin_position_id'] = 1;
        $insert_position_has_module['module_id'] = $new_module->module_id;
        $new_admin_position_has_module = new Tbl_admin_position_has_module($insert_position_has_module);
        $new_admin_position_has_module->save();

        Session::forget('new_admin_url');
        return redirect($new_admin_url); 
	}

}

