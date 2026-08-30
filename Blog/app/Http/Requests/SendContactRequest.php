<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class SendContactRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if(auth()->user()) {
            return [
                'message' => ['required', 'max:500'],
            ];
        }

        return [
            'name' => ['required', 'max:100'],
            'email' => ['required', 'max:255', 'email'],
            'message' => ['required', 'max:500'],
        ];
    }
}
