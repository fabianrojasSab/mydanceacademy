<?php

namespace App\Http\Requests\Api\V1\Store;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreServiceRequest extends FormRequest
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
            'academy_id' => 'required|integer|exists:academies,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255',
            'price' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'academy_id.required' => 'El campo academy_id es obligatorio.',
            'academy_id.integer' => 'El campo academy_id debe ser un número entero.',
            'academy_id.exists' => 'El campo academy_id no es válido.',
            'name.required' => 'El campo name es obligatorio.',
            'name.string' => 'El campo name debe ser una cadena de texto.',
            'name.max' => 'El campo name no debe tener más de 255 caracteres.',
            'description.required' => 'El campo description es obligatorio.',
            'description.string' => 'El campo description debe ser una cadena de texto.',
            'description.max' => 'El campo description no debe tener más de 255 caracteres.',
            'price.required' => 'El campo price es obligatorio.',
            'price.numeric' => 'El campo price debe ser un número.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
