<?php namespace App\Http\Controllers;
use DB;
use Request;
use Redirect;
use Carbon;
use Datatables;
use App\Tbl_rank;
use Validator;

class AdminRankingController extends AdminController
{
	public function index()
	{
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

				
				Tbl_rank::where('rank_level',Request::input('rank_level'))->update(['rank_level'=>$ranking->rank_level]);

				$ranking =Tbl_rank::find($ranking_id);
				$ranking->rank_name = Request::input('rank_name');
				$ranking->rank_level = Request::input('rank_level');
				$ranking->save();
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
		$query =Tbl_rank::findOrFail(Request::input('rank_id'))->delete();
		return json_encode($query);
		// return json_encode('success');
	}
}