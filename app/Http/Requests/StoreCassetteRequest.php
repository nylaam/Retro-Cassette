<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCassetteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:40'],
            'color' => ['required', 'in:coral,teal,purple,mustard'],
            'note' => ['nullable', 'string', 'max:200'],
            'visibility' => ['sometimes', 'in:private,friends,public'],
        ];
    }
}