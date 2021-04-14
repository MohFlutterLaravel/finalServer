<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProduitRequest extends FormRequest
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
          'famille' => 'required',
          'marque-id' => 'required',
          'product-name' => 'required|max:30',
          'product-description' => 'required|max:80',
          'product-pa' => 'required',
          'product-pv' => 'required',
          'product-re' => 'required'
        ];
    }
}
