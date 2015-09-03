<?php namespace App\Http\Controllers;
use DB;
// use Request;
// use Validator;
use Datatables;
use App\Tbl_position;
use Redirect;
use App\Tbl_admin_position_has_module;
use App\Tbl_module;
use App\Classes\Globals;
use App\Classes\Admin;
// use Illuminate\Http\Request;
use Request;
use App\Http\Requests;
use App\Http\Requests\AdminPositionAddRequest;
use App\Http\Requests\AdminPositionEditRequest;
use Validator;

class AdminPositionController extends AdminController
{
	public function index()
	{

		$data["allow_button"] = DB::table('tbl_settings')->where('key','allow_update')->first();

       	$data["allow"] = Admin::info()->admin_position_rank;                                
		if(!$data['allow_button'])
		{
			DB::table('tbl_settings')->insert(["key"=>"allow_update","value"=>"developer"]);
			$data["allow_button"] = DB::table('tbl_settings')->where('key','allow_update')->first();
		}
		$data["allow_button"] = DB::table('tbl_settings')->where('key','allow_update')->first()->value;
		if(Request::input('allow_button'))
		{
			DB::table('tbl_settings')->where('key','allow_update')->update(["value"=>Request::input('allow_button')]);
			$data["allow_button"] = DB::table('tbl_settings')->where('key','allow_update')->first()->value;
		}		
		
		
		/**
		 * UPDATE THE SUPER ADMIN MODULES.
		 */
		$_module = Tbl_module::all();
		Tbl_admin_position_has_module::where('admin_position_id',1 )->delete();
		if($_module)
		{
			foreach ($_module as $key => $value)
			{
				$insert['admin_position_id'] = 1;
				$insert['module_id'] = $value->module_id;
				$position_has_module = new Tbl_admin_position_has_module($insert);
				$position_has_module->save();
			
			}
		}

        return view('admin.utilities.position');
	}

	public function add()
	{

		$admin_position_id = Admin::info()->admin_position_id;
		$data["_module"] = Tbl_admin_position_has_module::leftJoin('tbl_module','tbl_module.module_id','=','tbl_admin_position_has_module.module_id')
							->where('admin_position_id', $admin_position_id)
							->get();

		$data["_module_array"] = $data["_module"]->pluck('module_id')->toArray();			


        return view('admin.utilities.position_add', $data);
	}

	public function create ()
	{
		

		$login_admin_rank = Admin::info()->admin_position_rank + 1;

		// dd(Request::input(''), $login_admin_rank);
		$request['admin_position_name'] = Request::input('admin_position_name');
		$rules['admin_position_name'] = 'required|unique:tbl_admin_position,admin_position_name';

		$request['admin_position_rank'] = Request::input('admin_position_rank');
		$rules['admin_position_rank'] = 'required|integer|min:'.$login_admin_rank;

		foreach ((array)Request::input('module') as $key => $value)
		{
			$request[$value] = $value;
		}

		$admin_position_id = Admin::info()->admin_position_id;

		foreach ((array)Request::input('module') as $key => $value)
		{
			$rules[$value] = 'exists:tbl_admin_position_has_module,module_id,admin_position_id,'.$admin_position_id;
		}




		$validator = Validator::make($request, $rules);

        if ($validator->fails())
        {
            return redirect('admin/utilities/position/add')
                        ->withErrors($validator)
                        ->withInput(Request::input());
        }	

		$position = new Tbl_position(Request::input());
		$position->save();
		Tbl_admin_position_has_module::where('admin_position_id',$position->admin_position_id)->delete();
		foreach ((array)Request::input('module') as $key => $value)
		{
			$insert['admin_position_id'] = $position->admin_position_id;
			$insert['module_id'] = $value;
			$position_has_module = new Tbl_admin_position_has_module($insert);
			$position_has_module->save();
		}
        return redirect('/admin/utilities/position');
	}








