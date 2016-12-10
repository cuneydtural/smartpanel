<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name'    => 'required',
            'category_id'    => 'required|integer',
            'brand_id' => 'required|integer',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'quantity_type' => 'required',
            'discount' => 'required|integer'
        ];
    }
}
