<?php namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Response;

abstract class Request extends FormRequest {

	public function rules()
    {
        return [
            'first_name' => 'required',
            'email_address' => 'required|email'
        ];
    }

    public function authorize()
    {
        // Only allow logged in users
        // return \Auth::check();
        // Allows all users in
        return true;
    }


}
