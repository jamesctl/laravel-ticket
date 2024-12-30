<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'gender' => 'required',
            'password' => 'required|min:3',
            'rePassword' => 'required|same:password',
            'phone' => 'required|unique:users,phone',
            'email' => 'required|unique:users,email'
        ];
    }

    public function messages()
    {
        return [
            'rePassword.same' => 'The re-entered password must match the password.',
            'password.required' => 'A password is required.',
            'password.min' => 'The password must be at least 8 characters long.',
            'email.required' => 'An email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'phone.unique' => 'This phone number is already in use.',
        ];
    }
    
}
