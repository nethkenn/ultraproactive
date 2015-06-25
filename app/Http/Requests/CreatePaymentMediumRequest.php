<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreatePaymentMediumRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'pm-name' => 'required|max:30',
			'pm-type' => 'required|exists:tbl_payment_medium_type,medium_type_id',
			'pm-details' => 'required|max:50',
			'pm-img' => 'required'
		];
	}

  public function attributes()
  {

    return [
        'pm-name' => 'Payment Medium Name',
        'pm-type' => 'Payment Medium Type',
        'pm-details' => 'Payment Medium Details',
        'pm-img'=>'Payment Medium Image'
    ];

   }


}
