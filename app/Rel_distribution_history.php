<?php
namespace App;

use Illuminate\Database\Eloquent\Model;

class rel_distribution_history extends Model
{
    protected $table = 'rel_distribution_history';
    public $timestamps = false;
    
    public function scopeSlot($query)
    {
        return $query->leftJoin('tbl_slot','tbl_slot.slot_id','=','tbl_distribution_history.slot_id');
    }

}