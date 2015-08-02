<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_membership extends Model
{
	protected $table = 'tbl_membership';
	protected $primaryKey = 'membership_id';
	public $timestamps = false;
	protected $fillable = ['membership_name', 'membership_price','archived', 'discount','max_income','membership_entry','membership_upgrade'];
	protected $guarded = ['membership_id'];



    public function scopeActive($query)
    {
        return $query->where('archived', 0);
    }
    public function scopeEntry($query)
    {
        return $query->where('membership_entry', 1);
    }
}

