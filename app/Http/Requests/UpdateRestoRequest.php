<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRestoRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
                Rule::unique('restos', 'name')->ignore($this->route('restos.updates')),
            ],
            'description' => [
                'sometimes',
                'nullable',
                'string',
                'max:750',
            ],
            'address' => [
                'sometimes',
                'required',
                'string',
                'max:750',
            ],
        ];
    }
}
