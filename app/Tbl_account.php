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
}
