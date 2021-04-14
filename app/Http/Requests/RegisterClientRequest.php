<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterClientRequest extends FormRequest
{
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
          'first_name' => 'required',
          'last_name' => 'required',
          'password' => 'required|min:6',
          'gender' => 'required',
          'phone_number' => 'required|unique:clients,phone_number',
          'email' => 'required|unique:clients,email',
          'address' => 'required',
        ];
    }
}
