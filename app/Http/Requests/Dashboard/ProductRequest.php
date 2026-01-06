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
            'name' => 'bail|required|regex:/^[a-zA-Z ]*$/',
            'image' => 'bail|required|image',
            'price' => 'bail|required|regex:/^[0-9]*(\.[0-9]{2})*$/',
            'details' => 'required',
            'points' => 'bail|required|regex:/^[0-9]*$/'
        ];
    }
}