	public function edit()
	{



		

		$data['position'] = Tbl_position::findOrFail(Request::input('admin_position_id'));

		$data['selected_position_module_array'] = Tbl_admin_position_has_module::where('admin_position_id',Request::input('admin_position_id'))->get()->pluck('module_id')->toArray();;
		
		// dd($data['selected_position_module_array']);
		$admin_position_id = Admin::info()->admin_position_id;
		$data["_module"] = Tbl_admin_position_has_module::leftJoin('tbl_module','tbl_module.module_id','=','tbl_admin_position_has_module.module_id')
							->where('admin_position_id', $admin_position_id)
							->get();
							
		$data["_module_array"] = $data["_module"]->pluck('module_id')->toArray();		

        return view('admin.utilities.position_edit', $data);
	}


	public function update()
	{


		$login_admin_rank = Admin::info()->admin_position_rank + 1;
		$selected_position = Tbl_position::findOrFail(Request::input('admin_position_id'));
		 



		$request['admin_position_id'] = Request::input('admin_position_id');
		$rules['admin_position_id'] = 'exists:tbl_admin_position,admin_position_id|is_authorized:'.Admin::info()->admin_position_rank.','.$selected_position->admin_position_rank;
		$message['admin_position_id.is_authorized'] = "You are Unauthorized to edit this position";


		$request['admin_position_name'] = Request::input('admin_position_name');
		$rules['admin_position_name'] = 'required|unique:tbl_admin_position,admin_position_name,'.Request::input('admin_position_id').',admin_position_id';

		$request['admin_position_rank'] = Request::input('admin_position_rank');
		$rules['admin_position_rank'] = 'required|integer|min:'.$login_admin_rank;

		foreach ((array)Request::input('module') as $key => $value)
		{
			$request[$value] = $value;
		}

		$admin_position_id = Admin::info()->admin_position_id;

		foreach ((array)Request::input('module') as $key => $value)
		{
			$rules[$value] = 'exists:tbl_admin_position_has_module,module_id,admin_position_id,'.$admin_position_id;
		}





		Validator::extend('is_authorized', function($attribute, $value, $parameters)
		{

			//current_admin > edited position
            if($parameters[0] >= $parameters[1] )
            {
            	return false;
            }
            else
            {
            	return true;
            }
        });


		$validator = Validator::make($request, $rules, $message);

        if ($validator->fails())
        {
            return redirect('admin/utilities/position/edit?admin_position_id='.Request::input('admin_position_id'))
                        ->withErrors($validator)
                        ->withInput(Request::input());
        }	

		$position = Tbl_position::find(Request::input('admin_position_id'));
		$position->admin_position_name = Request::input('admin_position_name');
		$position->admin_position_rank = Request::input('admin_position_rank');
		$position->save();

		Tbl_admin_position_has_module::where('admin_position_id',Request::input('admin_position_id'))->delete();
		foreach ((array)Request::input('module') as $key => $value)
		{
			$insert['admin_position_id'] = Request::input('admin_position_id');
			$insert['module_id'] = $value;
			$position_has_module = new Tbl_admin_position_has_module($insert);
			$position_has_module->save();
		}



		return redirect('/admin/utilities/position');
	}

	public function delete()
	{



		$position = $data['position']  = Tbl_position::findOrFail(Request::input('admin_position_id'));
		if(Admin::info()->admin_position_rank >= $position->admin_position_rank)
		{
			die("Forbidden");
		}


		return Tbl_position::where('admin_position_id', Request::input('admin_position_id'))->update(['archived'=>1]);

		

	}



	public function restore()
	{



		$position = $data['position']  = Tbl_position::findOrFail(Request::input('admin_position_id'));
		if(Admin::info()->admin_position_rank >= $position->admin_position_rank)
		{
			die("Forbidden");
		}
		return Tbl_position::where('admin_position_id', Request::input('admin_position_id'))->update(['archived'=>0]);

		

	}

	public function data()
	{


        $reqeust = Request::input('archived');


		$position = Tbl_position::where(function($query) use($reqeust)
								{
									if($reqeust)
									{
										$query->where('archived' , 1);
									}
									else
									{
										$query->where('archived' , 0);
									}
								})->get();



        return Datatables::of($position)	->addColumn('edit','<a href="admin/utilities/position/edit?admin_position_id={{$admin_position_id}}">EDIT</a>')
        								->addColumn('archive','<a href="#" class="{{Request::input("archived") ? "restore-position" : "archived-position"}}" position-id="{{$admin_position_id}}">{{Request::input("archived") ? "RESTORE" : "DELETE"}}</a>')
        								->make(true);
	}
}