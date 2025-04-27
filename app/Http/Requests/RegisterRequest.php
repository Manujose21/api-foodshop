<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name' => 'required',
            'address' => ['required', 'string'],
            'phone' => ['required', 'string', 'unique:users,phone', 'regex:/^(0414|0424|0412|0416|0426)[-][0-9]{7}$/'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->numbers()
                    ->symbols(),
            ],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio',
            'address.required' => 'La dirección es obligatoria',
            'phone.required' => 'El teléfono es obligatorio',
            'phone.regex' => 'El teléfono no es válido',
            'phone.unique' => 'El teléfono ya está en uso',
            'email.required' => 'El correo electrónico es obligatorio',
            'email.email' => 'El correo electrónico no es válido',
            'email.unique' => 'El correo electrónico ya está en uso',
            'password.required' => 'La contraseña es obligatoria',
            'password.confirmed' => 'La confirmación de la contraseña no coincide',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres',
            'password.letters' => 'La contraseña debe contener letras',
            'password.numbers' => 'La contraseña debe contener números',
            'password.symbols' => 'La contraseña debe contener símbolos'
        ];
    }

}
