<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|max:15'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Es necesario introducir un email',
            'email.email' => 'El formato del correo no es valido',
            'email.unique' => 'El correo ya existe.',
            'password.required' => 'Es necesario introducir una Contraseña'
        ];
    }
}
