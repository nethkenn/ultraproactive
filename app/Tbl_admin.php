<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tbl_admin extends Model
{
    //
    protected $table = "tbl_admin";
    protected $primaryKey = "admin_id";
    protected $fillable = ['admin_id','account_id','admin_position_id'];

    public function getaccount()
    {
       return $this->belongsTo('App\Tbl_account','account_id');
    }

    public function position()
    {
        return $this->hasOne('App\Tbl_position', 'admin_position_id');
    }

}
