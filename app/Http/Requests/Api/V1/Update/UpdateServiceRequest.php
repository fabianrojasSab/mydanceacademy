<?php

namespace App\Http\Requests\Api\V1\Update;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
        if ($this->method() === 'PUT') {
            return [
                'name' => 'required|string|max:255',
                'description' => 'required|string|max:255',
                'price' => 'required|numeric',
                'academy_id' => 'required|integer|exists:academies,id',
            ];
        } else {
            return [
                'name' => 'sometimes|string|max:255',
                'description' => 'sometimes|string|max:255',
                'price' => 'sometimes|numeric',
                'academy_id' => 'some|integer|exists:academies,id',
            ];
        }
    }
}
