<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_membership extends Model
{
	protected $table = 'tbl_membership';
	protected $primaryKey = 'membership_id';
	public $timestamps = false;
	protected $fillable = ['membership_name','leadership_bonus','check_match_level','membership_required_gpv','slot_limit', 'membership_price','archived', 'discount','max_income','membership_entry','membership_upgrade','membership_required_pv','member_upgrade_pts'];
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

