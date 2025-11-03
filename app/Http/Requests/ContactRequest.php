<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array {
        return [
            'name'    => ['required','string','max:100'],
            'email'   => ['required','email','max:150'],
            'subject' => ['nullable','string','max:150'],
            'message' => ['required','string','min:5'],
        ];
    }

    public function messages(): array {
        return [
            'name.required' => 'A név megadása kötelező.',
            'email.required'=> 'Az e-mail megadása kötelező.',
            'email.email'   => 'Érvényes e-mail címet adj meg.',
            'message.required' => 'Az üzenet mező kötelező.',
            'message.min'      => 'Az üzenet legalább :min karakter legyen.',
        ];
    }
}
