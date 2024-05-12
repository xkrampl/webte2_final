<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QuestionRequest extends FormRequest
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
            'description' => 'required|min:5',
            'type'        => 'required|string|in:answers,opened',
            'subject'     => 'required|exists:subjects,id',
            'answers'     => 'required_if:type,answers|array',
            'answers.*'   => 'nullable|required_if:type,answers|string|min:1'
        ];
    }
}
