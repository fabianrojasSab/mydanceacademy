<?php

namespace App\Http\Requests\Api\V1\Store;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreAcademyRequest extends FormRequest
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
            'name'  => ['required', 'string', 'max:255'], // Solo letras y espacios
            'description'  => ['required', 'string', 'max:255'], // Mínimo 8 caracteres y debe ser confirmado
            'email'  => ['required', 'string', 'email', 'max:255', 'unique:academies,email'], // Debe ser un correo válido y único
            'phone' => ['required', 'string', 'regex:/^\d{10,15}$/'], // Solo números, entre 10 y 15 dígitos
            'address'  => ['required', 'string', 'max:255'], // Mínimo 8 caracteres y debe ser confirmado
            'state' => ['required', 'integer', 'exists:states,id'], // Ejemplo de estados válidos: 1, 2, 3
            'rating' => ['required', 'integer', 'min:0', 'max:5'], // Ejemplo de rating válido: 0, 1, 2, 3, 4, 5
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',

            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no debe exceder los 255 caracteres.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'Debe ser un correo electrónico válido.',
            'email.max' => 'El correo electrónico no debe exceder los 255 caracteres.',
            'email.unique' => 'El correo electrónico ya está registrado.',

            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.string' => 'El número de teléfono debe ser una cadena de texto.',
            'phone.regex' => 'El número de teléfono debe contener solo dígitos y tener entre 10 y 15 caracteres.',

            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser una cadena de texto.',
            'address.max' => 'La dirección no debe exceder los 255 caracteres.',

            'state.required' => 'El estado es obligatorio.',
            'state.integer' => 'El estado debe ser un número entero.',
            'state.exists' => 'El estado no es válido.',

            'rating.required' => 'El rating es obligatorio.',
            'rating.integer' => 'El rating debe ser un número entero.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
