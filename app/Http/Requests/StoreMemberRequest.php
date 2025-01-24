<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
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
            'memberName' => ['required', 'string', 'max:10'],
            'memberKana' => ['required', 'string', 'regex:/^[ぁ-ゖー０-９]+$/u', 'max:255'],
        ];
    }

    public function messages()
    {
        return [
            'memberKana.regex' => 'メンバー名かなは、ひらがなと全角数字のみで入力してください。',
        ];
    }
}
