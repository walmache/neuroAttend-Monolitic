<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingTypeRequest extends FormRequest
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
            //'name' => 'required|string|max:100|unique:meeting_types,name,' . $this->route('meeting_type') ?? 'NULL',
            //'name' => 'required|string|max:100|unique:meeting_types,name,' . $this->meetingTypeId(),
            'name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre del tipo de reunión es obligatorio.',
            'name.string' => 'El nombre debe ser un texto válido.',
            'name.max' => 'El nombre no puede superar los 100 caracteres.',
            //'name.unique' => 'Este nombre de tipo de reunión ya existe.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no puede superar los 500 caracteres.',
        ];
    }
}
