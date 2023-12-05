<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'dni' => 'required|numeric|digits:8|exists:users,dni',
            'name' => 'nullable|string',
            'email' => 'nullable|email|unique:users,email' . ($this->get('dni') ? ','.$this->get('dni').',dni' : ''),
            'password' => 'nullable|string',
        ];
    }
}
