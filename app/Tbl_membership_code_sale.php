<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_membership_code_sale extends Model
{
	protected $table = 'tbl_membership_code_sale';
	protected $primaryKey = 'membershipcode_or_num';
	protected $fillable = [
							'membershipcode_or_code',
							'sold_to',
							'generated_by',
							'generated_by_name',
							'payment',
							'total_amount',
	 						];



}

