<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_stockist_user extends Model
{
	protected $table = 'tbl_stockist_user';
	protected $primaryKey = 'stockist_user_id';
	protected $fillable = [
							'stockist_id',
							'stockist_user_id',
							'stockist_email',
							'stockist_un',
							'stockist_pw',
							'level',
							'archive',
	 						];
	public $timestamps = false;


	public function scopeStockist($query)
    {
        return $query->leftJoin('tbl_stockist', 'tbl_stockist.stockist_id', '=', 'tbl_stockist_user.stockist_id');
    }


}