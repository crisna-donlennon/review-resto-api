<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * 
     * @return bool
     */
    public function authorize()
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
            'text' => [
                'required',
                'string',
                'max:750',
            ],
            'rating' => [
                'required',
                'numeric',
                'max:5',
                'min:1',
            ],
            'resto_id' => [
                'required',
                'numeric',
                'exists:restos,id',
            ],
        ];
    }
}
