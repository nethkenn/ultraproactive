<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
class Tbl_hack extends Model
{
	protected $table = 'tbl_hack';
	protected $primaryKey = 'hack_id';
    public $timestamps = false;
}
