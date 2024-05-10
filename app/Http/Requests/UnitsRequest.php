<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UnitsRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'f' => 'required|array',
            'f.*.unit' => 'required|string',
            'f.*.unit_coversion' => 'required|integer|min:1',
            'f.*.unit_coversion_factor' => 'required|integer|min:1',
        ];
    }
}
