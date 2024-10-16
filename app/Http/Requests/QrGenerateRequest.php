<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QrGenerateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'linkToConvert' => 'required|url',
            'qrColor' => 'nullable|hex_color',
            'qrType' => 'nullable|in:square,dot,round',
        ];
    }
}
