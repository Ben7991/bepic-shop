<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class DistributorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "bail|required|regex:/^[a-zA-Z ]*$/",
            "username" => "bail|required|regex:/^[a-zA-Z0-9]*[0-9]{1}[a-zA-Z0-9]*$/",
            "password" => "bail|required|regex:/^[a-zA-Z0-9]*[0-9]{1}[a-zA-Z0-9]*$/",
            "upline_id" => "bail|required|regex:/^[A-Z]{3}[0-9]{8}$/",
            "leg" => "required",
            "country" => "required",
            "phone" => "required",
        ];
    }
}
