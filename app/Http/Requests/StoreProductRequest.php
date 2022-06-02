<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|unique:product,name|max:255',
            'image_id' => 'required|integer',
            'description' => 'required|min:10',
            'stock_id'   => 'required|integer',
            'category_id' => 'required|integer',
        ];
    }
}
