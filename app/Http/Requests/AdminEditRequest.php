<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

use App\Classes\Admin;
use App\Tbl_admin_position_has_module;
use App\Tbl_admin;
use App\Tbl_position;

class AdminEditRequest extends Request {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $admin_rank = Admin::info()->admin_position_rank;
        $seleted_admin = $data['_admin'] = Tbl_admin::position()->findOrFail($this->input('admin_id'));
        if($seleted_admin->admin_position_rank <= $admin_rank)
        {
            return false;
        }

        

        return true;
    }


        /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {


        // $in = Tbl_admin::select('account_id')->where('account_id','=', $this->input('account_id'))->get()->pluck('account_id')->toArray();
        // $in = implode(',', $in);
        $admin = Admin::info();
       
        $position = Tbl_position::where('admin_position_rank','>', $admin->admin_position_rank)->get()->pluck('admin_position_id')->toArray();
        $position = implode(',', $position);

        return [

            'admin_id'=>'required|exists:tbl_admin,admin_id',
            // 'account_id'=>'required|exists:tbl_account,account_id|exists:tbl_account,account_id,account_id,'.$this->input('account_id'),
            'admin_position_id' => 'required|exists:tbl_admin_position,admin_position_id|in:'.$position
            //
        ];
    }

    // public function messages()
    // {
    //     return ['account_id.not_in' => "The selected account already have a position.",
    //             'account_id.exists' => "A valid account must be seleted."
    //     ];
    // }


}
