<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeetingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('datetime')) {
            // Extraer solo la primera fecha del rango
            $datetime = explode(' - ', $this->datetime)[0]; // Obtiene la fecha inicial

            // Convertir al formato correcto si es necesario
            $this->merge([
                'datetime' => \Carbon\Carbon::createFromFormat('Y-m-d H:i', $datetime)->format('Y-m-d H:i:s'),
            ]);
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

       

        return [
            'organization_id' => 'required|exists:organizations,id',
            'meeting_type_id' => 'required|exists:meeting_types,id',
            'datetime' => 'required|date|after_or_equal:today',
            'location' => 'required|string|max:200',
            'description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'organization_id.required' => 'Debe seleccionar una organización.',
            'organization_id.exists' => 'La organización seleccionada no es válida.',
            'meeting_type_id.required' => 'Debe seleccionar un tipo de reunión.',
            'meeting_type_id.exists' => 'El tipo de reunión seleccionado no es válido.',
            'datetime.required' => 'La fecha y hora de la reunión es obligatoria.',
            'datetime.date' => 'Debe ingresar una fecha válida.',
            'datetime.after_or_equal' => 'La fecha y hora de la reunión no pueden ser anteriores a hoy. ',
            'location.required' => 'Debe proporcionar una ubicación.',
            'location.string' => 'La ubicación debe ser un texto válido.',
            'location.max' => 'La ubicación no puede superar los 200 caracteres.',
            'description.string' => 'La descripción debe ser un texto válido.',
            'description.max' => 'La descripción no puede superar los 500 caracteres.',
        ];
    }
}
