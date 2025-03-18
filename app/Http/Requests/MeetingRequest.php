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
        $this->merge([
            'is_virtual' => $this->has('is_virtual') ? 1 : 0,
        ]);
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
            'datetime' => 'required|date_format:Y-m-d H:i|after_or_equal:today',
            'duration' => 'required|integer|min:1',
            'is_virtual' => 'nullable',
            'location' => 'required|string|max:200',
            'capacity' => 'required|integer|min:0',
            'fee_amount' => 'required|numeric|min:0',
            'description' => 'nullable|string|max:500',
        ];
    }

    public function messages(): array
    {
        return [
            'organization_id.required' => 'Seleccione una organización.',
            'organization_id.exists' => 'La organización seleccionada no existe.',
            'meeting_type_id.required' => 'Seleccione un tipo de reunión.',
            'meeting_type_id.exists' => 'El tipo de reunión seleccionado no existe.',
            'datetime.required' => 'La fecha y hora son obligatorias.',
            'datetime.date_format' => 'El formato de fecha y hora debe ser YYYY-MM-DD HH:MM.',
            'duration.required' => 'La duración es obligatoria.',
            'duration.integer' => 'La duración debe ser un número entero.',
            'duration.min' => 'La duración debe ser al menos 1 minuto.',
            'location.required' => 'La ubicación es obligatoria.',
            'location.max' => 'La ubicación no puede exceder los 200 caracteres.',
            'capacity.required' => 'La capacidad es obligatoria.',
            'capacity.integer' => 'La capacidad debe ser un número entero.',
            'capacity.min' => 'La capacidad no puede ser negativa.',
            'fee_amount.required' => 'El monto de la cuota es obligatorio.',
            'fee_amount.numeric' => 'El monto de la cuota debe ser un número.',
            'fee_amount.min' => 'El monto de la cuota no puede ser negativo.',
            'description.max' => 'La descripción no puede exceder los 500 caracteres.',
        ];
    }
}
