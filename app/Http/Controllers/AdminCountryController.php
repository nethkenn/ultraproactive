<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;

// use Illuminate\Http\Request;
use DB;
use Request;
use Validator;
use Datatables;
use App\Tbl_country;


class AdminCountryController extends AdminController
{

	
	public function index()
	{	
		// $query = DB::table('tbl_country');

		// if(isset($_GET['archived']))
		// {
		// 	$query->where('archived', 1);
		// }
		// else
		// {
		// 	$query->where('archived', 0);
		// }

		// $data['_country'] = $query->get();
		$data["page"] = "Country Maintenance";
		
        return view('admin.maintenance.country', $data);
	}


	public function add_country()
	{

		$data['_error'] = null;


		if(isset($_POST['country_name']))
		{


			$input['country_name'] = Request::input('country_name');
			$rules['country_name'] = 'required|unique:tbl_country,country_name';

			$input['currency'] = Request::input('currency');
			$rules['currency'] = 'required|unique:tbl_country,currency';

			$input['rate'] = Request::input('rate');
			$rules['rate'] = 'required';

			$validator = Validator::make($input,$rules);

			if (!$validator->fails())
			{
				$insert['country_name'] = Request::input('country_name');
				$insert['currency'] = Request::input('currency');
				$insert['rate'] = Request::input('rate');

				DB::table('tbl_country')->insert($insert);

				return redirect('admin/maintenance/country');
			}
			else
			{
				$data['_error'] = $validator->errors()->all();
			}


		}

		return view('admin.maintenance.country_add',$data);
	}

	public function edit_country()
	{

		$data['_error'] = null;

		$country_id = Request::input('id');
		
		$data['country'] = DB::table('tbl_country')->where('country_id',$country_id)->first();


		if(isset($_POST['country_name']))
		{
			$input['country_name'] = Request::input('country_name');
			$rules['country_name'] = 'required|unique:tbl_country,country_name,'.$country_id.',country_id';

			$input['currency'] = Request::input('currency');
			$rules['currency'] = 'required|unique:tbl_country,currency,'.$country_id.',country_id';

			$input['rate'] = Request::input('rate');
			$rules['rate'] = 'required';

			$validator = Validator::make($input,$rules);

			if (!$validator->fails())
			{
				$update['country_name'] = Request::input('country_name');
				$update['currency'] = Request::input('currency');
				$update['rate'] = Request::input('rate');

				DB::table('tbl_country')->where('country_id', $country_id )->update($update);

				return redirect('admin/maintenance/country');
			}
			else
			{
				$data['_error'] = $validator->errors()->all();
			}
		}



		
		return view('admin.maintenance.country_edit', $data);
	}

	public function archive_country()
	{	

		$id = Request::input('id');
		$data['query'] = DB::table('tbl_country')->where('country_id',$id)->update(['archived'=>'1']);

		return json_encode($data);
	}
	
	public function restore_country()
	{	

		$id = Request::input('id');
		$data['query'] = DB::table('tbl_country')->where('country_id',$id)->update(['archived'=>'0']);

		return json_encode($data);
	}


	public function get_country()
	{
		
		$country = Tbl_country::where('archived',Request::input('archived'))->get();
		$text = Request::input('archived') ? 'RESTORE' : 'ARCHIVE';
		$class = Request::input('archived') ? 'restore-country' : 'archive-country';
        return Datatables::of($country)->addColumn('edit','<a href="admin/maintenance/country/edit?id={{$country_id}}">EDIT</a>')

        ->addColumn('archive','<a class="'.$class.'" href="#" country-id="{{$country_id}}">'.$text.'</a>')
        ->make(true);
                // ->addColumn('archived','<a class="''" country-id="{{$country_id}}"> sadasd </a>')

						

    	// return $country;


    	//         return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$account_id}}">EDIT</a>')
     //    								->addColumn('archive','<a href="admin/maintenance/accounts/archive?id={{$account_id}}">ARCHIVE</a>')
     //    								->make(true);

    	        // return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/accounts/edit?id={{$account_id}}">EDIT</a>')
        					// 			->addColumn('archive','<a href="admin/maintenance/accounts/archive?id={{$account_id}}">ARCHIVE</a>')
        					// 			->make(true);

		// return Datatables::of($country)->make();
		// dd(json_encode($country));
		// return json_encode($country);
		// return 'get_coutnry';
	}

	// admin/maintenance/country/get_country

}