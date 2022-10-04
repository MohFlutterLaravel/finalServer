<?php

namespace App\Http\Requests\Categorie;

use Illuminate\Foundation\Http\FormRequest;

class CategorieRequest extends FormRequest
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
        'categorie-name' => 'required|max:50',
        'categorie-color' => 'required',
        'categorie-image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        'file' => 'max:10240'
      ];
    }
}
