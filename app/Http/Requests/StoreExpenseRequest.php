<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //
            "title"=> "required|string|max:255",
            "description"=> 'string',
            "receipt" => 'required|file|mimes:jpg, png, jpeg, pdf',
            "quantity" => 'integer|min:1',
            "unit_price" => 'required',
            "category" => "required"
        ];
    }
}
