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
            'name'  => 'required|unique:products,name|min:3',
            'photo_id' => 'required|integer|exists:photos,id',
            'description'  => 'required|min:10',
            'category_id' => 'required|integer|exists:categories,id',
            'price'  => 'required|integer',
            'stock_total' => 'required|integer',
        ];
    }
}
