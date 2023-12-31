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
            'role_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'string|email|max:255|unique:users,email,' . $this->route('user'),
            'password' => 'nullable|string|min:6|max:50',
//            'status' => 'required|boolean',
        ];
    }
}
