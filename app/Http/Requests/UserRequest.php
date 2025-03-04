<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $userId = $this->route('user') ? $this->route('user')->id : null;

        return [
            'organization_id' => 'nullable|exists:organizations,id',
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|min:3|max:255',
            'identification' => ['nullable', 'string', 'max:100', Rule::unique('users', 'identification')->ignore($userId)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($userId)],
            'phone' => 'nullable|string|max:20',
            'photo' => 'nullable|image|max:2048', // Permitir imágenes de hasta 2MB
            'status' => 'nullable|boolean',
            'password' => $this->isMethod('post') ? 'required|min:8|confirmed' : 'nullable|min:8|confirmed',
            'login' => 'required|string|min:3|max:255|unique:users,login',

        ];
    }

    public function messages(): array
    {
        return [
            'organization_id.exists' => 'La organización seleccionada no es válida.',
            'role_id.required' => 'El rol es obligatorio.',
            'role_id.exists' => 'El rol seleccionado no es válido.',
            'name.required' => 'El nombre es obligatorio.',
            'name.min' => 'El nombre debe tener al menos 3 caracteres.',
            'name.max' => 'El nombre no puede superar los 255 caracteres.',
            'identification.unique' => 'Esta identificación ya está registrada.',
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'Debe ingresar un correo válido.',
            'email.unique' => 'El correo ya está registrado.',
            'phone.max' => 'El teléfono no puede superar los 20 caracteres.',
            'photo.image' => 'Debe ser una imagen válida.',
            'photo.max' => 'La imagen no puede ser mayor a 2MB.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'login.required' => 'El campo de login es obligatorio.',
            'login.string' => 'El login debe ser un texto válido.',
            'login.min' => 'El login debe tener al menos 3 caracteres.',
            'login.max' => 'El login no puede superar los 255 caracteres.',
            'login.unique' => 'El login ingresado ya está en uso, por favor elija otro.',
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'status' => $this->status ?? 1, // Por defecto, activado si no se especifica
        ]);
    }


}
