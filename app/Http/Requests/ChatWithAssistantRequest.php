<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatWithAssistantRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'message' => ['required', 'string', 'min:2', 'max:1000'],
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'message.required' => 'Tulis pertanyaan terlebih dahulu.',
            'message.min' => 'Pertanyaan minimal terdiri dari 2 karakter.',
            'message.max' => 'Pertanyaan maksimal terdiri dari 1000 karakter.',
        ];
    }
}
