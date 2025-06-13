<?php

namespace App\Http\Requests\Dashboard;

use App\Utils\Enum\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->role === Role::ADMIN->name;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|regex:/^[a-zA-Z ]*$/',
            'image' => 'required|image',
            'price' => 'required|regex:/^[0-9]*(\.[0-9]{2})*$/',
            'details' => 'required'
        ];
    }
}
