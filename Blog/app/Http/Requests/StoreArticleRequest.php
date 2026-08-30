<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class StoreArticleRequest extends FormRequest
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
        return [
            // 'title' => 'required|max:150',
            'title' => ['required', 'max:150'],
            'category' => ['required', 'max:50'],
            'body' => 'max:5000',
        ];
    }

    public function messages(): array
    {
        return [
            // 'title.required' => 'Il campo Titolo è obbligatorio',
            'title.*' => 'Errore nel campo titolo',
        ];
    }
}
