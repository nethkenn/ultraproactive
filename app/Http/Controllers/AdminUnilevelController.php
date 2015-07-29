<?php namespace App\Http\Controllers;
use App\Tbl_slot;
use DB;
use Redirect;
use App\Tbl_distribution_history;
use App\Rel_distribution_history;
use App\Tbl_tree_sponsor;
use Carbon\Carbon;
use Request;
use App\Classes\Log;
class AdminUnilevelController extends AdminController
{
	public function index()
	{
		$data['slot'] = Tbl_slot::account()->membership()
		->where('slot_personal_points', '>=', DB::raw('membership_required_pv'))
		->get();
		$data['last_update'] = Tbl_distribution_history::orderBy('distribution_id','DESC')->first();
		$data['history'] = Rel_distribution_history::get();
		if(isset($_POST['sbmt']))
		{
			$data = $this->distribute();
			return Redirect::to('admin/transaction/unilevel-distribution');
		}

        return view('admin.transaction.unilevel',$data);
	}

	public function indexs()
	{
		$data['slot'] = Tbl_slot::account()->membership()
		->where('slot_personal_points', '>=', DB::raw('membership_required_pv'))
		->get();
		$data['last_update'] = Tbl_distribution_history::orderBy('distribution_id','DESC')->first();
		$data['history'] = Rel_distribution_history::get();
		if(isset($_POST['sbmt']))
		{
			$data = $this->dynamic();
			return Redirect::to('admin/transaction/unilevel-distribution/dynamic');
		}

        return view('admin.transaction.unilevel_dynamic',$data);
	}


	public function dynamic()
	{	
		$data['slot'] = Tbl_slot::account()->membership()
		->orderBy('slot_id','ASC')
		->where('slot_personal_points', '>=', DB::raw('membership_required_pv'))
		->where('slot_id', '!=', 1)
		->get();
		
		foreach($data['slot'] as $d)
		{	
			$z = Tbl_slot::account()->membership()->where('slot_id',$d->slot_id)->first();
			$convert = $z->slot_wallet + ($z->slot_group_points * $z->multiplier);
			Tbl_slot::where('slot_id',$z->slot_id)->update(['slot_wallet'=>$convert]);
			$getsponsor = Tbl_tree_sponsor::where('sponsor_tree_child_id',$z->slot_id)->where('sponsor_tree_level',1)->first();
			$check =  Tbl_slot::account()->membership()->where('slot_id',$getsponsor->sponsor_tree_parent_id)->first();
			$count = DB::table('tbl_unilevel_setting')->where('membership_id',$d->membership_id)->get();
			$counter = DB::table('tbl_unilevel_setting')->where('membership_id',$d->membership_id)->count();
			$counter = $counter -1;
			$counter2 = $counter;

			for($counter=0;$counter<=$counter2;)
			{
				$y = ($count[$counter]->value/100);

			

				if($check->slot_personal_points >= $check->membership_required_pv)
				{	
					$f = Tbl_slot::account()->membership()->where('slot_id',$check->slot_id)->first();
					$total = $f->slot_wallet + (($d->slot_group_points * $d->multiplier)*$y);
					Tbl_slot::where('slot_id',$f->slot_id)->update(['slot_wallet'=>$total]);	
					$getsponsor = Tbl_tree_sponsor::where('sponsor_tree_child_id',$check->slot_id)->where('sponsor_tree_level',1)->first();
					Log::slot($f->slot_id,'Distribute Group Points',$total);
					if(!$getsponsor)
					{
						break;
					}
					
					$check = Tbl_slot::account()->membership()->where('slot_id',$getsponsor->sponsor_tree_parent_id)->first();
					$counter++;
				}
				else
				{
					$getsponsor = Tbl_tree_sponsor::where('sponsor_tree_child_id',$check->slot_id)->where('sponsor_tree_level',1)->first();
					if(!$getsponsor)
					{
						break;
					}
					$check = Tbl_slot::account()->membership()->where('slot_id',$getsponsor->sponsor_tree_parent_id)->first();
				}
			}
			
		}

			$check =  Tbl_slot::account()->membership()->where('slot_id',1)->first();
			if($check->slot_personal_points >= $check->membership_required_pv)
			{
				$convert = $check->slot_wallet + ($check->slot_group_points * $check->multiplier);
				Tbl_slot::where('slot_id',$check->slot_id)->update(['slot_wallet'=>$convert]);
				Log::slot($check->slot_id,'Distribute Group Points',$convert);
			}
			DB::table('tbl_slot')->update(['slot_group_points'=>0,'slot_personal_points'=>0]);
	}


	public function distribute()
	{
		$data['slot'] = Tbl_slot::account()->membership()
		->where('slot_personal_points', '>=', DB::raw('membership_required_pv'))
		->get();

		$id = Tbl_distribution_history::insertGetId(['created_at'=>Carbon::now()]);
		foreach($data['slot'] as $key => $d)
		{
			$update['slot_wallet'] = $d->slot_wallet + ($d->slot_group_points * $d->multiplier);
			$insert['slot_id'] = $d->slot_id;
			$insert['group_points'] = $d->slot_group_points;
			$insert['distribution_id'] = $id;
			$insert['convert_amount'] = $d->slot_group_points * $d->multiplier;
 			Tbl_slot::where('slot_id',$d->slot_id)->update($update);
 			Log::slot($d->slot_id,'Distribute Group Points',$update['slot_wallet']);
			Rel_distribution_history::insert($insert);
		}

		$update2['slot_personal_points'] = 0;
		$update2['slot_group_points'] = 0;
		DB::table('Tbl_slot')->update($update2);
	}
}