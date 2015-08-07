<?php namespace App\Http\Controllers;
use App\Tbl_slot;
use DB;
use Redirect;
use App\Tbl_distribution_history;
use App\Rel_distribution_history;
use App\Tbl_tree_placement;
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
		// $slots = Tbl_slot::account()->membership()
		// ->orderBy('slot_id','ASC')
		// ->where('slot_personal_points', '>=', DB::raw('membership_required_pv'))
		// ->get();

		// $unilevel_setting = DB::table('tbl_unilevel_setting')->get();
		// $unilevel = null;

		// foreach($unilevel_setting as $key => $uni)
		// {
		// 	$unilevel[$uni->membership_id][$uni->level] = $uni->value;
		// }

		// foreach($slots as $key => $slot)
		// {
		// 	$oneslot = Tbl_slot::account()->membership()->where('slot_id',$slot->slot_id)->first();
		// 	$sponsor_tree = Tbl_tree_placement::child($slot->slot_id)->level()->distinct_level()->get();
		// 	$gpv = $oneslot->slot_group_points * $oneslot->multiplier;
		// 	$update['slot_wallet'] = $oneslot->slot_wallet + $gpv;
		// 	// $update['group_pv'] = 0;
		// 	// $update['slot_wallet'] = 0;
		// 	Tbl_slot::where('slot_id',$oneslot->slot_id)->update($update);
		// 	foreach($sponsor_tree as $key => $tree)
		// 	{
		// 		$slot_recipient = Tbl_slot::account()->membership()->where('slot_id',$tree->placement_tree_parent_id)->first();
		// 		if(isset($unilevel[$slot_recipient->membership_id][$tree->placement_tree_level]))
		// 		{
		// 			$update_recipient['slot_wallet'] = $slot_recipient->slot_wallet+(($unilevel[$slot_recipient->membership_id][$tree->sponsor_tree_level]/100)*$gpv);
		// 			echo($update_recipient['slot_wallet']);
		// 			Tbl_slot::account()->membership()->where('slot_id',$slot_recipient->slot_id)->update($update_recipient);	
		// 		}

		// 	}

		// }



	

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