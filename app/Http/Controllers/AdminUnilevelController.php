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
		$slots = Tbl_slot::account()->membership()
		->orderBy('slot_id','ASC')
		->where('slot_personal_points', '>=', DB::raw('membership_required_pv'))
		->get();

		$unilevel_setting = DB::table('tbl_unilevel_setting')->get();
		$unilevel = null;

		foreach($unilevel_setting as $key => $uni)
		{
			$unilevel[$uni->membership_id][$uni->level] = $uni->value;
		}

		foreach($slots as $key => $slot)
		{
			$oneslot = Tbl_slot::account()->membership()->where('slot_id',$slot->slot_id)->first();
			$placement = Tbl_tree_placement::child($slot->slot_id)->level()->distinct_level()->get();
			$gpv = $oneslot->slot_group_points * $oneslot->multiplier;
			$update['slot_wallet'] = $oneslot->slot_wallet + $gpv;
			Tbl_slot::where('slot_id',$oneslot->slot_id)->update($update);
			foreach($placement as $key => $tree)
			{
				$slot_recipient = Tbl_slot::account()->membership()->where('slot_id',$tree->placement_tree_parent_id)->first();
				if(isset($unilevel[$slot_recipient->membership_id][$tree->placement_tree_level]))
				{
					$update_recipient['slot_wallet'] = $slot_recipient->slot_wallet+(($unilevel[$slot_recipient->slot_membership][$tree->placement_tree_level]/100)*$gpv);
					Tbl_slot::account()->membership()->where('slot_id',$slot_recipient->slot_id)->update($update_recipient);	
				}

			}

		}

		$updateall['slot_group_points'] = 0;
		$updateall['slot_personal_points'] = 0;
		Tbl_slot::account()->membership()->update($updateall);
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