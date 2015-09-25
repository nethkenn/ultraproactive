<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon;
use Datatables;
use App\Tbl_rank;
use Validator;
use App\Classes\Log;
use App\Classes\Admin;
class AdminRankingController extends AdminController
{
	public function index()
	{	
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." visits Ranking Maintenance");
        return view('admin.maintenance.ranking');
	}
	public function data()
	{
        $account = Tbl_rank::select('*');
        return Datatables::of($account)	->addColumn('edit','<a href="admin/maintenance/ranking/edit?id={{$rank_id}}">EDIT</a>')
        								->addColumn('delete','<a class="delete-ranking" href="#" rank-id="{{$rank_id}}">DELETE</a>')
        								->make(true);		
	}


	public function add_ranking()
	{

		$data['_error'] = null;
		$rank_count = Tbl_rank::count() + 1;
		$rank = 1;

		while($rank_count > 0)
		{

			$rank_array[] =  $rank++;
			$rank_count = $rank_count - 1;
		}

		$data['rank_array'] = $rank_array;


		if(isset($_POST['rank_level']))
		{

			$rules['rank_name'] = 'required|unique:tbl_rank,rank_name|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['rank_level'] = 'required|min:0|numeric';
			// $rules['product'] = 'numeric|min:1'; 
			

						$message = [
				'rank_name.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',
				
			];

			$validator = Validator::make(Request::input(),$rules,$message);
			
			if (!$validator->fails())
			{


				$check = Tbl_rank::where('rank_level',Request::input('rank_level'))->first();
				if($check)
				{
					$check->update(['rank_level'=>end($rank_array)]);
				}				
				
				$ranking = new Tbl_rank(Request::input());
				$ranking->save();
				$new = DB::table('tbl_rank')->where('rank_id',$ranking->rank_id)->first();
				Log::Admin(Admin::info()->account_id,Admin::info()->account_username." add a Ranking id #".$ranking->rank_id,null,serialize($new));

				return Redirect('admin/maintenance/ranking');



			}
			else
			{
				$errors =  $validator->errors();
				$data['_error']['rank_name'] = $errors->get('rank_name');
				$data['_error']['rank_level'] = $errors->get('rank_level');
			}
		}





		return view('admin.maintenance.ranking_add', $data);
	}


	public function edit_ranking()
	{

		$ranking = Tbl_rank::findOrFail(Request::input('id'));
		$data['ranking'] = $ranking;
		$ranking_id = $ranking->rank_id;

		$data['_error'] = null;
		$rank_count = Tbl_rank::count();
		$rank = 1;

		while($rank_count > 0)
		{

			$rank_array[] =  $rank++;
			$rank_count = $rank_count - 1;
		}

		$data['rank_array'] = $rank_array;


		if(isset($_POST['rank_level']))
		{

			$rules['rank_name'] = 'required|unique:tbl_rank,rank_name,' . $ranking_id . ',rank_id|regex:/^[A-Za-z0-9\s-_]+$/';
			$rules['rank_level'] = 'required|min:0|numeric';
			// $rules['product'] = 'numeric|min:1'; 
			

						$message = [
				'rank_name.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',
				
			];

			$validator = Validator::make(Request::input(),$rules,$message);
			
			if (!$validator->fails())
			{

				$old = DB::table('tbl_rank')->where('rank_id',Request::input('id'))->first();

				Tbl_rank::where('rank_level',Request::input('rank_level'))->update(['rank_level'=>$ranking->rank_level]);

				$ranking =Tbl_rank::find($ranking_id);
				$ranking->rank_name = Request::input('rank_name');
				$ranking->rank_level = Request::input('rank_level');
				$ranking->save();



				$new = DB::table('tbl_rank')->where('rank_id',$ranking->rank_id)->first();
				Log::Admin(Admin::info()->account_id,Admin::info()->account_username." edit Ranking id #".$ranking->rank_id,serialize($old),serialize($new));

				return Redirect('admin/maintenance/ranking');



			}
			else
			{
				$errors =  $validator->errors();
				$data['_error']['rank_name'] = $errors->get('rank_name');
				$data['_error']['rank_level'] = $errors->get('rank_level');
				// $data['_error']['product'] = $errors->get('product');
			}
		}





		return view('admin.maintenance.ranking_edit', $data);
	}


	public function delete_ranking()
	{
		// return 'delete_ranking';
		$old = DB::table('tbl_rank')->where('rank_id',Request::input('rank_id'))->first();
		$query =Tbl_rank::findOrFail(Request::input('rank_id'))->delete();
		Log::Admin(Admin::info()->account_id,Admin::info()->account_username." delete Ranking id #".Request::input('rank_id'),serialize($old));

		return json_encode($query);
		// return json_encode('success');
	}
}