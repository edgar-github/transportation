<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreOrderRequest extends FormRequest
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
        $isAdmin = Auth::user()->role_id === Role::ADMIN;
        $requiredType = $isAdmin ? 'required' : 'nullable';

        return [
            'company_id' => 'required|integer',
            'driver_id' => $requiredType . '|integer|exists:users,id',
            'name' => 'required|string|max:255',
            'image' => 'required|string',
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
