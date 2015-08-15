<?php
namespace App;

use Illuminate\Database\Eloquent\Model;


class Tbl_response_data extends Model 
{





	protected $table = 'tbl_response_data';
	// protected $primaryKey = 'agentRefNo';
	protected $fillable = [
							'agentRefNo',
							'data_name',
							'data_value'
	 						];

	 public $timestamps = false;

}