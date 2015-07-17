<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_membership_code extends Model
{
	protected $table = 'tbl_membership_code';
	protected $primaryKey = 'code_pin';
	public $timestamps = false;
	protected $fillable = ['code_activation', 'code_type_id','membership_id', 'product_package_id', 'admin_id', 'inventory_update_type_id', 'account_id','created_at','used','blocked'];
	protected $guarded = ['code_pin'];
	


	public function scopeGetCodeType($query)
    {
        return $query->leftJoin('tbl_code_type','tbl_code_type.code_type_id','=','tbl_membership_code.code_type_id');
    }


    public function scopeGetMembership($query)
    {
        return $query->leftJoin('tbl_membership','tbl_membership.membership_id','=','tbl_membership_code.membership_id');
    }


    public function scopeGetPackage($query)
    {
        return $query->leftJoin('tbl_product_package','tbl_product_package.product_package_id','=','tbl_membership_code.product_package_id');
    }


    public function scopeGetInventoryType($query)
    {
        
        return $query->leftJoin('tbl_inventory_update_type','tbl_inventory_update_type.inventory_update_type_id','=','tbl_membership_code.inventory_update_type_id');
        // return $query->leftJoin('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id');
    }


    public function scopeGetUsedBy($query)
    {   


        return $query->leftJoin('tbl_account','tbl_account.account_id','=','tbl_membership_code.account_id');
        // ->OrWhereNull('tbl_membership_code.account_id')
        // ->OrWhereNotNull('tbl_membership_code.account_id');
    }



    public function codetype()
    {
        return $this->hasOne('App\Tbl_code_type');
    }


    








}