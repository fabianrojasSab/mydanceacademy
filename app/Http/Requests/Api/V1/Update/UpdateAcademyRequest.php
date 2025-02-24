<?php

namespace App\Http\Requests\Api\V1\Update;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAcademyRequest extends FormRequest
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
        if ($this->method() == 'PUT') {

            return [
                'name'  => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Solo letras y espacios
                'description'  => ['required', 'string', 'max:255'], // Solo letras y espacios
                'phone' => ['required', 'string', 'regex:/^\d{10,15}$/'], // Solo números, entre 10 y 15 dígitos
                'email'  => ['required', 'string', 'email', 'max:255'], // Debe ser un correo válido y único
                'address'  => ['required', 'string', 'max:255'], // Debe ser un correo válido y único
                'state'  => ['required', 'integer'], // Ejemplo de roles válidos: admin, user, guest
                'rating'  => ['required', 'integer'], // Ejemplo de roles válidos: admin, user, guest
            ];
        } else {
            return [
                'name'  => ['sometimes', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'], // Solo letras y espacios
                'description'  => ['sometimes', 'string', 'max:255'], // Solo letras y espacios
                'phone' => ['sometimes', 'string', 'regex:/^\d{10,15}$/'], // Solo números, entre 10 y 15 dígitos
                'email'  => ['sometimes', 'string', 'email', 'max:255'], // Debe ser un correo válido y único
                'address'  => ['sometimes', 'string', 'max:255'], // Debe ser un correo válido y único
                'state'  => ['sometimes', 'integer'], // Ejemplo de roles válidos: admin, user, guest
                'rating'  => ['sometimes', 'integer'], // Ejemplo de roles válidos: admin, user, guest
            ];
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es obligatorio.',
            'name.string' => 'El nombre debe ser una cadena de texto.',
            'name.max' => 'El nombre no debe exceder los 255 caracteres.',
            'name.regex' => 'El nombre solo puede contener letras y espacios.',

            'description.required' => 'La descripción es obligatoria.',
            'description.string' => 'La descripción debe ser una cadena de texto.',
            'description.max' => 'La descripción no debe exceder los 255 caracteres.',

            'phone.required' => 'El número de teléfono es obligatorio.',
            'phone.string' => 'El número de teléfono debe ser una cadena de texto.',
            'phone.regex' => 'El número de teléfono debe contener solo números.',

            'email.required' => 'El correo electrónico es obligatorio.',
            'email.string' => 'El correo electrónico debe ser una cadena de texto.',
            'email.email' => 'El correo electrónico debe ser un correo válido.',
            'email.max' => 'El correo electrónico no debe exceder los 255 caracteres.',

            'address.required' => 'La dirección es obligatoria.',
            'address.string' => 'La dirección debe ser una cadena de texto.',
            'address.max' => 'La dirección no debe exceder los 255 caracteres.',

            'state.required' => 'El estado es obligatorio.',
            'state.integer' => 'El estado debe ser un número entero.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
