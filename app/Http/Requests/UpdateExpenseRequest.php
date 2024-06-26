<?php

namespace App\Http\Requests;

use App\Enums\ExpenseStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateExpenseRequest extends FormRequest
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
        $rules = [
            "title" => "required|string|max:255",
            "description" => 'string',
            "receipt" => 'sometimes|file',
            "quantity" => 'integer|min:1',
            "unit_price" => 'required',
            "category" => "required"
        ];
    
        if (auth()->user()->hasRole('Administrator')) {
            $rules['status'] = 'required|in:pending,approved,rejected';
        }
        return $rules;  
    }
}
