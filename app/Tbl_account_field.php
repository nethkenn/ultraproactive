<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_account_field extends Model
{
	protected $table = 'tbl_account_field';
	protected $primaryKey = 'account_field_id';
	protected $fillable = [
                            'account_field_label',
                            'account_field_type',
                            'account_field_required'
	 						];

	public $timestamps = false;




}

