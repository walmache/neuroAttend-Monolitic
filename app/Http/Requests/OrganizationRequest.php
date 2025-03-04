<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Permite que cualquier usuario autenticado pueda enviar el formulario
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'          => 'required|string|max:100',
            'address'       => 'nullable|string|max:200',
            'representative'=> 'required|string|max:100',
            'phone'         => 'nullable|string|max:20',
            'email'         => 'nullable|email|max:100',
            'notes'         => 'nullable|string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'El nombre de la organización es obligatorio.',
            'name.max' => 'El nombre no debe exceder los 100 caracteres.',
            'address.max' => 'La dirección no debe exceder los 200 caracteres.',
            'representative.required' => 'El representante es obligatorio.',
            'representative.max' => 'El nombre del representante no debe exceder los 100 caracteres.',
            'phone.max' => 'El teléfono no debe exceder los 20 caracteres.',
            'email.email' => 'El correo electrónico debe ser válido.',
            'notes.max' => 'Las observaciones no deben exceder los 500 caracteres.',
        ];
    }
}