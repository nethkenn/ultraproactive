<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_get_input extends Model
{
    protected $table = 'tbl_get_input'; 
    // protected $primaryKey = 'id'; 
    public $timestamps = false;
   	protected $fillable = [
   							'transaction_code',
   							'inputfield_name',
   							'behavior',
   							'input_type'
   							];
}
