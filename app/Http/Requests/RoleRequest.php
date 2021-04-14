<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
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
          'role-name' => 'required|max:50',
          'permissions' => 'required_without:add_permissions|array',
          'add_permissions' => 'required_without:permissions|array',
          'password' => 'required'
      ];
    }
    /**
    * Custom message for validation
    *
    * @return array
    */
   public function messages()
   {
       return [
           'role-name.required' => 'role-name is required!',
           'permissions[].required' => 'Permissions is required!',
           'password.required' => 'Password is required!'
       ];
   }
}
