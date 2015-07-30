<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Classes\Admin;
use App\Tbl_position;
class AdminPositionEditRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		$admin = Admin::info();
		$position = Tbl_position::findOrFail($this->input('admin_position_id'));
		if((integer) $position->admin_position_rank <= (integer) Admin::info()->admin_position_rank)
		{
			return false;
		}
		return true;
	}
	
	public function rules()
	{

				$admin = Admin::info();
				$min_val = (integer) $admin->admin_position_rank + 1;
					$rules = [
						'admin_position_name'=>'unique:tbl_admin_position,admin_position_name,'.$this->input('admin_position_id').',admin_position_id|required|regex:/^[A-Za-z0-9\s-_]+$/|min:3',
						'admin_position_rank'=>'integer|min:1|required|min:'.$min_val,
						'module' => 'required'

					];
					

				foreach((array)$this->request->get('module') as $key => $val)
				  {
				    $rules['module.'.$key] = 'exists:tbl_admin_position_has_module,module_id,admin_position_id,'.$admin->admin_position_id;
				  }


				  return $rules;

	}


	public function messages()
	{




	$messages = ['admin_position_name.regex' => 'The :attribute must only have letters , numbers, spaces, hypens ( - ) and underscores ( _ )',];
	  foreach((array)$this->request->get('module') as $key => $val)
	  {
	    $messages['module.'.$key.'.exists'] = 'The selected module - '.$val.' does not exist in module choices';
	  }
	  return $messages;
	}

}
