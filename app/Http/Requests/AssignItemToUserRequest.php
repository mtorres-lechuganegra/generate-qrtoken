<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Foundation\Http\FormRequest;

class AssignItemToUserRequest extends FormRequest
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
            'entity_sku' => 'required|string',
            'entity_type' => 'required|string|in:' . implode(',', ['product', 'service']),
            'user_dni' => 'required|numeric|digits:8',
        ];
    }
}
