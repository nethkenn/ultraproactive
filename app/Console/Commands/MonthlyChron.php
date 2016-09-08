<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use DB;
use Carbon\Carbon;
class MonthlyCron extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'monthlychron';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Display an inspiring quote';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
		$_slot = Tbl_slot::whereRaw('current_rank != next_month_rank')->get();
		foreach($_slot as $slot)
		{
			$update["current_rank"] = $slot->next_month_rank;
			$update["next_month_rank"] = 1;
			
			Tbl_slot::where("slot_id",$slot->slot_id)->update($update);
		}
	}

}
