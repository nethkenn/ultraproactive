<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_account extends Model
{
	protected $table = 'tbl_account';
	protected $primaryKey = 'account_id';
	protected $fillable = [
							'account_name',
							'account_email',
							'account_contact_number',
							'account_country_id',
							'account_date_created',
							'account_password',
							'account_created_from',
							'archived'
	 						];

	public $timestamps = false;


	public function code()
    {
        return $this->belongsTo('App\Tbl_membership_code','code_pin');
    }

    public function admin()
    {
        return $this->hasOne('App\Tbl_admin','account_id');
    }


    public function scopePosition($query)
    {
        return $query->leftJoin('tbl_admin','tbl_admin.account_id','=','tbl_account.account_id')
        ->leftJoin('tbl_admin_position','tbl_admin_position.admin_position_id','=', 'tbl_admin.admin_position_id' );

        // ->leftJoin('tbl_admin_position', 'tbl_admin_position.admin_position_id', '=', 'tbl_admin.admin_position_id');
    }

    public function scopeCountry($query)
    {
        return $query->leftJoin("tbl_country","tbl_account.account_country_id", "=", "tbl_country.country_id");

        // ->leftJoin('tbl_admin_position', 'tbl_admin_position.admin_position_id', '=', 'tbl_admin.admin_position_id');
    }

    

}

